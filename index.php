<?php  
  include_once 'manage-students.php'; 
  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/sweetalert2.css">
    <link rel="stylesheet" href="./DataTable/dataTables.semanticui.min.css">
    <link rel="stylesheet" href="./DataTable/semantic.min.css">
    <title>PDO CRUD</title>
</head>
<body>

<div class="container">
    <h4 class="display-6 text-center">PHP CRUD Operations Using PDO</h4>
    
  <form action="" method="post" class="mb-5">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div class="form-group">
        <label for="">Name</label>
        <input type="text" placeholder="Enter Name" value="<?php echo $name; ?>" name="name" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Date of Birth</label>
        <input type="date" name="date" value="<?php echo $date; ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="">School Name</label>
        <input type="text" placeholder="Enter School" value="<?php echo $school; ?>" name="school" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Programme</label>
        <input type="text" placeholder="Enter Programme" value="<?php echo $programme; ?>" name="programme" class="form-control">
    </div>

    <div class="form-group">

    <?php if($update){ ?>
    <button type="submit" class="btn btn-info" name="update">Update</button>

        <?php }else{ ?>
            <button type="submit" class="btn btn-primary" name="save">Save</button>

         <?php } ?>   
    </div>
    
</form>




<table class="ui celled table table-striped " id="students-details" width="100%">
    <thead>
        <tr> 
            <th>ID.</th>
            <th>Name</th>
            <th>Programme</th>
            <th>Action(s)</th>
        </tr>
    </thead>

    <?php
     $C = connect();
     $query = "SELECT * FROM students";
     $res = mysqli_query($C, $query);
       $count = 0;

       foreach($res as $row){
        ?>

    <tbody>
        <tr>
            <td><?php echo ++$count; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['programme']; ?></td>
            <td>
                <a href="dashboard.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                <a href="dashboard.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger delete-btn">Delete</a>
                
            </td>
        </tr>
    </tbody>

        <?php
       }

?>

</table>


  <!-- Datatable Js files  -->
  <script src="./DataTable/jquery-3.5.1.js"></script>
<script src="./DataTable/jquery.dataTables.min.js"></script>
<script src="./DataTable/dataTables.semanticui.min.js"></script>
<script src="./DataTable/semantic.min.js"></script>
<script src="./assets/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
<?php

    if(isset($_SESSION['title']) && $_SESSION['title'] !== ''){

        ?>

        <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['icon']; ?>',
            title: '<?php echo $_SESSION['title']; ?>',
            timer: 3000,
        }).then(function () {
            window.location = "dashboard.php";
        })
        </script>

        <?php 
        unset($_SESSION['title']);
    }

    ?>

<script>
  $('.delete-btn').on('click',function (e) {
    e.preventDefault();
    const href = $(this).attr('href')

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.value){
          document.location.href = href;
          swal.fire(
            'Deleted!',
            'Records has been deleted.',
            'success'
          )
        }
    }).then(function () {
        window.location = "dashboard.php";
    })
  })
</script>

<script>
$(document).ready(function() {
  $(document).ready(function () {
    $('#students-details').DataTable();
});
} );
</script>