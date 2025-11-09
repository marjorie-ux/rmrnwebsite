<?php
include 'config.php';

$stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC");
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Manager - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">  

</head>

<!--<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-book-half me-2"></i>Recipe Manager
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="create.php"><i class="bi bi-plus-circle me-1"></i>Add Recipe</a>
        </div>
        </div>
    </nav>-->
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#" onclick="showHomePage()">
                <i class="bi bi-book-half me-2"></i>Recipe Manager
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="create.php" onclick="showCreatePage()">
                    <i class="bi bi-plus-circle me-1"></i>Add Recipe
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center mb-4 text-warning">Your Recipes</h1>
        <?php if (empty($recipes)): ?>
            <div class="alert alert-info text-center">No recipes yet. <a href="create.php">Add one!</a></div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($recipes as $recipe): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card recipe-card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-warning"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                                <p class="card-text"><strong>Ingredients:</strong> <?php echo htmlspecialchars(substr($recipe['ingredients'], 0, 100)) . '...'; ?></p>
                                <p class="card-text"><small class="text-muted">Added: <?php echo date('M j, Y', strtotime($recipe['created_at'])); ?></small></p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="view.php?id=<?php echo $recipe['id']; ?>" class="btn btn-outline-warning btn-sm me-2">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                                <a href="update.php?id=<?php echo $recipe['id']; ?>" class="btn btn-warning btn-sm me-2">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <a href="delete.php?id=<?php echo $recipe['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>