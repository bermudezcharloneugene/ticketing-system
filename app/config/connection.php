<?php

    namespace app\config;

    /**
     * OCI class instantation
     */
    class Connection 
    {
        private $serverName = 'localhost/EPPUAT';
        private $userName = 'TSYSTEM';
        private $password = 'TSYSTEM';
        public $connection;
        private $error;

        /**
         * Public method for creating an OCI connection
         * @return Mix
         */
        public function connect()
        {
            $this->connection = oci_connect($this->userName, $this->password, $this->serverName);
            if(!$this->connection)
            {
                $this->error = oci_error();
                return trigger_error(htmlentities($this->error['message'], ENT_QUOTES), E_USER_ERROR);
            }
            return $this->connection;
        }
    }
?>