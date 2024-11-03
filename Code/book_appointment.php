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

        // Sanitize and retrieve the data from the POST request
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $phone = htmlspecialchars(strip_tags($_POST['phone']));
        $s_link = htmlspecialchars(strip_tags($_POST['s_link']));
        $date = htmlspecialchars(strip_tags($_POST['date']));

        // Just in case the input is empty, we want to exit without processing further
        if (empty($name) || empty($phone) || empty($s_link) || empty($date)) {
            echo json_encode(['message' => 'Required fields are missing']);
            exit();
        }

        // Insert data into the Appointments table using parameterization, to ensure that we're really locking this down with proper security
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
        //handle the PDO exceptions specifically
        echo json_encode(['message' => 'Connection failed: ' . $e->getMessage()]);
    } catch (Exception $e) {
        //handle any other errors specifically
        echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
    }
?>
