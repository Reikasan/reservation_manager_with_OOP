<?php 
$filter = new Filter();

if(isset($_POST['search']) || isset($_POST['applyFilter'])) {

    if(isset($_POST['search'])) {
        $searchText =  $_POST['searchText'];
        $searchCategory =  $_POST['searchCategories'];
        $filter->searchArray[$searchCategory] = $searchText;

        if($filter->filters = $filter->getFiltersFromUrl()) {
            foreach($filter->filters as $searchedFilter) {
                $filter->searchArray[$searchedFilter] = $_GET[$searchedFilter];
            }
            unset($searchedFilter);
        };
    } elseif(isset($_POST['applyFilter'])) {
        $filter->searchArray  = $filter->setFiltersInArray();
        $searchCategory = $filter->getSearchCatFromUrl();

        if(isset($_GET[$searchCategory])) {
            $searchText =  $_GET[$searchCategory];
            $filter->searchArray[$searchCategory] = $searchText;
        }
    }
    
    $filter->filterParameter = $filter->constructFilterParameterForURL($filter->searchArray);
    $url = "search.php?{$filter->filterParameter}";

    $_SESSION['filterParameter'] = $filter->filterParameter;
    redirect($url);
}

?>

<div class="search">
    <form action="<?= !preg_match('/search.php/', $_SERVER['PHP_SELF']) ? "search.php" : null; ?>" method="post" id="searchForm">
        <div class="search-bar">
            <div class="row-1">
                <i class="fas fa-search"></i>
                <input type="text" name="searchText" id="searchText" class="search-input" placeholder="Search" requeired>
                <p> in </p>
            </div>
            <div class="row-2">
                <select name="searchCategories" id="searchCategory" class="search-input" requeired> 
                    <option value="">Category</option>
                    <option value="request_date">Date</option>
                    <option value="request_name">Name</option>
                    <option value="request_email">Email</option>
                    <option value="request_tel">Phone number</option>
                    <option value="request_comment">Special Request</option>    
                </select>
                <input type="submit" value="Search" name="search" id="searchBtn" class="searchBtn">
            </div>
        </div>
    </form>
    <p id="addFilter">Add Filter<i class="fas fa-caret-down"></i></p>
    <form  method="post" class="filter hide" id="filterForm">
        <i class='fas fa-times closeBtn'></i>
        <div class="filterContainer row">
            <div class="col1">
                <div>
                    <p>Flag</p>
                    <ul>
                        <li>With Flag<input type="checkbox" name='flag' value="active" id="flag1"></li>
                        <li>No Flag<input type="checkbox" name='flag' value="deactive" id="flag2"></li>
                    </ul>
                </div>
                <div>
                    <p>Upcoming</p>
                    <ul>
                        <li>Upcoming Request<input type="checkbox" name='date' value="upcoming" id="upcoming"></li>
                        <li>Past Request<input type="checkbox" name='date' value="past" id="past"></li>
                    </ul>
                </div>
            </div>
            <div class="col2">
                <div>
                    <p>Status</p>
                    <ul>
                        <li>Unread<input type="checkbox" name='status' value="unread" id="unread"></li>
                        <li>Pending<input type="checkbox" name='status' value="pending" id="pending"></li>
                        <li>Confirmed<input type="checkbox" name='status' value="confirmed" id="confirmed"></li>
                        <li>Canceled<input type="checkbox" name='status' value="canceled" id="canceled"></li>
                    </ul>
                </div>   
            </div> 
        </div>
        <div class="btn-container">
            <input class="filterBtn" type="button" value="Clear all Filter" id="clearBtn">
            <input class="filterBtn" type="submit" name="applyFilter" value="Apply Filter">
        </div>
    </form>
</div>


