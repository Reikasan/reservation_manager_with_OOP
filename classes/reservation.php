<?php 

class Reservation extends Db_object {
    protected static $db_table = "reservation_request";
    protected static $id_name = "request_id";
    protected static $db_table_fields = array('request_name', 'request_email', 'request_tel', 'request_date', 'request_time', 'request_num_seats', 'request_comment', 'request_status', 'request_recieved_time', 'request_edited_time', 'request_flag', 'request_via');
    
    public $request_id;
    public $request_name;
    public $request_email;
    public $request_tel;
    public $request_date;
    public $request_time;
    public $request_num_seats;
    public $request_comment;
    public $request_status;
    public $request_recieved_time;
    public $request_edited_time;
    public $request_flag;
    public $request_via;
    public $id;
 
    public static function selectByRequestDate($request_date) {
        return static::find_by_query("SELECT * FROM " .static::$db_table ." where request_date = '" .$request_date ."'");
    }

    public static function searchReservation($searchText, $searchCategory) {
        global $database;
        echo $searchText = $database->escape_string($searchText);
        echo $searchCategory = $database->escape_string($searchCategory);

        $sql = "SELECT * FROM " .static::$db_table ." WHERE {$searchCategory} LIKE '%{$searchText}%' ";
        return $results = static::find_by_query($sql);
    }

    public static function countSearchResult($searchText, $searchCategory) {
        return count(static::searchReservation($searchText, $searchCategory));
    }

    public static function searchReservationWithPagination($searchText, $searchCategory, $paginate) {
        $items_per_page = static::countSearchResult($searchText, $searchCategory);

        $sql = "SELECT * FROM " .static::$db_table ." WHERE {$searchCategory} LIKE '%{$searchText}%' ";
        $sql .= "ORDER BY request_recieved_time DESC ";
        $sql .= "LIMIT {$items_per_page} ";
        $sql .= "OFFSET {$paginate->offset()}";
        return $results = static::find_by_query($sql);
    }

    public static function filterReservation($filters) {
        $filters = constructFilterParameterForSQL($filters);
        echo $sql = "SELECT * FROM " .static::$db_table .$filters;
        return $results = static::find_by_query($sql);
    }

    public function isUnread() {
        if($this->request_status == "unread") {
            return true;
        }
    }

    public function showUnreadSign() {
        if($this->isUnread()) {
            return "<i class='fas fa-circle' title='unread'></i>";
        }
    }

    public function isFlagged(){
        if($this->request_flag === "active") {
            return "fas active";
        } else {
            return "far ";
        }
    }

    // ECHO SUBSTRINGED COMMENT 
    public function substringedComment() {
        if(strlen($this->request_comment) >= 20) {
            return $this->request_comment = substr($this->request_comment, 0, 20). "...";
        } elseif(strlen($this->request_comment) > 0) {
            return $this->request_comment;
        } else {
            return " - ";
        }
    }

    // Format Date and Time for Display
    public function formatDate() {
        $formatted_date = date_create($this->request_date);
        return $formatted_date = date_format($formatted_date, 'D d.m');
    } 

    public function formatTime() {
        $formatted_time = date_create($this->request_time);
        return $formatted_time = date_format($formatted_time, 'H:i');
    }

    public function formatTimeStamp($timestamp) {
        $formatted_timestamp = date_create($this->$timestamp);
        return $formatted_timestamp = date_format($formatted_timestamp, 'D d.m.Y H:i');
    }

    // CHECK PAST EVENT
    public function isPastEvent() {
        if($this->request_date < date("Y-m-d")) {
            return "done";
        } 
    }


    public function ajax_change_flag_status($flag_status, $request_id) {
        global $database;
        $flag_status = $database->escape_string($flag_status);
        $request_id = $database->escape_string($request_id);
        
        $sql = "UPDATE " .static::$db_table ." SET request_flag = '{$flag_status}' ";
        $sql .= "WHERE request_id = {$request_id}";

        $database->query($sql);
    }

    public function ajax_load_flag_status($request_id) {
        $reservation = static::find_by_id($request_id);
        return $reservation->isFlagged($reservation->request_flag);
    }
} // end of class Reservation

?>