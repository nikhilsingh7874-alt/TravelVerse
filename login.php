<?php
// login.php — authenticates against hardcoded users AND registered users in data/users.json

session_start();

// ─── If already logged in, go home ───────────────────────────────
if (!empty($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

// ─── Only handle POST ─────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    header('Location: login.html?error=1');
    exit;
}

// ─── 1. Hardcoded built-in accounts ──────────────────────────────
//     Passwords stored as plain text here (no hash) for demo convenience.
$builtin = [
    'admin' => ['password' => 'travel123', 'name' => 'Admin',       'role' => 'admin'],
    'guest' => ['password' => 'explore789', 'name' => 'Guest User', 'role' => 'user'],
];

if (isset($builtin[$username]) && $builtin[$username]['password'] === $password) {
    $_SESSION['logged_in']  = true;
    $_SESSION['username']   = $username;
    $_SESSION['full_name']  = $builtin[$username]['name'];
    $_SESSION['role']       = $builtin[$username]['role'];
    $_SESSION['login_time'] = date('Y-m-d H:i:s');
    header('Location: index.php');
    exit;
}

// ─── 2. Registered users from data/users.json ────────────────────
$users_file = __DIR__ . '/data/users.json';

if (file_exists($users_file)) {
    $raw   = file_get_contents($users_file);
    $users = json_decode($raw, true) ?? [];

    foreach ($users as $u) {
        // Case-insensitive username match
        if (strtolower($u['username']) === strtolower($username)) {
            if (password_verify($password, $u['password_hash'])) {
                $_SESSION['logged_in']  = true;
                $_SESSION['username']   = $u['username'];
                $_SESSION['full_name']  = $u['first_name'] . ' ' . $u['last_name'];
                $_SESSION['email']      = $u['email'];
                $_SESSION['role']       = $u['role'] ?? 'user';
                $_SESSION['login_time'] = date('Y-m-d H:i:s');
                header('Location: index.php');
                exit;
            }
            break; // username matched but password wrong — stop searching
        }
    }
}

// ─── Login failed ─────────────────────────────────────────────────
header('Location: login.html?error=1');
exit;
?>