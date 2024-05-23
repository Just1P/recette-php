<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['name'])) {
    header("Location: ../index.php");
    exit();
}

// Vérifier si l'identifiant de la recette à modifier est passé dans l'URL
if (!isset($_GET['recette_id'])) {
    // Redirection vers la page des recettes avec un message d'erreur si l'identifiant de la recette n'est pas spécifié
    header("Location: ../recettes.php?error=Identifiant de recette manquant");
    exit();
}

// Récupérer l'identifiant de la recette à modifier depuis l'URL
$recette_id = $_GET['recette_id'];

try {
    // Connexion à la base de données
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête pour récupérer les détails de la recette à modifier
    $request = $db_connect->prepare("SELECT * FROM `recette` WHERE `id` = :id");
    $request->bindParam(':id', $recette_id);
    $request->execute();
    // Récupérer les détails de la recette à modifier
    $recette = $request->fetch(PDO::FETCH_ASSOC);

    // Vérifier si la recette existe
    if (!$recette) {
        // Redirection vers la page des recettes avec un message d'erreur si la recette n'existe pas
        header("Location: ../recettes.php?error=La recette spécifiée n'existe pas");
        exit();
    }
} catch (PDOException $e) {
    // En cas d'erreur, redirection vers la page des recettes avec un message d'erreur
    header("Location: ../recettes.php?error=" . urlencode($e->getMessage()));
    exit();
}

// Afficher le formulaire de modification de la recette avec les détails récupérés
require_once __DIR__ . '/parts/header.php';
?>

<div class="container-recette">

<div class="return">
    <a href="recettes.php" class="fa-solid fa-arrow-left"></a>
</div>
    <h1>Modifier la recette</h1>
    <form action="../scripts/modif_recette.php" method="post" class="form-recette">
        <!-- Champ caché pour l'identifiant de la recette -->
        <input type="hidden" name="recette_id" value="<?php echo $recette['id']; ?>">
        <div class="left-side">
            <label for="name">Nom de la recette</label>
            <input type="text" id="name" name="name" value="<?php echo $recette['name']; ?>" class="form-control" required>

            <label for="ingredients">Ingrédients</label>
            <textarea id="ingredients" name="ingredients" class="form-control" rows="4" required><?php echo $recette['ingredients']; ?></textarea>
        </div>
        <div class="right-side">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*" class="form-control-file">

            <label for="steps">Étapes</label>
            <textarea id="steps" name="steps" class="form-control" rows="4" required><?php echo $recette['steps']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
</div>

<?php require_once __DIR__ . '/parts/footer.php'; ?>
