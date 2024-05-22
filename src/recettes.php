<?php
session_start();
if(!isset($_SESSION['name'])) {
    header("Location: /index.php");
    exit();
}
?>

<?php
require_once __DIR__ . '/parts/header.php';
?>

<?php
// Connect to db
try {
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    

    // prepare request
    $request = $db_connect->prepare("SELECT * FROM `recette` WHERE user_id = :id ORDER BY `id` DESC");
    // bindparams
    $request->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
    // execute request
    $request->execute();
    // fetch all data from table posts
    $recettes = $request->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php if (empty($recettes)): ?>
        <!-- Afficher le bouton si aucune recette n'est trouvée -->
        <a href="add_recette.php" class="btn btn-primary">Créer une recette</a>
    <?php endif; ?>



<!-- Boucle pour afficher toutes les recettes -->
<?php foreach ($recettes as $recette): ?>
    <div class="recette">
        <h2><?php echo $recette["name"]; ?></h2>
        <h3>Créé par : <?php echo $_SESSION['name']; ?></h3>
        <img src="<?php echo $recette["image_src"]; ?>" alt="<?php echo $recette["name"]; ?>" width="200">
        
        <!-- Affichage des ingrédients -->
        <h4>Ingrédients :</h4>
        <ul>
            <?php 
            $ingredientsList = explode(";", $recette["ingredients"]);
            foreach($ingredientsList as $ingredient):  
            ?>
                <li><?php echo $ingredient; ?></li>
            <?php endforeach; ?>    
        </ul>

        <!-- Affichage des étapes -->
        <h4>Étapes :</h4>
        <ol>
            <?php 
            $stepsList = explode(";", $recette["steps"]);
            foreach($stepsList as $step):  
            ?>
                <li><?php echo $step; ?></li>
            <?php endforeach; ?>    
        </ol>
        
        <!-- Bouton de suppression -->
        <form action="../scripts/suppr_recette.php" method="post">
            <!-- Identifiant de la recette à supprimer -->
            <input type="hidden" name="recette_id" value="<?php echo $recette['id']; ?>">
            <!-- Bouton de suppression -->
            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Supprimer</button>
        </form>

        <form action="../scripts/dupliquer_recette.php" method="post">
        <!-- Identifiant de la recette à dupliquer -->
        <input type="hidden" name="recette_id" value="<?php echo $recette['id']; ?>">
        <!-- Bouton de duplication -->
        <button type="submit" class="btn btn-primary"><i class="fa fa-copy"></i> Dupliquer</button>
        <a href="../modif_recette.php?recette_id=<?php echo $recette['id']; ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Modifier</a>
</form>
    </div>
<?php endforeach; ?>


<?php if ($recettes): ?>
        <!-- Afficher le bouton si aucune recette n'est trouvée -->
        <a href="add_recette.php" class="fa-solid fa-plus"></a>
    <?php endif; ?>



<?php
require_once __DIR__ . '/parts/footer.php';
?>
