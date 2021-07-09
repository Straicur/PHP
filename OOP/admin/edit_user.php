<?php include("includes/header.php"); ?>
<?php
if (!$session->is_signed_in()) { //jeżeli niejest zalogowany
    redirect("login.php");
}

?>

<?php
// $users = user::find_all();
if(empty($_GET['id'])){//sprawdzam czy mamy id 
    redirect("users.php");
}

$user = User::find_by_id($_GET['id']);
var_dump($user);
if(isset($_POST['update']))
{   
    
    if($user){
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];
        $user->set_file($_FILES['user_image']);
        $user->save_photo();
    }
}





?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">SB Admin</a>
    </div>
    <!-- Top Menu Items -->
    <?php include("includes/top_nav.php"); ?>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php include("includes/slide_nav.php"); ?>
    <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Users
                    <small>Subheading</small>
                </h1>
                <form action="" method="post" enctype="multipart/form-data" class="">
                    <div class="col-md-6 col-md-offset-3">

                        <div class="form-group">
                            <input type="file" name="user_image" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="username" class="caption">Username</label>
                            <input type="text" name="username" class="form-control" value=<?php echo $user->username;?> >
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="caption">First Name</label>
                            <input type="text" name="first_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="caption">Last Name</label>
                            <input type="text" name="last_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="caption">Password</label>
                            <input type="password" name="password" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <input type="submit" name="update" class="btn btn-primary" value="Update">
                        </div>
                        
                    </div>
                
                </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>