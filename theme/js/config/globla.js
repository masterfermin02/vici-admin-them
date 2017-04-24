var globla = {
	MAX_LOGIN_HOURS : 7,
	BASE_URL: '/vicidial/apps/index.php/nomina/',
	is_saturday: function(date){
		return moment(date).add(-1, 'days').format('dddd') === 'Saturday';
	},
	discount_for_max_hour: function(date){
		if(date)
		{
			return moment(date).format('dddd') === 'Saturday' ? 2 : 1;
		}
		return moment().add(-1, 'days').format('dddd') === 'Saturday' ? 2 : 1;
	},
};

var GREEN_LIMIT = 1;
var LIGHT_GREEN_LIMIT = 1.25;
var YELLOW_LIMIT = 0.75;

