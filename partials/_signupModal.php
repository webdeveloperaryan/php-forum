<?php include('_dbconnect.php'); ?>
<?php

$showerror = 'false';

$name_error = '';
$pass_error = '';
if($_SERVER['REQUEST_METHOD']=='POST'){

    $signupusername = $_POST['username'];
    $password = $_POST['pass'];
    $cpass = $_POST['cpass'];

    if(empty($signupusername)){
        $name_error = '* name is required';
    }else{
        $signupusername = trim($signupusername);
        $signupusername = htmlspecialchars($signupusername);
        if(!preg_match("/^[a-zA-Z ]+$/", $signupusername)){
            $name_error = '<br/> username should contain only char and space';
        }
    }
    if(empty($password)){
        $name_error = '* name is required';
    }else{
        $password = trim($password);
        $password = htmlspecialchars($password);
        if(!preg_match("/^[a-zA-Z ]+$/", $password)){
            $name_error = '<br/> password should contain only char and space';
        }
    }


    if(!empty($signupusername) && !(empty($password))){
        $sql1 = "SELECT * FROM users WHERE username = '$signupusername'";
        $result1 = mysqli_query($conn , $sql1);
        $numrows = mysqli_num_rows($result1);

        if($numrows>0){
            
            header('location: /php-forum/index.php?username-already-exist');
            
            // $showerror = 'username already exist';
            // echo $showerror;
        }else{
        
                if($password==$cpass){

                    $hash_pass = password_hash($password,PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `users` (`username`, `password`, `created_at`) VALUES ( '$signupusername', '$hash_pass', current_timestamp())";
                    $result = mysqli_query($conn , $sql);
                
                    if($result){
                        $showerror = 'true';

                        header("location: /php-forum/index.php");
                        
                        exit();

                    }
                }
            else{
                $showerror = 'Password do not match';
                
            }
        }
        
    }else{
        header('location: /php-forum/index.php?define-fields');
        
    }
    
    
}





// <!-- Thsi si a signup modal -->
//  <!-- Modal -->
echo ' <div class="modal fade" id="signupmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add SignUp Info</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/php-forum/partials/_signupModal.php" method="post">
                    
                
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="username">
                        
                    </div>
                    <div class="text-danger">'.$name_error .'</div>
                    
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="pass">
                    </div>
                    <div class="text-danger">'.$pass_error .'</div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="cpass">
                    </div>
                    
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