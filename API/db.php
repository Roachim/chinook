<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers', 'Content-Type');

class DataBase{

    public function connect(){
        //Get Heroku ClearDB connection information
        $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $cleardb_server = $cleardb_url["eu-cdbr-west-02.cleardb.net"];
        $cleardb_username = $cleardb_url["bffea5c4d1ff42"];
        $cleardb_password = $cleardb_url["49c8a9dd"];
        $cleardb_db = substr($cleardb_url["path"],1);
        $active_group = 'default';
        $query_builder = TRUE;

        try 
        {
            $connection = new mysqli($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
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