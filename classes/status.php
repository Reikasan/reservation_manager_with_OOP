<?php 

class Status {
    protected $status;

    public function changeStatus($option, $selectedRequestId) {
        $query = "UPDATE reservation_request SET request_status = ? WHERE request_id = ?";
        $db = new Database();
        $mysqli = $db->open_db_connection();
    
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $option, $selectedRequestId);
        $stmt->execute();
        $query = checkQuery();
    }

    
}


?>