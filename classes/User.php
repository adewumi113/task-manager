<?php

    error_reporting(E_ALL);
    require_once('Db.php');

    class User extends Db{

        private $dbconn;

        public function __construct(){
            $this->dbconn = $this->connect();
        }

        public function get_userbyid($userid){
            //sql
            $sql = "SELECT u.*, t.team_name, jt.job_title_name, ur.role_name FROM users u LEFT JOIN team t ON u.user_team_id = t.team_id LEFT JOIN job_title jt ON u.user_job_title_id = jt.job_title_id LEFT JOIN user_roles ur ON u.user_role_id = ur.role_id WHERE user_id = ?";

            //prepare
            $stmt = $this->dbconn->prepare($sql);

            //execute
            $stmt->execute([$userid]);

            //fetch
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            
            return $user;
        }

        public function create_account($firstname, $lastname, $useremail, $password, $confirm_password, $userdp, $team, $role, $jobtitle){

            if($password == $confirm_password){

                try{
                    //password hashing
                    $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

                    $resp = $this->upload_userdp($userdp);
                    if($resp){
                        #write the query.
                        $query = "INSERT INTO users (user_firstname,	user_lastname,	user_email,	user_password,	user_profile_picture,	user_team_id,	user_role_id,	user_job_title_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                        #prepare the query
                        $stmt = $this->dbconn->prepare($query);

                        #execute
                        $result = $stmt->execute([$firstname, $lastname, $useremail, $hashed_pwd, $resp, $team, $role, $jobtitle]);
                        if($result){
                            $_SESSION['userfeedback'] = "Account created successfully";
                            $userid  = $this->dbconn->lastInsertId();
                            return $userid;
                        }else{
                            $_SESSION['userfeedback'] = "Something went wrong";
                            return false;
                        }
                    }else{
                        $_SESSION['userfeedback'] = "Something went wrong";
                        return false;
                    }

                }catch(PDOException $e){
                    $_SESSION['errormessage'] = "An error occured:" . $e->getMessage();
                    return 0;
                }
                catch(Exception $e){
                    $_SESSION['errormessage'] = "An error occured:" . $e->getMessage();
                    return 0;
                }

            }else{
                $_SESSION['errormessage'] = "Password and Confirm Password must be the same";
                return 0;

            }
        }

        public function upload_userdp($userdp){
            $filename = $userdp['name'];
            $filetype = $userdp['type'];
            $filesize = $userdp['size'];
            $file_tmp_name = $userdp['tmp_name'];

            if($filesize > (2 * 1024 * 1024)){
                $_SESSION["error_message"] = "File is too big, maximum of 2mb allowed.";
                return false;
            }

            $allowed = ["image/jpeg", "image/png", "image/jpg"];

            if(!in_array($filetype, $allowed)){
                $_SESSION["error_message"] = "Image format not valid, please upload a valid image.";
                return false;
            }

            $unique_filename = "taskmasta" . "_" . uniqid(). "_" . $filename;

            $destination = "../uploads/". $unique_filename;

            if(move_uploaded_file($file_tmp_name, $destination)){
                return $unique_filename;
            }else{
                return false;
            }

        }

        public function logout(){
            session_unset();
            session_destroy();
        }

        public function user_login($email, $pwd){
            $query = "SELECT * FROM users WHERE user_email = ?  LIMIT 1";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($records);
            // d
            if($result){
                $hashed_password = $result['user_password'];
                $check = password_verify($pwd, $hashed_password);
                if($check){
                    return $result;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public function update_profile($firstname, $lastname, $email, $teamid, $jobtitleid, $roleid, $userid ){
            $sql = "UPDATE users SET user_firstname = ?, user_lastname = ?, user_email = ?, user_team_id = ?, user_job_title_id = ?, user_role_id = ? WHERE user_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $result = $stmt->execute([$firstname, $lastname, $email, $teamid, $jobtitleid, $roleid, $userid]);
            
            if($result){
                $_SESSION["success_message"] = "Profile updated successfully.";
                return true;
            }else{
                $_SESSION["error_message"] = "Profile update failed.";
                return false;
            }
        }

        public function fetch_userteamunitid($teamid){
            $sql = "SELECT team_unit_id FROM team WHERE team_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$teamid]);
            $unitid = $stmt->fetch(PDO::FETCH_ASSOC);
            return $unitid;
        }

        public function fetch_userunit($unitid){
            $sql = "SELECT unit_name, unit_department_id FROM unit WHERE unit_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$unitid]);
            $unit = $stmt->fetch(PDO::FETCH_ASSOC);
            return $unit;
        }



        public function fetch_userdepartment($deptid){
            $sql = "SELECT department_name, department_division_id FROM department WHERE department_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$deptid]);
            $dept = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dept;
        }

        public function fetch_userdivision($divisionid){
            $sql = "SELECT division_name FROM division WHERE division_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$divisionid]);
            $division = $stmt->fetch(PDO::FETCH_ASSOC);
            return $division;
        }


        public function fetch_allusers(){
            $sql = "SELECT * FROM users WHERE user_role_id = 5";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }

        public function fetch_user_team_members($teamid){
            $sql = "SELECT * FROM users WHERE user_team_id =? AND user_role_id = 5";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$teamid]);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }

    }

    $user1 = new User();

?>