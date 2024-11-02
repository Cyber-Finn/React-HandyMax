<?php
    require_once("connection_details.php");
    header('Content-Type: application/json');

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve and sanitize POST data
        $a_link = intval($_POST['a_link']);

        // Update the appointment as completed
        $stmt = $conn->prepare("UPDATE Appointments SET a_complete = 1 WHERE a_link = :a_link");
        $stmt->bindParam(':a_link', $a_link);
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Appointment marked as completed']);
        } else {
            echo json_encode(['message' => 'Failed to update appointment']);
        }

    } catch (PDOException $e) {
        echo json_encode(['message' => 'Connection failed: ' . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
    }
?>
