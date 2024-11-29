<?php
session_start(); // Start session to store messages

$server = "localhost";
$usr = "root";
$psw = ""; 
$db = "Thanakarn_Thanajai";

$conn = new mysqli($server, $usr, $psw, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_name = "";  
$email = "";
$customer_phone = ""; 
$customer_address = "";

$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : "";
$successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : "";

// Clear messages after displaying
unset($_SESSION['errorMessage']);
unset($_SESSION['successMessage']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $customer_phone = $_POST['customer_phone'];
    $customer_address = $_POST['customer_address'];

    $stmt = null; // Initialize the statement variable

    do {
        if (empty($customer_name) || empty($email) || empty($customer_phone) || empty($customer_address)) {
            $_SESSION['errorMessage'] = "All fields are required";
            break; // Exit the loop if there are errors
        }

        // Prepare SQL statement for inserting a new customer
        $stmt = $conn->prepare("INSERT INTO customer (customer_name, email, customer_phone, customer_address) VALUES (?, ?, ?, ?)");
        
        if ($stmt === false) {
            $_SESSION['errorMessage'] = "Error preparing statement: " . $conn->error;
            break; // Exit if preparation fails
        }

        $stmt->bind_param("ssss", $customer_name, $email, $customer_phone, $customer_address);

        // Execute the statement
        if (!$stmt->execute()) {
            $_SESSION['errorMessage'] = "Error inserting record: " . $stmt->error; // Capture error if insert fails
            break;
        }

        // Clear the fields after successful submission
        $customer_name = "";
        $email = "";
        $customer_phone = ""; 
        $customer_address = "";

        $_SESSION['successMessage'] = "Customer added correctly";

        // Redirect to index.php after successful insertion
        header("location: /TnkTnj/index.php");
        exit;

    } while (false);

    // Close the prepared statement if it was created
    if ($stmt) {
        $stmt->close(); // Close the prepared statement if it exists
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanakarn Thanajai</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Customer</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        if (!empty($successMessage)) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        <form method="post">
            <div>
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>">
                </div>
            </div>
            <div>
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>
            <div>
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="customer_phone" value="<?php echo htmlspecialchars($customer_phone); ?>">
                </div>
            </div>
            <div>
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="customer_address" value="<?php echo htmlspecialchars($customer_address); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/TnkTnj/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
