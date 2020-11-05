<?php 

  login();
  

?>

<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-md-6 col-ms-12">
        <div class="card animate__animated animate__zoomIn">
          <div class="card-header d-flex justify-content-center"">
            <h5>Login</h5>
          </div>
          <div class="card-body">
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
              <div class="tab-pane container active" id="student">
                <form action="" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="d-flex justify-content-center"">
                        <img src="img/avatar/ninja.svg" class="rounded-circle" alt="Cinque Terre" width="180" height="180"> 
                      </div>
                      <div class="input-group mt-3 mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="width: 6rem;">Username</span>
                        </div>
                        <input type="text" name="username_student" class="form-control">
                      </div>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="width: 6rem;">Password</span>
                        </div>
                        <input type="password" name="password_student" class="form-control">
                      </div>
                      <div class="d-flex justify-content-between form-row">
                        <button type="submit" name="submit-student" class="btn btn-primary btn-sm" style="width: 6rem;">Login</button>
                        <button type="submit" name="submit-student" class="btn btn-primary btn-sm" style="width: 6rem;">Sign Up</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane container fade" id="teacher">
                <form action="" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="d-flex justify-content-center"">
                        <img src="img/avatar/pumpkin.svg" class="rounded-circle" alt="Cinque Terre" width="180" height="180"> 
                      </div>
                      <div class="input-group mt-3 mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="width: 6rem;">Username</span>
                        </div>
                        <input type="text" name="username_teacher" class="form-control">
                      </div>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="width: 6rem;">Password</span>
                        </div>
                        <input type="password" name="password_teacher" class="form-control">
                      </div>
                      <div class="d-flex justify-content-between form-row">
                        <button type="submit" name="submit-teacher" class="btn btn-primary btn-sm" style="width: 6rem;">Login</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane container fade" id="admin">
                <form action="" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="d-flex justify-content-center"">
                        <img src="img/avatar/scientist.svg" class="rounded-circle" alt="Cinque Terre" width="180" height="180"> 
                      </div>
                      <div class="input-group mt-3 mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="width: 6rem;">Username</span>
                        </div>
                        <input type="text" name="username_admin" class="form-control">
                      </div>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="width: 6rem;">Password</span>
                        </div>
                        <input type="password" name="password_admin" class="form-control">
                      </div>
                      <div class="d-flex justify-content-between form-row">
                        <button type="submit" name="submit-admin" class="btn btn-primary btn-sm" style="width: 6rem;">Login</button>
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

  <script>
  $(function(){
    if("<?php echo $_GET['password']?>" == "incorrect"){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Username or Password Incorrect'
      })
    }
  }); 
  </script>