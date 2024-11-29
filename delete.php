<?php
var_dump($_GET); // Debugging line to check if id is passed

if (isset($_GET["id"])) { // Change from 'customer_id' to 'id'
    $customer_id = $_GET["id"]; // Update variable assignment to match 'id'

    $server = "localhost";
    $usr = "root";
    $psw = ""; 
    $db = "Thanakarn_Thanajai";

    $conn = new mysqli($server, $usr, $psw, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM customer WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $customer_id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Record deleted successfully.";
            } else {
                echo "No record found with customer_id: " . $customer_id;
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Error: id not set in URL.";
    exit;
}

header("Location: /TnkTnj/index.php");
exit;
?>
