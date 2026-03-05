<?php
// ============================================================
//  SmartSpecs — Phone Model
//  All database queries for phones live here.
// ============================================================

require_once __DIR__ . '/../config/database.php';

class PhoneModel {

    // ── Get all brands ──────────────────────────────────────
    public static function getBrands(): array {
        $db  = getDB();
        $sql = 'SELECT * FROM brands ORDER BY sort_order ASC';
        return $db->query($sql)->fetchAll();
    }

    // ── Get single brand by id ──────────────────────────────
    public static function getBrand(string $brandId): ?array {
        $db  = getDB();
        $sql = 'SELECT * FROM brands WHERE id = ? LIMIT 1';
        $st  = $db->prepare($sql);
        $st->execute([$brandId]);
        $row = $st->fetch();
        return $row ?: null;
    }

    // ── Get phones for a brand ──────────────────────────────
    public static function getPhonesByBrand(string $brandId): array {
        $db  = getDB();
        $sql = 'SELECT * FROM phones WHERE brand_id = ? ORDER BY sort_order ASC';
        $st  = $db->prepare($sql);
        $st->execute([$brandId]);
        $phones = $st->fetchAll();
        foreach ($phones as &$p) {
            $p['colors'] = json_decode($p['colors'], true);
        }
        return $phones;
    }

    // ── Get single phone ────────────────────────────────────
    public static function getPhone(string $phoneId): ?array {
        $db  = getDB();
        $sql = 'SELECT p.*, b.name AS brand_name, b.icon AS brand_icon,
                       b.gradient AS brand_gradient, b.color AS brand_color
                FROM phones p
                JOIN brands b ON b.id = p.brand_id
                WHERE p.id = ? LIMIT 1';
        $st  = $db->prepare($sql);
        $st->execute([$phoneId]);
        $phone = $st->fetch();
        if (!$phone) return null;
        $phone['colors'] = json_decode($phone['colors'], true);
        return $phone;
    }

    // ── Get full specs for a phone ──────────────────────────
    public static function getSpecs(string $phoneId): array {
        $db = getDB();

        // Fetch sections
        $stSec = $db->prepare(
            'SELECT * FROM spec_sections WHERE phone_id = ? ORDER BY sort_order ASC'
        );
        $stSec->execute([$phoneId]);
        $sections = $stSec->fetchAll();

        // Fetch rows per section
        $stRow = $db->prepare(
            'SELECT * FROM spec_rows WHERE section_id = ? ORDER BY sort_order ASC'
        );

        $result = [];
        foreach ($sections as $section) {
            $stRow->execute([$section['id']]);
            $result[] = [
                'title' => $section['title'],
                'rows'  => $stRow->fetchAll(),
            ];
        }
        return $result;
    }

    // ── Search phones ────────────────────────────────────────
    public static function search(string $query): array {
        $db   = getDB();
        $like = '%' . $query . '%';
        $sql  = 'SELECT p.*, b.name AS brand_name
                 FROM phones p
                 JOIN brands b ON b.id = p.brand_id
                 WHERE p.name LIKE ? OR b.name LIKE ? OR p.tag LIKE ?
                 ORDER BY b.sort_order, p.sort_order
                 LIMIT 20';
        $st = $db->prepare($sql);
        $st->execute([$like, $like, $like]);
        $phones = $st->fetchAll();
        foreach ($phones as &$p) {
            $p['colors'] = json_decode($p['colors'], true);
        }
        return $phones;
    }

    // ── Total counts (for home stats) ────────────────────────
    public static function getTotalPhones(): int {
        return (int) getDB()->query('SELECT COUNT(*) FROM phones')->fetchColumn();
    }

    public static function getTotalBrands(): int {
        return (int) getDB()->query('SELECT COUNT(*) FROM brands')->fetchColumn();
    }
}
