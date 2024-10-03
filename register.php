<?php

session_start();

require_once "classes/Team.php";
require_once "classes/Role.php";
require_once "classes/Job.php";

$teams = $team->fetch_allteams();
$roles = $role->fetch_allroles();
$jobs = $job->fetch_alljobs();

// print_r($teams);
// die();


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TaskMasta | Create Organization</title>
        <link rel="stylesheet" href="assets/css/fa/css/all.min.css">
        <link rel="stylesheet" href="assets/css/bootstrap/css/bootstrap.min.css">
        <style>
            *{
                margin:0px;
                padding:0px;
            }
        </style>
    </head>
    <body>
        <section class="vh-100" style="background-color: #eee;">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="card text-black" style="border-radius: 25px;">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-5 col-xl-6  order-2 order-lg-1">
                                    <?php
                                        require_once "partials/errormessage.php";
                                    ?>
                                        <p class="text-center h3 fw-bold mb-3 mx-1 mx-md-4">Create Account</p>
                                        <form class="mx-1 mx-md-4" action="process/process_user_signup.php" method="post" enctype="multipart/form-data">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Firstname">
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Lastname">
                                                </div>
                                            </div>
                        
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="email" id="useremail" name="useremail" class="form-control"placeholder="Email">
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                <select name="team" id="team" class="form-control">
                                                    <option value="">Select team</option>
                                                    <?php 
                                                        foreach($teams as $team){
                                                    ?>
                                                        <option value="<?php echo $team["team_id"]; ?>"><?php echo $team["team_name"]; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                <select name="role" id="role" class="form-control">
                                                    <option value="">Select role</option>
                                                    <?php 
                                                        foreach($roles as $role){
                                                    ?>
                                                        <option value="<?php echo $role["role_id"]; ?>"><?php echo $role["role_name"]; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                                </div>
                                            </div>


                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                <select name="jobtitle" id="jobtitle" class="form-control">
                                                    <option value="">Select job title</option>
                                                    <?php 
                                                        foreach($jobs as $job){
                                                    ?>
                                                        <option value="<?php echo $job["job_title_id"]; ?>"><?php echo $job["job_title_name"]; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label" for="userdp">Upload Profile Picture</label>
                                                    <input type="file" id="userdp" name="userdp" class="form-control">
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                                </div>
                                            </div>
                        
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Confirm password">
                                                </div>
                                            </div>
                    
                        
                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-2">
                                                <button type="submit" name="btn_submit"  class="btn btn-primary btn-lg">Create account</button>
                                            </div>
                                        </form>

                                        <div class="">
                                            <h5 class="text-center">Already have an account? <a href="login.php" class="text-decoration-none text-black"><span class="text-primary">Login</span></a></h5>
                                        </div>
                    
                                    </div>
                                    <div class="col-md-10 col-lg-4 col-xl-6 d-flex align-items-center  d-none d-md-block order-lg-2">
                                    <img src="assets/images/task-management.jpeg" class="img-fluid" alt="Sample image">
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>