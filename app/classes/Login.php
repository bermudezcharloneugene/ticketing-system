<?php

    namespace app\classes;

    use app\utils\Utility;
    use app\utils\Session;
    use app\utils\Query2;
    use Carbon\Carbon;

    class Login
    {
        public $sess_id;
        private $session;
        private $userData;

        public function __construct()
        {
            $this->email = isset($_POST['email']) ? $_POST['email'] : '';
            $this->password = isset($_POST['password']) ? $_POST['password'] : '';
            $this->session = new Session();
        }

        /**
         * FIXED SESSION HANDLING
         * 
         */
        public function login()
        {
            if($this->checkRequest() === false)
            {
                if(count(($this->userData = $this->getUserData($this->email))) > 0)
                {
                    if($this->getUserAttempts($this->userData[0]['USER_ID']))
                    {
                        if($this->hashExists($this->userData))
                        {
                            $this->deleteAllAttempts($this->userData[0]['USER_ID']);
                            $this->session->sessionStart();
                            $this->session->setSession($this->userData[0]['EMAIL'], $this->userData[0]['PASSWORD'], $this->userData[0]['NAME']);
                            return Utility::redirect('../../views/protected/dashboard.php');
                        }else {
                            if($this->getUserAttempts($this->userData[0]['USER_ID']))
                            {
                                $this->insertUserAttempt($this->userData[0]['USER_ID']);
                                echo $this->jsonEncodedResult(['message' => 'Invalid credentials. Please try again!'], true , 401);
                            }
                            else {
                                echo $this->jsonEncodedResult(['message' => 'Locked account!'], true , 401);
                            }
                        }
                    }else {
                        echo $this->jsonEncodedResult(['message' => 'Locked account!'], true , 401);
                    }
                }else {
                    echo $this->jsonEncodedResult(['message' => 'User does not exists'], true , 401);
                }
            }else {
                echo $this->jsonEncodedResult($this->checkRequest(), true , 401);
            }
        }


        /**
         * WILL REFACTOR THIS TO FOLLOW DRY PRINCIPLE
         * 
         */

        private function checkRequest()
        {
            $checkError = Utility::validator($_POST, [
                'email'             => 'required|email',
                'password'          => 'required'
            ]);

            if($checkError !== false)
            {
                $errors = $checkError->errors();
                return $errors->firstOfAll();

            }
                return false;
            
        }

        private function getUserData(String $email)
        {
            $db = new Query2;
            $query = "SELECT * FROM USERS WHERE EMAIL = :email";
            $result = $db->extractData($query, [
                ':email' => $email
            ]);
            
            return $result;
        }

        private function getUserAttempts($id)
        {
            $db = new Query2;
            $query = "SELECT USER_ATTEMPTS.*, USERS.USER_ID
            FROM USERS JOIN USER_ATTEMPTS ON 
            USER_ATTEMPTS.USER_ID_FK = USERS.USER_ID
            WHERE USER_ID_FK = :user_id";

            $result = $db->extractData($query, [
                ':user_id' => $id
            ]);

            return count($result) < 5 ? true : false;
        }
        
        private function hashExists(array $data)
        {

            $salt = $data[0]['SALT'];
            $hash = Utility::hashPassword($this->password, $salt);
            return $hash === $data[0]['PASSWORD'] ? true : false;
        }


        private function insertUserAttempt($id)
        {
            $db = new Query2;
            $now = time();
            $query = "INSERT INTO USER_ATTEMPTS (ATTEMPT_TIME_UNIX, ATTEMPT_DATE, USER_ID_FK) VALUES (:time_now, CURRENT_TIMESTAMP, :user_id)";
            $result = $db->executeQuery($query,[
                ':time_now' => $now,
                ':user_id'  => $id
            ]);
            $db->closeConnection();
            return $result;
        }

        private function deleteAllAttempts($id)
        {
            $db = new Query2;
            $query = "DELETE FROM USER_ATTEMPTS WHERE USER_ID_FK = :user_id";
            $result = $db->executeQuery($query,[
                ':user_id'  => $id
            ]);
            $db->closeConnection();
        }

        private function jsonEncodedResult($errorMessage = '', bool $error = false, int $statusCode = 200)
        {
            return Utility::encodedResult([
                'error' => $error,
                'errorMessage' => $errorMessage
            ], $statusCode);
        }


    }

?>