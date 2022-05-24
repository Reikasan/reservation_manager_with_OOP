<?php
// filters
$filter = new Filter();

$searchCategory = $filter->getSearchCatFromUrl();

if(isset($_GET[$searchCategory])) {
    $searchText =  $database->escape_string($_GET[$searchCategory]);
    $filter->searchArray[$searchCategory] = $searchText;
}

$filter->searchArray = $filter->setFiltersInArray();

$filteredReservation = Reservation::searchReservation($filter);
echo $numResult = Reservation::countSearchResult($filter);

// Set val for pagination
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4;
$items_total_count = $numResult;
$paginations_per_page = 5;

$paginate = new Paginate($page, $items_per_page, $items_total_count, $paginations_per_page);

$reservations = Reservation::searchReservationWithPagination($filter, $paginate, $items_per_page);
$_SESSION['current_search_page']= $page;

$displayCatName = Category::fetchCategoryName($searchCategory);

?>