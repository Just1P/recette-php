<?php require_once __DIR__ . '/parts/header.php'; ?>

<div class="container">

<a href="recettes.php" class="fa-solid fa-arrow-left"></a>

    <h1>Créer une recette</h1>
    <form action="../scripts/save_recette.php" method="post">
        <div class="form-group">
            <label for="name">Nom de la recette</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingrédients</label>
            <textarea id="ingredients" name="ingredients" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="steps">Étapes</label>
            <textarea id="steps" name="steps" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<?php require_once __DIR__ . '/parts/footer.php'; ?>

