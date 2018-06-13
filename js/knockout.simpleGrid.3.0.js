(function () {
    // Private function
    function getColumnsForScaffolding(data) {
        if ((typeof data.length !== 'number') || data.length === 0) {
            return [];
        }
        var columns = [];
        for (var propertyName in data[0]) {
            columns.push({ headerText: propertyName, rowText: propertyName });
        }
        return columns;
    }

    ko.simpleGrid = {
        // Defines a view model class you can use to populate a grid
        viewModel: function (configuration) {
            this.data = configuration.data;
            this.currentPageIndex = ko.observable(0);
            this.pageSize = configuration.pageSize || ko.observable(5);
			this.links =  configuration.links || ko.observableArray([]);
            // If you don't specify columns configuration, we'll use scaffolding
            this.columns = configuration.columns || getColumnsForScaffolding(ko.unwrap(this.data));
			this.modifies = configuration.modifies || ko.observable();
			
			this.sort = configuration.sort;
            this.itemsOnCurrentPage = ko.computed(function () {
                var startIndex = this.pageSize() * this.currentPageIndex();
                return ko.unwrap(this.data).slice(startIndex, startIndex + this.pageSize());
            }, this);
			
            this.maxPageIndex = ko.computed(function () {
                return Math.ceil(ko.unwrap(this.data).length / this.pageSize()) - 1;
            }, this);
        }
    };

    // Templates used to render the grid
    var templateEngine = new ko.nativeTemplateEngine();

    templateEngine.addTemplate = function(templateName, templateMarkup) {
        document.write("<script type='text/html' id='" + templateName + "'>" + templateMarkup + "<" + "/script>");
    };

    templateEngine.addTemplate("ko_simpleGrid_grid", "\
                    <table class=\"ko-grid table table-striped\" >\
                        <thead>\
                            <tr >\
							<!-- ko foreach: columns -->\
                               <th data-bind=\"text: headerText, click: $parent.sort  \"></th>\
							   <!-- /ko -->\
							   <th>Links</th>\
                            </tr>\
                        </thead>\
                        <tbody data-bind=\"foreach: itemsOnCurrentPage \">\
                           <tr  >\
						   <!-- ko foreach: $parent.columns -->\
                               <td  data-bind=\"text: typeof rowText == 'function' ? rowText($parent) : $parent[rowText] \"></td>\
							   <!-- /ko -->\
                            </tr>\
                        </tbody>\
                    </table>");
    templateEngine.addTemplate("ko_simpleGrid_pageLinks", "\
                    <div class=\"ko-grid-pageLinks\">\
                        <span class=\"label label-default\" >Page:</span>\
						<nav><ul class='pagination' >\
						<li>\
      <a href=\"#\" aria-label=\"Previous\" data-bind=\"click: function() { if($root.currentPageIndex() > 0){$root.currentPageIndex($root.currentPageIndex()-1);} }\" >\
        <span aria-hidden=\"true\">&laquo;</span>\
      </a>\
    </li>\
                        <!-- ko foreach: ko.utils.range(0, maxPageIndex) -->\
                               <li data-bind='css: { active: $data == $root.currentPageIndex() }' ><a href=\"#\" data-bind=\"text: $data + 1, click: function() { $root.currentPageIndex($data) }\">\
                            </a></li>\
                        <!-- /ko -->\
						<li>\
      <a href=\"#\" aria-label=\"Next\" data-bind=\"click: function() { if($root.currentPageIndex() < $root.maxPageIndex()){$root.currentPageIndex($root.currentPageIndex()+1);} }\">\
        <span aria-hidden=\"true\">&raquo;</span>\
      </a>\
    </li>\
						</ul></nav>\
                    </div>");

    // The "simpleGrid" binding
    ko.bindingHandlers.simpleGrid = {
        init: function() {
            return { 'controlsDescendantBindings': true };
        },
        // This method is called to initialize the node, and will also be called again if you change what the grid is bound to
        update: function (element, viewModelAccessor, allBindings) {
            var viewModel = viewModelAccessor();

            // Empty the element
            while(element.firstChild)
                ko.removeNode(element.firstChild);

            // Allow the default templates to be overridden
            var gridTemplateName      = allBindings.get('simpleGridTemplate') || "ko_simpleGrid_grid",
                pageLinksTemplateName = allBindings.get('simpleGridPagerTemplate') || "ko_simpleGrid_pageLinks";

            // Render the main grid
            var gridContainer = element.appendChild(document.createElement("DIV"));
            ko.renderTemplate(gridTemplateName, viewModel, { templateEngine: templateEngine }, gridContainer, "replaceNode");

            // Render the page links
            var pageLinksContainer = element.appendChild(document.createElement("DIV"));
            ko.renderTemplate(pageLinksTemplateName, viewModel, { templateEngine: templateEngine }, pageLinksContainer, "replaceNode");
        }
    };
})();