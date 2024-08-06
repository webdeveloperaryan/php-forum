<?php
    $conn = mysqli_connect('localhost','root','','iforum');
    if(!$conn)
    {
        die('database connection failed--->'.mysqli_connect_error($conn));
    }
?>