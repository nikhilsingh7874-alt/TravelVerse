<?php
require 'auth.php';

// ── Package data (mirrors packages.php) ──────────────────────────
$packages_data = [
  'Manali'       => ['name'=>'Manali',        'price'=>80000, 'nights'=>7,  'img'=>'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=400&q=80', 'dest'=>'Manali'],
  'Kashmir'      => ['name'=>'Kashmir',     'price'=>90000, 'nights'=>7, 'img'=>'https://images.unsplash.com/photo-1595815771614-ade9d652a65d?w=400&q=80', 'dest'=>'Kashmir'],
  'Goa'          => ['name'=>'Goa',     'price'=>60000, 'nights'=>5,  'img'=>'https://plus.unsplash.com/premium_photo-1697729701846-e34563b06d47?w=400&q=80', 'dest'=>'Goa'],
  'Jaipur'       => ['name'=>'Jaipur',       'price'=>50000, 'nights'=>4, 'img'=>'https://images.unsplash.com/photo-1603262110263-fb0112e7cc33?w=400&q=80', 'dest'=>'Jaipur'],
  'Mathura'      => ['name'=>'Mathura',    'price'=>75000,  'nights'=>4,  'img'=>'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&q=80', 'dest'=>'Mathura'],
  'Leh-Ladakh'   => ['name'=>'Leh-Ladakh',  'price'=>90000, 'nights'=>5,  'img'=>'https://images.unsplash.com/photo-1543832923-44667a44c804?w=400&q=80', 'dest'=>'Leh-Ladakh'],
  'Kerala'       => ['name'=>'Kerala',       'price'=>80000, 'nights'=>6,  'img'=>'https://plus.unsplash.com/premium_photo-1697729600773-5b039ef17f3b?w=400&q=80', 'dest'=>'Kerala'],
  'Andaman and Nicobar' => ['name'=>'Andaman and Nicobar', 'price'=>70000, 'nights'=>5,  'img'=>'https://images.unsplash.com/photo-1642498232612-a837df233825?w=400&q=80', 'dest'=>'Andaman and Nicobar'],
  'Darjeeling'   => ['name'=>'Darjeeling',  'price'=>50000, 'nights'=>4,  'img'=>'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=400&q=80', 'dest'=>'Darjeeling'],
  'Rishikesh'    => ['name'=>'Rishikesh',   'price'=>40000, 'nights'=>3,  'img'=>'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=400&q=80', 'dest'=>'Rishikesh'],
  'Jaisalmere'    => ['name'=>'Jaisalmere',   'price'=>70000, 'nights'=>5,  'img'=>'https://images.unsplash.com/photo-1676193361626-debc2960b1c4?w=400&q=80', 'dest'=>'Jaisalmere'],  
  
  ];

// ── Detect selected package ───────────────────────────────────────
$pkg_key = $_GET['pkg'] ?? $_POST['pkg_key'] ?? 'Manali';
if (!array_key_exists($pkg_key, $packages_data)) $pkg_key = 'Manali';
$pkg = $packages_data[$pkg_key];

