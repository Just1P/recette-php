<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['name'])) {
        header("Location: ../index.php?error=Vous devez être connecté pour dupliquer une recette");
        exit();
    }

    // Récupérer l'identifiant de la recette à dupliquer
    $recette_id = $_POST['recette_id'];

    // Connexion à la base de données
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    

    // Récupérer les informations de la recette à dupliquer
    $request = $db_connect->prepare("SELECT * FROM `recette` WHERE id = :id");
    $request->bindParam(':id', $recette_id);
    $request->execute();
    $recette = $request->fetch(PDO::FETCH_ASSOC);

    // Insérer une nouvelle entrée dans la table de recettes avec les mêmes informations que la recette originale
    $insert_request = $db_connect->prepare("INSERT INTO `recette` (`name`, `ingredients`, `steps`, `image_src`, `user_id`) 
                                            VALUES (:name, :ingredients, :steps, :image_src, :user_id)");
    $insert_request->bindParam(':name', $recette['name']);
    $insert_request->bindParam(':ingredients', $recette['ingredients']);
    $insert_request->bindParam(':steps', $recette['steps']);
    $insert_request->bindParam(':image_src', $recette['image_src']);
    $insert_request->bindParam(':user_id', $_SESSION['id']);
    $insert_request->execute();

    // Redirection vers la page des recettes avec un message de succès
    header("Location: ../recettes.php?success=La recette a été dupliquée avec succès");
    exit();
}
?>
