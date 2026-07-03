<?php

require_once __DIR__ . '/../includes/db.php';

/*
    PayFast sends payment notifications to this page.
    For this student project, we use the payment status sent by PayFast.
    A production system should fully validate the ITN according to PayFast documentation.
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $order_id = $_POST['m_payment_id'] ?? null;
    $payment_status = $_POST['payment_status'] ?? null;
    $payment_reference = $_POST['pf_payment_id'] ?? null;

    if ($order_id && $payment_status) {

        if ($payment_status == "COMPLETE") {
            $status = "Paid";
        } else {
            $status = $payment_status;
        }

        $sql = "UPDATE orders
                SET status = ?
                WHERE order_id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
        mysqli_stmt_execute($stmt);
    }
}

http_response_code(200);
echo "OK";

?>