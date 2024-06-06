<?php
session_start();
include ('includes/header.php');
?>
  <body>
      <div class="py-4">
          <div class="container">
              <div class="row justify-content-center">
                  <div class="col-md-6 col-lg-4">
                      <div class="card mt-5 shadow border border-0">
                          <div class="card-body">
                              <div class="card-title mb-4 m-3">
                                  <h5>Sign Up</h5>
                              </div>
                              <form action="code.php" method="POST">
                                  <div class="form-floating mb-3 m-3">
                                      <input type="text" name="username" class="form-control" id="username"
                                          placeholder="Username" required>
                                      <label for="username">Username</label>
                                  </div>
                                  <div class="form-floating mb-3 m-3">
                                      <input type="email" name="email" class="form-control" id="email" placeholder="Email Address"
                                          required>
                                      <label for="email">Email Address</label>
                                  </div>
                                  <div class="form-floating mb-3 m-3">
                                      <input type="password" name="password" class="form-control form-control-sm" id="password"
                                          placeholder="Password" required>
                                      <label for="password">Password</label>
                                  </div>
                                  <div class="d-grid mt-5 m-3">
                                      <button type="submit" name="register_btn" class="btn btn-outline-info">Register</button>
                                  </div>
                                  <div class="text-center">
                                      <p>Already a member? <a href="login.php" class="link-primary">Sign In</a></p>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    
  </body>
</html>
