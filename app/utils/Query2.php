<?php

namespace app\utils;

use app\config\Connection;

class Query2 extends Connection
{
    /**
     * Property for setting an OCI resource
     * @var Resource
     */
    private $stid;
    /**
     * Private property that holds OCI connection
     * @var Resource
     */
    private $conn;
    /**
     * Private property that holds ociParse function return value
     * @var Mix
     */
    private $stmt;

    // public function __construct()
    // {
    //     $this->conn =   
    // }
    public function ociParse(String $query, $conn)
    {
        $this->stid = oci_parse($conn, $query);

        if(!$this->stid) 
        {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }

        return $this->stid;
    }

    public static function execute(String $query, $arrayToBind = NULL)
    {

    }

    public function executeQuery(String $query, $arrayToBind = NULL)
    {
        $this->conn = $this->connect();
        $this->stmt = $this->ociParse($query, $this->conn);
        if($arrayToBind !== null && is_array($arrayToBind))
        {
            $this->bindParams($arrayToBind);
        }
        return oci_execute($this->stmt);
    }

    public function extractData(String $query, $arrayToBind = NULL)
    {
        $this->conn = $this->connect();
        $this->stmt = $this->ociParse($query, $this->conn);

        if($arrayToBind !== NULL && is_array($arrayToBind))
        {
            $this->bindParams($arrayToBind);
        }
        
        oci_execute($this->stmt, OCI_NO_AUTO_COMMIT);
        oci_fetch_all($this->stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $this->closeConnection();
        return $res;

    }

    private function bindParams(Array $arrayToBind)
    {
        foreach($arrayToBind as $key => $val)
        {
            oci_bind_by_name($this->stmt, $key, $arrayToBind[$key]);
        }
    }

    public function closeConnection()
    {
        
        oci_close($this->conn); 
        oci_free_statement($this->stmt); 
    }
}

?>