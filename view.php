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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title']); ?> - Recipe Manager</title>
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
                <a class="nav-link" href="create.php"><i class="bi bi-plus-circle me-1"></i>Add</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card recipe-card shadow-lg">
                    <div class="card-header bg-warning text-white text-center">
                        <h2><?php echo htmlspecialchars($recipe['title']); ?></h2>
                        <small>Added: <?php echo date('M j, Y', strtotime($recipe['created_at'])); ?></small>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-warning"><i class="bi bi-list-ul me-2"></i>Ingredients</h5>
                        <ul class="list-group list-group-flush">
                            <?php 
                            $ingArray = explode(',', $recipe['ingredients']);
                            foreach (array_map('trim', $ingArray) as $ing): 
                            ?>
                                <li class="list-group-item border-0"><?php echo htmlspecialchars($ing); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <h5 class="card-title text-warning mt-4"><i class="bi bi-card-list me-2"></i>Instructions</h5>
<ol class="list-group list-group-numbered">
    <?php 
    $instArray = explode('.', $recipe['instructions']);
    foreach (array_map('trim', $instArray) as $inst): 
        if (!empty($inst)): 
    ?>
        <li class="list-group-item border-0"><?php echo htmlspecialchars($inst); ?></li>
    <?php 
        endif;
    endforeach; 
    ?>
</ol>
                           