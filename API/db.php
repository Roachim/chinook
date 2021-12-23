<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers', 'Content-Type');

class DataBase{

    public function connect(){

        try 
        {
            $connection = new mysqli('eu-cdbr-west-02.cleardb.net', 'bffea5c4d1ff42', '49c8a9dd', 'heroku_647a2a0520c3f71');
        } catch (mysqli_sql_exception)
        {
            echo mysqli_error($connection);
            die('Connection error');
        }
        return $connection;


        // try 
        // {
        //     $connection = new mysqli('127.0.0.1', 'root', '', 'chinook_abridged');
        // } catch (mysqli_sql_exception)
        // {
        //     echo mysqli_error($connection);
        //     die('Connection error');
        // }
        // return $connection;
    }


}

?>