<?php
require_once 'includes/db.php';

$base = '';
$db   = getDB();

// ---- Validate phone ID -------------------------------------
$phoneId = isset($_GET['id']) ? $db->real_escape_string(trim($_GET['id'])) : '';
$phone   = null;

if ($phoneId) {
    $res = $db->query(
        "SELECT p.*, b.name AS brand_name, b.icon AS brand_icon,
                b.tagline AS brand_tagline, b.id AS brand_id
         FROM phones p
         JOIN brands b ON p.brand_id = b.id
         WHERE p.id = '$phoneId'
         LIMIT 1"
    );
    if ($res && $res->num_rows > 0) {
        $phone = $res->fetch_assoc();
    }
}

if (!$phone) {
    header('Location: index.php');
    exit;
}

// ---- Load spec sections + rows -----------------------------
$sections = $db->query(
    "SELECT * FROM spec_sections WHERE phone_id = '$phoneId' ORDER BY sort_order"
)->fetch_all(MYSQLI_ASSOC);

$specData = [];
foreach ($sections as $sec) {
    $sid  = (int)$sec['id'];
    $rows = $db->query(
        "SELECT spec_key, spec_value FROM spec_rows
         WHERE section_id = $sid ORDER BY sort_order"
    )->fetch_all(MYSQLI_ASSOC);
    $specData[] = ['title' => $sec['title'], 'rows' => $rows];
}

// ---- Brand gradient map ------------------------------------
$gradients = [
    'samsung' => 'radial-gradient(ellipse 60% 80% at 70% 50%, rgba(30,100,255,0.22) 0%, transparent 70%)',
    'apple'   => 'radial-gradient(ellipse 60% 80% at 70% 50%, rgba(150,150,170,0.22) 0%, transparent 70%)',
    'xiaomi'  => 'radial-gradient(ellipse 60% 80% at 70% 50%, rgba(255,60,60,0.22) 0%, transparent 70%)',
    'google'  => 'radial-gradient(ellipse 60% 80% at 70% 50%, rgba(50,200,100,0.22) 0%, transparent 70%)',
];
$grad    = isset($gradients[$phone['brand_id']]) ? $gradients[$phone['brand_id']] : $gradients['samsung'];
$colors  = json_decode($phone['colors'], true) ?: [];

$pageTitle    = $phone['name'];
$currentBrand = $phone['brand_id'];

include 'includes/header.php';
?>

<div style="padding-top: var(--nav-h);">

    <!-- Specs hero -->
    <section class="specs-hero" style="--brand-grad: <?php echo $grad; ?>;">
        <div class="specs-hero-img-wrap">
            <img src="assets/images/<?php echo htmlspecialchars($phone['image']); ?>"
                 alt="<?php echo htmlspecialchars($phone['name']); ?>"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
            <div class="specs-hero-placeholder-lg" style="display:none;"></div>
        </div>

        <div class="specs-hero-info">
            <a class="specs-back" href="brand.php?id=<?php echo urlencode($phone['brand_id']); ?>">
                &#8592; Back to <?php echo htmlspecialchars($phone['brand_name']); ?>
            </a>
            <div class="specs-brand-tag"><?php echo htmlspecialchars($phone['brand_name']); ?> &middot; <?php echo htmlspecialchars($phone['tag']); ?></div>
            <h1><?php echo htmlspecialchars($phone['name']); ?></h1>
            <p class="specs-tagline"><?php echo htmlspecialchars($phone['tagline']); ?></p>
            <div class="specs-price"><?php echo htmlspecialchars($phone['price']); ?></div>

            <?php if (!empty($colors)): ?>
            <div class="specs-colors">
                <span class="specs-colors-label">Colors</span>
                <?php foreach ($colors as $c): ?>
                <span class="specs-color-dot" style="background:<?php echo htmlspecialchars($c); ?>;"></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="specs-actions">
                <a class="btn-primary" href="#">Buy Now</a>
                <span class="btn-secondary">Add to Compare</span>
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <span class="sep">&#8250;</span>
        <a href="brand.php?id=<?php echo urlencode($phone['brand_id']); ?>"><?php echo htmlspecialchars($phone['brand_name']); ?></a>
        <span class="sep">&#8250;</span>
        <span class="current"><?php echo htmlspecialchars($phone['name']); ?></span>
    </div>

    <!-- Specs body -->
    <div class="specs-body">

        <!-- Highlights bar -->
        <div class="specs-highlights">
            <div class="hl-item">
                <div class="hl-val"><?php echo htmlspecialchars($phone['hl_display']); ?></div>
                <div class="hl-key">Display</div>
            </div>
            <div class="hl-item">
                <div class="hl-val"><?php echo htmlspecialchars($phone['hl_camera']); ?></div>
                <div class="hl-key">Camera</div>
            </div>
            <div class="hl-item">
                <div class="hl-val"><?php echo htmlspecialchars($phone['hl_battery']); ?></div>
                <div class="hl-key">Battery</div>
            </div>
            <div class="hl-item">
                <div class="hl-val"><?php echo htmlspecialchars($phone['hl_chip']); ?></div>
                <div class="hl-key">Chip</div>
            </div>
        </div>

        <?php if (empty($specData)): ?>
        <p style="color:var(--text-2); text-align:center; padding:40px 0;">
            Full specs coming soon for this model.
        </p>
        <?php else: ?>
            <?php foreach ($specData as $sec): ?>
            <h2 class="specs-section-heading"><?php echo htmlspecialchars($sec['title']); ?></h2>
            <table class="specs-table">
                <?php foreach ($sec['rows'] as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['spec_key']); ?></td>
                    <td><?php echo htmlspecialchars($row['spec_value']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

</div>

<?php
$db->close();
include 'includes/footer.php';
?>
