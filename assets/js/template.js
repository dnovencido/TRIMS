var Template = function(){
	this.__construct = function(){
		console.log("Template initialized");
	};

	this.job = function(obj){
		var output = '';
		output += '<tr class = "prev_job-'+obj.jobReqID+'">'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.jobReqNo)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.name)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.company)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.fault)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.product_item)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.product)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.model)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.full_name)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.contact)+'</div></td>'+
			'<td><div class = "td_class">'+Validations.empty_field(obj.cost)+'</div></td>'+
			'<td><button id = "btn-prev-job" type="button" class="btn btn-success btn-xs" data-id = '+obj.jobReqID+' data-toggle="modal" data-target="#modal-prev-job"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> Preview</button></td>'+
		'</tr>';
		return output;
	};

	this.update_job = function(obj){
		var output = '';
		output += '<td>'+Validations.empty_field(obj.jobReqNo)+'</td>'+
			'<td>'+Validations.empty_field(obj.name)+'</td>'+
			'<td>'+Validations.empty_field(obj.company)+'</td>'+
			'<td>'+Validations.empty_field(obj.fault)+'</td>'+
			'<td>'+Validations.empty_field(obj.product_item)+'</td>'+
			'<td>'+Validations.empty_field(obj.product)+'</td>'+
			'<td>'+Validations.empty_field(obj.model)+'</td>'+
			'<td>'+Validations.empty_field(obj.full_name)+'</td>'+
			'<td>'+Validations.empty_field(obj.contact)+'</td>'+
			'<td>'+Validations.empty_field(obj.cost)+'</td>'+
			'<td><button id = "btn-prev-job" type="button" class="btn btn-success btn-xs" data-id = '+obj.jobReqID+' data-toggle="modal" data-target="#modal-prev-job"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> Preview</button></td>';
		return output;
	};

	this.job_prev = function(obj){
		var output = '';
		output += '<div class = "col-sm-12 prev-job-tools">'+
		'<button type="button" class="btn btn-warning btn-sm btn-edit-job"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Edit </button>'+
		'<button type="button" class="btn btn-danger btn-sm btn-delete-job"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete </button>'+
		'<button type="button" class="btn btn-danger btn-sm cancel-job"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel </button>'+
		'<input type = "submit" class="btn btn-success btn-sm save-job" value = "Save">'+
		'<a href = "#" class = "print-this" target="_blank" data-title="Print job"><span class="glyphicon glyphicon-print"></span> Print job</a>'+
		'</div>'
		output += '<div class="col-sm-6">'+
              '<div class="form-group">'+
                '<label for="job-request-no">Job Request No. :</label>'+
                '<input type="text" class="form-control" id="job_request_no" value = "'+obj.jobReqNo+'" disabled>'+
              '</div>'+
              '<div class="form-group">'+
                '<label for="name">Customer name :</label>'+
                '<input type="text" class="form-control form-trims-prev" id="prev_name" name="name" value = "'+obj.name+'" disabled>'+
              '</div>'+
              '<div class="form-group">'+
                '<label for="company">Company :</label>'+
                '<input type="text" class="form-control form-trims-prev" id="prev_company" value = "'+obj.company+'" disabled>'+
              '</div>'+ 
              '<div class="form-group">'+
                '<label for="contact-no">Contact no :</label>'+
                '<input type="text" class="form-control form-trims-prev" id="prev_contact-no" value = "'+obj.contact+'" disabled>'+
              '</div>'+                                                                        
            '</div> <!-- End of col sm-6 -->'+
            '<div class="col-sm-6">'+  
              '<div class="form-group">'+
                '<label for="product-name">Item:</label>'+
                '<input type="text" class="form-control form-trims-prev" id="prev_prod-item" value = "'+obj.product_item+'"  disabled>'+
              '</div>'+                     
              '<div class="form-group">'+
                '<label for="product-name">Brand :</label>'+
                '<input type="text" class="form-control form-trims-prev" id="prev_prod-name" value = "'+obj.product+'" disabled>'+
              '</div>'+
              '<div class="form-group">'+
                '<label for="model">Model :</label>'+
                '<input type="text" class="form-control form-trims-prev" id="prev_prod-model" value = "'+obj.model+'" disabled>'+
              '</div>'+
              '<div class="form-group">'+
                '<label for="fault">Fault(s) :</label>'+
                '<textarea class="form-control form-trims-prev"  id="prev_faults" disabled>'+obj.fault+'</textarea>'+
              '</div>'+    
              '<div class="form-group">'+
                '<label for="cost">Technician Details :</label>'+
                '<textarea class="form-control form-trims-prev"  id="prev_faults" disabled></textarea>'+
              '</div>'+                       
              '<div class="form-group">'+
                '<label for="cost">Cost of repair :</label>'+
                '<input type="text" class="form-control form-trims-prev" id="prev_cost" value = "'+obj.cost+'" disabled>'+
              '</div>'+
              '<div class="form-group">'+
                '<label for="received-by">Received by :</label>'+
                '<input type="text" class="form-control form-trims" id="pwd" value="'+obj.full_name+'" disabled>'+
              '</div>';

        return output;
	}

	this.__construct();
}
