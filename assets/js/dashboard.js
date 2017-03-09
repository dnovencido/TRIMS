var Dashboard = function(){
	this.__construct = function(){
		console.log("Dashboard initialized");
		Template = new Template();
		Event = new Event();
		Result = new Result();
		Validations = new Validations();
		load_job_req();

	};

	var load_job_req = function(){
		$.ajax({
		  url: 'api/display_job_req',
		  type:"post",
		  dataType:"json",   
		  success: function(data) { 
		  	var page = 1;
		  		 // recPerPage = 5,
		  		 // startRec = Math.max(page - 1, 0) * 5,
		  		 // endRec = startRec + recPerPage
    			// recordsToShow = data.splice(startRec, endRec);
    			// alert(recordsToShow);
		  	if(data.result !== 0){
			  	var output = '';
			  	for(var i = 0; i<data.length; i++) {
			  		output += Template.job(data[i]);
			  	}
			  	$('.job-request-tb').html(output);
		  	} else {
		  		Result.empty(data.error);
		  	}

		  }         
		}); 		
	};
	
	this.__construct();
};