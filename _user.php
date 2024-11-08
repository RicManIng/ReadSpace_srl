<?php

    namespace MyUsers;

    class User {
        protected $username = null;
        protected $password = null;
        protected $email = null;
        protected $name = null;
        protected $surname = null;
        protected $birthDate = [];
        protected $mie_recensioni = [];

        public function set_username($value){
            $temp = htmlspecialchars(trim($value));
            if (is_string($temp) && strlen($temp) <= 20){
                $this->username = $temp;
                return 1;
            } else {
                return 0;
            }
        }

        public function get_username(){
            return $this->username;
        }

        public function username_exists($value, $file){
            $UserDatabase = json_decode(file_get_contents($file), true);
            foreach ($UserDatabase as $key => $user) {
                if($user['username'] == $value){
                    return 1;
                }
            }
            return 0;
        }

        public function set_password($value){
            $temp = htmlspecialchars(trim($value));
            if (is_string($temp) && strlen($temp) >= 8 && strlen($temp) <= 20){
                $this->password = $temp;
                return 1;
            } else {
                return 0;
            }
        }

        public function get_password(){
            return $this->password;
        }

        public function set_email($value){
            if (filter_var($value, FILTER_VALIDATE_EMAIL)){
                $this->email = $value;
                return 1;
            } else {
                return 0;
            }
        }

        public function get_email(){
            return $this->email;
        }

        public function email_exists($value, $file){
            $UserDatabase = json_decode(file_get_contents($file), true);
            foreach ($UserDatabase as $key => $user) {
                if($user['email'] == $value){
                    return 1;
                }
            }
            return 0;
        }

        public function set_name($value){
            $temp = htmlspecialchars(trim($value));
            if (is_string($temp) && strlen($temp) <= 50){
                $this->name = $temp;
                return 1;
            } else {
                return 0;
            }
        }

        public function get_name(){
            return $this->name;
        }

        public function set_surname($value){
            $temp = htmlspecialchars(trim($value));
            if (is_string($temp) && strlen($temp) <= 50){
                $this->surname = $temp;
                return 1;
            } else {
                return 0;
            }
        }

        public function get_surname(){
            return $this->surname;
        }

        public function set_birthDate($giorno, $mese, $anno){
            if (is_numeric($giorno) && is_numeric($mese) && is_numeric($anno)){
                if(checkdate($mese, $giorno, $anno)){
                    $this->birthDate = ['giorno' => $giorno, 'mese' => $mese, 'anno' => $anno];
                    return 1;
                } else {
                    return 0;
                }
            }
            else {
                return 0;
            }
        }

        public function get_birthDate(){
            return $this->birthDate;
        }

        public function user_save($file){
            $UserDatabase = json_decode(file_get_contents($file), true);
            $user_found = false;
            foreach ($UserDatabase as $key => $user) {
                if($user['username'] == $this->username){
                    $UserDatabase[$key] = ['username' => $this->username, 'password' => $this->password, 'email' => $this->email, 'name' => $this->name, 'surname' => $this->surname, 'birthDate' => $this->birthDate];
                    $user_found = true;
                }
            }
            if(!$user_found){
                array_push($UserDatabase, ['username' => $this->username, 'password' => $this->password, 'email' => $this->email, 'name' => $this->name, 'surname' => $this->surname, 'birthDate' => $this->birthDate]);
            }
            file_put_contents($file, json_encode($UserDatabase));
        }

        public function check_login($username, $password, $file_user){
            $UserDatabase = json_decode(file_get_contents($file_user), true);
            foreach ($UserDatabase as $key => $user) {
                if($user['username'] == $username && $user['password'] == $password){
                    $this->set_username($user['username']);
                    $this->set_password($user['password']);
                    $this->set_email($user['email']);
                    $this->set_name($user['name']);
                    $this->set_surname($user['surname']);
                    $this->set_birthDate($user['birthDate']['giorno'], $user['birthDate']['mese'], $user['birthDate']['anno']);
                    return 1;
                }
            }
            return 0;
        }
    }
?>