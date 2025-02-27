<?php
// Include database connection
require_once 'db.php';

// Initialize variables
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$registration_success = false;

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Bitte gib einen Benutzernamen ein.";
    } else {
        // Check if username exists
        $user = getUserByUsername($conn, trim($_POST["username"]));
        if ($user) {
            $username_err = "Dieser Benutzername ist bereits vergeben.";
        } else {
            $username = trim($_POST["username"]);
        }
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Bitte gib ein Passwort ein.";     
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Das Passwort muss mindestens 6 Zeichen lang sein.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Bitte bestätige das Passwort.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Die Passwörter stimmen nicht überein.";
        }
    }
    
    // Check input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        try {
            // Prepare an insert statement
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $conn->prepare($sql);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Securely hash the password
            
            // Bind parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Execute the prepared statement
            $stmt->execute();
            
            // Registration successful
            $registration_success = true;
            
            // Clear form values after successful registration
            $username = $password = $confirm_password = "";
            
        } catch(PDOException $e) {
            echo "Fehler: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #4285f4;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group input[type="submit"] {
            background-color: #4285f4;
            color: white;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #3367d6;
        }
        .error {
            color: #e53935;
            font-size: 14px;
            margin-top: 5px;
        }
        .success {
            background-color: #e8f5e9;
            color: #388e3c;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrierung</h1>
        
        <?php 
        if ($registration_success) {
            echo '<div class="success">Registrierung erfolgreich! Du kannst dich jetzt anmelden.</div>';
        }
        ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Benutzername</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <span class="error"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Passwort</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Passwort bestätigen</label>
                <input type="password" name="confirm_password">
                <span class="error"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Registrieren">
            </div>
            <div class="login-link">
                <p>Bereits registriert? <a href="index.php">Zurück zur Startseite</a></p>
            </div>
        </form>
    </div>
</body>
</html>