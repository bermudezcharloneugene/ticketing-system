<?php

    namespace app\classes;

    use app\utils\Utility;
    use app\utils\Session;
    use app\utils\Query as DB;
    use Rakit\Validation\Validator;

    class ChangePassword {

        private $newPassword;
        private $userPassword;
        private $userSalt;
        private $oldPassword;
        private $userId;
        private $hashedPassword;
        private $newHashedPassword;


        public function __construct() 
        {
            $this->oldPassword = isset($_POST['old_password']) ? $_POST['old_password'] : '';
            $this->newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            $this->confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        }

        public function index() 
        {
            $validator = new Validator;

            $validation = $validator->make($_POST, [
                'old_password'      => 'required|min:8|alpha_num',
                'new_password'      => 'required|min:8|alpha_num',
                'confirm_password'  => 'required|min:8|alpha_num|same:new_password'
            ]);

            $validation->validate();

            if($validation->fails()) 
            {
                $errors = $validation->errors();
                return $this->jsonEncodedResult($errors->firstOfAll(), true, 401);

            } else {
                
                $userData = $this->getUserData($_SESSION['email']);
                $this->userSalt = $userData[0]['SALT'];
                $this->userPassword = $userData[0]['PASSWORD'];
                $this->userId = $userData[0]['USER_ID'];
                
                if($this->compareCredentials())
                {
                    if($this->resetCredentials())
                    {
                        $session = new Session;

                        if($session->setSession($userData[0]['EMAIL'], $this->newHashedPassword, $userData[0]['NAME'])) {
                            return $this->jsonEncodedResult();
                        }
                        return $this->jsonEncodedResult('An error occured please try again!', true, 401);
                    }
                    
                } else {
                    return $this->jsonEncodedResult('Please use your old password', true, 401);
                }
            }
        }

        private function resetCredentials()
        {
            $salt = Utility::generateKey();
            $this->newHashedPassword = Utility::hashPassword($this->newPassword, $salt);
            $db = new DB;
            $query = "UPDATE USERS SET PASSWORD = :password, SALT = :salt WHERE USER_ID = :user_id";
            $result = $db->executeQuery($query, [
                ':password' => $this->newHashedPassword,
                ':salt'     => $salt,
                ':user_id'  => $this->userId
            ]);

            return $result;
        }

        private function getUserData($email)
        {
            $db = new DB;
            $query = "SELECT * FROM USERS WHERE EMAIL = :email";
            $result = $db->extractData($query, [
                ':email'    => $email
            ]);

            return $result;
        }

        private function compareCredentials()
        {
            $this->hashedPassword= Utility::hashPassword($this->oldPassword, $this->userSalt);
            return $this->userPassword === $this->hashedPassword ? true : false;

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