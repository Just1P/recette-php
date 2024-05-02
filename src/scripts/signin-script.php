<?php

 // Connect to db
 $db_connect = new PDO("mysql:host=db;dbname=wordpress", 'root', 'admin');
 // prepare request
 $request = $db_connect->prepare("SELECT * FROM recette WHERE author = :username");
 // bind param (if any)
 $request->bindParam(":username", $_POST["username"]);
 // execute request
 $request->execute();
 // fetch results
 $recettes = $request->fetchAll(PDO::FETCH_ASSOC);

$result = $request->fetch(PDO::FETCH_ASSOC);

if($result) {
session_start();
    $_SESSION['id'] = $result["id"];
    header('Location: ../recette.php?success=Vous êtes bien connecté');
} else {
    header('Location: ../index.php?error=Erreur lors de la connexion');
}


?>