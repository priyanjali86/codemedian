<!DOCTYPE html>
<html>
  <head>
    
    <title>CoreUI Free Bootstrap Admin Template</title>
    <!-- Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
    <link href="<?php echo $baseurl;?>assets/css/style.css" rel="stylesheet">
    
  </head>
  <body class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Admin Login</h1>
                <p class="text-muted">Sign In to your account</p>
                <form method="post" action="<?php echo $baseurl;?>DoLoginAdmin">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-user"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" name="UserName" placeholder="Username" required>
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-lock"></i>
                    </span>
                  </div>
                  <input class="form-control" type="password" name="Password" placeholder="Password" required>
                </div>
                <div class="row">
                  <div class="col-6">
                    <!-- <button class="btn btn-primary px-4" type="button">Login</button> -->
                    <input type="submit" class="btn btn-primary px-4" value="Login">
                  </div>
                  <div class="col-6 text-right">
                    <button class="btn btn-link px-0" type="button">Forgot password?</button>
                  </div>
                </div>
              </form>
              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <h2></h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>                  
                  <!-- <a href="<?php echo $baseurl;?>show_sign_up_form" class="btn btn-primary active mt-3">Register Now!</a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </body>
</html>
