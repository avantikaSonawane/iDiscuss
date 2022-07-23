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
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

  
        $sql2 = "select user_name from `users` where srno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $r2 = mysqli_fetch_assoc($result2);
        $posted_by = $r2['user_name'];

    }
    ?>

    <?php
     $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'POST')
        {
            //INSERT COMMENT INTO DB
            $comment = $_POST['comment'];


            $comment = str_replace("<","&lt;", $comment);
            $comment = str_replace(">","&gt;", $comment);

         $srno = $_POST['srno'];
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$srno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert) 
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesss! </strong>Your comment has been added!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }
    ?>



    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-5"><?php echo $title;  ?> forums</h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">


            <p>Posted by:<em> <?php echo $posted_by; ?></em></p>
        </div>

    </div>

    <?php
      if(isset($_SESSION['loggedin']) &&  $_SESSION['loggedin']==true)
      {

        
       
echo '<div class="container">
        <h1 class="py-2">Post a comment</h1>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">

            <div class="form-group">
                <label for="comment">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="srno" value=" '.$_SESSION["srno"].'">
            
                </div>
            <button type="submit" class="btn btn-primary mb-4">Submit</button>
        </form>
    </div>
    </div>';

} 
else
{
    echo '<div class="container">
    <h1 class="py-2">Post a comment</h1>
    <p class="lead">You are not logged in. Please login to post a comment.</p>
    </div>';
}

    ?>

    <div id="ques" class="container mb-5">

        <h1 class="py-2">Discussions</h1>
        <?php
        $no_res = true;
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` where thread_id=$id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) 
        {
            $no_res = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $th_user_id = $row['comment_by'];

            $sql2 = "select user_name from `users` where srno='$th_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $r2 = mysqli_fetch_assoc($result2);
            $name = $r2['user_name'];
            
            echo '<div class="media my-3">
            <img src="img/img1.png" width="45px" class="mr-3" alt="...">
            <div class="media-body">
           
             '. $content .'

             <p class="font-weight-light my-0">'.'commented by: '.$name .' '. $comment_time.'</p>
            </div>
        </div>';

        }
      
        if ($no_res) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-6">No comments found</p>
              <p class="lead">Be the first person to comment</p>
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