<?php
include("inc/data.php");
include("inc/functions.php");

//default value if none of condition are met
//if there is no value set for the variable in the query string we will display this
//which will display the full catalog, all the books,films, music. in the library
$pageTitle = "Full Catalog";

//by default we are not showing any of our catagories we are just showing the full
//catalog so we don't need anything to be underlined
$section = null;

//first check if get variable exists
if(isset($_GET["cat"])){
    if($_GET["cat"] == "books"){
        $pageTitle = "Books";
        $section = "books";
    }else if($_GET["cat"] == "movies"){
        $pageTitle = "Movies";
        $section = "movies";
    }else if($_GET["cat"] == "music"){
        $pageTitle = "Music";
        $section = "music";
    }
}



include('inc/header.php'); 

?>

<div class="section catalog page">
    
    <div class="wrapper">
        
    <h1><?php
          //give user option to link to full catalog
          //&gt gives 
        if($section != null){
            echo '<a href="catalog.php">Full Catalog</a> &gt;';
        }
        echo $pageTitle ?></h1>

        <ul class="items">
            <?php
            //call our array_category function from functions inc file,
            //pass in $catalog argument as well as our category arugment which is $section
            $categories = array_category($catalog,$section);

            foreach($categories as $id){
                   echo get_item_html($id,$catalog[$id]);
            }
            ?>
        </ul>

    </div>

</div>



<?php include('inc/footer.php'); ?>
