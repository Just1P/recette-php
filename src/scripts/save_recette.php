<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['name'])) {
    header("Location: ../index.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $image = $_POST['image'];

    try {
        // Connexion à la base de données
        $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
        

        // Préparer la requête pour insérer la nouvelle recette
        $request = $db_connect->prepare("INSERT INTO `recette` (`name`, `ingredients`, `steps`, `image_src`, `user_id`) VALUES (:name, :ingredients, :steps, :image_src, :user_id)");
        $request->bindParam(':name', $name);
        $request->bindParam(':ingredients', $ingredients);
        $request->bindParam(':steps', $steps);
        $request->bindParam(':image_src', $image);
        $request->bindParam(':user_id', $_SESSION['id']);
        $request->execute();

        // Redirection vers la page des recettes avec un message de succès
        header("Location: ../recettes.php?success=La recette a été ajoutée avec succès");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, redirection vers la page de création de recette avec un message d'erreur
        header("Location: ../add_recette.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirection vers la page de création de recette si le formulaire n'a pas été soumis
    header("Location: ../add_recette.php");
    exit();
}
?>



