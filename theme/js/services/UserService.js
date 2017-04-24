var UserService = function(){
			var self = this
			self.api = '/vicidial/apps/index.php/';
			self.defaultConf = {
				
			};
			
			var sv = new Service();
			
			
			self.update = function(conf){
				conf.url = self.api+'/api/update_vicidial_users';
				sv.post(conf);
			};
			
			self.users = function(conf){
				conf.url = self.api+'/api/vicidial_users';
				sv.post(conf);
			};
			
		};