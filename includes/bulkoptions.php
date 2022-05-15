<?php 
if(isset($_POST['bulkoptionApply'])) {
    
    if(isset($_POST['checkBoxArray']) && isset($_POST['bulk_options'])) {
        $checkBoxArray = $_POST['checkBoxArray'];
        $length = count($checkBoxArray);

        if($length > 0) {
            foreach($checkBoxArray as $selectedRequestId) {
                $bulkoption = $_POST['bulk_options'];

                $status = new Status();
                $status->changeStatus($bulkoption, $selectedRequestId);
            }

            if($length === 1) {
                $message = "<h2 class='success'><span class='bold'>1 item</span> selected and change status to <span class='bold'>" .ucfirst($bulkoption) ."</span><i class='fas fa-times closeBtn'></i></h2>";
            } else {
                $message = "<h2 class='success'><span class='bold'>$length items</span> selected and selected and change status to <span class='bold'>" .ucfirst($bulkoption) ."</span><i class='fas fa-times closeBtn'></i></h2>"; 
            }

        }
    } else {
        $bulkOptionError ="<div class='error'>Select Status and check at least one checkbox!</div>";
    }
} 
?>

<form id="bulkOptions" method="post">
    <div id="bulkOptionsContainer">
        <select name="bulk_options" id="">
            <option value="" disabled selected>Change Status</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirm</option>
            <option value="canceled">Cancel</option>
            <option value="unread">Unread</option>
        </select>
        <input type="submit" name="bulkoptionApply" id="bulkoptionApply" value="Apply">
    </div>
    <?= (isset($bulkOptionError))? $bulkOptionError : null;?>