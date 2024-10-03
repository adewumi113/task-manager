<?php
  require_once "partials/header.php";
  require_once "classes/Role.php";
  require_once "classes/Team.php";
  require_once "classes/Job.php";
  $teamunitid = $user["user_team_id"];
  $team_unit = $user1->fetch_userteamunitid($teamunitid);
  $user_unit = $user1->fetch_userunit($team_unit["team_unit_id"]);
  $user_dept = $user1->fetch_userdepartment($user_unit["unit_department_id"]);
  $user_division = $user1->fetch_userdivision($user_dept["department_division_id"]);
  $roles = $role->fetch_allroles();
  $teams = $team->fetch_allteams();
  $jobs = $job->fetch_alljobs();

?>

    <!-- ======= Sidebar ======= -->
    <?php
        require_once "partials/sidebar2.php"
    ?>
    <!-- End Sidebar-->

    <main id="main" class="main">

      <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Users</li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </nav>
        <?php
              require_once "partials/successmessage.php";
          ?>
          <?php
              require_once "partials/errormessage.php";
          ?>
          <p id="feedback"></p>
      </div><!-- End Page Title -->

      <section class="section profile">
        <div class="row">
          <div class="col-xl-4">

            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                <img src="uploads/<?php echo $user["user_profile_picture"]?>" alt="Profile" class="rounded-circle">
                <h2><?php echo $user["user_firstname"] . " " . $user["user_lastname"]?></h2>
                <h3><?php echo $user["job_title_name"]?></h3>
              </div>
            </div>

          </div>

          <div class="col-xl-8">

            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                  </li>
<!-- 
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                  </li> -->

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                  </li>

                </ul>
                <div class="tab-content pt-2">

                  <div class="tab-pane fade show active profile-overview" id="profile-overview">

                    <h5 class="card-title">Profile Details</h5>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Full Name</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user["user_firstname"] . " " . $user["user_lastname"]?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Division</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user_division["division_name"] ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Department</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user_dept["department_name"] ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Unit</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user_unit["unit_name"] ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Team</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user["team_name"]?></div>
                    </div>

                    <div class="row">
                      <?php if($user['user_role_id'] < 5){ ?>
                        <div class="col-lg-3 col-md-4 label">Supervisor</div>
                        <div class="col-lg-9 col-md-8"><?php echo $_SESSION["user_teamlead"]?></div>
                        <?php }else{ ?>
                        <div class="col-lg-3 col-md-4 label">Team Lead</div>
                        <div class="col-lg-9 col-md-8"><?php echo $_SESSION["user_teamlead"]?></div>
                      <?php } ?>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Job Role</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user["job_title_name"]?></div>
                    </div>

                    <h5 class="card-title">Contact Details</h5>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user["user_email"]?></div>
                    </div>

                  </div>

                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <!-- Profile Edit Form -->
                    <form action="process/process_user_profileupdate.php" method="POST" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-8 col-lg-9">
                          <img src="uploads/<?php echo $user["user_profile_picture"]?>" alt="Profile">
                          <div class="pt-2">
                            <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="fa fa-upload"></i></a>
                            <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="fa fa-trash"></i></a>
                          </div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="firstname" class="col-md-4 col-lg-3 col-form-label">Firstname</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="firstname" type="text" class="form-control" id="firstname" value="<?php echo $user["user_firstname"]?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Lastname</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="lastname" type="text" class="form-control" id="lastname" value="<?php echo $user["user_lastname"]?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="email" type="text" class="form-control" id="email" value="<?php echo $user["user_email"]?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="userteam" class="col-md-4 col-lg-3 col-form-label">Team</label>
                        <div class="col-md-8 col-lg-9">
                          <select class="form-control w-50" id="team_id" name="team_id">

                            <?php foreach ($teams as $team) {
                            
                              $selectedteam = ($team['team_name'] == $user["team_name"]) ? 'selected' : '';
                            ?>  
                            <option value="<?php echo $team['team_id'] ?>" <?php echo $selectedteam  ?>> <?php echo $team['team_name'] ?></option>
                      
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="userrole" class="col-md-4 col-lg-3 col-form-label">Role</label>
                        <div class="col-md-8 col-lg-9">
                        
                          <select class="form-control w-50" id="role_id" name="role_id">

                            <?php foreach ($roles as $role) {
                            
                              $selectedrole = ($role['role_name'] == $user["role_name"]) ? 'selected' : '';
                            ?>  
                            <option value="<?php echo $role['role_id'] ?>" <?php echo $selectedrole  ?>> <?php echo $role['role_name'] ?></option>
                      
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      

                      <div class="row mb-3">
                        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job Title</label>
                        <div class="col-md-8 col-lg-9">
                          <select class="form-control w-50" id="job_title_id" name="job_title_id">

                            <?php foreach ($jobs as $job) {
                            
                              $selectedjob = ($job['job_title_name'] == $user["job_title_name"]) ? 'selected' : '';
                            ?>  
                            <option value="<?php echo $job['job_title_id'] ?>" <?php echo $selectedjob  ?>> <?php echo $job['job_title_name'] ?></option>
                      
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" id="updatebtn"name="updatebtn" value="updatebtn" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form><!-- End Profile Edit Form -->

                  </div>

                  <!-- <div class="tab-pane fade pt-3" id="profile-settings"> -->

                    <!-- Settings Form -->
                    <!-- <form>

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                        <div class="col-md-8 col-lg-9">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="changesMade" checked>
                            <label class="form-check-label" for="changesMade">
                              Changes made to your account
                            </label>
                          </div> -->
                          <!-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="newProducts" checked>
                            <label class="form-check-label" for="newProducts">
                              Information on new products and services
                            </label>
                          </div> -->
                          <!-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="proOffers">
                            <label class="form-check-label" for="proOffers">
                              Marketing and promo offers
                            </label>
                          </div> -->
                          <!-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                            <label class="form-check-label" for="securityNotify">
                              Security alerts
                            </label>
                          </div> -->
                        <!-- </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form>
                    <-- End settings Form -->

                  <!-- </div> --> 

                  <div class="tab-pane fade pt-3" id="profile-change-password">
                    <!-- Change Password Form -->
                    <form>

                      <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="password" type="password" class="form-control" id="currentPassword">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="newpassword" type="password" class="form-control" id="newPassword">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                      </div>
                    </form><!-- End Change Password Form -->

                  </div>

                </div><!-- End Bordered Tabs -->

              </div>
            </div>

          </div>
        </div>
      </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
      require_once "partials/footer.php";
    ?>
    <!-- End Footer -->
    </body>
</html>