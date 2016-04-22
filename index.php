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
            //we use id key here to pass into get_item_html fn
            foreach($catalog as $id => $item){
                   echo get_item_html($id,$item);
            }
            ?>
            </ul>

			</div>

		</div>



<?php include('inc/footer.php'); ?>
