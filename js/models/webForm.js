function webForm(){
	var self = this;
	self.fields = [];
	
	this.init = function(){
		$.ajax({
				url: self.url,
				type: self.method,
				/*contentType: "application/json; charset=utf-8",*/
				data: {sql: self.sql, table: self.table},
				dataType: 'json',
				success: function (data) {
					self.records(data.length);
					$.each(data,function(key,value){
						self.addItem(value);
					});
				}
			});
	}
	
	this.getAllField = function(){
		return this.fields;
	}
	
	this.getField = function(pos){
		return this.fields[pos];
	}
	
	this.addItem = function(item){
		self.fields.push(item);
	}
	
	this.deleteItem = function(pos){
		return self.fields.slice(pos,1);
	}
	
}