<?php
header('Access-Control-Allow-Origin: *');

class DataBase{

    public function connection(){

        try 
        {
            $connection = mysqli_connect('127.0.0.1', 'root', '', 'chinook_abridged');
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