<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers', 'Content-Type');

class DataBase{

    public function connect(){

        try 
        {
            $connection = new mysqli('127.0.0.1', 'root', '', 'chinook_abridged');
        } catch (mysqli_sql_exception)
        {
            echo mysqli_error($connection);
            die('Connection error');
        }
        return $connection;
    }
    public function cutConnection($connection){
        $connection = null;
    }


}

?>