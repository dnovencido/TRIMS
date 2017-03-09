var Result = function(){
	this.__construct = function(){
		console.log("Result initialized");
	};

	this.success = function(msg,div){
      $(''+div+'').fadeIn();
      $(''+div+'').html('<div class = "alert-success-box"><p><span class="glyphicon glyphicon-ok"></span>'+msg+'</p></div>');
      $(''+div+'').delay(2000).fadeOut();
	};

	this.error = function(msg,div){
 		if($(''+div+'').is(':hidden')){
	       $(''+div+'').fadeIn();
	       $(''+div+'').html('<div class = "alert-error-box">'+msg+'</div>');
	       $(''+div+'').delay(2000).fadeOut();
	    }		
	};

	this.empty = function(msg){
		$('.job-request-tb').html('<td colspan = "11" class = "empty-records"><center>'+msg+'</center></td>');
	};

	this._user_session = function(msg){
		alert(msg);
		window.location.href = 'login/';
	};
	
	this.__construct();
}