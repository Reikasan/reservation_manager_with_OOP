<?php

// SEARCH
// $searchCategory = getSearchCatFromUrl();

// if(isset($_GET[$searchCategory])) {
//     echo $searchText =  $_GET[$searchCategory];
    
//     $_SESSION['searchText'] = $searchText;
//     $_SESSION['searchCategory'] = $searchCategory;
// }

// echo $numResult = Reservation::countSearchResult($searchText, $searchCategory);

// // Set val for pagination
// $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
// $items_per_page = 10;
// $items_total_count = $numResult;
// $paginations_per_page = 5;

// $paginate = new Paginate($page, $items_per_page, $items_total_count, $paginations_per_page);

// $reservations = Reservation::searchReservationWithPagination($searchText, $searchCategory, $paginate);
// $_SESSION['current_search_page']= $page;

// $displayCatName = Category::fetchCategoryName($searchCategory);


// filters
$filters = array();

if(isset($_GET['flag'])) {
    $filters["request_flag"] = $database->escape_string($_GET['flag']);
}
if(isset($_GET['date'])) {
    $filters["request_date"] = $database->escape_string($_GET['date']);
}
if(isset($_GET['status'])) {
    $filters["request_status"] = $database->escape_string($_GET['status']);
}

$filteredReservation = Reservation::filterReservation($filters);
echo $numResult = count($filteredReservation);

?>