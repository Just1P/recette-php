<?php
session_start();
?>

<?php
require_once __DIR__ . '/parts/header.php';
?>

<div class="container">
    <div class="front-page illustration col-6">
    </div>
    <div class="front-page form-container col-6">
        <h1 class="title">Connecte-toi</h1>
        <form action="./scripts/login.php" method="post" class="form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="submit" value="Envoyer" class="btn-submit">
        </form>
        <p>Pas encore de compte ? <a href="register.php">Inscris-toi ici</a></p>

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
    </div>  
</div>



<?php
require_once __DIR__ . '/parts/footer.php';
?>



