<?php

    namespace app\utils;

    use app\utils\Utility;
    use app\utils\Query as DB;

    class Session extends Utility
    {
        protected $session_name = 'sess';
        protected $httpOnly = false; // Params for setting session as httponly
        protected $secure = 'SECURE'; // Params for setting session as secure
        protected $cookieParams;

        public function sessionStart()
        {
            $lifetime = 42000;
            if (ini_set('session.use_only_cookies', 1) === FALSE) {
                exit();
            }

            $this->cookieParams = session_get_cookie_params();
            session_set_cookie_params(time()+$lifetime, $this->cookieParams["path"], 
                                        $this->cookieParams["domain"], '', $this->httpOnly);
            session_name($this->session_name);
            session_start();
            // session_regenerate_id(true);

        }

        public function closeSession() {
            // $this->sessionStart();
            $_SESSION = array();
            $params = session_get_cookie_params();
            setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            session_destroy();
        }

        public function setSession($email, $pass, $name){
            $_SESSION['session_id'] = $this->generateKey($pass); // will refactor this to have a dynamic value
            $_SESSION['password'] = $pass;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            if(isset($_SESSION['session_id'], $_SESSION['email'], $_SESSION['name']))
            {
                return true;
            }
            return false;
        }
    }

?>