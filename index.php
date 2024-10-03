<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TaskMasta | Task Management Solution</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        * {
            padding: 0px;
            margin: 0px;
        }
    </style>
</head>

<body>

    <!-- Navbar Start -->
    <div class="container-fluid nav-bar bg-light sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white p-3 py-lg-0 px-lg-4">
         
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="assets/images/new-logo.png" alt="Taskmasta" width="130" height="40">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div>
                <a href="login.php" class="btn ">Log in</a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 m-0">
        <div class="row position-relative p-0 m-0">
            <div class="m-0 p-0">
                <img class="img-fluid" src="assets/images/taskmanagement_4.jpg" alt="" style="width:100%; height:75%">
                <div class="position-absolute top-0 start-0 w-100 h-75 d-flex align-items-center" style="background: rgba(0, 0, 0, .4);">
                    <div class="container">
                        <div class="row justify-content-center justify-content-lg-start">
                            <div class="col-12 col-lg-8">
                                <h5 class="text-white  text-uppercase mb-3">Welcome to TaskMasta</h5>
                                <h1 class="display-3 text-white mb-4">An Efficient Task Management Solution</h1>
                                <p class="fs-5 fs-sm-6 fw-medium text-white mb-4 pb-2">TaskMasta offers a cohesive environment that fosters collaboration, enhances efficiency, reduces manual effort, and empowers users to organize and execute tasks effectively across various projects or workflows.</p>
                                <div class="text-center text-lg-start">
                                    <a href="organization/organization_signup.php" class="btn btn-primary py-md-3 px-md-5 me-3">Create organization</a>
                                    <a href="register.php" class="btn btn-success py-sm-3 px-sm-5">Create account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- JavaScript Libraries -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>