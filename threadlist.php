<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    </link>

    <title>iDiscuss - Coding forum</title>
</head>

<body>
<?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
   

    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_descript'];
    }
    ?>
    <?php
     $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'POST')
        {
            //INSERT THREAD INTO DB
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];

        $th_title = str_replace("<","&lt;", $th_title);
$th_title = str_replace(">","&gt;", $th_title);

$th_desc = str_replace("<","&lt;", $th_desc);
$th_desc = str_replace(">","&gt;", $th_desc);


            $srno = $_POST['srno'];
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `dt`) VALUES ('$th_title', '$th_desc', '$id', '$srno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert)
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesss! </strong>Your thread has been added! please wait for community to respond
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }
    ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-5">Welcome to <?php echo $catname;  ?> forums</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">

            <p>
            <p>Rules of forum</p>
            <ul>
                <li>
                    No Spam / Advertising / Self-promote in the forums.
                </li>
                <li>
                    Do not post copyright-infringing material.
                </li>
                <li>
                    Do not post “offensive” posts, links or images.
                </li>
                <li>
                    Remain respectful of other members at all times.
                </li>
            </ul>
            </p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <!-- <div id="ques" class="container"> -->

    <?php
      if(isset($_SESSION['loggedin']) &&  $_SESSION['loggedin']==true)
      {

       
    echo '<div class="container">
        <h1 class="py-2">Start a discussion</h1>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
            <div class="form-group">
                <label for="title">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="desc">Elaborate your problem</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <input type="hidden" name="srno" value=" '.$_SESSION["srno"].'">
            <button type="submit" class="btn btn-primary mb-4">Submit</button>
        </form>
    </div>';

} 
else
{
    echo '<div class="container">
    <h1 class="py-2">Start a discussion</h1>
    <p class="lead">You are not logged in. Please login to start a discussion</p>
    </div>';
}

    ?>



    <div id="ques" class="container mb-5">
        <h1 class="py-2">Browse Questions</h1>
        <?php

        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` where thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $no_res = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $no_res = false;
            $tid = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];


            $th_time = $row['dt'];
            $th_user_id = $row['thread_user_id'];
            $sql2 = "select user_name from `users` where srno='$th_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $r2 = mysqli_fetch_assoc($result2);
            $name = $r2['user_name'];

            echo '<div class="media my-3">
            <img src="img/img1.png" width="45px" class="mr-3" alt="...">
            
            <div class="media-body">
          
                <h5 class="mt-0"><a class="text-dark" href="threads.php?threadid=' . $tid . '">' . $title . '</a></h5>
                ' . $desc . '
                <p class="font-weight-light my-0">asked by: '.$name   .' '. $th_time .'</p>
            </div>
        
    </div>';
        }
        if ($no_res) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-6">No threads found</p>
              <p class="lead">Be the first person to ask a question</p>
            </div>
          </div>';
        }
        ?>

    </div>

    <?php include 'partials/_footer.php'; ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>