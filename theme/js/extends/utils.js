
var pluckArray = function(prop, arr){
	return ko.utils.arrayMap(arr,function(item){
		return item[prop];
	});
};

var pluckArrayFunction = function(prop, arr){
	return ko.utils.arrayMap(arr,function(item){
		return item[prop]();
	});
};

var getSum = function(total,num){
	return parseFloat(total) + parseFloat(num);
};

var sumArray = function(arr){
	if(arr.length > 0)
		return arr.reduce(getSum).toFixed(2);
	else
		return 0;
};