<?php


// SEARCH
if(isset($_POST['search']) || $session->is_searched()) {
    if($session->is_searched()) {
        $searchText = $_SESSION['searchText'];
        $searchCategory = $_SESSION['searchCategory'];
        
    } else {
        $searchText = $_POST['searchText'];
        $searchCategory = $_POST['searchCategories'];

        $_SESSION['searchText'] = $searchText;
        $_SESSION['searchCategory'] = $searchCategory;
    }
    
    $numResult = Reservation::countSearchResult($searchText, $searchCategory);

    // Set val for pagination
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $items_per_page = 10;
    $items_total_count = $numResult;
    $paginations_per_page = 5;

    $paginate = new Paginate($page, $items_per_page, $items_total_count, $paginations_per_page);

    $reservations = Reservation::searchReservationWithPagination($searchText, $searchCategory, $paginate);
    $_SESSION['currentPage']= $page;

    $displayCatName = Category::fetchCategoryName($searchCategory);
 
}

?>