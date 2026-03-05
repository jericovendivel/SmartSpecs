<?php
// ============================================================
//  SmartSpecs — Phone Specs Page
// ============================================================

$phoneId = $_GET['id'] ?? '';
$phone   = PhoneModel::getPhone($phoneId);

// 404 guard
if (!$phone) {
    header('HTTP/1.0 404 Not Found');
    $pageTitle = 'Phone Not Found';
    include __DIR__ . '/../includes/header.php';
    echo '<div class="error-page"><h2>Phone not found.</h2><a href="' . url('home') . '">← Go Home</a></div>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$specs     = PhoneModel::getSpecs($phoneId);
$pageTitle = $phone['name'] . ' Full Specs';
$highlights = [
    'Display'  => $phone['hl_display'],
    'Camera'   => $phone['hl_camera'],
    'Battery'  => $phone['hl_battery'],
    'Chipset'  => $phone['hl_chip'],
];

include __DIR__ . '/../includes/header.php';
?>

<!-- ════ SPECS HERO ════ -->
<div class="specs-hero" style="--brand-gradient:<?= e($phone['brand_gradient']) ?>;">

  <!-- Phone image -->
  <div class="specs-hero-image">
    <img
      src="<?= IMAGES_URL ?>/<?= e($phone['image']) ?>"
      alt="<?= e($phone['name']) ?>"
      onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
    <div class="specs-hero-placeholder" style="display:none;" aria-hidden="true"></div>
  </div>

  <!-- Info panel -->
  <div class="specs-hero-info">
    <a class="specs-back" href="<?= url('brand', ['brand' => e($phone['brand_id'])]) ?>">
      ← Back to <?= e($phone['brand_name']) ?>
    </a>
    <div class="specs-brand-tag"><?= e($phone['brand_name']) ?> · <?= e($phone['tag']) ?></div>
    <h1><?= e($phone['name']) ?></h1>
    <p class="tagline"><?= e($phone['tagline']) ?></p>

    <div class="specs-price"><?= formatPrice($phone['price']) ?></div>

    <!-- Color swatches -->
    <?php if (!empty($phone['colors'])): ?>
    <div class="specs-colors">
      <span class="specs-colors-label">Colors</span>
      <?= renderColorDots($phone['colors'], '20px') ?>
    </div>
    <?php endif; ?>

    <div class="specs-actions">
      <button class="btn-buy">Buy Now</button>
      <button class="btn-compare-add">+ Add to Compare</button>
    </div>
  </div>
</div>

<!-- ════ BREADCRUMB ════ -->
<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="<?= url('home') ?>">Home</a>
  <span class="sep">›</span>
  <a href="<?= url('brand', ['brand' => e($phone['brand_id'])]) ?>"><?= e($phone['brand_name']) ?></a>
  <span class="sep">›</span>
  <span><?= e($phone['name']) ?></span>
</nav>

<!-- ════ SPECS BODY ════ -->
<div class="specs-body">

  <!-- Highlight bar -->
  <div class="specs-highlight">
    <?php foreach ($highlights as $key => $val): ?>
    <div class="highlight-item">
      <div class="highlight-val"><?= e($val) ?></div>
      <div class="highlight-key"><?= e($key) ?></div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Spec sections -->
  <?php if (!empty($specs)): ?>
    <?php foreach ($specs as $section): ?>
    <h2 class="specs-section-title"><?= e($section['title']) ?></h2>
    <table class="specs-table" aria-label="<?= e($section['title']) ?> specifications">
      <tbody>
        <?php foreach ($section['rows'] as $row): ?>
        <tr>
          <td><?= e($row['spec_key']) ?></td>
          <td><?= e($row['spec_value']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endforeach; ?>

  <?php else: ?>
    <div class="specs-coming-soon">
      <div class="coming-icon">📋</div>
      <h3>Full specs coming soon</h3>
      <p>We're adding complete spec data for this model. Check back shortly.</p>
      <a class="btn-buy" href="<?= url('brand', ['brand' => e($phone['brand_id'])]) ?>">← Back to <?= e($phone['brand_name']) ?></a>
    </div>
  <?php endif; ?>

</div><!-- /.specs-body -->

<?php include __DIR__ . '/../includes/footer.php'; ?>
