<?php
// ============================================================
//  SmartSpecs — Search Results Page
// ============================================================

$query     = trim($_GET['q'] ?? '');
$results   = $query ? PhoneModel::search($query) : [];
$pageTitle = $query ? 'Search: ' . $query : 'Search';

include __DIR__ . '/../includes/header.php';
?>

<!-- ════ SEARCH HERO ════ -->
<div class="search-hero">
  <h1>Search Results</h1>
  <form class="search-form-big" action="<?= url('search') ?>" method="GET">
    <input type="hidden" name="page" value="search">
    <input type="text" name="q" value="<?= e($query) ?>" placeholder="Search phones, brands…" autofocus>
    <button type="submit">Search</button>
  </form>
</div>

<!-- ════ BREADCRUMB ════ -->
<nav class="breadcrumb">
  <a href="<?= url('home') ?>">Home</a>
  <span class="sep">›</span>
  <span>Search<?= $query ? ': ' . e($query) : '' ?></span>
</nav>

<!-- ════ RESULTS ════ -->
<div class="search-results-wrap">
  <?php if ($query && empty($results)): ?>
    <div class="no-results">
      <div style="font-size:3rem; margin-bottom:16px;">🔍</div>
      <h3>No results for "<?= e($query) ?>"</h3>
      <p>Try searching for a brand name or model number.</p>
    </div>

  <?php elseif (!empty($results)): ?>
    <p class="results-count"><?= count($results) ?> result<?= count($results) !== 1 ? 's' : '' ?> for "<strong><?= e($query) ?></strong>"</p>
    <div class="phone-grid search-grid">
      <?php foreach ($results as $phone): ?>
        <?php include __DIR__ . '/../includes/phone-card.php'; ?>
      <?php endforeach; ?>
    </div>

  <?php else: ?>
    <p class="results-count" style="text-align:center; padding: 60px 0; color: var(--text-secondary);">Enter a search term above to find phones.</p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
