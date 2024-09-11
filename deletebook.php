<?php

// Initialize an empty $id variable
$id = '';

// Check if 'id' is set in the GET request and assign it to $id if it exists
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
var_dump($id);
// Include the product class file that contains the Product class definition
require_once 'book.class.php';

// Create an instance of the Product class
$obj = new Books();

// Call the delete method of the Product class with the $id parameter
// If deletion is successful, output 'success'; otherwise, output 'failed'
if ($obj->delete($id)) {
    echo 'success';
} else {
    echo 'failed';
}