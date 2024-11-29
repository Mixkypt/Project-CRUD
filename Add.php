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
$errorMessage = "";
$customers = [];

// Fetch customers for selection
$sql = "SELECT customer_id, customer_name FROM customer"; // Adjust the table name as needed
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Error in query: " . $conn->error); // Debugging line to check SQL query errors
} elseif ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row; // Store customers in an array
    }
} else {
    $errorMessage = "No customers found."; // Error message if no customers exist
}

// Check if a customer is selected
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['customer_id'])) {
        $_SESSION['customer_id'] = intval($_POST['customer_id']); // Set customer ID in session
        header("Location: Credit Card.php"); // Redirect to Credit Card page
        exit(); // Ensure no further code is executed after redirect
    } else {
        $errorMessage = "Please select a customer.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Customer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Select Customer</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="customer_id" class="form-label">Customer</label>
                <select class="form-select" name="customer_id" id="customer_id" required>
                    <option value="">Select a customer</option>
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo htmlspecialchars($customer['customer_id']); ?>">
                                <?php echo htmlspecialchars($customer['customer_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No customers available</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="d-flex mb-3">
                <button type="submit" class="btn btn-primary me-2">Go to Credit Card</button>
                <a href="loan.php" class="btn btn-success me-2">Go to Loan</a>
                <a href="Account.php" class="btn btn-info">Go to Account</a>
                <a href="/TnkTnj/index.php" class="btn btn-outline-danger">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
