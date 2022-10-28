<?php 
include_once './config/db.php';
    function connect(){
        $C = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        if($C->connect_error){
            return false;
        }

        return $C;
    }

    function validateUserInput($data){
        $C = connect();
        mysqli_real_escape_string($C, $data);
        strip_tags($data);
        stripcslashes($data);
        htmlspecialchars($data);
        trim($data);

        return $data;
    }

    function sqlInsert($C, $query, $format=false, ...$vars){
        $stmt = $C->prepare($query);
        if($format){
            $stmt->bind_Param($format, ...$vars);
        }

        if($stmt->execute()){
            $id = $stmt->insert_id;
            $stmt->close();
            return $id; 
        }

        $stmt->close();
        return -1;

    }

    function sqlSelect($C, $query, $format=false, ...$vars){
        $stmt = $C->prepare($query);
        if($format){
            $stmt->bind_Param($format, ...$vars);
        }

        if($stmt->execute()){
            $res = $stmt->get_result();
            $stmt->close();

            return $res;
        }

        $stmt->close();
        return false;
    }

    function sqlUpdate($C, $query, $format=false, ...$vars){
        $stmt = $C->prepare($query);
        if($format){
            $stmt->bind_Param($format, ...$vars);
        }

        if($stmt->execute()){
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }
    function sqlDelete($C, $query, $format=false, ...$vars){
        $stmt = $C->prepare($query);
        if($format){
            $stmt->bind_Param($format, ...$vars);
        }

        if($stmt->execute()){
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

?>