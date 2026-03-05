<?php
require_once 'includes/db.php';

$pageTitle   = 'SmartSpecs - Smartphone Comparison';
$currentPage = 'home';
$base        = '';

$db = getDB();

// ---- Handle search -----------------------------------------
$search  = isset($_GET['search']) ? trim($_GET['search']) : '';
$results = [];
if ($search !== '') {
    $q    = '%' . $db->real_escape_string($search) . '%';
    $stmt = $db->query("SELECT p.*, b.name AS brand_name
                        FROM phones p
                        JOIN brands b ON p.brand_id = b.id
                        WHERE p.name LIKE '$q' OR b.name LIKE '$q'
                        ORDER BY b.sort_order, p.sort_order");
    $results = $stmt->fetch_all(MYSQLI_ASSOC);
}

// ---- Load brands -------------------------------------------
$brands = $db->query("SELECT * FROM brands ORDER BY sort_order")->fetch_all(MYSQLI_ASSOC);

include 'includes/header.php';
?>

<?php if ($search !== ''): ?>
<!-- ======= SEARCH RESULTS ======= -->
<div style="padding-top: var(--nav-h);">
    <div class="search-section">
        <h2>Search results for &ldquo;<?php echo htmlspecialchars($search); ?>&rdquo;</h2>
        <p class="sub"><?php echo count($results); ?> phone<?php echo count($results) != 1 ? 's' : ''; ?> found</p>

        <?php if (empty($results)): ?>
        <div class="no-results">
            <h2>No phones found</h2>
            <p>Try searching for a brand name or phone model.</p>
        </div>
        <?php else: ?>
        <div class="phone-grid" style="padding:0;">
            <?php foreach ($results as $i => $phone):
                $colors = json_decode($phone['colors'], true) ?: [];
            ?>
            <div class="phone-card fade-in fade-in-<?php echo min($i+1,6); ?>">
                <div class="phone-card-img">
                    <img src="assets/images/<?php echo htmlspecialchars($phone['image']); ?>"
                         alt="<?php echo htmlspecialchars($phone['name']); ?>"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                    <div class="phone-img-placeholder" style="display:none;"></div>
                </div>
                <div class="phone-card-body">
                    <div class="phone-card-tag"><?php echo htmlspecialchars($phone['brand_name']); ?> &middot; <?php echo htmlspecialchars($phone['tag']); ?></div>
                    <div class="phone-card-name"><?php echo htmlspecialchars($phone['name']); ?></div>
                    <div class="phone-card-tagline"><?php echo htmlspecialchars($phone['tagline']); ?></div>
                    <div class="phone-card-price"><?php echo htmlspecialchars($phone['price']); ?></div>
                    <div class="phone-card-highlights">
                        <span class="hl-pill"><?php echo htmlspecialchars($phone['hl_display']); ?></span>
                        <span class="hl-pill"><?php echo htmlspecialchars($phone['hl_camera']); ?></span>
                        <span class="hl-pill"><?php echo htmlspecialchars($phone['hl_battery']); ?></span>
                    </div>
                    <div class="phone-card-cta">
                        <a class="btn-view-specs" href="phone.php?id=<?php echo urlencode($phone['id']); ?>">View Specs</a>
                        <div class="color-dots">
                            <?php foreach (array_slice($colors,0,4) as $c): ?>
                            <span class="color-dot" style="background:<?php echo htmlspecialchars($c); ?>;"></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php else: ?>
<!-- ======= HOME PAGE ======= -->
<div style="padding-top: var(--nav-h);">

    <!-- Hero -->
    <section class="hero">
        <div class="hero-eyebrow">2024 - 2025 Flagship Lineup</div>
        <h1>Find Your Perfect<br>Smartphone.</h1>
        <p>Compare the latest flagships from Samsung, Apple, Xiaomi, and Google &mdash; specs, cameras, and everything in between.</p>
        <div class="hero-brand-btns">
            <?php foreach ($brands as $b): ?>
            <a class="hero-brand-btn" href="brand.php?id=<?php echo urlencode($b['id']); ?>"><?php echo htmlspecialchars($b['name']); ?></a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Stats bar -->
    <div class="stats-bar">
        <div class="stat-item"><div class="stat-num">24</div><div class="stat-label">Flagship Phones</div></div>
        <div class="stat-item"><div class="stat-num">4</div><div class="stat-label">Top Brands</div></div>
        <div class="stat-item"><div class="stat-num">50+</div><div class="stat-label">Specs Per Phone</div></div>
        <div class="stat-item"><div class="stat-num">2025</div><div class="stat-label">Latest Models</div></div>
    </div>

    <!-- Brand cards -->
    <section class="brand-section">
        <div class="brand-section-title">Explore by Brand</div>
        <p class="brand-section-sub">Click any brand to see their latest 6 flagship models</p>
        <div class="brand-cards">
            <?php foreach ($brands as $b): ?>
            <a class="brand-card" href="brand.php?id=<?php echo urlencode($b['id']); ?>">
                <div class="brand-card-icon"><?php echo htmlspecialchars($b['icon']); ?></div>
                <div class="brand-card-name"><?php echo htmlspecialchars($b['name']); ?></div>
                <div class="brand-card-count">6 flagships</div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Feature strip -->
    <div class="feature-strip">
        <div class="feature-item">
            <div class="feature-icon">&#128202;</div>
            <div class="feature-title">Detailed Specs</div>
            <div class="feature-desc">Every spec that matters &mdash; display, camera, battery, processor, and more.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">&#127942;</div>
            <div class="feature-title">Latest Models</div>
            <div class="feature-desc">Only 2024&ndash;2025 flagships. Updated with the newest releases.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">&#9889;</div>
            <div class="feature-title">Fast Comparison</div>
            <div class="feature-desc">Quick-scan specs and key highlights to compare phones in seconds.</div>
        </div>
    </div>

</div>
<?php endif; ?>

<?php
$db->close();
include 'includes/footer.php';
?>
