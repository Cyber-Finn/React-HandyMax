<?php
    require_once("connection_details.php");
    header('Content-Type: application/json');
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT s_link, s_name, s_description, s_image_path FROM services");
        $stmt->execute();

        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($services);

    } catch (PDOException $e) {
        echo json_encode(['message' => 'Connection failed: ' . $e->getMessage()]);
    }
?>
