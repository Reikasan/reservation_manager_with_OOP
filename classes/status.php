<?php 

class Status extends DB_object{
    protected static $db_table = "reservation_request";

    public function changeStatus($option, $selectedRequestId) {
        global $database;
        $this->status = $database->escape_string($option);
        $this->id = $database->escape_string($selectedRequestId);

        $sql = "UPDATE ".self::$db_table ." SET request_status = '{$this->status}' WHERE request_id = {$this->id}";
        $database->query($sql);
    }   
}


?>