<?php
require 'auth.php';

define('CONTACTS_FILE', __DIR__ . '/data/contacts.json');

// ── Helper: load / save contacts ────────────────────────────────
function loadContacts(): array {
    if (!file_exists(CONTACTS_FILE)) return [];
    return json_decode(file_get_contents(CONTACTS_FILE), true) ?? [];
}
function saveContacts(array $data): void {
    if (!is_dir(dirname(CONTACTS_FILE))) mkdir(dirname(CONTACTS_FILE), 0755, true);
    file_put_contents(CONTACTS_FILE, json_encode($data, JSON_PRETTY_PRINT));
}

$success = false;
$errors  = [];
$saved   = null;

// ── Handle POST (save contact message) ──────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'contact') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $phone   = trim($_POST['phone']   ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name))                                             $errors[] = 'Name is required.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (empty($message))                                          $errors[] = 'Message cannot be empty.';

    if (empty($errors)) {
        $saved = [
            'id'         => uniqid('msg_'),
            'name'       => $name,
            'email'      => $email,
            'phone'      => $phone,
            'subject'    => $subject ?: 'General Enquiry',
            'message'    => $message,
            'username'   => $_SESSION['username'],
            'submitted'  => date('Y-m-d H:i:s'),
            'status'     => 'unread',
        ];
        $all = loadContacts();
        $all[] = $saved;
        saveContacts($all);
        $success = true;
    }
}

// ── Load all messages for the current user (admin sees all) ─────
$allContacts  = loadContacts();
$is_admin     = ($_SESSION['username'] === 'admin');
$myContacts   = $is_admin
    ? array_reverse($allContacts)
    : array_reverse(array_values(array_filter($allContacts, fn($c) => $c['username'] === $_SESSION['username'])));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact — Travel World</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require 'nav.php'; ?>

<div class="page-header">
  <span class="section-label">Get in Touch</span>
  <h1 class="section-title">Contact Us</h1>
  <p class="section-sub" style="margin:0 auto;color:var(--muted);max-width:460px;">
    Have questions or want a custom itinerary? Our travel consultants are just a message away.
  </p>
</div>

<section class="section">
  <div class="contact-wrapper">

    <!-- Left: info -->
    <div class="contact-info fade-in">
      <h3>We'd love to hear from you</h3>
      <p style="color:var(--muted);font-size:0.9rem;margin-bottom:36px;">
        Whether you're planning your first trip or your fiftieth adventure, we're here to help craft the perfect journey.
      </p>

      <div class="contact-item">
        <div class="contact-icon">📍</div>
        <div><strong>Our Office</strong>
          <p>Tikhampur, Ballia<br>Uttar Pradesh, India — 277001</p></div>
      </div>
      <div class="contact-item">
        <div class="contact-icon">📞</div>
        <div><strong>Phone</strong>
          <p>+91 98567 45634/p><p>Mon–Sat, 9 AM – 7 PM IST</p></div>
      </div>
      <div class="contact-item">
        <div class="contact-icon">✉️</div>
        <div><strong>Email</strong>
          <p>hello@travelworld.in</p><p>We reply within 24 hours</p></div>
      </div>
      <div class="contact-item">
        <div class="contact-icon">💬</div>
        <div><strong>WhatsApp</strong>
          <p>+91 98765 43210</p><p>Quick replies on WhatsApp</p></div>
      </div>
    </div>

    <!-- Right: form -->
    <div class="contact-form fade-in">
      <h3 style="font-family:'Playfair Display',serif;font-size:1.35rem;margin-bottom:24px;">Send Us a Message</h3>

      <?php if ($success && $saved): ?>
        <div style="background:rgba(63,185,80,0.08);border:1px solid rgba(63,185,80,0.3);border-radius:12px;padding:28px;text-align:center;">
          <div style="font-size:2.2rem;margin-bottom:10px;">✅</div>
          <strong style="color:var(--success);font-size:1.05rem;display:block;margin-bottom:8px;">Message Received!</strong>
          <p style="color:var(--muted);font-size:0.9rem;margin-bottom:16px;">
            Thank you, <strong style="color:var(--text)"><?= htmlspecialchars($saved['name']) ?></strong>!
            We'll reply to <strong style="color:var(--text)"><?= htmlspecialchars($saved['email']) ?></strong> within 24 hours.
          </p>
          <div style="background:rgba(0,0,0,0.2);border-radius:8px;padding:12px 16px;text-align:left;font-size:0.83rem;color:var(--muted);">
            <div style="margin-bottom:4px;"><strong style="color:var(--text)">Subject:</strong> <?= htmlspecialchars($saved['subject']) ?></div>
            <div><strong style="color:var(--text)">Message ID:</strong> <span style="color:var(--gold);font-family:monospace"><?= $saved['id'] ?></span></div>
          </div>
          <button onclick="document.getElementById('contactFormWrap').style.display='block';this.closest('div').style.display='none';"
                  class="btn-outline" style="margin-top:20px;border-radius:8px;padding:10px 28px;font-size:0.85rem;">
            Send Another Message
          </button>
        </div>
        <div id="contactFormWrap" style="display:none;margin-top:24px;">
      <?php else: ?>
        <div id="contactFormWrap">
      <?php endif; ?>

        <?php if (!empty($errors)): ?>
          <div style="background:rgba(248,81,73,0.08);border:1px solid rgba(248,81,73,0.3);border-radius:8px;padding:14px;margin-bottom:20px;">
            <?php foreach ($errors as $e): ?>
              <p style="color:var(--danger);font-size:0.85rem;margin-bottom:4px;">⚠ <?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form id="contactForm" method="POST" action="contact.php" novalidate>
          <input type="hidden" name="action" value="contact">
          <div class="form-row">
            <div class="form-group">
              <label for="name">Full Name *</label>
              <input type="text" id="name" name="name" placeholder="Your name"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
              <div class="form-error" id="nameErr">Please enter your name.</div>
            </div>
            <div class="form-group">
              <label for="email">Email Address *</label>
              <input type="email" id="email" name="email" placeholder="your@email.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
              <div class="form-error" id="emailErr">Please enter a valid email.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210"
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="subject">Subject</label>
              <input type="text" id="subject" name="subject" placeholder="What is your enquiry about?"
                value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" placeholder="Tell us about your dream trip..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
            <div class="form-error" id="msgErr">Please enter a message.</div>
          </div>
          <button type="submit" class="btn-primary" style="width:100%;border-radius:8px;padding:14px;">
            Send Message &rarr;
          </button>
        </form>
        </div><!-- /contactFormWrap -->
    </div>

  </div>
