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
<div class="recette-container">
<?php if ($recettes): ?>
    <div class="add-recette">
        <a href="add_recette.php" class="fa-solid fa-plus"></a>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>
    
<?php endif; ?>
<?php foreach ($recettes as $recette): ?>
    <div class="recette">
        <div class="header-card">
            <h1 class="recette-title"><?php echo $recette["name"]; ?></h1>
            <h3 class="recette-subtitle">Créée par : <?php echo $_SESSION['name']; ?></h3>
            <img src="<?php echo $recette["image_src"]; ?>" alt="<?php echo $recette["name"]; ?>" width="150">
        </div>
        
        
        <!-- Affichage des ingrédients -->
        <div class="content-card">
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
        </div>
        
        <div class="button-container">
                <!-- Bouton de suppression -->
            <form action="../scripts/suppr_recette.php" method="post">
                <!-- Identifiant de la recette à supprimer -->
                <input type="hidden" name="recette_id" value="<?php echo $recette['id']; ?>">
                <!-- Bouton de suppression -->
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </form>

            <form action="../scripts/dupliquer_recette.php" method="post">
            <!-- Identifiant de la recette à dupliquer -->
            <input type="hidden" name="recette_id" value="<?php echo $recette['id']; ?>">
            <!-- Bouton de duplication -->
            </form>
            <button type="submit" class="btn btn-primary"><i class="fa fa-copy"></i></button>
            <a href="../modif_recette.php?recette_id=<?php echo $recette['id']; ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Modifier</a>
        </div>
        
    </div>
<?php endforeach; ?>




</div>


<?php
require_once __DIR__ . '/parts/footer.php';
?>
