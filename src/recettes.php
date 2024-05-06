<?php
    require_once __DIR__ . '/parts/header.php'
?>

<h1>Hello <?php echo $_POST["username"] ?> </h1>
    
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
        // show data
    ?>



    <?php foreach($recettes as $recette):
        
        $ingredientsList = explode(";", $recette["ingredients"]);
        $stepsList = explode(";", $recette["steps"]);
    ?>
            
        <h2><?php echo $recette["name"] ?></h2>
        <ul>
            <?php  foreach($ingredientsList as $ingredient):  ?>
                <li><?php echo $ingredient ?></li>
            <?php endforeach ?>    
        </ul>
        <ul>
            <?php  foreach($stepsList as $step):  ?>
                <li><?php echo $step ?></li>
            <?php endforeach ?>    
        </ul>
    <?php endforeach ?>    
     
<?php
    require_once __DIR__ . '/parts/footer.php'
?>