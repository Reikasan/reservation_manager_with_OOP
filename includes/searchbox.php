<?php 
$filter = new Filter();

if(isset($_POST['search']) || isset($_POST['applyFilter'])) {
    
    if($filter->setSearchCategory()) {
        $filter->searchArrayForUrl[$filter->setSearchCategory()] = $filter->setSearchText();
    }

    $filter->combineFilters();
    $filter->filterParameter = $filter->constructFilterParameterForURL($filter->searchArrayForUrl);
    $url = "search.php?{$filter->filterParameter}";

    $session->filterParameter($filter, $filter->filterParameter);
    $session->searchArrayForUrl($filter, $filter->searchArrayForUrl);
    
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
    <p class="error-message hidden"></p>
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


