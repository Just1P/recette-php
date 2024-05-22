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
    $recette_id = $_POST['recette_id'];
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $image = $_POST['image'];

    try {
        // Connexion à la base de données
        $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
        $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête pour mettre à jour la recette
        $request = $db_connect->prepare("UPDATE `recette` SET `name` = :name, `ingredients` = :ingredients, `steps` = :steps, `image_src` = :image_src WHERE `id` = :id");
        $request->bindParam(':name', $name);
        $request->bindParam(':ingredients', $ingredients);
        $request->bindParam(':steps', $steps);
        $request->bindParam(':image_src', $image);
        $request->bindParam(':id', $recette_id);
        $request->execute();

        // Redirection vers la page des recettes avec un message de succès
        header("Location: ../recettes.php?success=La recette a été modifiée avec succès");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, redirection vers la page de modification de recette avec un message d'erreur
        header("Location: ../modifier_recette.php?recette_id=$recette_id&error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirection vers la page de modification de recette si le formulaire n'a pas été soumis
    header("Location: ../modifier_recette.php?recette_id=$recette_id");
    exit();
}
?>

