<?php

    namespace app\classes;

    use app\utils\Utility;
    use app\utils\Session;
    use app\utils\Query2 as DB;
    use Rakit\Validation\Validator;

    class Profiles 
    {
        /**
         * @var Mixed
         */
        private $id;

        /**
         * Sets id and user_id property values
         * @return Void
         */
        public function __construct()
        {
            $this->id = isset($_POST['user_role']) ? $_POST['user_role'] : '';
            $this->user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        }

        public function userList() 
        {
            return json_encode($this->userExtract());
        }

        public function update()
        {
            if($this->id === '')
            {
                return $this->jsonEncodedResult('An error occured while doing this action. Please try again!', true, 401);
            } else {

                if($this->changeStatus()) 
                {
                    return $this->jsonEncodedResult();
                }
            }
        }

        private function userExtract()
        {
            $db = new DB;
            $query = "SELECT USERS.NAME, USERS.USER_ID, USER_ROLES.USER_ROLE_ID, ROLES.ROLE_NAME, ROLE_ID_FK FROM USERS 
                    INNER JOIN USER_ROLES ON USER_ROLES.USER_ID_FK = USERS.USER_ID
                    INNER JOIN ROLES ON USER_ROLES.ROLE_ID_FK = ROLES.ROLE_ID";
            $result = $db->extractData($query);
            return $result;

        }

        private function getUserId(string $email)
        {
            $query = "SELECT USER_ID FROM USERS WHERE EMAIL = :email";
            $db = new DB;
            $result = $db->extractData($query,[
                ':email' => $email
            ]);
            return $result;
        }

        private function changeStatus()
        {  
            $db = new DB;
            $query = "UPDATE USER_ROLES SET ROLE_ID_FK = :role_id WHERE USER_ID_FK = :user_id";
            $result = $db->executeQuery($query, [
                ':role_id' => $this->id,
                ':user_id' => $this->user_id
            ]);

            return $result;
        }

        private function jsonEncodedResult($errorMessage = '', bool $error = false, int $statusCode = 200)
        {
            return Utility::encodedResult([
                'error' => $error,
                'errorMessage' => $errorMessage
            ], $statusCode);
        }

        public function getUserProfilePath($email)
        {
            $db = new DB;
            $query = "SELECT USERS.USER_ID, USER_PROFILE.PROFILE_PATH 
                      FROM USERS
                      INNER JOIN USER_PROFILE on USERS.USER_ID = USER_PROFILE.USER_ID_FK
                      WHERE EMAIL = :email";

            $result = $db->extractData($query, [
                ':email' => $email
            ]);
            return $result[0]['PROFILE_PATH'];
        }

    }

?>