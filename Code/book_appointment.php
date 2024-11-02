<?php
    require_once("connection_details.php");
    header('Content-Type: application/json');
    
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sanitize and retrieve the data from the POST request
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $phone = htmlspecialchars(strip_tags($_POST['phone']));
        $s_link = htmlspecialchars(strip_tags($_POST['s_link']));
        $date = htmlspecialchars(strip_tags($_POST['date']));

        // Debugging lines
        if (empty($name) || empty($phone) || empty($s_link) || empty($date)) {
            echo json_encode(['message' => 'Required fields are missing']);
            exit();
        }

        // Insert data into the Appointments table
        $sql = "INSERT INTO Appointments (s_link, a_name, a_phone, a_date) VALUES (:s_link, :name, :phone, :date)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':s_link', $s_link);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':date', $date);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Appointment successfully booked']);
        } else {
            echo json_encode(['message' => 'Failed to book appointment']);
        }

    } catch (PDOException $e) {
        echo json_encode(['message' => 'Connection failed: ' . $e->getMessage()]);
    }
?>
