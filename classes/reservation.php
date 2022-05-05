<?php 

class Reservation extends Db_object {
    protected static $db_table = "reservation_request";
    protected static $db_table_fields = array('request_name', 'request_email', 'request_tel', 'request_date', 'request_time', 'request_num_seats', 'request_comment', 'request_status', 'request_recieved_time', 'request_edited_time', 'request_flag', 'request_via');

    public $request_id;
    public $request_name;
    private $request_email;
    private $request_tel;
    public $request_date;
    public $request_time;
    public $request_num_seats;
    public $request_comment;
    public $request_status;
    public $request_recieved_time;
    public $request_edited_time;
    public $request_flag;
    public $request_via;
 

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

    public function isflaged(){
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

    // Format Date and Time
    public function formatDate () {
        $formated_date = date_create($this->request_date);
        return $formated_date = date_format($formated_date, 'D d.m');
    } 
    
    public function formatTime() {
        $formated_time = date_create($this->request_time);
        return $formated_time = date_format($formated_time, 'H:i');
    }

    // CHECK PAST EVENT
    public function isPastEvent() {
        if($this->request_date < date("Y-m-d")) {
            return "done";
        } 
    }
} // end of class Reservation

?>