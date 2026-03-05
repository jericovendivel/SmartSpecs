<?php
// ============================================================
//  SmartSpecs -- Database Connection
//  Edit the credentials below to match your XAMPP setup
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // XAMPP default is empty
define('DB_NAME', 'smartspecs');

function getDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die('
        <div style="font-family:sans-serif;padding:40px;background:#fff0f0;border:1px solid #ffcccc;margin:40px;border-radius:8px;">
            <h2 style="color:#cc0000;">Database Connection Failed</h2>
            <p><strong>Error:</strong> ' . $conn->connect_error . '</p>
            <p>Make sure XAMPP MySQL is running and you have imported <code>data/schema.sql</code>.</p>
        </div>');
    }
    $conn->set_charset('utf8');
    return $conn;
}
?>
