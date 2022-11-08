<?php

include('connection.php');


$stmt =  $conn->prepare("SELECT * FROM  `cor_prods` LIMIT 4");

$stmt->execute();


$featuredProducts =  $stmt->get_result(); //[]

//echo $featuredProducts;
