var NominaTotal = function(setting){
			var self = this;
			self.empleados = ko.observableArray(setting.empleados || []);
			
			self.getSum = function(total,num){
							return parseFloat(total) + parseFloat(num);
					};
					
			self.sumArray = function(arr){
				if(arr.length > 0)
					return arr.reduce(self.getSum).toFixed(2);
				else
					return 0;
			};
			
			self.pluckArray = function(prop, arr){
				return ko.utils.arrayMap(arr,function(empleado){
					return empleado[prop];
				});
			};
			
			self.horasNomales = function(){
				return self.pluckArray('Horas_Normales',self.empleados());
			};
			
			self.worktimes = function(){
				return self.pluckArray('WorkTime',self.empleados());
			};
			
			self.ventas = function(){
				return self.pluckArray('Ventas',self.empleados());
			};
			
			self.pagoBases = function(){
				return self.pluckArray('PagoBase',self.empleados());
			};
			
			self.totalPorPagars = function(){
				return self.pluckArray('Total_pagar',self.empleados());
			};
			
			self.totalGeneralHorasNomales = ko.computed(function(){
				return self.sumArray(self.horasNomales());
			});
			
			self.totalGeneralWorkTime = ko.computed(function(){
				return self.sumArray(self.worktimes());
			});
			
			self.totalGeneralVentas = ko.computed(function(){
				return parseInt(self.sumArray(self.ventas()));
			});
			
			self.totalGeneralVPH = ko.computed(function(){
				var result = self.totalGeneralVentas() / self.totalGeneralWorkTime();
				return (isNaN(result) ? 0 : result).toFixed(2);
			});
			
			self.totalGeneralPagoBase = ko.computed(function(){
				return self.sumArray(self.pagoBases());
			});
			
			self.totalGeneralTotalPagar = ko.computed(function(){
				return self.sumArray(self.totalPorPagars());
			});
			
			self.bgRowColor = function(){
				switch(true){
					
					case self.isSphLightGreen() : 
						return 'bg-success';
					break;
					
					case self.isSphGreen() : 
						return 'light-green';
					break;
					
					case self.isSphYellow() : 
						return 'bg-warning';
					break;
					
					case self.isSphBlue() : 
						return 'blue';
					break;
				}
			};
			
			self.isSphLightGreen = function(){
				return self.totalGeneralVPH() >= LIGHT_GREEN_LIMIT;
			};
			
			self.isSphGreen = function(){
				return self.totalGeneralVPH() >= GREEN_LIMIT;
			};
			
			self.isSphYellow = function(){
			return self.totalGeneralVPH() >= YELLOW_LIMIT;
			};
			
			self.isSphBlue = function(empleado){
				return self.totalGeneralVPH() < YELLOW_LIMIT;
			};
			
			
		};