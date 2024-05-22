<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

// Vérifier si l'identifiant de la recette à supprimer est présent dans la requête
if (isset($_POST['recette_id'])) {
    $recette_id = $_POST['recette_id'];

    // Connexion à la base de données
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    

    // Préparer et exécuter la requête SQL pour supprimer la recette
    $request = $db_connect->prepare("DELETE FROM recette WHERE id = :recette_id");
    $request->bindParam(':recette_id', $recette_id);
    $request->execute();

    // Redirection vers la page des recettes avec un message de succès
    header("Location: ../recettes.php?success=La recette a été supprimée avec succès");
    exit();
} else {
    // Redirection vers la page des recettes en cas d'erreur
    header("Location: ../   recettes.php?error=Erreur lors de la suppression de la recette");
    exit();
}
?>
