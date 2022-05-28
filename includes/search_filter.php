<?php
// filters
$filter = new Filter();

if(isset($_POST['cancelFilter'])) {
    $filter->cancelFilterAndRefreshSearch();
}

$searchCategory = $filter->setSearchCategory();
$filter->searchArrayForSql = $filter->setFiltersInArray();

if(isset($_GET[$searchCategory])) {
    $filter->searchArrayForSql[$searchCategory] = $filter->setSearchText();
}


$numResult = Reservation::countSearchResult($filter);

// Set val for pagination
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$items_total_count = $numResult;
$paginations_per_page = 5;

$paginate = new Paginate($page, $items_per_page, $items_total_count, $paginations_per_page);

$reservations = Reservation::searchReservationWithPagination($filter, $paginate, $items_per_page);

$session->current_search_page($page);

$displayCatName = Category::fetchCategoryName($searchCategory);

?>