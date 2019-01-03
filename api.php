<?php

error_reporting(0);

/**
 * To prevent repeating several lines of code, here's a handy function to respond & kill the page
 *
 * @param array $data The data to respond with
 * @param boolean $success Whether or not the data fetch was successful
 * @return void
 */
function respond($data = [], $success = true){
	header('Content-type: application/json');
	
	die(json_encode([
		'data' => $data,
		'success' => $success,
	]));
}



// Connect to the database
try {
	$DB = new PDO(
		'mysql:host=localhost;dbname=vuejs-search;',
		'root',
		''
	);
}
// If it fails, respond with false success and a 500 error
catch(Exception $e){
	http_response_code(500);
	
	respond([
		'message' => 'Fatal error: could not connect to database'
	], false);
}



// See if the search string is valid

// $_REQUEST because idk if I'm using $_GET or $_POST
// For the sake of this example, I don't see any need to restrict it to one or the otehr
if(empty($s = $_REQUEST['s'])){
	respond([
		'message' => 'No search string given',
	], false);
}



// Database code

// Set the baseline SQL here
// We're gonna use the same baseline SQL string to get the total number of results,
// As well as a limited number of the actual results
$sql = "SELECT {{KEYS}} FROM words WHERE word LIKE :queries";
// Set the values for execute() here
// We want to use it more than once so it really should be saved here to prevent repeated code
$values = [
	'queries' => preg_replace('/[ \*]/', '%', $s) . '%',
];
// Get the maximum number of results per page
$limit = 10;
// Set the page number here
// It has to exist, be an integer, and be at least one
// Otherwise, default to 1
if(empty($page = $_REQUEST['page']) || !is_numeric($page) || $page < 1){
	$page = 1;
}
// Get the actual page value that we put in the LIMIT part of the query
$pageValue = $limit * ($page  - 1);

// Get the number of results by querying for the count without a limit
$count = $DB->prepare(str_replace('{{KEYS}}', 'COUNT(*) AS count', $sql));
$count->execute($values);
$count = $count->fetch(PDO::FETCH_OBJ);

// See if the count is valid
// If not, assume no results
if(empty($count = $count->count)){
	respond([
		'message' => 'No results'
	], false);
}

// Do the same, but for the actual results now
$q = $DB->prepare(str_replace('{{KEYS}}', 'word', $sql) . " LIMIT $pageValue, $limit;");
$q->execute($values);

// Get the results
$results = $q->fetchAll(PDO::FETCH_OBJ);

// Respond with the results
respond([
	'message' => 'Results found',
	'results' => $results,
	'totalPages' => ceil($count / $limit),
	'totalResults' => $count,
]);

?>