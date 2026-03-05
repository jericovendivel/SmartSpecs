<?php
// ============================================================
//  SmartSpecs — Phone Card Component
//  Usage:  $phone = [...];  include 'includes/phone-card.php';
//  Or loop: foreach ($phones as $phone) include ...;
// ============================================================

// $phone must be set before including this file.
if (!isset($phone)) return;

$colors     = $phone['colors'] ?? [];
$colorDots  = renderColorDots($colors, '10px');
?>
<article class="phone-card" onclick="window.location='<?= url('phone', ['id' => e($phone['id'])]) ?>'">

  <!-- ── Product Image ── -->
  <div class="phone-card-img">
    <img
      src="<?= IMAGES_URL ?>/<?= e($phone['image']) ?>"
      alt="<?= e($phone['name']) ?>"
      loading="lazy"
      onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
    <div class="phone-placeholder" style="display:none;" aria-hidden="true"></div>
  </div>

  <!-- ── Card Body ── -->
  <div class="phone-card-body">
    <div class="phone-card-tag"><?= e($phone['tag']) ?></div>
    <h3 class="phone-card-name"><?= e($phone['name']) ?></h3>
    <p class="phone-card-tagline"><?= e($phone['tagline']) ?></p>

    <div class="phone-card-price"><?= formatPrice($phone['price']) ?></div>

    <!-- Quick specs pills -->
    <div class="phone-card-quick">
      <span class="quick-spec">📺 <?= e($phone['hl_display']) ?></span>
      <span class="quick-spec">📷 <?= e($phone['hl_camera']) ?></span>
      <span class="quick-spec">🔋 <?= e($phone['hl_battery']) ?></span>
    </div>

    <!-- Color swatches -->
    <?php if ($colors): ?>
    <div class="phone-card-colors"><?= $colorDots ?></div>
    <?php endif; ?>

    <!-- Footer CTA -->
    <div class="phone-card-cta">
      <a class="btn-details" href="<?= url('phone', ['id' => e($phone['id'])]) ?>">View Specs</a>
      <span class="compare-badge">+ Compare</span>
    </div>
  </div>

</article>
