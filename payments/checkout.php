<?php

session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['product_id'])) {
    die("No product selected.");
}

$buyer_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];

$sql = "SELECT products.*, users.full_name
        FROM products
        JOIN users ON products.user_id = users.user_id
        WHERE products.product_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

$amount = number_format($product['price'], 2, '.', '');
$quantity = 1;
$status = "Pending";

$order_sql = "INSERT INTO orders (buyer_id, product_id, quantity, total_price, status)
              VALUES (?, ?, ?, ?, ?)";

$order_stmt = mysqli_prepare($conn, $order_sql);
mysqli_stmt_bind_param($order_stmt, "iiids", $buyer_id, $product_id, $quantity, $amount, $status);
mysqli_stmt_execute($order_stmt);

$order_id = mysqli_insert_id($conn);

/* PayFast Sandbox Credentials */
$merchant_id = "10000100";
$merchant_key = "46f0cd694581a";

/* IMPORTANT: Leave blank for these sandbox credentials */
$passphrase = "";

$return_url = "http://sowetomarket.fwh.is/payments/payment-success.php?order_id=" . $order_id;
$cancel_url = "http://sowetomarket.fwh.is/payments/payment-cancel.php?order_id=" . $order_id;
$notify_url = "http://sowetomarket.fwh.is/payments/payment-notify.php";

$payment_data = array(
    "merchant_id" => $merchant_id,
    "merchant_key" => $merchant_key,
    "return_url" => $return_url,
    "cancel_url" => $cancel_url,
    "notify_url" => $notify_url,
    "m_payment_id" => $order_id,
    "amount" => $amount,
    "item_name" => trim($product['product_name'])
);

/* Build PayFast signature */
$signature_string = "";

foreach ($payment_data as $key => $value) {
    if ($value !== "") {
        $signature_string .= $key . "=" . urlencode(trim($value)) . "&";
    }
}

$signature_string = rtrim($signature_string, "&");

if ($passphrase !== "") {
    $signature_string .= "&passphrase=" . urlencode(trim($passphrase));
}

$payment_data["signature"] = md5($signature_string);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - SowetoMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="../products.php" class="navbar-brand">SowetoMarket</a>
    </div>
</nav>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-success text-white">
                    <h3>Checkout</h3>
                </div>

                <div class="card-body">

                    <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>

                    <p>
                        <strong>Price:</strong>
                        R<?php echo number_format($product['price'], 2); ?>
                    </p>

                    <p>
                        <strong>Seller:</strong>
                        <?php echo htmlspecialchars($product['full_name']); ?>
                    </p>

                    <p>
                        <strong>Order ID:</strong>
                        <?php echo $order_id; ?>
                    </p>

                    <form action="https://sandbox.payfast.co.za/eng/process" method="POST">

                        <?php foreach ($payment_data as $key => $value) { ?>
                            <input type="hidden"
                                   name="<?php echo htmlspecialchars($key); ?>"
                                   value="<?php echo htmlspecialchars($value); ?>">
                        <?php } ?>

                        <button type="submit" class="btn btn-success w-100">
                            Pay with PayFast
                        </button>

                    </form>

                    <a href="../product-details.php?id=<?php echo $product_id; ?>" class="btn btn-secondary w-100 mt-3">
                        Cancel
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>