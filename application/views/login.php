<div class="container">
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="login-form">
      <div id="alert-login"></div>
        <div class="panel panel-default">
          <div class="logo-img"><img src="<?= base_url()?>/assets/img/logo.jpg" class="logo-style"></div>
          <div class="logo-heading"><center><h4>Information Management System</h4></center></div>
          <div class="panel-body">
            <form id = "login-form">
              <div class="form-group">
                <label for="username"><span class="glyphicon glyphicon-user"></span> Username :</label>
                <input type="text" class="form-control" id="username">
              </div>
              <div class="form-group">
                <label for="pwd"><span class="glyphicon glyphicon-lock"></span> Password :</label>
                <input type="password" class="form-control" id="pwd">
              </div>
              <button type="submit" class="btn btn-danger">Submit</button>
            </form><!-- End of login form  -->            
          </div><!-- End of panel-body -->
        </div>         
      </div>  
    </div><!-- End of col-md-6 -->
    <div class="col-md-4">
    </div>
  </div>
</div>
<script type="text/javascript">
  var form_login = $('#login-form');
  form_login.submit(function(e){
    e.preventDefault();
    var data = {
      "username" : $('#username').val(),
      "password" : $('#pwd').val()
    }
    $.ajax({
      data:data,
      url:"<?= site_url('login/login_process')?>",
      type:"post",
      dataType:"json",
      success: function(data) {
        if(data.result == 0) {
          if ($('#alert-login').is(':hidden')){
            $('#alert-login').fadeIn();
            $('#alert-login').html('<div class="alert-error-box"><p><span class="glyphicon glyphicon-remove"></span> Invalid credentials. Please try again.</p></div>');
            $('#alert-login').delay(2000).fadeOut();
          }
        } else {
          window.location.href = '<?= site_url('menu') ?>'
        }
      }
    });
  });
</script>
