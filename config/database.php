<?php
// ============================================================
//  SmartSpecs — Database Configuration
// ============================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'smartspecs');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// DSN for PDO
define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET);

/**
 * Returns a singleton PDO connection.
 */
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // In production, log the error and show a user-friendly message
            error_log('DB Connection Error: ' . $e->getMessage());
            die(renderError('Database connection failed. Please try again later.'));
        }
    }
    return $pdo;
}

function renderError(string $msg): string {
    return "<!DOCTYPE html><html><body style='font-family:sans-serif;padding:40px;'>
            <h2 style='color:#c00;'>Error</h2><p>{$msg}</p></body></html>";
}
