<?php
require_once 'config.php';
//methods in here will deal with getting data from database and executing commands at database
class DataAccess
{
    private $port=DB_PORT;
    private $host=DB_HOST;
    private $database= DB_NAME;
    private $username=DB_USER;
    private $password=DB_PASS;
    /**
     * @return PDO
     */
    private function GetConn(): PDO
    {


        $conn = new PDO("mysql:host={$this->host}:{$this->port};dbname={$this->database}", $this->username, $this->password);
           //$conn=new PDO("mysql:host=$host;port=$port;dbname=$database;user=$username;password=$password");
        //catch exceptions
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    public function GetDataSql($sql):array
    {
        try {
            return $this->getConn()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
//            $conn = $this->getConn();
//            $results = $conn->query($sql);
//
//            return $results->fetchAll(PDO::FETCH_ASSOC);//returns associative array

        } catch (Exception $ex)
        {
            throw ($ex);
        }
    }

    //function to get database data using EXECUTE method | WITH PARAMETERS
    function GetData($sql, $params=null): array
    {
        try{
            $conn = (new DataAccess())->GetConn();

            /* handle parameters */
            $values = is_array($params)? $params : ( (is_null($params))? array() : array($params) );
            $stmt   = $conn->prepare($sql); //strtolower($sql)
            $stmt->execute($values);
            $arr_data = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch returns Array so use count to get count
            //free objects
            $stmt->closeCursor();
            $conn = null;

            return $arr_data;

        } catch (Exception $ex) {
            throw $ex;
        }
    }


    /**
     * @throws Exception
     */
    public function ExecuteSql($sql): int
    {
        try {
            $conn = $this->getConn();
            return $conn->exec($sql);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}
