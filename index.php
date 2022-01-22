<?php
  //Start from 01:27:19 
  $insert = false;
  $update = false;
  $delete = false;

  //Connect to the Database
  $serverName = "localhost";          
  $userName = "root";
  $password = "";
  $database = "notes";
  
  //Create a connection
  $conn = mysqli_connect($serverName, $userName, $password, $database);

  // Die if connection was not successful
  if(!$conn){
    die("Sorry we failed to connect: " . mysqli_connect_error());
  }
  // else{
  //   echo "Connection was successful<br>";
  // }
  if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    // echo $sno;
    $delete = true;
    //SQL query to be executed
    $sql = "DELETE FROM `notes` WHERE `sno`= '$sno'";
    $result = mysqli_query($conn, $sql);
  }

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['snoEdit'])){
      //Update the notes
      $sno = $_POST['snoEdit'];
      $title = $_POST['titleEdit'];
      $description = $_POST['descriptionEdit'];

      //SQL query to be executed
      $sql = "UPDATE `notes` SET `title`='$title', `description`='$description' WHERE `sno`= '$sno'";
      $result = mysqli_query($conn, $sql);

      if($result){
        // echo "The has been updated successfully!<br>";
        $update = true;
      }
      else {
        echo "The was not updated successfully because of this error --->" . mysqli_connect_error($conn);
      }
    }
    else{
      $title = $_POST['title'];
      $description = $_POST['description'];

      //SQL query to be executed
      $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
      $result = mysqli_query($conn, $sql);

      //Add a new note to the notes table in the database 
      if($result){
        // echo "The has been inserted successfully!<br>";
        $insert = true;
      }
      else {
        echo "The was not inserted successfully because of this error --->" . mysqli_connect_error($conn);
      }
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="./css/style.css">

    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon"> 
    
    <title>iNotes - Notes taking makes easy</title>

  </head>
  <body>
    <!-- Edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
    Edit Modal
    </button> -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="./index.php" method="post">
            <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
              </div>
              <div class="mb-3">
                  <label for="desc" class="form-label">Note Description</label>
                  <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>
              <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
            </div>
            <div class="modal-footer d-block mr-auto">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php"> <img class='logo' src="./img/logo.png" alt="iNotes"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li> 
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
    </nav>
    <?php
      if($insert){
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> You note has been inserted successfully
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
            <script>
              alertTime = ()=>{
                window.location = './index.php';
              };
              setTimeout(alertTime, 2000);
            </script>
          </button>
        </div>
        ";
      }
      if($delete){
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> You note has been deleted successfully
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
            <script>
              alertTime = ()=>{
                window.location = './index.php';
              };
              setTimeout(alertTime, 2000);
            </script>
          </button>
        </div>
        ";
      }
      if($update){
        echo "
        <div class='alert alert-primary alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> You note has been updated successfully
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
            <script>
              alertTime = ()=>{
                window.location = './index.php';
              };
              setTimeout(alertTime, 2000);
            </script>
          </button>
        </div>
        ";
      }
    ?>
    <div class="container my-5">
        <h2>Add a Note</h2>
        <form action="./index.php" method="post">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <div class="container my-5"> 
        <table class="table table-hover" id="myTable">
          <thead>
            <tr>
              <th scope="col">S.NO</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * FROM `notes`"; 
              $result = mysqli_query($conn, $sql);
              $sno = 0;
              while($row = mysqli_fetch_assoc($result)){
                $sno = $sno + 1;
                echo "
                <tr>
                  <th scope='row'>" . $sno . "</th>
                  <td>" . $row['title'] . "</td>
                  <td>" . $row['description'] . "</td>
                  <td><button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-danger' id=d" . $row['sno'] . ">Delete</button></td>
                </tr>
                ";
              }
            ?>
          </tbody> 
        </table>
    </div>
    <!-- <hr> -->
    <!-- <div class="container"> -->
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 px-5 mt-4 border-top  navbar-dark bg-dark">
        <p class="col-md-4 mb-0 text-muted">© 2021 iNotes, Inc</p>

        <a href="./index.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
          <img class='logo' src="./img/logo.png" alt="iNotes">
          <!-- <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg> -->
        </a>

        <ul class="nav col-md-4 justify-content-end">
          <li class="nav-item"><a href="./index.php" class="nav-link px-2 text-white active" aria-current="page">Home</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Contact Us</a></li>
          <!-- <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li> -->
        </ul>
      </footer>
    <!-- </div> -->
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          // console.log('Edit', e.target.parentNode.parentNode);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          // console.log(title, description); 
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoEdit.value = e.target.id;
          var editModal = new bootstrap.Modal(document.getElementById('editModal'), {
            keyboard: false
          });
          editModal.toggle();
        });
      });
      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          // console.log('delete', e.target.parentNode.parentNode);
          sno = e.target.id.substr(1,);
          // console.log(sno);
          if(confirm("Are you sure you want to delete this note!")){
            window.location = `./index.php?delete=${sno}`;
            //TODO: Create a form and Use post request to submit a form
          }
          else{
            console.log('no');
          }
        });
      });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>