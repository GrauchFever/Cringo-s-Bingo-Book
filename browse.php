<?php
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

    $category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

    if ($category) {
        $sql = "SELECT * FROM products WHERE product_category = '$category' AND is_active = 1";
        $result = mysqli_query($conn, $sql);

        echo "<div class='container'><div class='row'>";
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $productId = $row['product_id'];
                echo "<div class='col-6 col-sm-4 col-md-3 mb-3 mt-3'>";
                echo "  <div class='card h-100 shadow-sm' style='border: 1px solid #eee;'>";

                // Image
                echo "    <a href='product.html?id=$productId'>";
                echo "      <img src='" . htmlspecialchars($row['image_url']) . "' class='card-img-top' style='height: 160px; object-fit: contain; padding: 10px;' alt='Product Image'>";
                echo "    </a>";

                // Body
                echo "    <div class='card-body p-2'>";
                echo "      <h6 class='card-title mb-1' style='font-size: 0.95rem;'>" . htmlspecialchars($row['product_name']) . "</h6>";
                echo "      <p class='text-muted mb-1' style='font-size: 0.9rem;'>R" . htmlspecialchars($row['product_price']) . "</p>";
                echo "      <p class='card-text' style='font-size: 0.8rem;'>" . htmlspecialchars($row['product_description']) . "</p>";
                echo "    </div>";

                echo "  </div>";
                echo "</div>";
            }
        } else {
            echo "<p>No products found in category: " . htmlspecialchars($category) . "</p>";
        }
        echo "</div></div>";
    } else {
        echo "<p>Invalid category.</p>";
    }

    mysqli_close($conn);
?>