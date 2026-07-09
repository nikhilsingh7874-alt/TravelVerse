<?php
// register.php
// Handles:
//   GET  ?check_username=xxx  → JSON availability check
//   POST action=register      → create new user, save to data/users.json

header('Content-Type: application/json');

// ─── Storage file ────────────────────────────────────────────────
define('USERS_FILE', __DIR__ . '/data/users.json');

// ─── Built-in (hardcoded) reserved usernames ─────────────────────
$RESERVED = ['admin', 'user', 'guest'];

// ─── Helpers ─────────────────────────────────────────────────────
function loadUsers(): array {
    if (!file_exists(USERS_FILE)) return [];
    $raw = file_get_contents(USERS_FILE);
    return json_decode($raw, true) ?? [];
}

function saveUsers(array $users): void {
    if (!is_dir(dirname(USERS_FILE))) {
        mkdir(dirname(USERS_FILE), 0755, true);
    }
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
}

function jsonOut(bool $ok, string $message = '', array $extra = []): void {
    echo json_encode(array_merge(['success' => $ok, 'message' => $message], $extra));
    exit;
}

function isUsernameTaken(string $username, array $users, array $reserved): bool {
    if (in_array(strtolower($username), array_map('strtolower', $reserved))) return true;
    foreach ($users as $u) {
        if (strtolower($u['username']) === strtolower($username)) return true;
    }
    return false;
}

// ─── GET: check username availability ────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['check_username'])) {
    $username = trim($_GET['check_username']);

    if (strlen($username) < 3) {
        jsonOut(false, 'Too short.', ['available' => false]);
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        jsonOut(false, 'Only letters, numbers and underscores allowed.', ['available' => false]);
    }

    $users = loadUsers();
    if (isUsernameTaken($username, $users, $RESERVED)) {
        jsonOut(false, 'Username is already taken.', ['available' => false]);
    }

    jsonOut(true, 'Available!', ['available' => true]);
}

// ─── POST: register new user ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name']  ?? '');
    $email      = trim($_POST['email']      ?? '');
    $phone      = trim($_POST['phone']      ?? '');
    $username   = trim($_POST['username']   ?? '');
    $password   = $_POST['password'] ?? '';
    $confirm    = $_POST['confirm']  ?? '';

    // ── Server-side validation ────────────────────────────────────
    if (empty($first_name))                                   jsonOut(false, 'First name is required.');
    if (empty($last_name))                                    jsonOut(false, 'Last name is required.');
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                                                              jsonOut(false, 'A valid email address is required.');
    if (empty($username) || strlen($username) < 3)            jsonOut(false, 'Username must be at least 3 characters.');
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username))          jsonOut(false, 'Username may only contain letters, numbers and underscores.');
    if (empty($password) || strlen($password) < 6)            jsonOut(false, 'Password must be at least 6 characters.');
    if ($password !== $confirm)                               jsonOut(false, 'Passwords do not match.');

    $users = loadUsers();

    // Check uniqueness
    if (isUsernameTaken($username, $users, $RESERVED)) {
        jsonOut(false, 'That username is already taken. Please choose another.');
    }

    // Check email uniqueness
    foreach ($users as $u) {
        if (strtolower($u['email']) === strtolower($email)) {
            jsonOut(false, 'An account with that email already exists.');
        }
    }

    // ── Save new user (password hashed) ──────────────────────────
    $new_user = [
        'id'           => uniqid('u_'),
        'username'     => $username,
        'password_hash'=> password_hash($password, PASSWORD_BCRYPT),
        'first_name'   => $first_name,
        'last_name'    => $last_name,
        'email'        => $email,
        'phone'        => $phone,
        'role'         => 'user',
        'registered_at'=> date('Y-m-d H:i:s'),
    ];

    $users[] = $new_user;
    saveUsers($users);

    jsonOut(true, 'Account created successfully!', ['username' => $username]);
}

// ─── Fallback ─────────────────────────────────────────────────────
jsonOut(false, 'Invalid request.');
?> 