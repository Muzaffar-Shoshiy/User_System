<?php


    require_once 'config.php';

    class Auth extends Database{

        // registering new user
        public function register($name, $email, $password){
            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["name"=>$name, "email"=>$email, "password"=>$password]);
            return true;
        }

        // checking user if already registered
        public function user_exist($email){
            $sql = "SELECT email FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["email"=>$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

        // login existing user
        public function login($email){
            $sql = "SELECT email, password FROM users WHERE email = :email AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["email"=>$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        // current users in session
        public function currentUser($email){
            $sql = "SELECT * FROM users WHERE email = :email AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["email"=>$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        // forgot password\
        public function forgot_password($token, $email){
            $sql = "UPDATE users SET token = :token, token_expire = DATE_ADD(NOW(),INTERVAL 10 MINUTE) WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["token"=>$token, "email"=>$email]);

             return true;
        }

        // reset password user auth
        public function reset_pass_auth($email, $token){
            $sql = "SELECT id FROM users WHERE email = :email AND token = :token AND token != '' AND token_expire > NOW() AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["email"=>$email,"token"=>$token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        // update new password
        public function update_new_pass($pass, $email){
            $sql = "UPDATE users SET token = '', password = :pass WHERE email = :email AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["pass"=>$pass,"email"=>$email]);
            return true;
        }

        // add new note
        public function add_new_note($uid, $title, $note){
            $sql = "INSERT INTO notes (uid, title, note) VALUES (:uid, :title, :note)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["uid"=>$uid,"title"=>$title,"note"=>$note]);
            return true;
        }

        // fetch all note of user
        public function get_notes($uid){
            $sql = "SELECT * FROM notes WHERE uid = :uid";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["uid"=>$uid]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        // edit note auth and user
        public function edit_note($id){
            $sql = "SELECT * FROM notes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id"=>$id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        // update the note of an user
        public function update_note($id, $title, $note){
            $sql = "UPDATE notes SET title = :title, note = :note, updated_at = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["title"=>$title,"note"=>$note,"id"=>$id]);
            return true;
        }

        // delete a note
        public function delete_note($id){
            $sql = "DELETE FROM notes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id"=>$id]);
            return true;
        }

        // update profile
        public function update_profile($name,$gender,$dob,$phone,$photo,$id){
            $sql = "UPDATE users SET name = :name, gender = :gender, dob = :dob, phone = :phone, photo = :photo WHERE id = :id AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["name"=>$name,"gender"=>$gender,"dob"=>$dob,"phone"=>$phone,"photo"=>$photo,"id"=>$id,]);
            return true;
        }

        // change pass
        public function change_password($pass,$id){
            $sql = "UPDATE users SET password = :pass WHERE id = :id AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["pass"=>$pass,"id"=>$id]);
            return true;
        }

        // verify email
        public function verify_email($email){
            $sql = "UPDATE users SET verified = 1 WHERE email = :email AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["email"=>$email]);
            return true;
        }

        // send feedback to admin
        public function send_feedback($sub,$feed,$uid){
            $sql = "INSERT INTO feedback (uid, subject, feedback) VALUES (:uid, :sub, :feed)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["uid"=>$uid,"sub"=>$sub,"feed"=>$feed]);
            return true;
        }

        // insert notification
        public function notification($uid,$type,$message){
            $sql = "INSERT INTO notification (uid, type, message) VALUES (:uid, :type, :message)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["uid"=>$uid,"type"=>$type,"message"=>$message]);
            return true;
        }

        // fetch notification
        public function fetchNotification($uid){
            $sql = "SELECT * FROM notification WHERE uid = :uid AND type = 'user'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["uid"=>$uid]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result; 
        }

        // remove notification
        public function removeNotification($id){
            $sql = "DELETE FROM notification WHERE id = :id AND type = 'user'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id"=>$id]);
            return true; 
        }

        
    }

?>