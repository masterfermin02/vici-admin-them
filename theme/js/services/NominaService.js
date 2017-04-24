var NominaService = function(){
			var self = this
			self.api = globla.BASE_URL;
			self.defaultConf = {
				
			};
			
			var sv = new Service();
			self.aprove = function(conf){
				conf.url = self.api+'aprove_record';
				sv.post(conf);
			};
			
			self.approveAll = function(conf){
				conf.url = self.api+'approve_all';
				sv.post(conf);
			};
			
			self.review = function(conf){
				conf.url = self.api+'review_record';
				sv.post(conf);
			};
			
			self.reviewAll = function(conf){
				conf.url = self.api+'review_all';
				sv.post(conf);
			};
			
			self.update = function(conf){
				conf.url = self.api+'update_record';
				sv.post(conf);
			};
			
			self.delete = function(conf){
				conf.url = self.api+'delete_record';
				sv.post(conf);
			};
			
			self.getNominaAproved = function(conf){
				conf.url = self.api+'imported_hours';
				sv.post(conf);
			};
			
			self.getNominaReportData = function(conf){
				conf.url = self.api+'report_data';
				sv.post(conf);
			};
			
			self.getCheque = function(conf){
				conf.url = self.api+'cheque';
				sv.post(conf);
			};
			
			self.searchNomina = function(conf){
				conf.url = self.api+'report_date';
				sv.post(conf);
			};
			
			self.saveNominaHistory = function(conf){
				conf.url = self.api+'nomina_history';
				sv.post(conf);
			};
			
			self.create = function(conf){
				conf.url = self.api+'store';
				sv.post(conf);
			};
		};