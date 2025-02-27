<?php
    $host = "localhost";
    $dbname = "userdata";
    $username = "root";
    $password = "";

    try {
        // Datenbankverbindung herstellen
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Fehlerberichtsmodus auf Exception setzen
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Verbindungsfehler: " . $e->getMessage());
    }

    // Funktion zum Abrufen eines Benutzers anhand des Benutzernamens
    function getUserByUsername($conn, $username) {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Fehler: " . $e->getMessage();
            return false;
        }
    }

    // Funktion zum Abrufen aller Benutzer
    function getAllUsers($conn) {
        try {
            $stmt = $conn->query("SELECT * FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Fehler: " . $e->getMessage();
            return false;
        }
    }
?>