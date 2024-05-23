<?php require_once __DIR__ . '/parts/header.php'; ?>

<div class="container-recette">

<div class="return">
    <a href="recettes.php" class="fa-solid fa-arrow-left"></a>
</div>


    <h1>Créer une recette</h1>
    <form action="../scripts/save_recette.php" method="post" class="form-recette">
        <div class="left-side">
            <label for="name">Titre</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Nom de la recette"required>

            <label for="ingredients">Ingrédients</label>
            <textarea id="ingredients" name="ingredients" class="form-control" rows="4" placeholder="Ingrédient 1; ingrédient2; ..." required></textarea>
        </div>
        <div class="right-side">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*" class="form-control-file">

            <label for="steps">Étapes</label>
            <textarea id="steps" name="steps" class="form-control" rows="4" placeholder="Etape 1; Etape 2; ..."required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
    
</div>

<?php require_once __DIR__ . '/parts/footer.php'; ?>