// ── Handle form submission ────────────────────────────────────────
$success   = false;
$errors    = [];
$booking   = [];
$ref_no    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect & sanitise
    $full_name   = trim($_POST['full_name']   ?? '');
    $email       = trim($_POST['email']       ?? '');
    $phone       = trim($_POST['phone']       ?? '');
    $adults      = (int)($_POST['adults']     ?? 1);
    $children    = (int)($_POST['children']   ?? 0);
    $check_in    = trim($_POST['check_in']    ?? '');
    $check_out   = trim($_POST['check_out']   ?? '');
    $room_type   = trim($_POST['room_type']   ?? '');
    $meal_plan   = trim($_POST['meal_plan']   ?? '');
    $special     = trim($_POST['special']     ?? '');
    $pkg_key_post= trim($_POST['pkg_key']     ?? $pkg_key);

    // Validation
    if (empty($full_name))  $errors[] = 'Full name is required.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (empty($phone) || !preg_match('/^[0-9+\-\s]{7,15}$/', $phone)) $errors[] = 'Valid phone number is required.';
    if ($adults < 1)        $errors[] = 'At least 1 adult is required.';
    if (empty($check_in))   $errors[] = 'Check-in date is required.';
    if (empty($check_out))  $errors[] = 'Check-out date is required.';
    if (!empty($check_in) && !empty($check_out) && strtotime($check_out) <= strtotime($check_in))
                            $errors[] = 'Check-out must be after check-in.';
    if (empty($room_type))  $errors[] = 'Please select a room type.';
    if (empty($meal_plan))  $errors[] = 'Please select a meal plan.';

    if (empty($errors)) {
        // Calculate nights & total
        $nights_booked = max(1, (int)((strtotime($check_out) - strtotime($check_in)) / 86400));
        $pax           = $adults + $children;
        $base_price    = $packages_data[$pkg_key_post]['price'] ?? $pkg['price'];
        $total_price   = $base_price * $adults + ($base_price * 0.5 * $children);

        // Generate booking reference
        $ref_no = 'TW-' . strtoupper(substr(md5(uniqid()), 0, 8));
        $booked_at = date('Y-m-d H:i:s');

        // Build booking record
        $booking = [
            'ref_no'        => $ref_no,
            'pkg_key'       => $pkg_key_post,
            'package_name'  => $packages_data[$pkg_key_post]['name'] ?? $pkg['name'],
            'destination'   => $packages_data[$pkg_key_post]['dest'] ?? $pkg['dest'],
            'full_name'     => $full_name,
            'email'         => $email,
            'phone'         => $phone,
            'adults'        => $adults,
            'children'      => $children,
            'check_in'      => $check_in,
            'check_out'     => $check_out,
            'nights_booked' => $nights_booked,
            'room_type'     => $room_type,
            'meal_plan'     => $meal_plan,
            'special'       => $special,
            'total_price'   => $total_price,
            'booked_by'     => $_SESSION['username'],
            'booked_at'     => $booked_at,
            'status'        => 'confirmed',
        ];

        // ── Save to JSON file ──────────────────────────────────────
        $storage_file = 'data/bookings.json';
        if (!is_dir('data')) mkdir('data', 0755, true);

        $all_bookings = [];
        if (file_exists($storage_file)) {
            $raw = file_get_contents($storage_file);
            $all_bookings = json_decode($raw, true) ?? [];
        }
        $all_bookings[] = $booking;
        file_put_contents($storage_file, json_encode($all_bookings, JSON_PRETTY_PRINT));

        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book <?= htmlspecialchars($pkg['name']) ?> — Travel World</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="booking-page">

<?php require 'nav.php'; ?>

<?php if ($success): ?>
<!-- ── SUCCESS STATE ──────────────────────────────────────────── -->
<div class="booking-success-wrap fade-in visible">
  <div class="success-icon">✅</div>
  <h2>Booking Confirmed!</h2>
  <p>Thank you, <strong><?= htmlspecialchars($booking['full_name']) ?></strong>! Your trip is being arranged.</p>
  <p style="font-size:0.88rem">A confirmation will be sent to <strong><?= htmlspecialchars($booking['email']) ?></strong></p>

  <div class="booking-ref"><?= htmlspecialchars($booking['ref_no']) ?></div>

  <div class="booking-detail-table">
    <div class="bdr"><span>Package</span>    <span><?= htmlspecialchars($booking['package_name']) ?></span></div>
    <div class="bdr"><span>Destination</span><span><?= htmlspecialchars($booking['destination']) ?></span></div>
    <div class="bdr"><span>Check-In</span>   <span><?= date('D, d M Y', strtotime($booking['check_in'])) ?></span></div>
    <div class="bdr"><span>Check-Out</span>  <span><?= date('D, d M Y', strtotime($booking['check_out'])) ?></span></div>
    <div class="bdr"><span>Duration</span>   <span><?= $booking['nights_booked'] ?> Night<?= $booking['nights_booked']>1?'s':'' ?></span></div>
    <div class="bdr"><span>Guests</span>     <span><?= $booking['adults'] ?> Adult<?= $booking['adults']>1?'s':'' ?><?= $booking['children']>0 ? ', '.$booking['children'].' Child'.($booking['children']>1?'ren':'') : '' ?></span></div>
    <div class="bdr"><span>Room Type</span>  <span><?= htmlspecialchars($booking['room_type']) ?></span></div>
    <div class="bdr"><span>Meal Plan</span>  <span><?= htmlspecialchars($booking['meal_plan']) ?></span></div>
    <div class="bdr"><span>Total Amount</span><span style="color:var(--gold);font-weight:700">₹<?= number_format($booking['total_price']) ?></span></div>
  </div>

  <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
    <a href="packages.php" class="btn-primary">Browse More Packages</a>
    <a href="index.php" class="btn-outline">Back to Home</a>
  </div>
</div>

<?php else: ?>
<!-- ── BOOKING HERO ───────────────────────────────────────────── -->
<div class="booking-hero">
  <div class="booking-hero-inner">
    <div class="booking-pkg-info">
      <img class="booking-pkg-thumb" src="<?= htmlspecialchars($pkg['img']) ?>" alt="<?= htmlspecialchars($pkg['name']) ?>">
      <div>
        <div class="booking-pkg-title"><?= htmlspecialchars($pkg['name']) ?></div>
        <div class="booking-pkg-subtitle">📍 <?= htmlspecialchars($pkg['dest']) ?> &nbsp;·&nbsp; ⏱ <?= $pkg['nights'] ?> Nights / <?= $pkg['nights']+1 ?> Days</div>
      </div>
    </div>
    <div class="booking-price-tag">
      <span class="amount">₹<?= number_format($pkg['price']) ?></span>
      <span class="per">per adult</span>
    </div>
  </div>
</div>

<!-- ── BOOKING BODY ──────────────────────────────────────────── -->
<div class="booking-body">

  <!-- FORM -->
  <div class="booking-form-card">
    <h2>Complete Your Booking</h2>

    <?php if (!empty($errors)): ?>
    <div style="background:rgba(248,81,73,0.08);border:1px solid rgba(248,81,73,0.25);border-radius:8px;padding:16px;margin-bottom:24px;">
      <?php foreach ($errors as $e): ?>
        <p style="color:var(--danger);font-size:0.85rem;margin-bottom:5px;">⚠ <?= htmlspecialchars($e) ?></p>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <form id="bookingForm" method="POST" action="booking.php?pkg=<?= urlencode($pkg_key) ?>" novalidate>
      <input type="hidden" name="pkg_key" value="<?= htmlspecialchars($pkg_key) ?>">

      <!-- Personal Info -->
      <div class="section-divider">Personal Information</div>

      <div class="form-row">
        <div class="form-group">
          <label for="full_name">Full Name *</label>
          <input type="text" id="full_name" name="full_name" placeholder="As per passport"
            value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
          <div class="form-error" id="err_name">Full name is required.</div>
        </div>
        <div class="form-group">
          <label for="email">Email Address *</label>
          <input type="email" id="email" name="email" placeholder="you@email.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          <div class="form-error" id="err_email">Valid email required.</div>
        </div>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number *</label>
        <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210"
          value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
        <div class="form-error" id="err_phone">Valid phone number required.</div>
      </div>

      <!-- Guests -->
      <div class="section-divider">Number of Guests</div>

      <div class="form-row">
        <div class="form-group">
          <label>Adults (12+ yrs) *</label>
          <div class="person-counter">
            <button type="button" class="counter-btn" onclick="changeCount('adults',-1)">−</button>
            <span class="counter-val" id="adults_display">1</span>
            <button type="button" class="counter-btn" onclick="changeCount('adults',1)">+</button>
          </div>
          <input type="hidden" id="adults" name="adults" class="counter-input" value="<?= (int)($_POST['adults']??1) ?>">
          <div class="form-error" id="err_adults">At least 1 adult required.</div>
        </div>
        <div class="form-group">
          <label>Children (2–11 yrs)</label>
          <div class="person-counter">
            <button type="button" class="counter-btn" onclick="changeCount('children',-1)">−</button>
            <span class="counter-val" id="children_display">0</span>
            <button type="button" class="counter-btn" onclick="changeCount('children',1)">+</button>
          </div>
          <input type="hidden" id="children" name="children" class="counter-input" value="<?= (int)($_POST['children']??0) ?>">
        </div>
      </div>

      <!-- Travel Dates -->
      <div class="section-divider">Travel Dates</div>

      <div class="form-row">
        <div class="form-group">
          <label for="check_in">Check-In Date *</label>
          <input type="date" id="check_in" name="check_in"
            min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
            value="<?= htmlspecialchars($_POST['check_in'] ?? '') ?>">
          <div class="form-error" id="err_checkin">Check-in date required.</div>
        </div>
        <div class="form-group">
          <label for="check_out">Check-Out Date *</label>
          <input type="date" id="check_out" name="check_out"
            min="<?= date('Y-m-d', strtotime('+2 day')) ?>"
            value="<?= htmlspecialchars($_POST['check_out'] ?? '') ?>">
          <div class="form-error" id="err_checkout">Check-out date required.</div>
        </div>
      </div>

      <!-- Preferences -->
      <div class="section-divider">Stay Preferences</div>

      <div class="form-row">
        <div class="form-group">
          <label for="room_type">Room Type *</label>
          <select id="room_type" name="room_type">
            <option value="" disabled <?= empty($_POST['room_type'])?'selected':'' ?>>Select room type</option>
            <option value="Standard Room"    <?= ($_POST['room_type']??'')==='Standard Room'?'selected':'' ?>>Standard Room</option>
            <option value="Deluxe Room"      <?= ($_POST['room_type']??'')==='Deluxe Room'?'selected':'' ?>>Deluxe Room</option>
            <option value="Suite"            <?= ($_POST['room_type']??'')==='Suite'?'selected':'' ?>>Suite</option>
            <option value="Overwater Villa"  <?= ($_POST['room_type']??'')==='Overwater Villa'?'selected':'' ?>>Overwater Villa</option>
            <option value="Family Room"      <?= ($_POST['room_type']??'')==='Family Room'?'selected':'' ?>>Family Room</option>
          </select>
          <div class="form-error" id="err_room">Please select a room type.</div>
        </div>
        <div class="form-group">
          <label for="meal_plan">Meal Plan *</label>
          <select id="meal_plan" name="meal_plan">
            <option value="" disabled <?= empty($_POST['meal_plan'])?'selected':'' ?>>Select meal plan</option>
            <option value="Room Only"        <?= ($_POST['meal_plan']??'')==='Room Only'?'selected':'' ?>>Room Only</option>
            <option value="Breakfast Only"   <?= ($_POST['meal_plan']??'')==='Breakfast Only'?'selected':'' ?>>Breakfast Only</option>
            <option value="Half Board"       <?= ($_POST['meal_plan']??'')==='Half Board'?'selected':'' ?>>Half Board (B+D)</option>
            <option value="Full Board"       <?= ($_POST['meal_plan']??'')==='Full Board'?'selected':'' ?>>Full Board (B+L+D)</option>
            <option value="All Inclusive"    <?= ($_POST['meal_plan']??'')==='All Inclusive'?'selected':'' ?>>All Inclusive</option>
          </select>
          <div class="form-error" id="err_meal">Please select a meal plan.</div>
        </div>
      </div>

      <div class="form-group">
        <label for="special">Special Requests</label>
        <textarea id="special" name="special" placeholder="Dietary restrictions, anniversary setup, accessibility needs..."><?= htmlspecialchars($_POST['special'] ?? '') ?></textarea>
      </div>

      <button type="submit" class="btn-primary" style="width:100%;border-radius:8px;padding:16px;font-size:1rem;">
        Confirm Booking →
      </button>
    </form>
  </div>

  <!-- SUMMARY SIDEBAR -->
  <div class="booking-summary-card">
    <h3>Booking Summary</h3>

    <div class="summary-row">
      <span class="label">Package</span>
      <span class="value"><?= htmlspecialchars($pkg['name']) ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Destination</span>
      <span class="value"><?= htmlspecialchars($pkg['dest']) ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Duration</span>
      <span class="value" id="sum_duration"><?= $pkg['nights'] ?> Nights / <?= $pkg['nights']+1 ?> Days</span>
    </div>
    <div class="summary-row">
      <span class="label">Check-In</span>
      <span class="value" id="sum_checkin">—</span>
    </div>
    <div class="summary-row">
      <span class="label">Check-Out</span>
      <span class="value" id="sum_checkout">—</span>
    </div>
    <div class="summary-row">
      <span class="label">Guests</span>
      <span class="value" id="sum_guests">1 Adult</span>
    </div>
    <div class="summary-row">
      <span class="label">Room</span>
      <span class="value" id="sum_room">—</span>
    </div>

    <hr class="summary-divider">

    <div class="summary-row" style="font-size:0.82rem">
      <span class="label">Price/adult</span>
      <span class="value">₹<?= number_format($pkg['price']) ?></span>
    </div>
    <div class="summary-row" style="font-size:0.82rem">
      <span class="label">Price/child (50%)</span>
      <span class="value">₹<?= number_format($pkg['price'] * 0.5) ?></span>
    </div>

    <hr class="summary-divider">

    <div class="summary-total">
      <span class="total-label">Estimated Total</span>
      <span class="total-amount" id="sum_total">₹<?= number_format($pkg['price']) ?></span>
    </div>

    <div class="booking-notice">
      💡 This is an estimate. Final pricing will be confirmed by our consultant after reviewing your booking details.
    </div>

    <div style="margin-top:20px;padding:14px;background:rgba(63,185,80,0.05);border:1px solid rgba(63,185,80,0.15);border-radius:8px;font-size:0.8rem;color:var(--muted);">
      🔒 Your data is stored securely and will only be used to process your booking.
    </div>
  </div>

</div><!-- /booking-body -->
<?php endif; ?>

<?php require 'footer.php'; ?>

<script src="main.js"></script>
<script>
// ── Person counters ──────────────────────────────────────────────
const BASE_PRICE  = <?= $pkg['price'] ?>;
const CHILD_PRICE = BASE_PRICE * 0.5;

function changeCount(field, delta) {
  const input   = document.getElementById(field);
  const display = document.getElementById(field + '_display');
  let val = parseInt(input.value) + delta;
  if (field === 'adults')   val = Math.max(1, Math.min(20, val));
  if (field === 'children') val = Math.max(0, Math.min(10, val));
  input.value   = val;
  display.textContent = val;
  updateSummary();
}

// Sync displays on load
document.addEventListener('DOMContentLoaded', () => {
  ['adults','children'].forEach(f => {
    const inp = document.getElementById(f);
    const dis = document.getElementById(f + '_display');
    if (inp && dis) dis.textContent = inp.value;
  });
  updateSummary();
});

// ── Live summary updater ─────────────────────────────────────────
function fmt(n) { return '₹' + n.toLocaleString('en-IN'); }

function fmtDate(val) {
  if (!val) return '—';
  const d = new Date(val + 'T00:00:00');
  return d.toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' });
}

function updateSummary() {
  const adults   = parseInt(document.getElementById('adults')?.value   || 1);
  const children = parseInt(document.getElementById('children')?.value || 0);
  const checkIn  = document.getElementById('check_in')?.value;
  const checkOut = document.getElementById('check_out')?.value;
  const room     = document.getElementById('room_type')?.value;

  // Nights
  let nightsStr = '<?= $pkg['nights'] ?> Nights';
  if (checkIn && checkOut) {
    const diff = Math.round((new Date(checkOut) - new Date(checkIn)) / 86400000);
    if (diff > 0) nightsStr = diff + ' Night' + (diff > 1 ? 's' : '');
  }

  // Guests string
  let guests = adults + ' Adult' + (adults > 1 ? 's' : '');
  if (children > 0) guests += ', ' + children + ' Child' + (children > 1 ? 'ren' : '');

  // Total
  const total = BASE_PRICE * adults + CHILD_PRICE * children;

  // Update DOM
  const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
  set('sum_duration', nightsStr);
  set('sum_checkin',  fmtDate(checkIn));
  set('sum_checkout', fmtDate(checkOut));
  set('sum_guests',   guests);
  set('sum_room',     room || '—');
  set('sum_total',    fmt(total));
}

// Bind live updates
['check_in','check_out','room_type'].forEach(id => {
  document.getElementById(id)?.addEventListener('change', updateSummary);
});

// ── Set checkout min when checkin changes ────────────────────────
document.getElementById('check_in')?.addEventListener('change', function() {
  const coEl = document.getElementById('check_out');
  if (coEl) {
    const next = new Date(this.value);
    next.setDate(next.getDate() + 1);
    coEl.min = next.toISOString().split('T')[0];
    if (coEl.value && coEl.value <= this.value) { coEl.value = ''; updateSummary(); }
  }
});

// ── Client-side validation ───────────────────────────────────────
document.getElementById('bookingForm')?.addEventListener('submit', function(e) {
  let valid = true;
  const hide = id => { const el = document.getElementById(id); if (el) el.style.display = 'none'; };
  const show = id => { const el = document.getElementById(id); if (el) el.style.display = 'block'; valid = false; };

  ['err_name','err_email','err_phone','err_adults','err_checkin','err_checkout','err_room','err_meal'].forEach(hide);

  if (!document.getElementById('full_name').value.trim()) show('err_name');
  const em = document.getElementById('email').value.trim();
  if (!em || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)) show('err_email');
  if (!document.getElementById('phone').value.trim()) show('err_phone');
  if (parseInt(document.getElementById('adults').value) < 1) show('err_adults');
  if (!document.getElementById('check_in').value) show('err_checkin');
  if (!document.getElementById('check_out').value) show('err_checkout');
  if (!document.getElementById('room_type').value) show('err_room');
  if (!document.getElementById('meal_plan').value) show('err_meal');

  if (!valid) { e.preventDefault(); window.scrollTo({top: 200, behavior: 'smooth'}); }
});
</script>
</body>
</html>