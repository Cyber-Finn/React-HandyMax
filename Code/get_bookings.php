<?php
    require_once("connection_details.php");
    header('Content-Type: application/json');

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $conn->prepare("
            SELECT s.s_name as Service, a.a_name as Customer, a.a_phone as Phone, a.a_date as Date, a.a_link
            FROM Appointments as a
            LEFT JOIN Services as s ON s.s_link = a.s_link
            WHERE a.a_complete = false
            ORDER BY a.a_date ASC
        ");
        $stmt->execute();
    
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode($bookings);
    
    } catch (PDOException $e) {
        echo json_encode(['message' => 'Connection failed: ' . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
    }
?>
