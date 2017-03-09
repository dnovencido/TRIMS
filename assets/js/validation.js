var Validations = function(){
	this.__construct = function(){
		console.log("Validations initialized");
	};
	this.empty_field = function(row){
		if(row == ''){
			var frow
			row = '---';
		} 
		return row;
	}
	this.__construct();
}