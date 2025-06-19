<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "cringo_db";

    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart']))
    {
        echo "<p>Your cart is empty.</p>";
        exit;
    }

    $ids = implode(",", array_map('intval', array_keys($_SESSION['cart'])));
    $sql = "SELECT * FROM products WHERE product_id IN ($ids)";
    $result = mysqli_query($conn, $sql);

    echo "<ul class='list-group mb-3'>";
    $total = 0;
    while ($row = mysqli_fetch_assoc($result))
    {
        $id = $row['product_id'];
        $quantity = $_SESSION['cart'][$id];
        $price = $row['product_price'];
        $subtotal = $price * $quantity;
        $total += $subtotal;

        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo htmlspecialchars($row['product_name']) . " (x$quantity)";
        echo "<span>R" . number_format($subtotal, 2) . "</span>";
        echo "<form method='post' action='removeFromCart.php' style='display:inline; margin-left:10px;'>
            <input type='hidden' name='product_id' value='" . $id . "'>
            <button type='submit' class='btn btn-danger btn-sm'>Remove</button>
          </form>";
        echo "</li>";
    }

    echo "</ul>";
    echo "<div class='d-flex justify-content-end mt-3'>";
    echo "<h5>Total: R" . number_format($total, 2) . "";
    echo "<a href='checkout.html' class='btn btn-success btn-sm mx-3'>Go to Checkout</a>";
    echo "</h5>";
    echo "</div>";

    mysqli_close($conn);
?>