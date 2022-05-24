<?php 

class filter {
    private $searchSet;
    public $filterParameter;
    public $key;
    public $value;

    public function getSearchCatFromUrl() {
        $searchSet = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY );
        if(preg_match('/request_date|request_name|request_email|request_tel|request_comment/',$searchSet, $matches))  {
            return $searchCategory = $matches[0];
        }  
    }

    public function getFiltersFromUrl() {
        echo $searchSet = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY );
        if(preg_match_all('/flag|date|status/',$searchSet, $matches))  {
            return $matches[0];
        }  
    }

    public function setFiltersInArray($searchArray) {
        global $database;

        if(isset($_POST['flag'])) {
            $searchArray["flag"] = $database->escape_string($_POST['flag']);
        }
        if(isset($_POST['date'])) {
            $searchArray["date"] = $database->escape_string($_POST['date']);
        }
        if(isset($_POST['status'])) {
            $searchArray["status"] = $database->escape_string($_POST['status']);
        }

        if(isset($_GET['flag'])) {
            $searchArray["request_flag"] = $database->escape_string($_GET['flag']);
        }
        if(isset($_GET['date'])) {
            $searchArray["request_date"] = $database->escape_string($_GET['date']);
        }
        if(isset($_GET['status'])) {
            $searchArray["request_status"] = $database->escape_string($_GET['status']);
        }
        return $searchArray;
    } 

    public function constructFilterParameterForURL($searchArray) {
        $filterParameter = "";
        foreach($searchArray as $key => $value) {
            $filterParameter .= "{$key}={$value}&";
        }
        unset($value);
        return preg_replace('/\&$/', "", $filterParameter);
    }
    
    public function constructFilterParameterForSQL($searchArray) {
        $filterParameter = " WHERE ";
    
        foreach($searchArray as $key => $value) {
            if($key === "request_date" && $value === "upcoming") {
                $filterParameter .= "{$key} >= now() AND ";
            } elseif($key === "request_date" && $value === "past") {
                $filterParameter .= "{$key} < now() AND ";
            } elseif(preg_match('/request_date|request_name|request_email|request_tel|request_comment/',$key)) {
                $filterParameter .= "{$key} LIKE '%{$value}%' AND ";
            } else {
                $filterParameter .= "{$key} = '{$value}' AND ";
            }
        }
        unset($value);
        return preg_replace('/AND\s$/', "", $filterParameter);
    }
    
    
}

?>