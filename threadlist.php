<?php include('partials/_header.php'); ?>
<?php include('partials/_dbconnect.php'); ?>
<?php

$title_error = '';
$desc_error = '';

if($_SERVER['REQUEST_METHOD']=='POST'){

    $id = $_GET['catid'];
    
    $thread_title = $_POST['thread_title'];
    $thread_desc = $_POST['description'];
    
    if(empty($thread_title)){
        $title_error = '* Title is required';
    }else{
        $thread_title = trim($thread_title);
        $thread_title = htmlspecialchars($thread_title);
        if(!preg_match("/^[a-zA-Z ]+$/", $thread_title)){
            $title_error = '<br/> name should contain only char and space';
        }
    }

    if(empty($thread_desc)){
        $desc_error = '* description is required';
    }else{
        $thread_desc = trim($thread_desc);
        $thread_desc = htmlspecialchars($thread_desc);
        if(!preg_match("/^[a-zA-Z ]+$/", $thread_desc)){
            $desc_error = '<br/> description should contain only char and space';
        }
    }
    if(!empty($thread_title) && !(empty($thread_desc))){
        $sql = "INSERT INTO `threads` (`thread_cat_id`, `thread_user_id`, `thread_desc`, `created_at`, `thread_title`) VALUES ('$id', '0', '$thread_desc', current_timestamp(), '$thread_title')";

        $result = mysqli_query($conn, $sql);
        if($result){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> Thankyou for asking a Quesstion. Wait for sometime to reply of another person ......
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';

        }
        else{
            echo 'not inserted';
        }

        }
    
    
}


?>
<?php
$id = $_GET['catid'];
$sql = "SELECT * FROM `categories` WHERE category_id=$id";
        $tabledata = mysqli_query($conn, $sql);

        // firstly fetch the data
        while ($data = mysqli_fetch_assoc($tabledata)) {
            $catid = $data['category_id'];
            $catname = $data['category_name'];
            $desc = $data['category_description'];
        }
?>


<div class="container bg-light my-4 py-4 ">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to the <?php echo $catname;?> forum</h1>
        <p><?php echo $desc;?> </p>
        <hr class="my-4">
        <p>This is a peer to peer form dont abuse anyone</p>
    </div>
    <div>
        <button type="button" class="btn btn-success">Learn More</button>
    </div>
</div>



<div class="container my-3">
    <h1>Start Your Discussion</h1>
    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Give your title here....</label>
            <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="thread_title">
            <div id="emailHelp" class="form-text text-danger"><?php echo $title_error; ?></div>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">Description of your problem</span>
            <textarea class="form-control" aria-label="With textarea" name="description"></textarea>
            
        </div>
        <div id="emailHelp" class="form-text text-danger mb-2 mt-1"><?php echo $desc_error ;?></div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>


<div class="container cont-height">
    <h1>Browse Questions</h1>
    <?php
            $id = $_GET['catid'];
         
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
                    $tabledata = mysqli_query($conn, $sql);

                    // firstly fetch the data
                    $noResult = true;
                    
                    while ($data = mysqli_fetch_assoc($tabledata)) {
                        $noResult = false;
                        $thread_id = $data['thread_id'];
                        $title = $data['thread_title'];
                        $threaddesc = $data['thread_desc'];

                        echo '<div class="media my-2 py-3 border bg-light">
                            <img src="img/a.png" alt="" class="mr-3 rounded-circle" width="64">
                            <h3 class="d-inline mt-2"><a href="threads.php?threadid='.$thread_id.'">'.$title.'</a></h3>
                            <div class="media-body">
                                <p class="px-3">'.$threaddesc.'</p>
                            </div>
                        </div>';
                    }
                    if($noResult){
                        echo '<div class="media my-2 py-3 border bg-light">
                            <img src="img/a.png" alt="" class="mr-3 rounded-circle" width="64">
                            <h3 class="d-inline mt-2">No threads Found</h3>
                            <div class="media-body">
                                <p class="px-3">Be the first person to ask</p>
                            </div>
                        </div>';
                    }

                    
     ?>

</div>


<?php include('partials/_footer.php'); ?>