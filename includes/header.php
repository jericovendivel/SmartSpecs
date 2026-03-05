<?php
$pageTitle   = isset($pageTitle)   ? $pageTitle . ' | SmartSpecs' : 'SmartSpecs';
$currentPage  = isset($currentPage)  ? $currentPage  : '';
$currentBrand = isset($currentBrand) ? $currentBrand : '';
$base         = isset($base)         ? $base         : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <a class="nav-logo" href="<?php echo $base; ?>index.php">Smart<span>Specs</span></a>
    <ul class="nav-links">
        <li><a href="<?php echo $base; ?>index.php"              <?php if($currentPage=='home')     echo 'class="active"'; ?>>Home</a></li>
        <li><a href="<?php echo $base; ?>brand.php?id=samsung"   <?php if($currentBrand=='samsung') echo 'class="active"'; ?>>Samsung</a></li>
        <li><a href="<?php echo $base; ?>brand.php?id=apple"     <?php if($currentBrand=='apple')   echo 'class="active"'; ?>>Apple</a></li>
        <li><a href="<?php echo $base; ?>brand.php?id=xiaomi"    <?php if($currentBrand=='xiaomi')  echo 'class="active"'; ?>>Xiaomi</a></li>
        <li><a href="<?php echo $base; ?>brand.php?id=google"    <?php if($currentBrand=='google')  echo 'class="active"'; ?>>Google</a></li>
    </ul>
    <form class="nav-search-form" action="<?php echo $base; ?>index.php" method="GET">
        <input type="text" name="search" class="nav-search" placeholder="Search phones..."
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    </form>
</nav>
