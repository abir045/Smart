<?php
define('DB_SERVER', 'localhost'); //servername
define('DB_USERNAME', 'root'); // DB username
define('DB_PASSWORD', ''); //password
define('DB_NAME', 'trixgxle_smart'); //database name

/* Attempt to connect to MySQL database */
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . $conn->connect_error);
}

// getting featured products

//fetching values
//$stmt->fetch();

// create a prepared statement
$stmt =  $conn->prepare("SELECT * FROM  `cor_prods` LIMIT 4");

// execute query
$stmt->execute();


$featuredProducts =  $stmt->get_result();

//fetching all products


$limit = 4;

if (isset($_GET['page'])) {
    $page_number = $_GET['page'];
} else {
    $page_number = 1;
}

//get the nitial page number

$initial_page = ($page_number - 1) * $limit;


//get data of selected rows per page

$stmt2 = $conn->prepare("SELECT * FROM  `cor_prods` LIMIT $initial_page, $limit ");

$stmt2->execute();

$allProducts = $stmt2->get_result();

$getQuery = "SELECT COUNT(*) FROM `cor_prods` ";

$result = mysqli_query($conn, $getQuery);

$row = mysqli_fetch_row($result);

$total_rows = $row[0];



//pagination for stay products

$stay_limit = 20;

if (isset($_GET['page'])) {
    $stay_page_number = $_GET['page'];
} else {
    $stay_page_number = 1;
}

//get the nitial page number

$initial_stay_page = ($stay_page_number - 1) * $stay_limit;


//get data of selected rows per page

$stmt9 = $conn->prepare("SELECT * FROM  `cor_prods` WHERE cat='6' LIMIT $initial_stay_page, $stay_limit ");

$stmt9->execute();

$stayProducts = $stmt9->get_result();


$getStayQuery = "SELECT COUNT(*) FROM `cor_prods` WHERE cat='6' ";



$stay_result = mysqli_query($conn, $getStayQuery);

$stay_row = mysqli_fetch_row($stay_result);

$stay_total_rows = $stay_row[0];

echo $stay_total_rows;




//filter by category Food

$stmt3 = $conn->prepare("SELECT * FROM  `cor_prods`  WHERE cat='1' ");

$stmt3->execute();

$foodProducts = $stmt3->get_result();


// var_dump($foodProducts);

//filter by category Multi themes

$stmt4 = $conn->prepare("SELECT * FROM  `cor_prods`  WHERE cat='2' ");

$stmt4->execute();

$multiThemesProducsts = $stmt4->get_result();


//filter by category spa

$stmt5 = $conn->prepare("SELECT * FROM  `cor_prods`  WHERE cat='7' ");

$stmt5->execute();

$spaProducts = $stmt5->get_result();

// var_dump($spaProducts);

//filter by category stay

// $stmt6 = $conn->prepare("SELECT * FROM  `cor_prods`  WHERE cat='6' ");

// $stmt6->execute();

// $stayProducts = $stmt6->get_result();

//var_dump($stayProducts);


//filter by category wellness

$stmt7 = $conn->prepare("SELECT * FROM  `cor_prods`  WHERE cat='4' ");

$stmt7->execute();

$wellnessProducts = $stmt7->get_result();

//var_dump($wellnessProducts);



//filter by category sport

$stmt8 = $conn->prepare("SELECT * FROM  `cor_prods`  WHERE cat='5' ");

$stmt8->execute();

$sportsProducts = $stmt8->get_result();

// var_dump($sportsProducts);
