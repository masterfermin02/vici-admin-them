
var InfoBoxModel = function(items) {
    this.items = ko.observableArray(items);
 
    this.addItem = function(obj) {
        this.items.push(obj);
    }; 
};