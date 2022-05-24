<?php 
// REDIRECT
function redirect($location) {
    header("Location: " .$location);
    exit;
}

// CHECK UNREAD REQUEST
function checkUnreadRequest() {
    global $connection;
    $query = "SELECT * FROM reservation_request WHERE request_status = 'unread'";
    $result = mysqli_query($connection, $query);

    $num_rows = mysqli_num_rows($result);
}

// ECHO FLAG
function echoFlag($flag){
    if($flag === "" || empty($flag) || $flag === "deactive") {
        echo "<i class='far fa-flag'></i>";
    } else {
        echo "<i class='fas fa-flag active'></i>";
    }
}

//  ECHO COMMENT SIGN
function echoCommentSign($another_request_comment) {
    if($another_request_comment !== "" || !empty($another_request_comment)) {
        echo "<p title='Special Request'><i class='fas fa-exclamation'></i></p>";
    } 
}

function checkSelected($value, $selected_value) {
    if($value == $selected_value) {
        return "selected";
    } 
}






// SEARCH_FILTER.PHP
// function chengeFilterQuery($selectedFilter, $selectedFilterValue, $selectedFilterQueries, $filters, $filterValues, $filterQueries) {
//     global $filters;
//     global $filterValues;
//     global $filterQueries;
    
//     if($selectedFilter == "Flag") {
//         $columnName = 'request_flag';
//     } elseif ($selectedFilter == "Event date") {
//         $columnName = 'request_date';
//     } elseif ($selectedFilter == "Status") {
//         $columnName = 'request_status';
//     }

//     if((isset($_POST['search']) || isset($_SESSION['searchText'])) || count($filters) > 0) {
//         if($selectedFilterValue == "upcoming") {
//             $selectedFilterQueries = "AND {$columnName} >= now() ";
//         } elseif($selectedFilterValue == "past") {
//             $selectedFilterQueries = "AND {$columnName} < now() ";
//         } else {
//         $selectedFilterQueries = "AND {$columnName} = '{$selectedFilterValue}' ";
//         }
//     } else {
//         if($selectedFilterValue == "upcoming") {
//             $selectedFilterQueries = "WHERE {$columnName} >= now() ";
//         } elseif($selectedFilterValue == "past") {
//             $selectedFilterQueries = "WHERE {$columnName} < now() ";
//         } else {
//         $selectedFilterQueries = "WHERE {$columnName} = '{$selectedFilterValue}' ";
//         }
//     }

//     array_push($filters, $selectedFilter);
//     array_push($filterValues, $selectedFilterValue);
//     array_push($filterQueries, $selectedFilterQueries);
// }

function createFilterQuery($filters, $filterQueries, $query, $filterLength) {
    if($filterLength > 0) {
        foreach($filterQueries as $filterQuery) {
            $filterQuery;
            $query .= $filterQuery;
        }

        return $query;
    } else {
        return $query;
    }
}

function createFilterBtn($filters, $filterValues, $i) {
    if(array_key_exists($i, $filters)) {
        $filter = ucfirst($filters[$i]);
        $filterValue = ucfirst($filterValues[$i]);
        echo $filterBtn = "<button class='filterBtn'>{$filter}: <span class='bold'>'{$filterValue}'</span><input type='submit' class='cancelFilterInput' name='cancelFilter' value='{$filterValue}'><i class='fas fa-times'></i></button>";
    } 
}

function replaceQueryString($filterQueries, $arrayIndex) {
    $changeQuery = $filterQueries[$arrayIndex];
    $filterQueries[$arrayIndex] = str_replace('AND', 'WHERE', $changeQuery);
    return $filterQueries[$arrayIndex];
}

/* BULKOPTIONS */
function checkQuery() {
    if(isset($_SESSION['searchQuery'])) {
        $query = $_SESSION['searchQuery'];
    } elseif(isset($_SESSION['query'])) {
        $query = $_SESSION['query'];
    } else {
        $query = "SELECT * FROM reservation_request ";
    }

    return $query;
}

/* DETAILS.PHP */
function checkChecked($value, $selected_value) {
    if($selected_value === $value) {
        echo "checked";
    }
}

/* EDIT_RESERVATION.PHP */
function returnValueIfItsNotNull($variable) {
    if($variable !== null) {
        return $variable;
    }
}

/* SEARCH_FILTER.PHP */
function getSearchCatFromUrl() {
    $searchSet = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY );
    preg_match('/request_date|request_name|request_email|request_tel|request_comment/',$searchSet, $matches);
    return $searchCategory = $matches[0];
}

/* SEARCHBOX.PHP */
function constructFilterParameterForURL($filters) {
    $filterParameter = "";
    foreach($filters as $key => $value) {
        $filterParameter .= "{$key}={$value}&";
    }
    unset($value);
    return preg_replace('/\&$/', "", $filterParameter);
}

function constructFilterParameterForSQL($filters) {
    $filterParameter = " WHERE ";

    foreach($filters as $key => $value) {
        if($key === "request_date" && $value === "upcoming") {
            $filterParameter .= "{$key} >= now() AND ";
        } elseif($key === "request_date" && $value === "past") {
            $filterParameter .= "{$key} < now() AND ";
        } else {
            $filterParameter .= "{$key} = '{$value}' AND ";
        }
    }
    unset($value);
    return preg_replace('/AND\s$/', "", $filterParameter);
}

?>