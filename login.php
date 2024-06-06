<?php
session_start();
include ('includes/header.php');
?>
<div class="py-4">


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card mt-5 shadow border border-0">
                    <div class="card-body">
                        <div class="card-title mb-4 m-3">
                            <h5>Welcome back</h5>
                        </div>

                        <!-- Display the login form -->
                        <form action="ver.php" method="POST">
                        <?php if (isset($_SESSION['error_message'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $_SESSION['error_message']; ?>
                                </div>
                                <?php
                                unset($_SESSION['error_message']); // Clear the error message after displaying it
                            }
                            ?>
                            <div class="form-floating mb-3 m-3">
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Email Address" required>
                                <label for="email">Email Address</label>
                            </div>
                            <div class="form-floating mb-3 m-3">
                                <input type="password" name="password" class="form-control form-control-sm" id="password"
                                    placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                          
                            <div class="d-grid mt-5 m-3">
                                <button type="submit" name="login_btn" class="btn btn-outline-info">Sign in</button>
                            </div>
                            <div class="text-center">
                                <p>Not a member? <a href="register.php" class="link-primary">Sign Up</a></p>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
