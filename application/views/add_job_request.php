<div class="container" id = "content">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default panel-add-job">
        <div class="panel-heading"><label><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Job request</label></div>
        <div class="panel-body"> 
          <div class="tool-bar">
            <div class="add-new"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-add-job"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> New job (F1)</button></div>
              <label class="search-label">Search by :</label>
               <form id = "search-field" action="<?= site_url('api/search_by')?>">
                  <div class="form-group search-by">
                    <select class="form-control" id="search-drop">
                      <option value="1">Customer name</option>
                      <option value="2">Job request #</option>
                      <option value="3">Company</option>
                      <option value="4">Faults</option>
                      <option value="5">Item</option>
                      <option value="6">Brand</option>
                      <option value="7">Model</option>
                      <option value="8">Received</option>
                      <option value="9">Contact Number</option>
                    </select>
                  </div> 
                  <div class="form-group form-search-field">
                    <input type="text" class="form-control" id="search_field" placeholder="Enter details">
                  </div>
                  <input type="submit" class="btn btn-danger btn-sm btn-search" value="Search">
                </form>
                <div class="form-record-count">
                  <label>Record Count : </label>
                </div>                             
              <div class="clear-fix"></div>          
          </div>
          <div class="list-of-job-request"> 
            <label><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Records</label>  
            <table class="table table-striped table-bordered table-responsive">
              <thead>
                <tr>
                  <th>Job Request #</th>
                  <th>Customer name</th>
                  <th>Company</th>
                  <th>Fault(s)</th>
                  <th>Item</th>
                  <th>Brand</th>
                  <th>Model</th>
                  <th>Received</th>
                  <th>Number</th>
                  <th>Cost</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="job-request-tb">
            
              </tbody>
            </table>          
          </div>          
        </div>
      </div>      
    </div>
  </div>
  <!-- Add a job modal -->
  <div class="modal fade" id="modal-add-job" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-custom">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h4 class="modal-title">Add Job Request</h4></center>
        </div>
        <div class="modal-body">
          <div id="alert-job-req"></div>
          <div class="row">
            <form id="add-job-request" action="<?= site_url('api/add_job_request')?>">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="job-request-no">Job Request No. :</label>
                <input type="text" class="form-control form-trims" id="job_request_no" disabled>
              </div>
              <div class="form-group">
                <label for="name">Customer name :</label>
                <input type="text" class="form-control form-trims" id="name" name="name">
              </div>
              <div class="form-group">
                <label for="company">Company if any :</label>
                <input type="text" class="form-control form-trims" id="company">
              </div>   
              <div class="form-group">
                <label for="contact-no">Contact no :</label>
                <input type="text" class="form-control form-trims" id="contact-no">
              </div>                                                                         
            </div> <!-- End of col sm-6 -->
            <div class="col-sm-6">  
              <div class="form-group">
                <label for="product-name">Item :</label>
                <input type="text" class="form-control form-trims" id="prod-item">
              </div>                      
              <div class="form-group">
                <label for="product-name">Brand :</label>
                <input type="text" class="form-control form-trims" id="prod-name">
              </div>
              <div class="form-group">
                <label for="model">Model :</label>
                <input type="text" class="form-control form-trims" id="prod-model">
              </div>
              <div class="form-group">
                <label for="fault">Fault(s) :</label>
                <textarea class="form-control form-trims"  id="faults"></textarea>
              </div> 
              <div class="form-group">
                <label for="fault">Notes :</label>
                <textarea class="form-control form-trims"  id="notes"></textarea>
              </div>                           
              <div class="form-group">
                <label for="cost">Cost of repair ($) :</label>
                <input type="text" class="form-control form-trims" id="cost">
              </div>
              <div class="form-group">
                <label for="received-by">Received by :</label>
                <input type="text" class="form-control form-trims" id="pwd" value="<?= $this->session->userdata('userfullname'); ?>" disabled>
              </div>                                                                 
            </div><!-- End of col sm-6 -->
            <input type="submit" class="btn btn-danger btn-add-job-req" value="Submit">
            </form> <!-- End of form -->        
          </div>
        </div>
      </div>
    </div>
  </div><!-- End of modal -->
  <!-- Preview modal -->
  <div class="modal fade" id="modal-prev-job" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-custom">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h4 class="modal-title">Preview job</h4></center>
        </div>
        <div class="modal-body">
        <div id="alert-prev-job-req"></div>
          <div class="row">
              <form id = "prev_job">
              </form>                       
          </div><!-- End of col sm-6 -->
        </div>
      </div>
    </div>
  </div><!-- End of preview -->  
</div>
<script type="text/javascript">
$(function(){
  var dashboard = new Dashboard();
});
  shortcut.add("F1",function() {
    $('#modal-add-job').modal({
      show: 'true'
    });
    generate_job_request();
  }); 
  // End of shortcut f1
  $('#modal-add-job').on('shown.bs.modal', function(e) {
    $('#name').focus();
    generate_job_request();
  });  
  // End of Focus customer name
  var job_request_no;
  function generate_job_request(){
    var jrn_number = $('#job_request_no');   
    $.ajax({
      url: "<?= site_url('api/generate_request_no')?>",
      type:"post",
      dataType:"json",   
        success: function(data) {         
            var formatted_id = data.last_id;
            jrn_number.val(formatted_id);
            job_request_no = formatted_id;
        }    
    });
  }// End of generate_job_request
  
  // var add_job_request = $('#add-job-request');
  // add_job_request.submit(function(e){
  //   e.preventDefault();
  //     var data = {
  //       'name' : $('#name').val(),
  //       'company' : $('#company').val(),
  //       'faults' : $('#faults').val(),
  //       'prod-name' : $('#prod-name').val(),
  //       'prod-model' : $('#prod-model').val(),
  //       'contact-no' : $('#contact-no').val(),
  //       'cost' : $('#cost').val(),
  //       'job-req-no' : job_request_no
  //     }
  //     $.ajax({
  //         data:data,
  //         url: "<?= site_url('api/add_job_request')?>",
  //         type:"post",
  //         dataType:"json",   
  //         success: function(data) { 
  //          if(data.result == 0){
  //           if($('#alert-job-req').is(':hidden')){
  //             $('#alert-job-req').fadeIn();
  //             $('#alert-job-req').html('<div class = "alert-error-box">'+data.error+'');
  //             $('#alert-job-req').delay(2000).fadeOut();
  //           }
  //          } else {
  //             $('#alert-job-req').fadeIn();
  //             $('#alert-job-req').html('<div class = "alert-success-box"><p><span class="glyphicon glyphicon-ok"></span> Successfully added job request...</p></div>');
  //             $('#alert-job-req').delay(2000).fadeOut();
  //             add_job_request[0].reset();    
  //             generate_job_request();             
  //          }
  //         }         
  //     }); 
  // }); // End of for job request
</script>
