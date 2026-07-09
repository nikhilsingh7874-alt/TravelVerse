<?php
// cancel-booking.php
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

// ── Inputs ────────────────────────────────────────────────────────
$ref_no = trim($_POST['ref_no'] ?? '');
$reason = trim($_POST['reason'] ?? 'No reason given');

if ($ref_no === '') {
    fail('Booking reference is required.');
}

// ── Load bookings ─────────────────────────────────────────────────
$file = __DIR__ . '/data/bookings.json';

if (!file_exists($file)) {
    fail('No bookings found.');
}

$decoded  = json_decode(file_get_contents($file), true);
$bookings = is_array($decoded) ? $decoded : [];

$is_admin = ($_SESSION['username'] === 'admin');
$found    = false;

foreach ($bookings as &$b) {
    if ($b['ref_no'] !== $ref_no) continue;

    // Permission: regular users can only cancel their own bookings
    if (!$is_admin && ($b['booked_by'] ?? '') !== $_SESSION['username']) {
        fail('Permission denied: this is not your booking.');
    }

    // Already cancelled?
    if (($b['status'] ?? 'confirmed') === 'cancelled') {
        fail('This booking is already cancelled.');
    }

    // Users cannot cancel past check-in (admin always can)
    if (!$is_admin && strtotime($b['check_in']) <= time()) {
        fail('Cannot cancel a booking whose check-in date has already passed.');
    }

    // Apply cancellation
    $b['status']        = 'cancelled';
    $b['cancelled_at']  = date('Y-m-d H:i:s');
    $b['cancelled_by']  = $_SESSION['username'];
    $b['cancel_reason'] = $reason;

    $found = true;
    break;
}
unset($b);

if (!$found) {
    fail('Booking reference not found.');
}

// ── Save ──────────────────────────────────────────────────────────
if (file_put_contents($file, json_encode($bookings, JSON_PRETTY_PRINT)) === false) {
    fail('Server error: could not save changes. Check file permissions on data/ folder.');
}

echo json_encode([
    'success' => true,
    'message' => 'Booking cancelled successfully.',
    'ref_no'  => $ref_no,
]);
exit;
?>