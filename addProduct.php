<?php
    ini_set('session.cookie_path', '/');
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $product_name = trim($_POST["product_name"]);
        $description = trim($_POST["description"]);
        $price = floatval($_POST["price"]);
        $category = $_POST["category"];
        $quantity = intval($_POST["quantity"]);
        $date_added = date("m-d-Y H:i:s");
        $is_active = 1;
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            die("Error: User not logged in.");
        }

        $host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "cringo_db";
        // Establish Connection
        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

        // Check if connection was successful
        if (!$conn)
        {
            die("Connection Failed".mysqli_connect_error());
        }

        // Handle image upload
        $targetDir = "uploads/products/";
        if (!is_dir($targetDir))
        {
            mkdir($targetDir, 0755, true);
        }

        $imagePath = "";
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK)
        {
            $imageTmpPath = $_FILES["image"]["tmp_name"];
            $imageName = basename($_FILES["image"]["name"]);
            $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
            $uniqueName = uniqid("product_", true) . '.' . $imageExt;
            $destination = $targetDir . $uniqueName;

            $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array(strtolower($imageExt), $validExtensions))
            {
                die("Invalid image format. Only JPG, PNG, GIF, and WEBP are allowed.");
            }

            if (move_uploaded_file($imageTmpPath, $destination))
            {
                $imagePath = $destination;
            } else
            {
                die("Failed to upload image");
            }
        } else
        {
            die("Image upload error");
        }

        // Insert into database
        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO products (
            user_id,
            product_name,
            product_description,
            product_price,
            product_category,
            stock_quantity,
            image_url,
            date_added,
            is_active
        ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

        // Check if prepare() succeeded
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind the parameters
        $stmt->bind_param("issdsisi", 
            $user_id,         // i = integer
            $product_name,    // s = string
            $description,     // s = string (can have apostrophes)
            $price,           // d = double/float
            $category,        // s = string
            $quantity,        // i = integer
            $imagePath,       // s = string (e.g., 'uploads/products/product_6842795f6c1f66.45536421.png' in this case)
            $is_active        // i = integer (e.g., 1 or 0)
        );

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: index.html");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
?>