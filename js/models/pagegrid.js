
var colummns = [
    
];
var userModel = function(){
	
};
var PagedGridModel = function() {
		var self = this;
		var defaultSortColumn = 0;
		/*Class properties*/
		self.items = ko.observableArray([]);
		self.sql = ko.observable("");
		self.table = ko.observable("");
		self.records = ko.observable(0);
		self.colummns = ko.observableArray([]);
		self.showbtn = ko.observable("Show all");
		self.activeFlagColumn = ko.observable('active');
		self.activeFlagVal = ko.observable('Y');
		self.activeSort = self.colummns[defaultSortColumn];
		self.filter = ko.observable('');
        self.selectedField = ko.observable();
		self.recordPerPage = ko.observable(15);
		self.recordPerPageList = ko.observableArray([5,10,15,20,30,50,100]);
		self.modifies = ko.observable();
		/*ajax properties*/
		self.url = ko.observable('get_grid_data.php');
		self.method = ko.observable('POST');
		self.dataType = ko.observable('json');
		self.links = ko.observableArray([]);
		self.edit = function(){
			
		}
		/* load the data from the server */
		self.loadData = function(){
			$.ajax({
				url: self.url(),
				type: self.method(),
				/*contentType: "application/json; charset=utf-8",*/
				data: {sql: self.sql(), table: self.table()},
				dataType: 'json',
				success: function (data) {
					self.records(data.length);
					$.each(data,function(key,value){
						self.addItem(value);
					});
				}
			});
		};
		
		
		self.filterActiveRecords =  ko.computed(function() {
			if(self.showbtn() == 'Show all') {
				
				return ko.utils.arrayFilter(self.items(), function(item) {
					return item[self.activeFlagColumn()] == self.activeFlagVal();
				});
				
			} else {
				return self.items(); 
			}
		});
		
		self.toggleUsers = function(){
			if(self.showbtn() == 'Show all') {
				self.showbtn('Show only active');
			}else{
				self.showbtn('Show all');
			}
		};
		
		self.addItem = function(obj) {
			
			self.items.push(obj);
		};
		
		self.modifyItem = function(){
			alert(this.user);
		};
		
		self.sort = function(header, event){
			//if this header was just clicked a second time...
			if(self.activeSort === header) {
				header.asc = !header.asc; //...toggle the direction of the sort
			} else {
				self.activeSort = header; //first click, remember it
			}
			var prop = self.activeSort.rowText;
			var ascSort = function(a,b){ return a[prop] < b[prop] ? -1 : a[prop] > b[prop] ? 1 : a[prop] == b[prop] ? 0 : 0; };
			var descSort = function(a,b){ return a[prop] > b[prop] ? -1 : a[prop] < b[prop] ? 1 : a[prop] == b[prop] ? 0 : 0; };
			var sortFunc = self.activeSort.asc ? ascSort : descSort;
			self.items.sort(sortFunc);
		};
		
		self.field = function(name, value) {
						this.fieldName = name;
						this.fieldVal = value;
					};
		self.filterFields = ko.observableArray([]);
		
		self.filteredItems = ko.computed(function () {
			
			var filter = self.filter().toLowerCase();

			if (!filter) {
				return self.filterActiveRecords();
			} else {
				return ko.utils.arrayFilter(self.items(), function (item) {
					if(self.showbtn() == 'Show all') {
						return (item[self.selectedField().fieldVal] !== null && item[self.selectedField().fieldVal].toLowerCase().indexOf(filter) !== -1 && item[self.activeFlagColumn()] == self.activeFlagVal());
						
					} else {
						return (item[self.selectedField().fieldVal] !== null && item[self.selectedField().fieldVal].toLowerCase().indexOf(filter) !== -1);
					}
					
				});
			}		

		}, self);
		 
		self.jumpToFirstPage = function() {
			self.gridViewModel.currentPageIndex(0);
		};
		 
		self.gridViewModel = new ko.simpleGrid.viewModel({
			data: self.filteredItems,
			columns: self.colummns,
			pageSize: self.recordPerPage,
			sort: self.sort,
			links: self.links,
			modifies: self.modifies
		});
};


