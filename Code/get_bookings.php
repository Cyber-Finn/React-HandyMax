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
        
        //this query didn't need to be paramaterized, because it doesn't take inputs.
        //  this should ideally be converted to a stored procedure, but I wanted to keep this simple for those that didn't study Database Engineering
        $stmt = $conn->prepare("
            SELECT s.s_name as Service, a.a_name as Customer, a.a_phone as Phone, a.a_date as Date, a.a_link
            FROM Appointments as a
            LEFT JOIN Services as s ON s.s_link = a.s_link
            WHERE a.a_complete = false
            ORDER BY a.a_date ASC
        ");
        $stmt->execute();
    
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return the data in JSON format to the calling React
        echo json_encode($bookings);
    
    } catch (PDOException $e) {
        //handle the PDO exceptions specifically
        echo json_encode(['message' => 'Connection failed: ' . $e->getMessage()]);
    } catch (Exception $e) {
        //handle any other errors specifically
        echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
    }
?>
