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
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        <a href="creer_recette.php" class="btn btn-primary">Créer une recette</a>
    <?php endif; ?>

<?php foreach($recettes as $recette):
    $ingredientsList = explode(";", $recette["ingredients"]);
    $stepsList = explode(";", $recette["steps"]);
?>
    <h2><?php echo htmlspecialchars($recette["name"]); ?></h2>
    <ul>
        <?php foreach($ingredientsList as $ingredient): ?>
            <li><?php echo htmlspecialchars($ingredient); ?></li>
        <?php endforeach; ?>    
    </ul>
    <ul>
        <?php foreach($stepsList as $step): ?>
            <li><?php echo htmlspecialchars($step); ?></li>
        <?php endforeach; ?>    
    </ul>
<?php endforeach; ?>

<?php
require_once __DIR__ . '/parts/footer.php';
?>
