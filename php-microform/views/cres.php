<!DOCTYPE html>
<html lang="en">
<head>
<?php
include '../templates/metadata.php';
// Handle Return Notification from 3DS
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $data = $_POST;
    $transId = $data["TransactionId"];
    $authTransId = "";
    if(isset($data["TransactionId"])) {
        $authTransId = $data["TransactionId"];
    }
    // save 3DS auth result
    if (!is_dir('../storage')) {
        mkdir('../storage', 0777, true); // true = recursive
    }
    file_put_contents('../storage/authTransId.txt', $authTransId, FILE_APPEND | LOCK_EX);
}
?>
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Key</th>
                <th scope="col">value</th>
            </tr>
        </thead>
        <tbody>
            <tr scope="row">
                <td>Cres</td>
                <td style="max-width: 200px">
                    <pre><?php echo json_encode($data, JSON_PRETTY_PRINT); ?></pre>
                </td>
            </tr>
            <?php
                include 'validateauth.php';
            ?>
<?php
include '../templates/footer.php';
?>