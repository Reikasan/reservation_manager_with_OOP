<?php 

class filter {
    protected $url;
    public $searchArray;
    public $searchCategory;
    public $filters;
    public $filterParameter;
    protected $key;
    protected $value;

    public function __construct() {
        $this->searchArray = array();
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
            $this->searchArray["flag"] = $database->escape_string($_POST['flag']);
        }
        if(isset($_POST['date'])) {
            $this->searchArray["date"] = $database->escape_string($_POST['date']);
        }
        if(isset($_POST['status'])) {
            $this->searchArray["status"] = $database->escape_string($_POST['status']);
        }

        if(isset($_GET['flag'])) {
            $this->searchArray["request_flag"] = $database->escape_string($_GET['flag']);
        }
        if(isset($_GET['date'])) {
            $this->searchArray["request_date"] = $database->escape_string($_GET['date']);
        }
        if(isset($_GET['status'])) {
            $this->searchArray["request_status"] = $database->escape_string($_GET['status']);
        }
        return $this->searchArray;
    } 

    public function constructFilterParameterForURL() {
        $this->filterParameter = "";
        foreach($this->searchArray as $key => $value) {
            $this->filterParameter .= "{$key}={$value}&";
        }
        unset($value);
        return preg_replace('/\&$/', "", $this->filterParameter);
    }
    
    public function constructFilterParameterForSQL() {
        $this->filterParameter = " WHERE ";
    
        foreach($this->searchArray as $key => $value) {
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
            return $database->escape_string($_POST['searchCategories']);
        } else {
            return $this->getSearchCatFromUrl();
        }
    }

    public function setSearchText() {
        global $database;

        if(isset($_POST['search'])) {
            return $database->escape_string($_POST['searchText']);
        } elseif (isset($_POST['applyFilter'])) {
            return $database->escape_string($_GET[$this->getSearchCatFromUrl()]);
        } elseif(isset($_GET[$this->setSearchCategory()])) {
            return $database->escape_string($_GET[$this->setSearchCategory()]);
        }
    }
    public function combineFilters() {
        global $database;
        
        if($this->getFiltersFromUrl()) {
            foreach($this->filters as $searchedFilter) {
                $this->searchArray[$searchedFilter] = $database->escape_string($_GET[$searchedFilter]);
            }
            unset($searchedFilter);
        } else {
            $this->searchArray = $this->setFiltersInArray();
        }
    }
}

?>