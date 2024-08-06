<?php include('partials/_header.php'); ?>
<?php include('partials/_dbconnect.php'); ?>
<?php
$id = $_GET['threadid'];
$sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $tabledata = mysqli_query($conn, $sql);

        // firstly fetch the data
       
        while ($data = mysqli_fetch_assoc($tabledata)) {
            
            $thread_title = $data['thread_title'];
            $thread_desc = $data['thread_desc'];
    
        }
?>

<?php
$comment_error = '';
if($_SERVER['REQUEST_METHOD']=='POST'){

    $id = $_GET['threadid'];
    // Insert data on db
    $comment_content = $_POST['comment'];

    if(empty($comment_content)){
        $comment_error = '* comment is required';
    }else{
        $comment_content = trim($comment_content);
        $comment_content = htmlspecialchars($comment_content);
        if(!preg_match("/^[a-zA-Z ]+$/", $comment_content)){
            $comment_error = '<br/> * comment should contain only char and space';
        }
    }

    if(!empty($comment_content)){
        $sql = "INSERT INTO `comments` (`comment_thread_id`, `comment_content`, `comment_time`) VALUES ('$id', '$comment_content', current_timestamp())";

        $result = mysqli_query($conn, $sql);

        if($result){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> Thankyou for your great comment...
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }else{
            echo 'not inserted';
        }
    }
    

}


?>


<div class="container bg-light my-4 py-4">
    <div class="jumbotron">
        <h1 class="display-2"><?php echo $thread_title;?></h1>
        <p><?php echo $thread_desc;?> </p>
        <hr class="my-4">
        <p>This is a peer to peer form dont abuse anyone</p>
    </div>
    <div>
        <button type="button" class="btn btn-success">Learn More</button>
    </div>
</div>

<!-- Creating for the comments -->
<div class="container my-5">
    <h1 class="mb-5">Type your comments here</h1>
    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text">Your comment</span>
            <textarea class="form-control" aria-label="With textarea" name="comment"></textarea>
        </div>
        <div class="my-2 text-warning"><?php echo $comment_error; ?></div>
        <button type="submit" class="btn btn-success">Post Your Comment</button>
    </form>
</div>


<div class="container cont-height">
    <h1>Discussions</h1>

    <?php
            $id = $_GET['threadid'];
         
            $sql = "SELECT * FROM `comments` WHERE comment_thread_id=$id";
                    $tabledata = mysqli_query($conn, $sql);

                    // firstly fetch the data
                    $noResult = true;
                    
                    while ($data = mysqli_fetch_assoc($tabledata)) {
                        $noResult = false;
                        $comment_id = $data['comment_id'];
                        $comments = $data['comment_content'];
                        

                        echo '<div class="media my-2 py-3 border bg-light">
                            <img src="img/a.png" alt="" class="mr-3 rounded-circle" width="64">
                            <h3 class="d-inline mt-2">User</h3>
                            <div class="media-body">
                                <p class="px-3">'.$comments.'</p>
                            </div>
                        </div>';
                    }
                    if($noResult){
                        echo '<div class="media my-2 py-3 border bg-light">
                            <img src="img/a.png" alt="" class="mr-3 rounded-circle" width="64">
                            <h3 class="d-inline mt-2">No Comments Found</h3>
                            
                        </div>';
                    }

                    
     ?>
        
</div>


<?php include('partials/_footer.php'); ?>