<?php
include 'config.php';

$id = $_GET['id'] ?? 0;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    header("Location: index.php");
    exit;
}

if ($_POST) {
    $title = trim($_POST['title']);
    $ingredients = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);

    if (!empty($title) && !empty($ingredients) && !empty($instructions)) {
        $stmt = $pdo->prepare("UPDATE recipes SET title = ?, ingredients = ?, instructions = ? WHERE id = ?");
        $stmt->execute([$title, $ingredients, $instructions, $id]);
        header("Location: index.php?updated=1");
        exit;
    } else {
        $error = "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe - Recipe Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-book-half me-2"></i>Recipe Manager
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php"><i class="bi bi-house me-1"></i>Home</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center mb-4 text-warning">Edit Recipe</h1>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success">Recipe updated successfully!</div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-md-12">
                <label for="title" class="form-label">Recipe Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
                <div class="invalid-feedback">Title is required.</div>
            </div>
            <div class="col-md-12">
                <label for="ingredients" class="form-label">Ingredients (comma-separated)</label>
                <textarea class="form-control" id="ingredients" name="ingredients" rows="4" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
                <div class="invalid-feedback">Ingredients are required.</div>
            </div>
            <div class="col-md-12">
                <label for="instructions" class="form-label">Instructions</label>
                <textarea class="form-control" id="instructions" name="instructions" rows="6" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
                <div class="invalid-feedback">Instructions are required.</div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-warning">Update Recipe</button>
                <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>