</section>

<!-- ── MY MESSAGES ──────────────────────────────────────────────── -->
<?php if (!empty($myContacts)): ?>
<section class="section" style="background:var(--dark);border-top:1px solid rgba(255,255,255,0.04);padding-top:72px;">
  <div style="max-width:960px;margin:0 auto;">
    <span class="section-label"><?= $is_admin ? 'All Submissions' : 'Your Messages' ?></span>
    <h2 class="section-title" style="margin-bottom:8px;">
      <?= $is_admin ? 'Inbox' : 'Message History' ?>
    </h2>
    <p style="color:var(--muted);font-size:0.9rem;margin-bottom:36px;">
      <?= $is_admin
        ? count($myContacts) . ' total message' . (count($myContacts)>1?'s':'') . ' received.'
        : 'All messages you\'ve sent to our team.' ?>
    </p>

    <div style="display:flex;flex-direction:column;gap:16px;">
      <?php foreach ($myContacts as $c): ?>
      <div class="msg-card fade-in" onclick="this.classList.toggle('expanded')">
        <div class="msg-card-header">
          <div class="msg-card-left">
            <div class="msg-avatar"><?= strtoupper(substr($c['name'],0,1)) ?></div>
            <div>
              <div class="msg-name"><?= htmlspecialchars($c['name']) ?></div>
              <div class="msg-email"><?= htmlspecialchars($c['email']) ?>
                <?php if ($c['phone']): ?>· <?= htmlspecialchars($c['phone']) ?><?php endif; ?>
              </div>
            </div>
          </div>
          <div class="msg-card-right">
            <span class="msg-subject"><?= htmlspecialchars($c['subject']) ?></span>
            <span class="msg-date"><?= date('d M Y, H:i', strtotime($c['submitted'])) ?></span>
          </div>
          <div class="msg-chevron">&#8250;</div>
        </div>
        <div class="msg-card-body">
          <p class="msg-text"><?= nl2br(htmlspecialchars($c['message'])) ?></p>
          <div class="msg-meta-row">
            <span style="font-size:0.75rem;color:var(--muted);font-family:monospace">ID: <?= $c['id'] ?></span>
            <?php if ($is_admin): ?>
              <span style="font-size:0.75rem;color:var(--gold)">by @<?= htmlspecialchars($c['username']) ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require 'footer.php'; ?>

<script src="main.js"></script>
<script>
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      let valid = true;
      document.querySelectorAll('.form-error').forEach(el => el.style.display = 'none');
      const name    = document.getElementById('name').value.trim();
      const email   = document.getElementById('email').value.trim();
      const message = document.getElementById('message').value.trim();
      if (!name)  { document.getElementById('nameErr').style.display  = 'block'; valid = false; }
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailErr').style.display = 'block'; valid = false;
      }
      if (!message) { document.getElementById('msgErr').style.display = 'block'; valid = false; }
      if (!valid) e.preventDefault();
    });
  }
</script>
</body>
</html>