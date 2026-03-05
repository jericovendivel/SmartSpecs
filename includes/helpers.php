<?php
// ============================================================
//  SmartSpecs — Helper Functions
// ============================================================

/**
 * Safely output HTML-escaped string.
 */
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Build a URL for an internal page.
 * e.g. url('brand', ['id' => 'samsung']) → index.php?page=brand&id=samsung
 */
function url(string $page, array $params = []): string {
    $params = array_merge(['page' => $page], $params);
    return 'index.php?' . http_build_query($params);
}

/**
 * Get current page from query string.
 */
function currentPage(): string {
    return $_GET['page'] ?? 'home';
}

/**
 * Returns true if the given page/brand/phone is "active" for nav highlight.
 */
function isActivePage(string $page, string $brandId = ''): bool {
    $cp = currentPage();
    if ($brandId) {
        return ($cp === 'brand' || $cp === 'phone')
            && ($_GET['brand'] ?? '') === $brandId;
    }
    return $cp === $page;
}

/**
 * Render color dot swatches from an array of hex colors.
 */
function renderColorDots(array $colors, string $size = '12px'): string {
    $html = '';
    foreach ($colors as $hex) {
        $hex  = e($hex);
        $html .= "<span class='color-dot' style='width:{$size};height:{$size};background:{$hex};'></span>";
    }
    return $html;
}

/**
 * Format price — already stored formatted, just escape.
 */
function formatPrice(string $price): string {
    return e($price);
}

/**
 * Redirect to a URL and stop execution.
 */
function redirect(string $url): never {
    header('Location: ' . $url);
    exit;
}
