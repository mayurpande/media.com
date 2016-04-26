<?php
include("inc/data.php");
include("inc/functions.php");

//to pull the details for a specific item we are going to use the get variable again
//to pass the id. we will change the get variable in the first if statement to id. as
//we are going to change what we are doing with this variable we do not need the nested
//if statement
if(isset($_GET["id"])){
	//if an id was passed into the get variable, we want to check if that id is in our catalog
	$id = $_GET["id"];
	//check for this id in our catalog
	if(isset($catalog[$id])){
		$item = $catalog[$id];
	}
}

//if we don't find an item or we aren't passing a variable, then our item variable we
//not be set, we will want to redirect them to a full catalog
if(!isset($item)){
	header("locaction:catalog.php");
	exit;
}

//we have moved the pagetitle and section values below the redirect so that we can use
//the item values
$pageTitle = $item["title"];


//by default we are not showing any of our catagories we are just showing the full
//catalog so we don't need anything to be underlined.
//We can leave section null seeing as we are not using it in our navigation

$section = null;

include('inc/header.php'); 

?>

<div class="section page">

	<div class="wrapper">

		<div class="media-picture">
			
			<span>

				<img src="<?php echo $item["img"]; ?>" alt="<?php echo $item["title"]; ?>" />
			</span>

		</div>

	</div>

</div>

