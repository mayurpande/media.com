<?php

function get_item_html($id,$item){
	$output =  '<li><a href="details.php?id=' . $id .'"><img src="'
          . $item["img"] . '" alt="'
          . $item["title"] .'" />'
          . '<p>View Details</p>'
          . '</a></li>';
   
   return $output;
}

//fn to return array keys for catalog
//we pass in arguements catalog array and the category we wish to return
function array_category($catalog,$category){
    //as the default section equal null, we run a condition to test to see if this
    //is true if it is display all categories
   
    //we want to return an array so we start by creating an empty array named output
    $output = array();

    //we need to loop through our catalog array, so once again we create a foreach loop

    foreach($catalog as $id => $item) {
        //foreach item we need to if the category is the one that matches our category
        //parameter
        if($category == null || strtolower($category) == strtolower($item["category"])){
            //after we check if this item matches our category, we want to create
            //a variable to use for sorting we can use any element to sort with 
            //but title would seem the most useful
            $sort = $item["title"];
            //we use ltrim to get rid of any preceding words in title i.e. the,a
            $sort = ltrim($sort,"The ");
            $sort = ltrim($sort,"A ");
            $sort = ltrim($sort,"An ");
            /* now instead of just adding the key to the array we also want to assign the
             * value to sort
             */
            //if the category we passed in as our arugement matches the category of the 
            //current item we are looping through, we need to add the id to the o/p array
            $output[$id] = $sort;
                   }
    }
    //before we return our o/p array we need to do two things;
    //1) sort the array using in-built fn called asort
    //2) Since we changed our array to include more than just the keys, we want to return
    //only the keys, like we did on null. So again we use array keys

    asort($output);
    return array_keys($output);
    
}
