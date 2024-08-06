<!-- This is a header file ( navbar ) -->
<?php include('partials/_header.php'); ?>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">iForum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Catergories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link ">Contact me</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
                <div class="mx-2">
                    <?php 
                    
                    
                        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                            echo '<button class="btn btn-outline-success" type="submit" data-bs-toggle="modal" data-bs-target="#signupmodal">SignUp</button><a href="/php-forum/partials/_logoutHandler.php" class="btn btn-outline-success mx-2" type="submit">Logout</a>
                                ';
                        }
                        else{
                            echo '
                                <button class="btn btn-outline-success" type="submit" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button><button class="btn btn-outline-success mx-2" type="submit" data-bs-toggle="modal" data-bs-target="#signupmodal">SignUp</button>';
                       }
                       ?>

                </div>
            </div>
    </nav>

    <?php include 'partials/_loginModal.php'; ?>
    <?php include 'partials/_signupModal.php'; ?>
    <?php include('partials/_dbconnect.php'); ?>


<div class="container">
    <div class="row">
        <h3 class="text-center my-4">iForum | All categories are here!</h3>
        <!-- fetch the data from the db into the cards -->
        <?php
        $sql = "SELECT * FROM `categories`";
        $tabledata = mysqli_query($conn, $sql);

        // firstly fetch the data
        while ($data = mysqli_fetch_assoc($tabledata)) {
            $id = $data['category_id'];
            $catname = $data['category_name'];
            $desc = $data['category_description'];
            
            echo '<div class="col-md-4">
                            <div class="card my-3" style="width: 18rem;">
                                <img src="img\premium_photo-1682140993556-f263e434000b.avif" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="threadlist.php?catid='.$id.'">'.$catname.'</a></h5>
                                    <p class="card-text">'.substr($desc,0,50).'....</p>
                                    <a href="threadlist.php?catid='.$id.'" class="btn btn-success">View threads</a>
                                </div>
                            </div>
                        </div>';
        }?>

    </div>
</div>


<?php include('partials/_footer.php'); ?>