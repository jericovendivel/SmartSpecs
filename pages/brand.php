<?php
// ============================================================
//  SmartSpecs — Brand Page  (3 × 2 phone grid)
// ============================================================

$brandId = $_GET['brand'] ?? '';
$brand   = PhoneModel::getBrand($brandId);

// 404 guard
if (!$brand) {
    header('HTTP/1.0 404 Not Found');
    $pageTitle = 'Brand Not Found';
    include __DIR__ . '/../includes/header.php';
    echo '<div class="error-page"><h2>Brand not found.</h2><a href="' . url('home') . '">← Go Home</a></div>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$phones    = PhoneModel::getPhonesByBrand($brandId);
$pageTitle = $brand['name'] . ' Smartphones';

include __DIR__ . '/../includes/header.php';
?>

<!-- ════ BRAND HERO ════ -->
<div class="brand-hero" style="--brand-gradient: <?= e($brand['gradient']) ?>;">
  <div class="brand-icon"><?= e($brand['icon']) ?></div>
  <h1><?= e($brand['name']) ?></h1>
  <p><?= e($brand['tagline']) ?></p>
</div>

<!-- ════ BREADCRUMB ════ -->
<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="<?= url('home') ?>">Home</a>
  <span class="sep" aria-hidden="true">›</span>
  <span><?= e($brand['name']) ?></span>
</nav>

<!-- ════ PHONE GRID  3 × 2 ════ -->
<div class="phone-grid brand-<?= e($brandId) ?>">
  <?php
  $delay = 0;
  foreach ($phones as $phone):
      $phone['_delay'] = $delay;
      $delay += 80;
  ?>
  <div class="fade-in" style="animation-delay:<?= $delay - 80 ?>ms;">
    <?php include __DIR__ . '/../includes/phone-card.php'; ?>
  </div>
  <?php endforeach; ?>

  <?php if (empty($phones)): ?>
  <p class="no-phones">No phones found for this brand yet.</p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
