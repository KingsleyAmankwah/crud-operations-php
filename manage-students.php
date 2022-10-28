<?php   
include './functions/utils.php';  
//session_start();
$update = false;
$id = 0;
$name = "";
$date = "";
$school = "";
$programme= "";

if(isset($_POST['save'])){
    $name = validateUserInput($_POST['name']);
    $date = validateUserInput($_POST['date']);
    $school = validateUserInput($_POST['school']);
    $programme = validateUserInput($_POST['programme']);

    $C = connect();

    if($C){

        try {
            $id = sqlInsert($C,  "INSERT INTO students VALUES(NULL, ?,?,?,?)", 'ssss', $name,$date,$school,$programme);
            if($id !== -1){
                $_SESSION['title'] = "Successfully Added";
                $_SESSION['icon'] = "success";
            }else{
                $_SESSION['title'] = "Sorry something occurred while inserting";
                $_SESSION['icon'] = "error";
            }
    
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

   
}

if(isset($_GET['delete'])){
    $student_id = $_GET['delete'];
    $C = connect();

    if($C){

        try {
            sqlDelete($C, "DELETE FROM students WHERE id=?", 'i' , $student_id);
            exit(0);
        } catch (\Throwable $e) {
           echo $e->getMessage();
        }
    }

    
}


if (isset($_GET['edit'])) {
    $update = true;
    $student_id = $_GET['edit'];
    $C = connect();

    if($C){

        try {
            $res = sqlSelect($C, "SELECT * FROM students WHERE id=?", 'i', $student_id);
            while($row = mysqli_fetch_assoc($res)){
                $id = $row['id'];
                $name = $row['fullname'];
                $date = $row['date_of_birth'];
                $school = $row['school'];
                $programme = $row['programme'];
            }
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    
}

if(isset($_POST['update'])){
    $student_id = $_POST['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $school = $_POST['school'];
    $programme = $_POST['programme'];

    $C = connect();

    if($C){
        try {
            $query = sqlUpdate($C, "UPDATE students SET fullname=?, date_of_birth=?, school=?, programme=? WHERE id=?", 'ssssi', $name,$date,$school,$programme,$student_id);
            if($query){
                $_SESSION['title'] = "Successfully Updated";
                $_SESSION['icon'] = "info";
            }else{
                $_SESSION['title'] = "Sorry something occurred while inserting";
                $_SESSION['icon'] = "error";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    

}

?>