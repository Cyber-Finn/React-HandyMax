<?php
    // I have my connection details stored into this file, so that it's easy to just include them for reusability
    // Require_once ensures that we don't get cyclic-dependencies
    require_once("connection_details.php");
    //ensure that we're getting JSON from the React code
    header('Content-Type: application/json');
    //trycatch for our risky code, to ensure that we gracefully handle errors
    try {
        // We use PHPs PDO (PHP Data Objects) method of accessing databases. This is the advised method of access
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve and sanitize POST data
        $a_link = intval($_POST['a_link']);

        // Insert data into the Appointments table as completed, using parameterization, to ensure that we're really locking this down with proper security
        $stmt = $conn->prepare("UPDATE Appointments SET a_complete = 1 WHERE a_link = :a_link");
        $stmt->bindParam(':a_link', $a_link);
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Appointment marked as completed']);
        } else {
            echo json_encode(['message' => 'Failed to update appointment']);
        }

    } catch (PDOException $e) {
        //handle the PDO exceptions specifically
        echo json_encode(['message' => 'Connection failed: ' . $e->getMessage()]);
    } catch (Exception $e) {
        //handle any other errors specifically
        echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
    }
?>
