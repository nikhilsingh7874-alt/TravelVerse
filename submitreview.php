<?php
// submit-review.php
// Always JSON — never redirects. Session checked manually.

session_start();                          // MUST be first — before any header()

header('Content-Type: application/json');
header('Cache-Control: no-cache');

// ── Helper ────────────────────────────────────────────────────────
function fail(string $msg): void {
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

// ── Auth check (JSON-safe, no redirect) ───────────────────────────
if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    fail('Session expired. Please refresh the page and log in again.');
}

// ── Only accept POST ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail('Invalid request method.');
}

// ── Collect inputs ────────────────────────────────────────────────
$name        = trim($_POST['reviewer_name'] ?? '');
$destination = trim($_POST['destination']   ?? '');
$rating      = (int)($_POST['rating']       ?? 0);
$title       = trim($_POST['title']         ?? '');
$body        = trim($_POST['body']          ?? '');

// ── Validate ──────────────────────────────────────────────────────
if ($name === '')              fail('Name is required.');
if ($destination === '')       fail('Please select a destination.');
if ($rating < 1 || $rating > 5) fail('Please select a star rating (1–5).');
if (strlen($body) < 20)       fail('Review must be at least 20 characters.');

// ── Build record ──────────────────────────────────────────────────
$review = [
    'id'            => uniqid('rev_'),
    'reviewer_name' => $name,
    'destination'   => $destination,
    'rating'        => $rating,
    'title'         => $title !== '' ? $title : $destination . ' Experience',
    'body'          => $body,
    'username'      => $_SESSION['username'] ?? 'unknown',
    'submitted'     => date('Y-m-d H:i:s'),
    'verified'      => true,
];

// ── Save to data/reviews.json ─────────────────────────────────────
$file = __DIR__ . '/data/reviews.json';
$dir  = dirname($file);

if (!is_dir($dir)) {
    if (!mkdir($dir, 0755, true)) {
        fail('Server error: could not create data directory. Check folder permissions.');
    }
}

$all = [];
if (file_exists($file)) {
    $decoded = json_decode(file_get_contents($file), true);
    $all = is_array($decoded) ? $decoded : [];
}

$all[] = $review;

if (file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT)) === false) {
    fail('Server error: could not save review. Check file permissions on data/ folder.');
}

echo json_encode(['success' => true, 'review' => $review]);
exit;
?>