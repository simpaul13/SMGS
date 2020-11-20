<?php 

login_signup();

if(isset($_GET['password'])) {

  $password = escape_string($_GET['password']);
  $completesignup = null;

} else if (isset($_GET['signup'])) {

  $completesignup = escape_string($_GET['signup']);
  $password = null;
  
} else {

  $password = null;
  $completesignup = null;

}


?>

<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-md-6 col-ms-12">
      <div class="card animate__animated animate__zoomIn">
        <div class="card-header d-flex justify-content-center"">
            <h5>Login</h5>
          </div>
          <div class=" card-body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#student">STUDENT</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#teacher">TEACHER</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#admin">ADMIN</a>
            </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <!-- STUDENT LOGIN FORM -->
            <div class="tab-pane container active" id="student">
              <form action="" method="post">
                <div class="row">
                  <div class="col-md-12">
                    <div class="d-flex justify-content-center"">
                        <img src="resources/img/avatar/ninja.svg" class="rounded-circle" alt="Cinque Terre" width="180"
                      height="180">
                    </div>
                    <div class="input-group mt-3 mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 6rem;">Username</span>
                      </div>
                      <input type="text" name="username_student" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 6rem;">Password</span>
                      </div>
                      <input type="password" name="password_student" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between form-row">
                      <button type="submit" name="submit-student" class="btn btn-primary btn-sm"
                        style="width: 6rem;">Login</button>
                      <button type="button" class="btn btn-primary btn-sm" style="width: 6rem;" data-toggle="modal"
                        data-target="#myModal">Sign Up</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- TEACHER LOGIN FORM -->
            <div class="tab-pane container fade" id="teacher">
              <form action="" method="post">
                <div class="row">
                  <div class="col-md-12">
                    <div class="d-flex justify-content-center"">
                        <img src=" resources/img/avatar/pumpkin.svg" class="rounded-circle" alt="Cinque Terre" width="180"
                      height="180">
                    </div>
                    <div class="input-group mt-3 mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 6rem;">Username</span>
                      </div>
                      <input type="text" name="username_teacher" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 6rem;">Password</span>
                      </div>
                      <input type="password" name="password_teacher" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between form-row">
                      <button type="submit" name="submit-teacher" class="btn btn-primary btn-sm"
                        style="width: 6rem;">Login</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- ADMIN LOGIN FORM -->
            <div class="tab-pane container fade" id="admin">
              <form action="" method="post">
                <div class="row">
                  <div class="col-md-12">
                    <div class="d-flex justify-content-center"">
                        <img src="resources/img/avatar/scientist.svg" class="rounded-circle" alt="Cinque Terre" width="180"
                      height="180">
                    </div>
                    <div class="input-group mt-3 mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 6rem;">Username</span>
                      </div>
                      <input type="text" name="username_admin" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 6rem;">Password</span>
                      </div>
                      <input type="password" name="password_admin" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between form-row">
                      <button type="submit" name="submit-admin" class="btn btn-primary btn-sm"
                        style="width: 6rem;">Login</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- STUDENT SIGN UP FORM -->
<form action="" method="post">
  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header d-flex justify-content-center">
          <h4 class="modal-title">Student Sign up</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label for="">Firstname</label>
                <input type="text" name="firstname" class="form-control" required>
               </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Lastname</label>
                <input type="text" name="lastname" class="form-control" required>
               </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Username</label>
                <input type="text" name="username" class="form-control" required>
               </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" required>
               </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" required>
               </div>
            </div>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="submit" name="signup" class="btn btn-primary btn-sm" style="width: 6rem;">Sign Up</button>
          <button type="button" class="btn btn-secondary btn-sm" style="width: 6rem;" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</form>


  <script>
  $(function () {

    if ("<?php echo $password; ?>" == "incorrect") {

      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Username or Password Incorrect'
      })

    } else if ("<?php echo $completesignup; ?>" == "registered") {
      
      Swal.fire({
        icon: 'success',
        title: 'Successful',
        text: 'You Have Successfully Registered'
      })

    } else if ("<?php echo $completesignup; ?>" == "inscribe") {
      
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'It seems ready have registered'
      })

    } else if ("<?php echo $completesignup; ?>" == "username") {
      
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'It Seems username have been Taken'
      })

    } else if ("<?php echo $completesignup; ?>" == "email") {
      
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'It Seems email have been Taken'
      })

    }
  });
  </script>