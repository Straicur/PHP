<?php include("includes/init.php"); ?>
<?php 
if(!$session->is_signed_in()){//jeżeli niejest zalogowany
    redirect("login.php");
}

?>
<?php 
    if(empty($_GET['id'])){
        redirect("photos.php");
    }
    $photos = Photo::find_by_id($_GET['id']);
    if($photos){
        $photos->delete_photo();
        redirect("photos.php");
    }
    else
    {
        redirect("photos.php");
    }
?>