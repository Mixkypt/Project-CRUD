<?php
session_start(); // Start the session

$server = "localhost";
$usr = "root";
$psw = ""; 
$db = "Thanakarn_Thanajai";

// Establish the connection
$conn = new mysqli($server, $usr, $psw, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$card_type = "";  
$expire_date = date('Y-m-d', strtotime('+5 years')); // Default expire date is +5 years
$limit = ""; 
$errorMessage = "";
$successMessage = "";

// Debug: Check if customer_id is set in the session
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id']; // Get customer_id from session
} else {
    die("Customer ID is not set. Please select a customer first.");
}

// Verify customer_id exists in the database
$checkCustomer = $conn->prepare("SELECT customer_id FROM customer WHERE customer_id = ?");
$checkCustomer->bind_param("i", $customer_id);
$checkCustomer->execute();
$result = $checkCustomer->get_result();

if ($result->num_rows == 0) {
    die("Invalid customer ID. Please ensure the customer exists.");
} 

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_type = $_POST["card_type"];

    // Set limits based on card type
    if ($card_type == "Platinum") {
        $limit = 1000000;
    } elseif ($card_type == "Gold") {
        $limit = 100000;
    } elseif ($card_type == "Plastic") {
        $limit = 10000;
    } else {
        $errorMessage = "Please select a valid card type.";
    }

    // Insert into the database only if card_type is valid
    if (empty($errorMessage)) {
        $sql = "INSERT INTO creditcard (card_type, expire_date, limits, customer_id) 
                VALUES (?, ?, ?, ?)";

        // Prepare and bind
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("SQL prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("ssii", $card_type, $expire_date, $limit, $customer_id);

        if ($stmt->execute()) {
            $successMessage = "Credit card information saved successfully.";
            // Reset the variables for new entry
            $card_type = "";
            $limit = ""; // Reset limit after successful insert
        } else {
            $errorMessage = "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Credit Card</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        function updateLimit() {
            var cardType = document.getElementById("card_type").value;
            var limitField = document.getElementById("limit");
            var limit = "";

            // Set limit based on the selected card type
            if (cardType == "Platinum") {
                limit = 1000000;
            } else if (cardType == "Gold") {
                limit = 100000;
            } else if (cardType == "Plastic") {
                limit = 10000;
            }

            // Update the limit field with the formatted value
            limitField.value = limit ? limit.toLocaleString() : ''; // Format as currency
        }
    </script>
</head>
<body>
    <div class="container my-5">
        <h2>Add Credit Card</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "<div class='alert alert-warning'>$errorMessage</div>";
        }
        if (!empty($successMessage)) {
            echo "<div class='alert alert-success'>$successMessage</div>";
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label for="card_type" class="form-label">Card Type</label>
                <select class="form-select" name="card_type" id="card_type" required onchange="updateLimit()">
                    <option value="">Select a card type</option>
                    <option value="Platinum">Platinum Card</option>
                    <option value="Gold">Gold Card</option>
                    <option value="Plastic">Plastic Card</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="expire_date" class="form-label">Expire Date</label>
                <input type="text" class="form-control" id="expire_date" value="<?php echo $expire_date; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="limit" class="form-label">Limit</label>
                <input type="text" class="form-control" id="limit" value="<?php echo !empty($limit) ? number_format($limit) : ''; ?>" readonly>
            </div>
            <div class="d-flex mb-3">
                <button type="submit" class="btn btn-primary">Save Credit Card</button>
                <a href="/TnkTnj/Add.php" class="btn btn-outline-danger">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
