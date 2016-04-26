<?php 
include("inc/data.php");
include("inc/functions.php");

$pageTitle = "Personal Media Library";

//even though we are not using underlining in our navigation for the index page
//we still need to add the variable there as well to prevent errors
$section = null;
include('inc/header.php'); 
?>

		<div class="section catalog random">

			<div class="wrapper">

				<h2>May we suggest something?</h2>

				<ul class="items">
                <?php
                //generate an random array that gets 4 items from the catalog
                $random = array_rand($catalog,4);
                //instead of looping through the catalog we loop through the random var
 
                foreach($random as $id){
                //we still pass in id to our fn, but instead of passing in item
                    //we pass in $catalog[$id] to call the specific catalog item accordig
                    //to that id
                       echo get_item_html($id,$catalog[$id]);
                }
                ?>
                </ul>

			</div>

		</div>



<?php include('inc/footer.php'); ?>
