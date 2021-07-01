<?php

    namespace app\utils;
    
    use app\config\Connection;
    
    class Query extends Connection
    {
        public $conn;
        public $rows;
        private $stid;
        
        // public function __construct()
        // {
        //     $this->conn = $this->connect();
        // }
        
        /**
         * Parses oci query
         * @param String $query
         * @return Resource
         */
        public function ociParse(String $query)
        {
            $this->stid = oci_parse($this->conn, $query);
    
            if(!$this->stid) {
                $m = oci_error();
                trigger_error(htmlentities($m['message']), E_USER_ERROR);
            }
    
            return $this->stid;
        }

        /**
         * Accepts a string params
         * Method for extracting records relative to what query is executed
         * @return Mix
         */
        public function extract(String $query) {
            
            $stmt = $this->ociParse($query);
            oci_execute($stmt);
            oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $res;
        }

        public function extract2(String $query, Array $bindValues)
        {

            $stmt = $this->ociParse($query);

            foreach($bindValues as $key => $val)
            {
                oci_bind_by_name($stmt, $key, $bindValues[$key]);
            }

            oci_execute($stmt);

            oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            
            return $res;

        }

        public function defaultExtract(String $query)
        {
            $stmt = $this->ociParse($query);
            oci_execute($stmt);
            oci_fetch_all($stmt, $res);
            return $res; 
        }

        public function executeQuery(String $query, $arrayBind = null) {

            $stmt = $this->ociParse($query);

            if($arrayBind !== null && is_array($arrayBind)){
                
                foreach($arrayBind as $key => $val)
                {
                    oci_bind_by_name($stmt, $key, $arrayBind[$key]);
                }
            }
            
            oci_execute($stmt);
        }

        public function executeQuery2(String $query, $arrayBind = null) {

            $stmt = $this->ociParse($query);

            if($arrayBind !== null && is_array($arrayBind)){
                
                foreach($arrayBind as $key => $val)
                {
                    oci_bind_by_name($stmt, $key, $arrayBind[$key]);
                }
            }
            
            $result = oci_execute($stmt);
            return $result;
        }

        public function extractObject(String $query)
        {
            $rows = array();
            $this->stid = oci_parse($this->conn, $query);
            oci_execute($this->stid);
            while (($row = oci_fetch_object($this->stid)) != false) {
                $rows[] = $row;
            }
            return $rows;
        }

        /**
         * 
         * WORK IN PROGRESS NEED TO REFACTOR CODE
         * 
         */
        public function queryBuilder(Array $params, String $keyword)
        {
            $keyword = strtoupper($keyword);
            $arrKeyword = ['SELECT', 'INSERT', 'UPDATE'];
            if(in_array($arrKeyword, $keyword))
            {
                // FUNCTION STARTS HERE
            }
            $query = "SELECT * FROM $tbl" . " '$keyword' ". "'$params'";
            return $result = $this->extract($query); 


        }

        /**
         * @params mixed
         * Accepts params corresponds to what OCI connection returns
         * returns mixed
         */
        public function error($checker) // Will refactor
        {
            return !$checker ? false : trigger_error(htmlentities(oci_error()['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // public function __destruct()
        // {
        //     oci_free_statement($this->stid); 
        //     oci_close($this->conn); 
        // }

    }

?>