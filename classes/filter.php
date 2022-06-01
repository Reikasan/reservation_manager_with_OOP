<?php 

class filter {
    protected $url;
    public $searchArrayForSql;
    public $searchArrayForUrl;
    public $searchCategory;
    public $searchText;
    public $filters;
    public $filterParameter;
    protected $key;
    protected $value;
    public $filterBtnArray;

    public function __construct() {
        $this->searchArrayForSql = array();
        $this->searchArrayForUrl = array();
    }

    public function getSearchCatFromUrl() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY );
        if(preg_match('/request_date|request_name|request_email|request_tel|request_comment/',$url, $matches))  {
            return $this->searchCategory = $matches[0];
        }  
    }

    public function getFiltersFromUrl() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY );
        if(preg_match_all('/flag|date|status/',$url, $matches))  {
            return $this->filters = $matches[0];
        }  
    }

    public function setFiltersInArray() {
        global $database;

        if(isset($_POST['flag'])) {
            $this->searchArrayForUrl["flag"] = $database->escape_string($_POST['flag']);
        }
        if(isset($_POST['date'])) {
            $this->searchArrayForUrl["date"] = $database->escape_string($_POST['date']);
        }
        if(isset($_POST['status'])) {
            $this->searchArrayForUrl["status"] = $database->escape_string($_POST['status']);
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->searchArrayForUrl;
        }

        if(isset($_GET['flag'])) {
            $this->searchArrayForSql["request_flag"] = $database->escape_string($_GET['flag']);
        }
        if(isset($_GET['date'])) {
            $this->searchArrayForSql["request_date"] = $database->escape_string($_GET['date']);
        }
        if(isset($_GET['status'])) {
            $this->searchArrayForSql["request_status"] = $database->escape_string($_GET['status']);
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->searchArrayForSql;
        }
    } 

    public function constructFilterParameterForURL() {
        $this->filterParameter = "";
        foreach($this->searchArrayForUrl as $key => $value) {
            $this->filterParameter .= "{$key}={$value}&";
        }
        unset($value);
        return preg_replace('/\&$/', "", $this->filterParameter);
    }
    
    public function constructFilterParameterForSQL() {
        $this->filterParameter = " WHERE ";
    
        foreach($this->searchArrayForSql as $key => $value) {
            if($key === "request_date" && $value === "upcoming") {
                $this->filterParameter .= "{$key} >= now() AND ";
            } elseif($key === "request_date" && $value === "past") {
                $this->filterParameter .= "{$key} < now() AND ";
            } elseif(preg_match('/request_date|request_name|request_email|request_tel|request_comment/',$key)) {
                $this->filterParameter .= "{$key} LIKE '%{$value}%' AND ";
            } else {
                $this->filterParameter .= "{$key} = '{$value}' AND ";
            }
        }
        unset($value);
        return preg_replace('/AND\s$/', "", $this->filterParameter);
    }

    public function setSearchCategory() {
        global $database;

        if(isset($_POST['search'])) {
            return $this->searchCategory = $database->escape_string($_POST['searchCategories']);
        } else {
            return $this->searchCategory = $this->getSearchCatFromUrl();
        }
    }

    public function setSearchText() {
        global $database;

        if(isset($_POST['search'])) {
            return $this->searchText = $database->escape_string($_POST['searchText']);
        } elseif (isset($_POST['applyFilter'])) {
            return $this->searchText = $database->escape_string($_GET[$this->getSearchCatFromUrl()]);
        } elseif(isset($_GET[$this->setSearchCategory()])) {
            return $this->searchText = $database->escape_string($_GET[$this->setSearchCategory()]);
        }
    }

    public function combineFilters() {
        global $database;

        if(isset($_POST['applyFilter'])) {
            $this->searchArrayForUrl = $this->setFiltersInArray();
        } else {
            foreach($this->filters as $searchedFilter) {
                $this->searchArrayForUrl[$searchedFilter] = $database->escape_string($_GET[$searchedFilter]);
            }
            unset($searchedFilter);
        }
    }
    
    private function setSearchArrayFromUrlForFilterBtn() {
        global $database;
        $this->searchCategory = $this->setSearchCategory();

        if(isset($this->searchCategory)) {
            $this->searchArrayForUrl[$this->searchCategory] = $this->setSearchText();
        }
        if(isset($_GET['flag'])) {
            $this->searchArrayForUrl["flag"] = $database->escape_string($_GET['flag']);
        }
        if(isset($_GET['date'])) {
            $this->searchArrayForUrl["date"] = $database->escape_string($_GET['date']);
        }
        if(isset($_GET['status'])) {
            $this->searchArrayForUrl["status"] = $database->escape_string($_GET['status']);
        }
        return $this->searchArrayForUrl;
    }
    
    public function echoFilterBtn() {
        global $session;

        if(isset($session->searchArrayForUrl) && !empty($session->searchArrayForUrl)) {
            $this->searchArrayForUrl = $session->searchArrayForUrl;
        } else {
            $this->searchArrayForUrl = $this->setSearchArrayFromUrl();
        }

        $session->searchArrayForUrl($this, $this->searchArrayForUrl);
    
        echo "<form class='filterBtnContainer' method='post'> ";

        foreach($this->searchArrayForUrl as $key => $value) {
            if($key === 'flag' && $value === 'active') {
                echo "<button class='filterBtn'><span class='bold'>With Flag</span><input type='submit' class='cancelFilterInput' name='cancelFilter' value='{$key}'><i class='fas fa-times'></i></button>";
            } elseif($key === 'flag' && $value === 'deactive' ) {
                echo "<button class='filterBtn'><span class='bold'>Without Flag</span><input type='submit' class='cancelFilterInput' name='cancelFilter' value='{$key}'><i class='fas fa-times'></i></button>";
            } elseif(preg_match('/request_date|request_name|request_email|request_tel|request_comment/',$key)) {
                $displayCatName = Category::fetchCategoryName($this->searchCategory);
                echo "<button class='filterBtn'>" .ucfirst($displayCatName) ." = <span class='bold'>'" .ucfirst($value) ."'</span><input type='submit' class='cancelFilterInput' name='cancelFilter' value='{$key}'><i class='fas fa-times'></i></button>";
            } else {
                echo "<button class='filterBtn'>" .ucfirst($key) ." = <span class='bold'>'" .ucfirst($value) ."'</span><input type='submit' class='cancelFilterInput' name='cancelFilter' value='{$key}'><i class='fas fa-times'></i></button>";
            }
        }
        unset($value);
        
        echo "</form>";
    }

    public function cancelFilterAndRefreshSearch() {
        global $session;

        $this->canceledFilter = $_POST['cancelFilter'];
        $this->searchArrayForUrl =  $session->searchArrayForUrl;
        unset($this->searchArrayForUrl[$this->canceledFilter]);

        if(count($this->searchArrayForUrl) === 0) {
            $url = "reservation.php";
            unset($session->filterParameter);
            unset($session->searchArrayForUrl);
        } else {
            $this->filterParameter = $this->constructFilterParameterForURL($this->searchArrayForUrl);
            $url = "search.php?{$this->filterParameter}";
            $session->filterParameter($this, $this->filterParameter); 
            $session->searchArrayForUrl($this, $this->searchArrayForUrl);
        }
        redirect($url);
    }
}

?>