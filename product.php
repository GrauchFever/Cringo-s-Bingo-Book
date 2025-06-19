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

    $product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    if ($product_id > 0)
    {
        $sql = "SELECT * FROM products WHERE product_id = $product_id AND is_active = 1";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($result))
        {
            echo "<div class='container my-5'>";
            echo "  <div class='row justify-content-center'>";

            // LEFT: Image + Description in one white box
            echo "    <div class='col-md-8'>";
            echo "      <div class='bg-white p-4 shadow-sm'>";

            // Top: Product Name
            echo "        <h1 class='h4 mb-4'>" . htmlspecialchars($row['product_name']) . "</h1>";

            // Flex row: image on left, description on right
            echo "        <div class='row'>";

            // Image
            echo "          <div class='col-sm-5'>";
            echo "            <img src='" . htmlspecialchars($row['image_url']) . "' alt='Product Image' class='img-fluid mb-3' style='max-height: 400px;'>";
            echo "          </div>";

            // Description
            echo "          <div class='col-sm-7'>";
            echo "            <p>" . nl2br(htmlspecialchars($row['product_description'])) . "</p>";
            echo "          </div>";

            echo "        </div>"; // end inner row

            echo "      </div>"; // end white box
            echo "    </div>"; // end col-md-8

            // RIGHT: Price & Add to Cart
            echo "    <div class='col-md-4'>";
            echo "      <div class='bg-white p-4 shadow-sm mt-3 mt-md-0 h-100 d-flex flex-column justify-content-between'>";
            echo "        <div>";
            echo "          <h4 class='text-black'>R" . htmlspecialchars($row['product_price']) . "</h4>";
            echo "        </div>";
            echo "        <div>";
            echo "          <button class='btn btn-primary w-100 mt-3 addToCart-btn' data-id='" . htmlspecialchars($row['product_id']) . "'>Add to Cart</button>";
            echo "        </div>";
            echo "      </div>";
            echo "    </div>";

            echo "  </div>"; // end outer row
            echo "</div>"; // end container

            // Get the category of the current product
            $category = $row['product_category'];

            // Query related products
            $relatedQuery = "SELECT * FROM products WHERE product_category = ? AND product_id != ?";
            $relatedStmt = $conn->prepare($relatedQuery);
            $relatedStmt->bind_param("si", $category, $row['product_id']);
            $relatedStmt->execute();
            $relatedResult = $relatedStmt->get_result();

            if ($relatedResult->num_rows > 0) {
                echo "<div class='container my-5'>";
                echo "<h4 class='mb-4'>Related Products</h4>";
                echo "<div class='owl-carousel related-carousel'>";
            
                while ($related = $relatedResult->fetch_assoc()) {
                    echo "<div class='item bg-white p-3 text-center shadow-sm'>";
                    echo "  <a href='product.html?id=" . htmlspecialchars($related['product_id']) . "' style='text-decoration: none; color: inherit;'>";
                    echo "    <img src='" . htmlspecialchars($related['image_url']) . "' class='img-fluid mb-2' style='height: 150px; object-fit: contain;'>";
                    echo "    <div><strong>" . htmlspecialchars($related['product_name']) . "</strong></div>";
                    echo "    <div class='text-success'>R" . htmlspecialchars($related['product_price']) . "</div>";
                    echo "  </a>";
                    echo "</div>";
                }
            
                echo "</div>"; // end .owl-carousel
                echo "</div>"; // end .container
            }
        } else
        {
            echo "<p>Product not found.</p>";
        }
    } else
    {
        echo "<p>Invalid product ID.</p>";
    }

    mysqli_close($conn);
?>