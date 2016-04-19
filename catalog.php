<?php
//default value if none of condition are met
//if there is no value set for the variable in the query string we will display this
//which will display the full catalog, all the books,films, music. in the library
$pageTitle = "Full Catalog";

if($_GET["cat"] == "books"){
    $pageTitle = "Books";
}else if($_GET["cat"] == "movies"){
    $pageTitle = "Movies";
}else if($_GET["cat"] == "music"){
    $pageTitle = "Music";
}



include('inc/header.php'); 

?>

<div class="section page">
    <h1><?php echo $pageTitle ?></h1>
</div>



<?php include('inc/footer.php'); ?>
