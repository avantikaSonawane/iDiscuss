<?php
session_start();



echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum_site">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum_site">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
         Top Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';


          $sql = "select category_name,category_id  from `categories` limit 5";
          $result = mysqli_query($conn, $sql);
          
          while ($row = mysqli_fetch_assoc($result))
          {

            echo '<a class="dropdown-item" href="threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a>';
          }
         
        
        echo '</div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php" >Contact</a>
      </li>
    </ul>';
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
       echo  '<form class="d-flex form-inline my-2 my-lg-0">
       <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
       <button class="btn btn-primary" type="submit">Search</button>
       <p class="text-light my-0 mx-2">Welcome '. $_SESSION['user_name'].'</p></form>
       <a href="partials/_logout.php" class="btn btn-outline-primary" >Logout</a>';
      }
    else
    {
      echo  '<form class="d-flex" action="search.php" method="GET">
       <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
       <button class="btn btn-primary" type="submit">Search</button>
        </form>
       <div class="mx-2">
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
    }
      
  echo '</div>
  </div>
</div>
</nav>';
include 'partials/login_modal.php';
include 'partials/signup_modal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true")
{
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Sucesss! </strong>You can login now
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
?>
