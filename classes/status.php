<?php 

class Status {
    protected $status;

    public function changeStatus($bulk_options, $selectedRequestId) {
        $bulkoptionQuery = "UPDATE reservation_request SET request_status = ? WHERE request_id = ?";
        $db = new Database();
        $mysqli = $db->open_db_connection();
    
        $stmt = $mysqli->prepare($bulkoptionQuery);
        $stmt->bind_param("si", $bulk_options, $selectedRequestId);
        $stmt->execute();
        $query = checkQuery();
    }
}


?>