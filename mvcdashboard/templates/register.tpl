<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin 2 - Register</title>
  <!-- Custom fonts for this template-->
  <link href="../../mvcdashboard/public/admin_assests/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../mvcdashboard/public/admin_assests/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
        <div class="col-lg-7">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
            </div>
            <form action="register" method="POST" class="user">
              {* {$smarty.block.parent} *}
              <div class="form-group">
                <input name="name" type="text" class="form-control form-control-user {if isset($smarty.request.name) && $smarty.request.name == ''}is-invalid{/if}" id="exampleInputName" placeholder="Name">
                {if isset($smarty.request.name) && $smarty.request.name == ''}
                  <span class="invalid-feedback">Name is required</span>
                {/if}
              </div>
              <div class="form-group">
                <input name="email" type="email" class="form-control form-control-user {if isset($smarty.request.email) && $smarty.request.email == ''}is-invalid{/if}" id="exampleInputEmail" placeholder="Email Address">
                {if isset($smarty.request.email) && $smarty.request.email == ''}
                  <span class="invalid-feedback">Email is required</span>
                {/if}
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input name="password" type="password" class="form-control form-control-user {if isset($smarty.request.password) && $smarty.request.password == ''}is-invalid{/if}" id="exampleInputPassword" placeholder="Password">
                  {if isset($smarty.request.password) && $smarty.request.password == ''}
                    <span class="invalid-feedback">Password is required</span>
                  {/if}
                </div>
                <div class="col-sm-6">
                  <input name="password_confirmation" type="password" class="form-control form-control-user {if isset($smarty.request.password_confirmation) && $smarty.request.password_confirmation == ''}is-invalid{/if}" id="exampleRepeatPassword" placeholder="Repeat Password">
                  {if isset($smarty.request.password_confirmation) && $smarty.request.password_confirmation == ''}
                    <span class="invalid-feedback">Password confirmation is required</span>
                  {/if}
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="/mvcdashboard/login">Already have an account? Login!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="../../mvcdashboard/public/admin_assests/vendor/jquery/jquery.min.js"></script>
<script src="../../mvcdashboard/public/admin_assests/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../mvcdashboard/public/admin_assests/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../mvcdashboard/public/admin_assests/js/sb-admin-2.min.js"></script>
</body>
</html>
