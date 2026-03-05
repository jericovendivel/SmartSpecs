<?php
require_once 'includes/db.php';

$base = '';
$db   = getDB();

// ---- Validate brand ID -------------------------------------
$brandId = isset($_GET['id']) ? $db->real_escape_string(trim($_GET['id'])) : '';
$brand   = null;

if ($brandId) {
    $res = $db->query("SELECT * FROM brands WHERE id = '$brandId' LIMIT 1");
    if ($res && $res->num_rows > 0) {
        $brand = $res->fetch_assoc();
    }
}

if (!$brand) {
    header('Location: index.php');
    exit;
}

// ---- Load phones for this brand ----------------------------
$phones = $db->query(
    "SELECT * FROM phones WHERE brand_id = '$brandId' ORDER BY sort_order"
)->fetch_all(MYSQLI_ASSOC);

// ---- Brand gradient map ------------------------------------
$gradients = [
    'samsung' => 'radial-gradient(ellipse 80% 60% at 50% 0%, rgba(30,100,255,0.3) 0%, transparent 70%)',
    'apple'   => 'radial-gradient(ellipse 80% 60% at 50% 0%, rgba(150,150,170,0.3) 0%, transparent 70%)',
    'xiaomi'  => 'radial-gradient(ellipse 80% 60% at 50% 0%, rgba(255,60,60,0.3) 0%, transparent 70%)',
    'google'  => 'radial-gradient(ellipse 80% 60% at 50% 0%, rgba(50,200,100,0.3) 0%, transparent 70%)',
];
$grad = isset($gradients[$brandId]) ? $gradients[$brandId] : $gradients['samsung'];

$pageTitle    = $brand['name'] . ' Phones';
$currentBrand = $brandId;

include 'includes/header.php';
?>

<div style="padding-top: var(--nav-h);">

    <!-- Brand hero -->
    <section class="brand-hero" style="--brand-grad: <?php echo $grad; ?>;">
        <div class="brand-hero-icon"><?php echo htmlspecialchars($brand['icon']); ?></div>
        <h1><?php echo htmlspecialchars($brand['name']); ?></h1>
        <p class="brand-hero-sub"><?php echo htmlspecialchars($brand['tagline']); ?></p>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <span class="sep">&#8250;</span>
        <span class="current"><?php echo htmlspecialchars($brand['name']); ?></span>
    </div>

    <!-- 3x2 Phone grid -->
    <div class="phone-grid brand-<?php echo htmlspecialchars($brandId); ?>">
        <?php foreach ($phones as $i => $phone):
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
                <div class="phone-card-tag"><?php echo htmlspecialchars($phone['tag']); ?></div>
                <div class="phone-card-name"><?php echo htmlspecialchars($phone['name']); ?></div>
                <div class="phone-card-tagline"><?php echo htmlspecialchars($phone['tagline']); ?></div>
                <div class="phone-card-price"><?php echo htmlspecialchars($phone['price']); ?></div>
                <div class="phone-card-highlights">
                    <span class="hl-pill">&#128250; <?php echo htmlspecialchars($phone['hl_display']); ?></span>
                    <span class="hl-pill">&#128247; <?php echo htmlspecialchars($phone['hl_camera']); ?></span>
                    <span class="hl-pill">&#128267; <?php echo htmlspecialchars($phone['hl_battery']); ?></span>
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

</div>

<?php
$db->close();
include 'includes/footer.php';
?>
