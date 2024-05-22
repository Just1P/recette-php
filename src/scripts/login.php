<?php
try {
    // Connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    $connectDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare request
    $request = $connectDatabase->prepare("SELECT * FROM `users` WHERE `name` = :name");
    // Bind parameters
    $request->bindParam(':name', $_POST['username'], PDO::PARAM_STR);
    // Execute request
    $request->execute();
    $result = $request->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        header("Location: ../index.php?error=Aucun utilisateur à ce nom");
        exit();
    }

    session_start();
    $_SESSION["name"] = $result['name'];
    $_SESSION["id"] = $result['id'];

    header("Location: ../recettes.php");
    exit();
} catch (PDOException $e) {
    header("Location: ../index.php?error=Erreur de connexion à la base de données: " . $e->getMessage());
    exit();
}
?>

