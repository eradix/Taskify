<?php

//function to make string a slug
function to_slug($slug)
{
    $data = str_replace(' ', '-', strtolower($slug));
    return $data;
}

// function to sanatize data
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
