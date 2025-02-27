<?php
// Session starten
session_start();

// Überprüfen, ob Benutzer eingeloggt ist
$logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$username = $logged_in ? $_SESSION["username"] : "Besucher";
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meine PHP-Testseite</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 40px;
                line-height: 1.6;
                color: #333;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f9f9f9;
            }
            h1 {
                color: #4285f4;
            }
            .info {
                background-color: #e8f5e9;
                padding: 10px;
                border-radius: 5px;
                margin-top: 20px;
            }
            .nav {
                display: flex;
                justify-content: flex-end;
                margin-bottom: 20px;
            }
            .nav a {
                margin-left: 15px;
                text-decoration: none;
                color: #4285f4;
            }
            .nav a:hover {
                text-decoration: underline;
            }
            .user-info {
                background-color: #e3f2fd;
                padding: 10px;
                border-radius: 5px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="nav">
                <?php if($logged_in): ?>
                    <span>Hallo, <?php echo htmlspecialchars($username); ?>!</span>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Registrieren</a>
                <?php endif; ?>
            </div>
            
            <h1>Willkommen zu meiner PHP-Seite</h1>
            
            <p>Dies ist eine einfache PHP-Testseite.</p>
            
            <?php if($logged_in): ?>
            <div class="user-info">
                <h2>Benutzerbereich</h2>
                <p>Du bist eingeloggt als <strong><?php echo htmlspecialchars($username); ?></strong>.</p>
                <p>Hier könnten personalisierte Inhalte erscheinen.</p>
            </div>
            <?php endif; ?>
            
            <div class="info">
                <h2>PHP Info:</h2>
                <p>Datum und Uhrzeit: <?php echo date('d.m.Y H:i:s'); ?></p>
                
                <?php
                // Ein einfaches PHP-Beispiel
                $uhrzeit = date('H');
                
                if ($uhrzeit < 12) {
                    $gruß = "Guten Morgen";
                } elseif ($uhrzeit < 18) {
                    $gruß = "Guten Tag";
                } else {
                    $gruß = "Guten Abend";
                }
                
                echo "<p>$gruß, $username!</p>";
                
                // PHP-Version anzeigen
                echo "<p>PHP-Version: " . phpversion() . "</p>";
                ?>
            </div>
        </div>
    </body>
</html>