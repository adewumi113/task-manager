<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/fa/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-6 col-xl-8">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-10 col-lg-5 col-xl-6 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-2 mx-1 mx-md-4 mt-4">Log in</p>
                                    <!-- display error message -->
                                    <?php
                                    if(isset($_SESSION['userfeedback'])){
                                        echo "<div class='alert alert-warning'>" . $_SESSION['userfeedback'] . "</div>";
                                        unset($_SESSION['userfeedback']);
                                    }
                                    require_once "partials/errormessage.php";
                                    ?>
                                    <form class="mx-1 mx-md-4" action="process/process_user_login.php" method="POST" id="loginForm">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" name="useremail" id="useremail" class="form-control" placeholder="Your Email">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="userpassword" id="userpassword" class="form-control" placeholder="Password">
                                            </div>
                                        </div>
                                        <!-- Hidden input for user time zone -->
                                        <input type="hidden" name="usertimezone" id="usertimezone" value="">
                                        <div class="d-flex justify-content-center mx-4 mb-2 mb-lg-4">
                                            <button type="submit" name="userloginbtn" class="btn btn-primary btn-lg">Log in</button>
                                        </div>
                                    </form>
                                    <div>
                                        <a href="" class="text-decoration-none text-primary text-center mt-2">
                                            <p>Forgotten Password?</p>
                                        </a>
                                    </div>
                                    <div class="">
                                        <h5 class="text-center">Don't have an account? </h5>
                                        <h6 class="text-center"><a href="register.php" class="text-decoration-none text-black"><span class="text-primary">Click here to register</span></a></h6>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-4 col-xl-6 d-flex align-items-center order-1 order-lg-2">
                                    <img src="assets/images/tasks1.jpg" class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Get the user's time zone offset
            var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;;

            // Set the value of the hidden input field
            $('#usertimezone').val(userTimeZone);
        });
    </script>
</body>
</html>
