<?php

include ('_dbconnect.php');

$name_error = '';
$pass_error = '';
if ($_SERVER['REQUEST_METHOD']=='POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)){
        $name_error = '* name is required';
    }else{
        $username = trim($username);
        $username = htmlspecialchars($username);
        if(!preg_match("/^[a-zA-Z ]+$/", $username)){
            $name_error = '<br/> username should contain only char and space';
        }
    }
    

    if(!empty($username) && !(empty($password))){
        $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
        $result = mysqli_query($conn, $sql);

        $numrows = mysqli_num_rows($result);
        if($numrows == 1){ 
        while($numrows == 1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password,$row['password'])){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
            
                header("location: /php-forum/index.php?login=true");
                exit();

            }else{
                header("location: /php-forum/index.php?username=used&pass=false");
            }
        }
    }else{
        header('location: /php-forum/index.php?username-not-found');
        
    }
        
        
    }
    else{
        header('location: /php-forum/index.php?define-fields');
        
    }
    
    
}






// <!-- Modal -->
echo '<div class="modal fade" id="loginmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Login Info</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/php-forum/partials/_loginModal.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="username">
                        <div class="text-danger">'.$name_error .'</div>
                        
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="text-danger">'.$pass_error .'</div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>';


?>