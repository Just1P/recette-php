<?php
    require_once __DIR__ . '/parts/header.php'
?>  


    <div class="container">
        <div class="front-page illustration col-6" >
            
        </div>
        <div class="front-page form-container col-6">
            <h1 class="title">Connecte toi </h1>
            <form action="./scripts/signin.php" method="post" class="form">
                <input type="text" name="username" placeholder="Username">
                <input type="submit" value="Envoyer" class="btn-submit">
            </form>
            
        </div>  
    </div>

    
    
    

<?php
    require_once __DIR__ . '/parts/footer.php'
?>
