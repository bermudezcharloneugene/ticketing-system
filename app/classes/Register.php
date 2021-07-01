<?php
    /**
     * 
     declare(strict_types=1);
     * 
     *  */    

    namespace app\classes;

    use app\config\Connection;
    use app\utils\Query as DB;
    use app\utils\Utility;
    use app\utils\Validate as Request;

    Class Register extends Utility
    {   
        public $name;
        public $email;
        public $password;
        public $confirm_password;
        public $salt;

        protected const DOMAIN = ['philpacs.com', 'lbp.com'];

        public function __construct() 
        {
            $this->name = isset($_POST['name']) ? $_POST['name'] : '';
            $this->email = isset($_POST['email']) ? $_POST['email'] : '';
            $this->password = isset($_POST['password']) ? $_POST['password'] : '';
            $this->confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        }

        public function register()
        {
            if($this->checkRequest() === false) {

                if($this->validateEmailDomain($this->email))
                {
                    if(!$this->checkIfUserExist($this->email)){
                        return $this->insertNewUser();
                    }else {
                        return $this->jsonEncodedResult(['email' => 'This user exists. Please try again!'], true, 500);
                    }
                }
                else {
                    return $this->jsonEncodedResult(['email' => 'Invalid email address domain. Please try again!'], true, 500);
                }
            }else {
                return $this->jsonEncodedResult($this->checkRequest(), true , 500);
            }
        }

        private function insertNewUser()
        {
            $id = '';
            $salt = Utility::generateKey();
            $hashed = Utility::hashPassword($this->password, $salt);
            $query1 = "INSERT INTO USERS (NAME, EMAIL, PASSWORD, CREATED_AT, SALT) 
                      VALUES (:name, :email, :password, CURRENT_TIMESTAMP, :salt)
                      RETURNING USER_ID INTO :id";
                      
            $query2 = "INSERT INTO USER_ROLES (ROLE_ID_FK, USER_ID_FK) 
                      VALUES (2, :user_id)";

            $db = new DB;
            $stmt = $db->ociParse($query1);

            $bindValues1 = [
                ':name'     => $this->name,
                ':email'    => $this->email,
                ':password' => $hashed,
                ':salt'     => $salt
            ];

            foreach($bindValues1 as $key => $val)
            {
                oci_bind_by_name($stmt, $key, $bindValues1[$key]);
            }

            oci_bind_by_name($stmt, ':id', $id, 100);
            oci_execute($stmt, OCI_NO_AUTO_COMMIT);

            $stmt = $db->ociParse($query2);
            oci_bind_by_name($stmt, ':user_id', $id, 100);
            oci_execute($stmt);
            return $this->jsonEncodedResult();
        }

        private function checkRequest()
        {
            $checkError = Utility::validator($_POST, [
                'name'              => 'required',
                'email'             => 'required|email',
                'password'          => 'required|min:8|alpha_num',
                'confirm_password'  => 'required|same:password'
            ]);

            if($checkError !== false)
            {
                $errors = $checkError->errors();
                return $errors->firstOfAll();

            } else {
                return false;
            }
        }

        /**
         * Verify email domain
         * returns Boolean
         */
        private function validateEmailDomain($email) 
        {

            $domain = Utility::getDomain($email);
            return in_array($domain, self::DOMAIN) ? true : false;
           
        }

        /**
         * WILL REFACTOR THIS TO FOLLOW DRY PRINCIPLE
         */
        private function checkIfUserExist($email)
        {
            $query = "SELECT * FROM users WHERE EMAIL = :email";
            $db = new DB;
            $result = $db->extract2($query, [
                ':email'    => $email
            ]);

            return count($result) > 0 ? true : false;
 
        }
        
        /**
         * @param Mixed $errorMessage 
         * @param Boolean $error
         * @param Integer $statusCode 
         */
        private function jsonEncodedResult($errorMessage = '', bool $error = false, int $statusCode = 200)
        {
            return Utility::encodedResult([
                'error' => $error,
                'errorMessage' => $errorMessage
            ], $statusCode);
        }

    }

?>