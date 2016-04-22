<?php

function get_item_html($id,$item){
   $output =  '<li><a href="#"><img src="'
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
    if($category == null){
        //it returns an array of just the keys
        return array_keys($catalog);
    }
    //we want to return an array so we start by creating an empty array named output
    $output = array();

    //we need to loop through our catalog array, so once again we create a foreach loop

    foreach($catalog as $id => $item) {
        //foreach item we need to if the category is the one that matches our category
        //parameter 
        if(strtolower($category) == strtolower($item["category"])){
            //if the category we passed in as our arugement matches the category of the 
            //current item we are looping through, we need to add the id to the o/p array
            $output[] = $id;
        }
    }
    return $output;
    
}
