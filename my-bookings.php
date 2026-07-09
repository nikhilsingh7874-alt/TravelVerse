<?php
require 'auth.php';

$storage_file = 'data/bookings.json';
$all_bookings = [];

if (file_exists($storage_file)) {
    $raw = file_get_contents($storage_file);
    $all_bookings = json_decode($raw, true) ?? [];
}

$is_admin = ($_SESSION['username'] === 'admin');

// Filter for regular users
if (!$is_admin) {
    $all_bookings = array_values(array_filter($all_bookings, fn($b) => $b['booked_by'] === $_SESSION['username']));
}

// Newest first
$all_bookings = array_reverse($all_bookings);

// Count stats
$confirmed_count = count(array_filter($all_bookings, fn($b) => ($b['status'] ?? 'confirmed') === 'confirmed'));
$cancelled_count = count(array_filter($all_bookings, fn($b) => ($b['status'] ?? 'confirmed') === 'cancelled'));

// Admin revenue (confirmed only)
$total_rev = 0;
$total_pax = 0;
if ($is_admin) {
    foreach ($all_bookings as $b) {
        if (($b['status'] ?? 'confirmed') === 'confirmed') {
            $total_rev += $b['total_price'];
            $total_pax += $b['adults'] + ($b['children'] ?? 0);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $is_admin ? 'All Bookings' : 'My Bookings' ?> — Travel World</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require 'nav.php'; ?>

<div class="page-header">
  <span class="section-label"><?= $is_admin ? 'Admin Panel' : 'Your Trips' ?></span>
  <h1 class="section-title"><?= $is_admin ? 'All Bookings' : 'My Bookings' ?></h1>
  <p class="section-sub" style="margin:0 auto;color:var(--muted);max-width:440px;">
    <?= $is_admin
      ? 'Manage all customer bookings. You can confirm or cancel any booking.'
      : 'View and manage all your travel bookings. Cancel anytime before check-in.' ?>
  </p>
</div>

<section class="section">

  <?php if (empty($all_bookings)): ?>
  <!-- Empty state -->
  <div style="text-align:center;padding:80px 24px;">
    <div style="font-size:3.5rem;margin-bottom:16px;">✈️</div>
    <h3 style="font-family:'Playfair Display',serif;font-size:1.4rem;margin-bottom:10px;">No bookings yet</h3>
    <p style="color:var(--muted);margin-bottom:28px;">You haven't made any bookings. Start exploring our packages!</p>
    <a href="packages.php" class="btn-primary">Browse Packages</a>
  </div>

  <?php else: ?>

  <!-- Toolbar -->
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;flex-wrap:wrap;gap:16px;">
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <!-- Status filter tabs -->
      <div style="display:flex;background:var(--card);border:1px solid rgba(255,255,255,0.06);border-radius:8px;padding:4px;gap:4px;">
        <button class="filter-btn active" data-filter="all"       onclick="filterBookings('all',this)">All (<?= count($all_bookings) ?>)</button>
        <button class="filter-btn"        data-filter="confirmed" onclick="filterBookings('confirmed',this)">Confirmed (<?= $confirmed_count ?>)</button>
        <button class="filter-btn"        data-filter="cancelled" onclick="filterBookings('cancelled',this)">Cancelled (<?= $cancelled_count ?>)</button>
      </div>
    </div>
    <a href="packages.php" class="btn-primary" style="font-size:0.85rem;padding:10px 24px;border-radius:8px;">+ New Booking</a>
  </div>

  <!-- Bookings table -->
  <div class="bookings-table-wrap" id="bookingsTableWrap">
    <table class="bookings-table" id="bookingsTable">
      <thead>
        <tr>
          <th>Ref No.</th>
          <th>Package &amp; Destination</th>
          <th>Guest Details</th>
          <th>Dates</th>
          <th>Guests</th>
          <th>Room / Meal</th>
          <th>Total</th>
          <?php if ($is_admin): ?><th>Booked By</th><?php endif; ?>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($all_bookings as $b):
          $status      = $b['status'] ?? 'confirmed';
          $isCancelled = $status === 'cancelled';
          $checkInPast = strtotime($b['check_in']) <= time();
          // User can cancel if: not cancelled, check-in in future
          // Admin can cancel if: not cancelled
          $canCancel   = !$isCancelled && ($is_admin || !$checkInPast);
        ?>
        <tr class="booking-row" data-status="<?= $status ?>" id="row-<?= htmlspecialchars($b['ref_no']) ?>"
            style="<?= $isCancelled ? 'opacity:0.55;' : '' ?>">

          <td>
            <strong style="color:<?= $isCancelled ? 'var(--muted)' : 'var(--gold)' ?>;font-family:'Playfair Display',serif;font-size:0.9rem">
              <?= htmlspecialchars($b['ref_no']) ?>
            </strong>
            <span style="display:block;font-size:0.73rem;color:var(--muted);margin-top:2px;">
              <?= date('d M Y', strtotime($b['booked_at'])) ?>
            </span>
          </td>

          <td>
            <strong><?= htmlspecialchars($b['package_name']) ?></strong>
            <span style="display:block;font-size:0.8rem;color:var(--muted);"><?= htmlspecialchars($b['destination']) ?></span>
          </td>

          <td>
            <strong><?= htmlspecialchars($b['full_name']) ?></strong>
            <span style="display:block;font-size:0.78rem;color:var(--muted);"><?= htmlspecialchars($b['email']) ?></span>
            <?php if (!empty($b['phone'])): ?>
            <span style="font-size:0.75rem;color:var(--muted);"><?= htmlspecialchars($b['phone']) ?></span>
            <?php endif; ?>
          </td>

          <td>
            <strong><?= date('d M Y', strtotime($b['check_in'])) ?></strong>
            <span style="display:block;font-size:0.78rem;color:var(--muted);">→ <?= date('d M Y', strtotime($b['check_out'])) ?></span>
            <span style="font-size:0.73rem;color:var(--muted);"><?= $b['nights_booked'] ?> night<?= $b['nights_booked']>1?'s':'' ?></span>
          </td>

          <td>
            <?= $b['adults'] ?> Adult<?= $b['adults']>1?'s':'' ?>
            <?php if (($b['children'] ?? 0) > 0): ?>
              <span style="display:block;font-size:0.78rem;color:var(--muted);"><?= $b['children'] ?> Child<?= $b['children']>1?'ren':'' ?></span>
            <?php endif; ?>
          </td>

          <td>
            <strong><?= htmlspecialchars($b['room_type']) ?></strong>
            <span style="display:block;font-size:0.78rem;color:var(--muted);"><?= htmlspecialchars($b['meal_plan']) ?></span>
            <?php if (!empty($b['special'])): ?>
              <span style="display:block;font-size:0.73rem;color:var(--accent);" title="<?= htmlspecialchars($b['special']) ?>">📝 Special request</span>
            <?php endif; ?>
          </td>

          <td style="color:<?= $isCancelled ? 'var(--muted)' : 'var(--gold)' ?>;font-family:'Playfair Display',serif;font-size:0.95rem;font-weight:700;">
            <?= $isCancelled ? '<s>' : '' ?>₹<?= number_format($b['total_price']) ?><?= $isCancelled ? '</s>' : '' ?>
          </td>

          <?php if ($is_admin): ?>
          <td>
            <strong><?= htmlspecialchars($b['booked_by']) ?></strong>
          </td>
          <?php endif; ?>

          <!-- Status badge -->
          <td>
            <?php if ($isCancelled): ?>
              <span class="status-badge status-cancelled">Cancelled</span>
              <span style="display:block;font-size:0.7rem;color:var(--muted);margin-top:4px;">
                <?= date('d M Y', strtotime($b['cancelled_at'] ?? $b['booked_at'])) ?>
              </span>
              <?php if ($is_admin && !empty($b['cancel_reason'])): ?>
                <span style="display:block;font-size:0.7rem;color:var(--muted);font-style:italic;max-width:100px;" title="<?= htmlspecialchars($b['cancel_reason']) ?>">
                  "<?= htmlspecialchars(mb_strimwidth($b['cancel_reason'], 0, 22, '…')) ?>"
                </span>
              <?php endif; ?>
            <?php elseif ($checkInPast && !$is_admin): ?>
              <span class="status-badge status-completed">Completed</span>
            <?php else: ?>
              <span class="status-badge status-confirmed">Confirmed</span>
            <?php endif; ?>
          </td>

          <!-- Action button -->
          <td>
            <?php if ($canCancel): ?>
              <button class="btn-cancel-booking"
                      data-ref="<?= htmlspecialchars($b['ref_no']) ?>"
                      data-pkg="<?= htmlspecialchars($b['package_name']) ?>"
                      data-date="<?= date('d M Y', strtotime($b['check_in'])) ?>"
                      onclick="openCancelModal(this)">
                ✕ Cancel
              </button>
            <?php elseif ($isCancelled): ?>
              <span style="font-size:0.78rem;color:var(--muted);">—</span>
            <?php else: ?>
              <span style="font-size:0.78rem;color:var(--muted);" title="Check-in date has passed">Past trip</span>
            <?php endif; ?>
          </td>

        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- No results after filter -->
  <div id="noFilterResults" style="display:none;text-align:center;padding:48px 24px;color:var(--muted);">
    <div style="font-size:2rem;margin-bottom:12px;">🔍</div>
    <p>No bookings match this filter.</p>
  </div>

  <!-- Admin stats -->
  <?php if ($is_admin): ?>
  <div style="display:flex;gap:28px;flex-wrap:wrap;margin-top:40px;padding:28px 36px;background:var(--card);border-radius:var(--radius);border:1px solid rgba(201,168,76,0.12);">
    <div class="stat"><div class="stat-num"><?= count($all_bookings) ?></div><div class="stat-label">Total Bookings</div></div>
    <div class="stat"><div class="stat-num" style="color:var(--success)"><?= $confirmed_count ?></div><div class="stat-label">Confirmed</div></div>
    <div class="stat"><div class="stat-num" style="color:var(--danger)"><?= $cancelled_count ?></div><div class="stat-label">Cancelled</div></div>
    <div class="stat"><div class="stat-num">₹<?= number_format($total_rev) ?></div><div class="stat-label">Active Revenue</div></div>
    <div class="stat"><div class="stat-num"><?= $total_pax ?></div><div class="stat-label">Total Travellers</div></div>
  </div>
  <?php endif; ?>

  <?php endif; ?>
</section>

<!-- ══════════════════════════════════════════════════════════
     CANCEL CONFIRMATION MODAL
══════════════════════════════════════════════════════════ -->
<div id="cancelModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.75);backdrop-filter:blur(6px);display:none;align-items:center;justify-content:center;padding:24px;">
  <div style="background:var(--card);border-radius:16px;border:1px solid rgba(248,81,73,0.25);max-width:480px;width:100%;animation:fadeUp 0.3s ease;overflow:hidden;">

    <!-- Modal header -->
    <div style="padding:28px 28px 0;display:flex;justify-content:space-between;align-items:flex-start;">
      <div style="display:flex;gap:14px;align-items:flex-start;">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(248,81,73,0.1);border:1px solid rgba(248,81,73,0.25);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">🚫</div>
        <div>
          <h3 style="font-family:'Playfair Display',serif;font-size:1.25rem;margin-bottom:4px;">Cancel Booking</h3>
          <p style="color:var(--muted);font-size:0.85rem;">This action cannot be undone.</p>
        </div>
      </div>
      <button onclick="closeCancelModal()" style="background:rgba(255,255,255,0.06);border:none;color:var(--muted);width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:background 0.2s;flex-shrink:0;" onmouseover="this.style.background='rgba(255,255,255,0.12)'" onmouseout="this.style.background='rgba(255,255,255,0.06)'">✕</button>
    </div>

    <!-- Booking preview -->
    <div style="margin:20px 28px;background:rgba(248,81,73,0.04);border:1px solid rgba(248,81,73,0.12);border-radius:10px;padding:16px;">
      <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:8px;">
        <span style="color:var(--muted);">Reference</span>
        <strong id="modalRefNo" style="color:var(--gold);font-family:'Playfair Display',serif;"></strong>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:8px;">
        <span style="color:var(--muted);">Package</span>
        <strong id="modalPkg" style="text-align:right;max-width:60%;"></strong>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:0.85rem;">
        <span style="color:var(--muted);">Check-In</span>
        <strong id="modalDate"></strong>
      </div>
    </div>

    <!-- Reason input -->
    <div style="padding:0 28px;">
      <label style="display:block;font-size:0.75rem;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);margin-bottom:8px;">Reason for cancellation</label>
      <select id="cancelReasonSelect" style="width:100%;background:rgba(0,0,0,0.3);border:1px solid rgba(255,255,255,0.08);border-radius:8px;padding:11px 14px;color:var(--text);font-family:'Raleway',sans-serif;font-size:0.9rem;outline:none;margin-bottom:12px;appearance:none;" onchange="toggleCustomReason(this.value)">
        <option value="">— Select a reason —</option>
        <option value="Change of plans">Change of plans</option>
        <option value="Found a better deal">Found a better deal</option>
        <option value="Personal emergency">Personal emergency</option>
        <option value="Health reasons">Health reasons</option>
        <option value="Travel restrictions">Travel restrictions / Visa issue</option>
        <option value="Incorrect booking">Made an incorrect booking</option>
        <option value="Other">Other (please specify)</option>
      </select>
      <textarea id="cancelReasonOther" placeholder="Please describe your reason..." style="display:none;width:100%;background:rgba(0,0,0,0.3);border:1px solid rgba(255,255,255,0.08);border-radius:8px;padding:11px 14px;color:var(--text);font-family:'Raleway',sans-serif;font-size:0.88rem;outline:none;resize:vertical;min-height:80px;box-sizing:border-box;margin-bottom:12px;" oninput="this.style.borderColor='var(--gold)'"></textarea>
      <div id="cancelReasonErr" style="display:none;color:var(--danger);font-size:0.8rem;margin-bottom:10px;">⚠ Please select or enter a cancellation reason.</div>
    </div>

    <!-- Warning note -->
    <div style="margin:0 28px 20px;background:rgba(201,168,76,0.06);border:1px solid rgba(201,168,76,0.15);border-radius:8px;padding:12px 14px;font-size:0.8rem;color:var(--muted);">
      💡 Cancellation is permanent. Please review our refund policy before proceeding.
    </div>

    <!-- API error -->
    <div id="cancelApiErr" style="display:none;margin:0 28px 16px;background:rgba(248,81,73,0.08);border:1px solid rgba(248,81,73,0.25);border-radius:8px;padding:12px 14px;color:var(--danger);font-size:0.85rem;"></div>

    <!-- Buttons -->
    <div style="display:flex;gap:12px;padding:0 28px 28px;">
      <button onclick="closeCancelModal()" class="btn-outline" style="flex:1;border-radius:8px;padding:13px;font-size:0.88rem;">
        Keep Booking
      </button>
      <button id="confirmCancelBtn" onclick="confirmCancel()" style="flex:1;background:var(--danger);color:#fff;border:none;border-radius:8px;padding:13px;font-weight:700;font-size:0.88rem;cursor:pointer;transition:all 0.3s;letter-spacing:0.5px;" onmouseover="this.style.background='#ff6b63'" onmouseout="this.style.background='var(--danger)'">
        ✕ Confirm Cancel
      </button>
    </div>

  </div>
</div>

<?php require 'footer.php'; ?>
<script src="main.js"></script>
<script>
/* ── Base URL (always correct regardless of server subfolder) ── */
const BASE_URL = '<?= rtrim(dirname($_SERVER['PHP_SELF']), '/\\') ?>/';

/* ── Cancel modal state ────────────────────────────────── */
let _cancelRef = '';

function openCancelModal(btn) {
  _cancelRef = btn.dataset.ref;
  document.getElementById('modalRefNo').textContent = btn.dataset.ref;
  document.getElementById('modalPkg').textContent   = btn.dataset.pkg;
  document.getElementById('modalDate').textContent  = btn.dataset.date;
  // Reset form
  document.getElementById('cancelReasonSelect').value = '';
  document.getElementById('cancelReasonOther').style.display = 'none';
  document.getElementById('cancelReasonOther').value  = '';
  document.getElementById('cancelReasonErr').style.display  = 'none';
  document.getElementById('cancelApiErr').style.display     = 'none';
  // Show modal
  const m = document.getElementById('cancelModal');
  m.style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeCancelModal() {
  document.getElementById('cancelModal').style.display = 'none';
  document.body.style.overflow = '';
}

function toggleCustomReason(val) {
  const other = document.getElementById('cancelReasonOther');
  other.style.display = val === 'Other' ? 'block' : 'none';
}

// Close on backdrop click
document.getElementById('cancelModal').addEventListener('click', function(e) {
  if (e.target === this) closeCancelModal();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeCancelModal(); });

/* ── Perform cancellation via fetch ──────────────────────── */
async function confirmCancel() {
  const select = document.getElementById('cancelReasonSelect');
  const other  = document.getElementById('cancelReasonOther');
  const errEl  = document.getElementById('cancelReasonErr');
  const apiErr = document.getElementById('cancelApiErr');
  errEl.style.display  = 'none';
  apiErr.style.display = 'none';

  // Validate reason
  let reason = select.value;
  if (!reason) { errEl.style.display = 'block'; return; }
  if (reason === 'Other') {
    reason = other.value.trim();
    if (!reason) { errEl.style.display = 'block'; errEl.textContent = '⚠ Please describe your reason.'; return; }
  }

  const btn = document.getElementById('confirmCancelBtn');
  btn.disabled    = true;
  btn.textContent = 'Cancelling…';

  try {
    const body = new URLSearchParams({ ref_no: _cancelRef, reason });
    const resp = await fetch(BASE_URL + 'cancel-booking.php', { method: 'POST', body });
    const text = await resp.text();           // read raw first
    let data;
    try { data = JSON.parse(text); }
    catch(e) {
      apiErr.style.display = 'block';
      apiErr.textContent   = 'Server error: ' + text.replace(/<[^>]+>/g,'').trim().slice(0,200);
      btn.disabled = false; btn.textContent = '✕ Confirm Cancel';
      return;
    }

    if (data.success) {
      closeCancelModal();
      markRowCancelled(_cancelRef);
      updateCounts();
    } else {
      apiErr.style.display = 'block';
      apiErr.textContent   = data.message || 'Cancellation failed.';
    }
  } catch(err) {
    apiErr.style.display = 'block';
    apiErr.textContent   = 'Could not reach server. Check your connection or PHP setup.';
  }

  btn.disabled    = false;
  btn.textContent = '✕ Confirm Cancel';
}

/* ── Update row UI after cancel ──────────────────────────── */
function markRowCancelled(ref) {
  const row = document.getElementById('row-' + ref);
  if (!row) return;
  row.dataset.status = 'cancelled';
  row.style.opacity  = '0.55';
  row.style.transition = 'opacity 0.5s';

  // Replace status badge
  const statusCell = row.querySelector('.status-badge');
  if (statusCell) {
    statusCell.className   = 'status-badge status-cancelled';
    statusCell.textContent = 'Cancelled';
  }

  // Replace action button with dash
  const actionCell = row.cells[row.cells.length - 1];
  actionCell.innerHTML = '<span style="font-size:0.78rem;color:var(--muted);">—</span>';

  // Strike the price
  const priceCells = row.querySelectorAll('td');
  priceCells.forEach(td => {
    if (td.style.color === 'rgb(201, 168, 76)' || td.style.fontFamily.includes('Playfair')) {
      // find the price td heuristically
    }
  });

  // Flash row briefly green then back
  row.style.background = 'rgba(248,81,73,0.06)';
  setTimeout(() => row.style.background = '', 1200);

  // Re-apply current filter
  const activeFilter = document.querySelector('.filter-btn.active');
  if (activeFilter) filterBookings(activeFilter.dataset.filter, activeFilter);
}

/* ── Filter tabs ─────────────────────────────────────────── */
function filterBookings(filter, btn) {
  // Update tab UI
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  const rows   = document.querySelectorAll('.booking-row');
  let visible  = 0;
  rows.forEach(row => {
    const status  = row.dataset.status || 'confirmed';
    const show    = filter === 'all' || status === filter;
    row.style.display = show ? '' : 'none';
    if (show) visible++;
  });

  document.getElementById('noFilterResults').style.display = visible === 0 ? 'block' : 'none';
}

/* ── Update tab counts dynamically ─────────────────────── */
function updateCounts() {
  const rows = document.querySelectorAll('.booking-row');
  let confirmed = 0, cancelled = 0;
  rows.forEach(r => {
    if ((r.dataset.status || 'confirmed') === 'confirmed') confirmed++;
    else cancelled++;
  });
  const total = confirmed + cancelled;
  const btns  = document.querySelectorAll('.filter-btn');
  if (btns[0]) btns[0].textContent = `All (${total})`;
  if (btns[1]) btns[1].textContent = `Confirmed (${confirmed})`;
  if (btns[2]) btns[2].textContent = `Cancelled (${cancelled})`;
}
</script>

</body>
</html>