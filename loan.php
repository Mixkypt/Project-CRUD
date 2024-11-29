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
$loan_type = "";  
$amount = ""; 
$interest_rate = ""; 
$loan_duration = ""; 
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
    $loan_type = $_POST["loan_type"];
    $amount = $_POST["amount"];
    $interest_rate = $_POST["interest_rate"];
    $loan_duration = $_POST["loan_duration"];

    // Basic validation
    if (empty($loan_type) || empty($amount) || empty($interest_rate) || empty($loan_duration)) {
        $errorMessage = "All fields are required.";
    }

    // Insert into the database only if all fields are valid
    if (empty($errorMessage)) {
        $sql = "INSERT INTO loan (loan_type, amount, interest_rate, loan_duration, customer_id) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare and bind
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("SQL prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sdssi", $loan_type, $amount, $interest_rate, $loan_duration, $customer_id);

        if ($stmt->execute()) {
            $successMessage = "Loan information saved successfully.";
            // Reset the variables for new entry
            $loan_type = "";
            $amount = ""; 
            $interest_rate = ""; 
            $loan_duration = ""; 
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
    <title>Add Loan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Add Loan</h2>
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
                <label for="loan_type" class="form-label">Loan Type</label>
                <select class="form-select" name="loan_type" id="loan_type" required>
                    <option value="">Select a loan type</option>
                    <option value="Home loan">Home loan</option>
                    <option value="Personal loan">Personal loan</option>
                    <option value="Welfare loan">Welfare loan</option>
                    <option value="Car registration loan">Car registration loan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" name="amount" id="amount" required>
            </div>
            <div class="mb-3">
                <label for="interest_rate" class="form-label">Interest Rate (%)</label>
                <input type="number" step="0.01" class="form-control" name="interest_rate" id="interest_rate" required>
            </div>
            <div class="mb-3">
                <label for="loan_duration" class="form-label">Loan Duration (months)</label>
                <input type="number" class="form-control" name="loan_duration" id="loan_duration" required>
            </div>
            
            <div class="d-flex mb-3">
                <button type="submit" class="btn btn-primary">Save Loan</button>
                <a href="/TnkTnj/Add.php" class="btn btn-outline-danger">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
