<?php
    
    namespace app\classes;

    use app\utils\Session;
    use app\utils\Utility;

    class AuthChecker extends Session
    {

        public function __construct()
        {
            $this->sessionStart();
            $this->checkIfAuth();
        }

        public function checkIfAuth()
        {
            
            if(isset($_SESSION['session_id']))
            {
                if($_SESSION['session_id'] !== $this->generateKey($_SESSION['password']))
                {   
                    $this->closeSession();
                }
            }else {
                return Utility::redirect('../../index.php');
            }

        }
        


    }