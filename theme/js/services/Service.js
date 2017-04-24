var Service = function(){
			var self = this;
			self.post = function(conf){
				conf.type = 'POST';
				self.sendRequest(conf);
			};
			
			self.get = function(conf){
				conf.type = 'GET';
				self.sendRequest(conf);
			};
			
		self.sendRequest = function(conf){
		var done = conf.doneCb || function(data){};
		var fail = conf.failCb || function(){};
		var always = conf.alwaysCb || function(){};
			$.ajax({
					url: conf.url,
					type: conf.type,
					dataType: 'json',
					data: conf.data
				}).done(done)
				.fail(fail)
				.always(always);
		};
			
		};