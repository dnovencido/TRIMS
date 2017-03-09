var Event = function(){
	this.__construct = function(){
		console.log("Event initialized");
		add_job_request();
		preview_job();
		update_job();
		print_this();
		search_drop();
		search_keypress();
	};
	var add_job_request = function() {
		var add_job_request = $('#add-job-request');

		add_job_request.submit(function(e){
		  e.preventDefault();	
			var data = {
			'name' : $('#name').val(),
			'company' : $('#company').val(),
			'faults' : $('#faults').val(),
			'prod-item' : $('#prod-item').val(),
			'prod-name' : $('#prod-name').val(),
			'prod-model' : $('#prod-model').val(),
			'contact-no' : $('#contact-no').val(),
			'cost' : $('#cost').val(),
			'job-req-no' : job_request_no
			}
			$.ajax({
			  data:data,
			  url: add_job_request.attr('action'),
			  type:"post",
			  dataType:"json",   
			  success: function(data) { 
				if(data.user_login == 0) {
					Result._user_session('You dont have permission to access this site. Please refresh the page');
				} else {
				   if(data.result == 0){
				   		Result.error(data.error,'#alert-job-req');
				   } else {
				   		Result.success(' Successfully added...','#alert-job-req');
				      	var output = Template.job(data.last_row[0]);
						
						if ($(".job-request-tb").has(".empty-records").length <= 0) {
						   	$('.job-request-tb').prepend(output);
						} else {
							$('.job-request-tb').html(output);
						}

				      	add_job_request[0].reset();    
				      	generate_job_request();     
				   }
				}
			  }         
			}); 
		});			
	};
	var job_req_id = null;
	var preview_job = function(){
		$("body").on('click', '#btn-prev-job', function(e){
			e.preventDefault();
			
			job_req_id = $(this).attr('data-id');
			
			var data = {
				"jobReqID" : $(this).attr('data-id')
			}
			$.ajax({
			  data:data,
			  url: 'api/prev_job',
			  type:"post",
			  dataType:"json", 
			  success: function(data) { 
			  	var output = Template.job_prev(data[0]);
			  	$('#prev_job').html(output);
			  	$('.save-job').css('display', 'none');
			  	$('.cancel-job').css('display', 'none');
			  	print_this();
			  }				
			});	
		});
	};

	var update_job = function(){
		$("body").on('click', '.btn-edit-job', function(e){
			e.preventDefault();
			$('.form-trims-prev').removeAttr('disabled');
			$('#prev_name').focus();			
			$('.save-job').css('display', 'block');
			$('.cancel-job').css('display', 'block');
			$('.btn-delete-job').css('display', 'none');
			$(this).css('display', 'none');
		});

		$("body").on('click', '.cancel-job', function(e){
			e.preventDefault();

			$('.save-job').css('display', 'none');
			$('.btn-edit-job').css('display', 'block');
			$(this).css('display', 'none');
			$('.form-trims-prev').prop('disabled', true);
			$('.btn-delete-job').css('display', 'block');
		});

		$("body").on('click', '.btn-delete-job', function(e){
			e.preventDefault();
			var result = confirm("Are you sure you want to delete this job?");
			if (result) {
				var data = {
					"jobReqID" : job_req_id
				}	

				$.ajax({
				  data:data,
				  url: 'api/delete_job_req',
				  type:"post",
				  dataType:"json", 
				  success: function(data) { 
				  	if(data.result == 1) {
				  		$('#modal-prev-job').modal('toggle');
							$('.prev_job-'+data.data_id+'').remove();				  		
						if ($(".job-request-tb").has("td").length <= 0) {
							Result.empty('Empty-record');
						} else {
							$('.prev_job-'+data.data_id+'').remove();
						}
						
				  	} else {
				  		Result.success('<p><span class="glyphicon glyphicon-remove"></span>There was an error in deleting this job.</p>' , '#alert-prev-job-req');
				  	}
				  }				
				});
			}				
		});

		$("body").on('click', '.save-job', function(e){
			e.preventDefault();

			$('.btn-edit-job').css('display', 'block');
			$(this).css('display', 'none');
			$('.cancel-job').css('display', 'none');
			$('.form-trims-prev').prop('disabled', true);

			var data = {
				"jobReqID" : job_req_id,
				"prev_name" : $('#prev_name').val(),
				"prev_company" : $('#prev_company').val(),
				"prev_contact-no" : $('#prev_contact-no').val(),
				"prev_prod-item" : $('#prev_prod-item').val(),
				"prev_prod-name" : $('#prev_prod-name').val(),
				"prev_prod-model" : $('#prev_prod-model').val(),
				"prev_faults" : $('#prev_faults').val(),
				"prev_cost" : $('#prev_cost').val()
			}
			$.ajax({
			  data:data,
			  url: 'api/update_job_req',
			  type:"post",
			  dataType:"json", 
			  success: function(data) { 
			  	if(data.result == 1) {
				  	var output = Template.update_job(data.update_row[0]);
				  	$('.prev_job-'+data.data_id+'').html(output);
				  	Result.success(' Successfully updated.','#alert-prev-job-req');			  		
				} else {
				  	Result.error('<p><span class="glyphicon glyphicon-remove"></span> No changes were made...</p>' , '#alert-prev-job-req');
				}
			  }				
			});	
		});		
	};

	var print_this = function() {
		var data = {
			"jobReqID" : job_req_id
		}

		$.ajax({
			data:data,
			url: 'Fpdf_report/',
			type:"post",	
			success: function(data) { 
				$(".print-this").attr("href", "Fpdf_report/print_job/"+data.jobReqID+"");
				
			}			
		});
	};
	var load_search = function() {
		var data = {
			"data_val" : $('#search-drop').val(),
			"input_field" : $('#search_field').val()
		}

		$.ajax({
			data:data,
			url: 'api/search_by',
			type:"post",	
			success: function(data) { 
				if(data.result !== 0){
					var output = '';	
				  	for(var i = 0; i<data.entry.length; i++) {
				  		output += Template.job(data.entry[i]);
				  	}
				  	$('.job-request-tb').html(output);
				} else {
					Result.empty('No result found...');
				}
			}			
		});			
	}
	var search_drop = function() {
		var search_field = $('#search-field');
		search_field.submit(function(e){
			e.preventDefault();
			load_search();
						
		});	
	};

	var search_keypress = function() {
		$("body").on('keyup', '#search_field', function(){
			load_search();
		});
	};

	this.__construct();
};