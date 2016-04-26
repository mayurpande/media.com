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

		<div class="media-details">
			
			<h1><?php echo $item["title"]; ?></h1>

			<table>

				<tr>
					<th>Category</th>
					<td><?php echo $item["category"]; ?></td>
				</tr>
				
				<tr>
					<th>Genre</th>
					<td><?php echo $item["genre"]; ?></td>
				</tr>
				<tr>
					<th>Format</th>
					<td><?php echo $item["format"]; ?></td>
				</tr>			
				<tr>
					<th>Year</th>
					<td><?php echo $item["year"]; ?></td>
				</tr>

				<?php 
				/* our different categories will have different item details in them, we can use a conditional to check through for these additional item details using strtolower fn and then display them using the same format as above */
				if(strtolower($item["category"]) == "books"){
				?>
				<tr>
					<th>Authors</th>
					<!-- implode built in php fn that allows us to seperate array elenents with a comma --!>
					<td><?php echo implode(", ",$item["authors"]); ?></td>
				</tr>

				<tr>
					<th>Publisher</th>
					<td><?php echo $item["publisher"]; ?></td>
				</tr>

				<tr>
					<th>ISBN</th>
					<td><?php echo $item["isbn"]; ?></td>
				</tr>

				<?php } else if(strtolower($item["category"]) == "movies"){ ?>
				
				<tr>
					<th>Director</th>
					<td><?php echo $item["director"]; ?></td>
				</tr>

				<tr>
					<th>Writers</th>
					<!-- implode built in php fn that allows us to seperate array elenents with a comma --!>
					<td><?php echo implode(", ",$item["writers"]); ?></td>
				</tr>
				<tr>
					<th>Stars</th>
					<!-- implode built in php fn that allows us to seperate array elenents with a comma --!>
					<td><?php echo implode(", ",$item["stars"]); ?></td>
				</tr>
				
				<?php } else if(strtolower($item["category"]) == "music"){ ?>
				<tr>
					<th>Artist</th>
					<td><?php echo $item["artist"]; ?></td>
				</tr>			
				

				<?php } ?>

			</table>
		</div>


	</div>

</div>

