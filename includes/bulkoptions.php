<?php 
if(isset($_POST['bulkoptionApply'])) {
    
    if(isset($_POST['checkBoxArray']) && isset($_POST['bulk_options'])) {
        $checkBoxArray = $_POST['checkBoxArray'];
        $length = count($checkBoxArray);

        if($length > 0) {
            foreach($checkBoxArray as $selectedRequestId) {
                $bulk_options = $_POST['bulk_options'];

                $status = new Status();
                $status->changeStatus($bulk_options, $selectedRequestId);

                $message = bulkoptionMessage($length, $bulk_options);
            }
        }
    } else {
        $bulkError = "<div class='error'>Select Status and check at least one checkbox!</div>";
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
    <?= (isset($bulkError))? $bulkError :"";?>