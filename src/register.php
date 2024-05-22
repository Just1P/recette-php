<?php
require_once __DIR__ . '/parts/header.php';
?>

<div class="container">
    <h1 class="title">Inscription</h1>
    <form action="../scripts/signup.php" method="post" class="form">
        <input type="text" name="username" placeholder="Username" required>
        <input type="submit" value="S'inscrire" class="btn-submit">
    </form>

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

<?php
require_once __DIR__ . '/parts/footer.php';
?>

