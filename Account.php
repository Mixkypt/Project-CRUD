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
$account_type = "";  
$balance = ""; 
$errorMessage = "";
$successMessage = "";

// Check if customer_id is set in the session
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id']; // Get customer_id from session
} else {
    die("Customer ID is not set. Please select a customer first.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_type = $_POST["account_type"];
    $balance = $_POST["balance"];

    // Basic validation
    if (empty($account_type) || empty($balance)) {
        $errorMessage = "All fields are required.";
    }

    // Insert into the database only if all fields are valid
    if (empty($errorMessage)) {
        $sql = "INSERT INTO account (account_type, balance, customer_id) 
                VALUES (?, ?, ?)";

        // Prepare and bind
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("SQL prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sdi", $account_type, $balance, $customer_id);

        if ($stmt->execute()) {
            $successMessage = "Account information saved successfully.";
            // Reset the variables for new entry
            $account_type = "";
            $balance = ""; 
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
    <title>Add Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Add Account</h2>
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
                <label for="account_type" class="form-label">Account Type</label>
                <select class="form-select" name="account_type" id="account_type" required>
                    <option value="">Select an account type</option>
                    <option value="Savings">Savings</option>
                    <option value="Checking">Checking</option>
                    <option value="Investment">Investment</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="balance" class="form-label">Balance</label>
                <input type="number" class="form-control" name="balance" id="balance" required>
            </div>
            
            <div class="d-flex mb-3">
                <button type="submit" class="btn btn-primary">Save Account</button>
                <a href="/TnkTnj/Add.php" class="btn btn-outline-danger">Cancel</a>
            </div>

        </form>
    </div>
</body>
</html>
