<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
        $connectDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = trim($_POST['username']);
        if (empty($name)) {
            throw new Exception("Le nom d'utilisateur ne peut pas être vide");
        }

        // Vérifier si le nom d'utilisateur existe déjà
        $checkUser = $connectDatabase->prepare("SELECT * FROM `users` WHERE `name` = :name");
        $checkUser->bindParam(':name', $name, PDO::PARAM_STR);
        $checkUser->execute();
        if ($checkUser->rowCount() > 0) {
            throw new Exception("Le nom d'utilisateur existe déjà, veuillez en choisir un autre");
        }

        // Insérer le nouvel utilisateur dans la base de données
        $request = $connectDatabase->prepare("INSERT INTO `users` (`name`) VALUES (:name)");
        $request->bindParam(':name', $name, PDO::PARAM_STR);
        $request->execute();

        header("Location: ../index.php?success=Inscription réussie, veuillez vous connecter");
        exit();
    } catch (Exception $e) {
        header("Location: ../register.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
