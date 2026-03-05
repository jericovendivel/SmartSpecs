<?php
// ============================================================
//  SmartSpecs — Home Page
// ============================================================

$brands      = PhoneModel::getBrands();
$totalPhones = PhoneModel::getTotalPhones();
$totalBrands = PhoneModel::getTotalBrands();
$pageTitle   = 'Compare the Latest Smartphones';

include __DIR__ . '/../includes/header.php';
?>

<!-- ════ HERO ════ -->
<section class="hero">
  <div class="hero-eyebrow">2024 – 2025 Flagship Lineup</div>
  <h1 class="hero-title">Find Your Perfect<br>Smartphone.</h1>
  <p class="hero-sub">Compare the latest flagships from Samsung, Apple, Xiaomi, and Google — specs, cameras, and everything in between.</p>
  <div class="hero-brands">
    <?php foreach ($brands as $brand): ?>
    <a class="hero-brand-btn" href="<?= url('brand', ['brand' => e($brand['id'])]) ?>">
      <?= e($brand['name']) ?>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ════ STATS BAR ════ -->
<div class="home-stats">
  <div class="stat-item"><div class="stat-num"><?= $totalPhones ?></div><div class="stat-label">Flagship Phones</div></div>
  <div class="stat-item"><div class="stat-num"><?= $totalBrands ?></div><div class="stat-label">Top Brands</div></div>
  <div class="stat-item"><div class="stat-num">50+</div><div class="stat-label">Specs Per Phone</div></div>
  <div class="stat-item"><div class="stat-num">2025</div><div class="stat-label">Latest Models</div></div>
</div>

<!-- ════ BRAND CARDS ════ -->
<div style="background:#000; padding-bottom: 20px;">
  <div class="section-header" style="color:white; padding: 60px 40px 0;">
    <h2 class="section-title" style="color:white;">Explore by Brand</h2>
    <p class="section-sub" style="color:rgba(255,255,255,0.45);">Click any brand to see their latest <?= PHONES_PER_BRAND ?> flagship models</p>
  </div>

  <div class="brand-cards">
    <?php foreach ($brands as $brand): ?>
    <a class="brand-card" href="<?= url('brand', ['brand' => e($brand['id'])]) ?>">
      <div class="brand-card-emoji"><?= e($brand['icon']) ?></div>
      <div class="brand-card-name"><?= e($brand['name']) ?></div>
      <div class="brand-card-count"><?= PHONES_PER_BRAND ?> flagships</div>
    </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- ════ FEATURE STRIP ════ -->
<div class="feature-strip">
  <div class="feature-item">
    <div class="feature-icon">📊</div>
    <div class="feature-title">Detailed Specs</div>
    <div class="feature-desc">Every spec that matters — display, camera, battery, processor, and more.</div>
  </div>
  <div class="feature-item">
    <div class="feature-icon">🏆</div>
    <div class="feature-title">Latest Models</div>
    <div class="feature-desc">Only 2024–2025 flagships. Updated with the newest releases.</div>
  </div>
  <div class="feature-item">
    <div class="feature-icon">⚡</div>
    <div class="feature-title">Side-by-Side Ready</div>
    <div class="feature-desc">Quick-scan specs and key highlights to compare in seconds.</div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
