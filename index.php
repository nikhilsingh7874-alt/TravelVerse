<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel World — Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require 'nav.php'; ?>

<!-- ── HERO ────────────────────────────────────────────── -->
<section class="hero">
  <div class="hero-slider">
    <div class="slide slide-1 active"></div>
    <div class="slide slide-2"></div>
    <div class="slide slide-3"></div>
  </div>
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <div class="hero-badge">Welcome, <?= htmlspecialchars(ucfirst($currentUser)) ?></div>
    <h1>Discover the<br><em>World's Beauty</em></h1>
    <p>Create Your journeys to the planet's most extraordinary places. Every trip, a story worth telling.</p>
    <div class="hero-cta">
      <a href="destinations.php" class="btn-primary">Explore Destinations</a>
      <a href="packages.php"     class="btn-outline">View Packages</a>
    </div>
  </div>

  <div class="slider-dots">
    <button class="dot active" data-slide="0"></button>
    <button class="dot"        data-slide="1"></button>
    <button class="dot"        data-slide="2"></button>
  </div>
</section>

<!-- ── STATS ─────────────────────────────────────────────────── -->
<div class="stats-bar">
  <div class="stat">
    <div class="stat-num">120+</div>
    <div class="stat-label">Destinations</div>
  </div>
  <div class="stat">
    <div class="stat-num">48K</div>
    <div class="stat-label">Happy Travellers</div>
  </div>
  <div class="stat">
    <div class="stat-num">15</div>
    <div class="stat-label">Years of Experience</div>
  </div>
  <div class="stat">
    <div class="stat-num">4.9★</div>
    <div class="stat-label">Average Rating</div>
  </div>
</div>

<!-- ── FEATURED DESTINATIONS ─────────────────────────────────── -->
<section class="section">
  <div class="section-header">
    <span class="section-label">Handpicked for You</span>
    <h2 class="section-title">Popular Destinations</h2>
    <p class="section-sub">From ancient wonders to pristine beaches — explore the world's most breathtaking destinations.</p>
  </div>
  <div class="grid-4">

    <div class="dest-card fade-in">
      <img class="dest-img" src="https://images.unsplash.com/photo-1593181629936-11c609b8db9b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8bWFuYWxpfGVufDB8fDB8fHww" alt="Manali">
      <div class="dest-body">
        <span class="dest-tag">Manali</span>
        <div class="dest-name">Manali</div>
        <p class="dest-desc">Experience the beauty of the Himalayas — snow-capped peaks, lush valleys, and thrilling adventures.</p>
        <div class="dest-meta"><span>⏱ 5–7 days</span><span>💰 From ₹80,000</span></div>
      </div>
    </div>

    <div class="dest-card fade-in">
      <img class="dest-img" src="https://images.unsplash.com/photo-1595815771614-ade9d652a65d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8a2FzaG1pcnxlbnwwfHwwfHx8MA%3D%3D" alt="Kashmir">
      <div class="dest-body">
        <span class="dest-tag">Kashmir</span>
        <div class="dest-name">Kashmir</div>
        <p class="dest-desc">Discover the natural beauty of Kashmir — snow-capped mountains, serene lakes, and vibrant culture.</p>
        <div class="dest-meta"><span>⏱ 6–8 days</span><span>💰 From ₹90,000</span></div>
      </div>
    </div>

    <div class="dest-card fade-in">
      <img class="dest-img" src="https://plus.unsplash.com/premium_photo-1697729701846-e34563b06d47?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8R29hfGVufDB8fDB8fHww" alt="Goa">
      <div class="dest-body">
        <span class="dest-tag">Goa</span>
        <div class="dest-name">Goa</div>
        <p class="dest-desc">Experience the vibrant beaches and rich culture of Goa — from bustling markets to serene temples.</p>
        <div class="dest-meta"><span>⏱ 5–6 days</span><span>💰 From ₹60,000</span></div>
      </div>
    </div>

    <div class="dest-card fade-in">
      <img class="dest-img" src="https://images.unsplash.com/photo-1603262110263-fb0112e7cc33?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8amFpcHVyfGVufDB8fDB8fHww" alt="Jaipur">
      <div class="dest-body">
        <span class="dest-tag">Jaipur</span>
        <div class="dest-name">Jaipur</div>
        <p class="dest-desc">Explore the pink city of Jaipur — majestic palaces, vibrant markets, and rich cultural heritage.</p>
        <div class="dest-meta"><span>⏱ 4–5 days</span><span>💰 From ₹50,000</span></div>
      </div>
    </div>

  </div>
  <div style="text-align:center;margin-top:48px;">
    <a href="destinations.php" class="btn-outline">View All Destinations</a>
  </div>
</section>

<!-- ── FEATURED PACKAGES ──────────────────────────────────────── -->
<section class="section" style="background:var(--dark);border-top:1px solid rgba(255,255,255,0.04);">
  <div class="section-header">
    <span class="section-label">Best Value</span>
    <h2 class="section-title">Top Packages</h2>
    <p class="section-sub">All-inclusive travel packages designed to make every journey seamless and unforgettable.</p>
  </div>
  <div class="grid-3">

    <div class="pkg-card fade-in">
      <img class="pkg-img" src="https://images.unsplash.com/photo-1593181629936-11c609b8db9b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8bWFuYWxpfGVufDB8fDB8fHww" alt="Manali">
      <div class="pkg-body">
        <div class="pkg-name">Manali</div>
        <p class="pkg-desc">Experience the beauty of the Himalayas — snow-capped peaks, lush valleys, and thrilling adventures.</p>
        <div class="pkg-details">
          <div class="pkg-price">₹80,000<sub>/person</sub></div>
          <div class="pkg-dur"><strong>7 Nights</strong>8 Days</div>
        </div>
        <button class="btn-book" onclick="location.href='booking.php?pkg=manali'">Book Now →</button>
      </div>
    </div>

    <div class="pkg-card featured fade-in">
      <span class="pkg-badge">Most Popular</span>
      <img class="pkg-img" src="https://images.unsplash.com/photo-1595815771614-ade9d652a65d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8a2FzaG1pcnxlbnwwfHwwfHx8MA%3D%3D" alt="Kashmir">
      <div class="pkg-body">
        <div class="pkg-name">Kashmir</div>
        <p class="pkg-desc">Discover the natural beauty of Kashmir — snow-capped mountains, serene lakes, and vibrant culture.</p>
        <div class="pkg-details">
          <div class="pkg-price">₹90,000<sub>/person</sub></div>
          <div class="pkg-dur"><strong>7 Nights</strong>15 Days</div>
        </div>
        <button class="btn-book" onclick="location.href='booking.php?pkg=kashmir'">Book Now →</button>
      </div>
    </div>

    <div class="pkg-card fade-in">
      <img class="pkg-img" src="https://plus.unsplash.com/premium_photo-1697729701846-e34563b06d47?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8R29hfGVufDB8fDB8fHww" alt="Goa">
      <div class="pkg-body">
        <div class="pkg-name">Goa</div>
        <p class="pkg-desc">Experience the vibrant beaches and rich culture of Goa — from bustling markets to serene temples.</p>
        <div class="pkg-details">
          <div class="pkg-price">₹60,000<sub>/person</sub></div>
          <div class="pkg-dur"><strong>5 Nights</strong>9 Days</div>
        </div>
        <button class="btn-book" onclick="location.href='booking.php?pkg=goa'">Book Now →</button>
      </div>
    </div>

  </div>
  <div style="text-align:center;margin-top:48px;">
    <a href="packages.php" class="btn-primary">See All Packages</a>
  </div>
</section>

<!-- ── REVIEWS ──────────────────────────────────────────────────── -->
<?php
// Load seeded + user-submitted reviews
$seedReviews = [
  ['reviewer_name'=>'Arjun & Priya Mehta','destination'=>'Goa',    'rating'=>5,'title'=>'Surreal Anniversary Trip',   'body'=>'Our anniversary in Goa felt like a dream brought to life. From serene beaches to breathtaking sunsets, every moment was magical. The stay was luxurious, and the entire experience was handled so smoothly that we could simply relax and enjoy each other’s company. Truly unforgettable!. Travel World handled every single detail — we didn\'t have to think about anything except enjoying ourselves.','submitted'=>'2025-03-14 10:00:00','verified'=>true,'username'=>'verified'],
  ['reviewer_name'=>'Sneha Kapoor',        'destination'=>'Risikesh', 'rating'=>5,'title'=>'Dream Come True',             'body'=>'“Rishikesh gave us the perfect blend of peace and adventure. From the calming Ganga aarti to thrilling river rafting, every experience was unforgettable. The scenic beauty and spiritual vibe made it a journey we’ll cherish forever. Already planning my next trip with them!','submitted'=>'2025-01-22 09:15:00','verified'=>true,'username'=>'verified'],
  ['reviewer_name'=>'Rahul Sharma',        'destination'=>'Manali', 'rating'=>5,'title'=>'Worth Every Rupee',           'body'=>'Manali was absolutely mesmerizing! Snow-covered mountains, fresh air, and stunning views made every second worth it. The trip was perfectly organized, and every detail was taken care of. It truly felt like a refreshing escape from everyday life.','submitted'=>'2024-12-10 14:30:00','verified'=>true,'username'=>'verified'],
  ['reviewer_name'=>'Nandita Rao',         'destination'=>'Kashmir',       'rating'=>5,'title'=>'A Masterpiece of Planning',   'body'=>'Kashmir is truly heaven on earth. The valleys, snow-capped peaks, and peaceful lakes left us speechless. Every day felt like a postcard moment. The entire journey was smooth, and we created memories that will last a lifetime.','submitted'=>'2025-04-05 11:00:00','verified'=>true,'username'=>'verified'],
  ['reviewer_name'=>'Vikram Patel',        'destination'=>'Varanshi',       'rating'=>5,'title'=>'Incredible Value',            'body'=>'Varanasi touched our soul in the most beautiful way. The spiritual energy of the ghats, the mesmerizing Ganga aarti, and the rich culture made this trip deeply meaningful. It was not just travel—it was an experience of a lifetime.Will 100% book again.','submitted'=>'2025-02-18 16:45:00','verified'=>true,'username'=>'verified'],
  ['reviewer_name'=>'Kavya & Dev Anand',   'destination'=>'Mathura',      'rating'=>5,'title'=>'Most Romantic Trip Ever',     'body'=>'Mathura was filled with devotion and positivity. Visiting Krishna Janmabhoomi and experiencing the vibrant temple atmosphere was truly heartwarming. The peaceful vibes and spiritual connection made this journey very special.','submitted'=>'2025-05-01 08:20:00','verified'=>true,'username'=>'verified'],
];
$userReviews = [];
$reviewsFile = __DIR__ . '/data/reviews.json';
if (file_exists($reviewsFile)) {
    $userReviews = json_decode(file_get_contents($reviewsFile), true) ?? [];
}
// Merge: user reviews first (newest), then seeds
$allReviews = array_merge(array_reverse($userReviews), $seedReviews);
// Compute live rating
$totalRating = array_sum(array_column($allReviews,'rating'));
$avgRating   = count($allReviews) ? round($totalRating / count($allReviews), 1) : 4.9;
$totalCount  = count($allReviews);
?>
<section class="reviews-section">
  <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:24px;margin-bottom:52px;">
    <div>
      <span class="section-label">What Travellers Say</span>
      <h2 class="section-title" style="margin-bottom:8px;">Real Stories, Real Adventures</h2>
      <p style="color:var(--muted);font-size:0.95rem;max-width:480px;">
        Don't take our word for it — hear from explorers who've trusted us with their journeys.
      </p>
    </div>
    <button class="btn-primary" onclick="openReviewModal()" style="border-radius:8px;padding:13px 28px;white-space:nowrap;">
      ✍ Write a Review
    </button>
  </div>

  <div class="reviews-grid" id="reviewsGrid">
    <?php foreach (array_slice($allReviews, 0, 6) as $i => $r):
      $stars = str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']);
      $initials = strtoupper(substr($r['reviewer_name'], 0, 1));
      $isNew = isset($r['id']); // user-submitted reviews have an id
    ?>
    <div class="review-card <?= $i===0 && $isNew ? 'featured-review' : ($i===0 && !$isNew ? 'featured-review' : '') ?> fade-in">
      <?php if ($isNew): ?><span class="review-destination-badge" style="background:rgba(63,185,80,0.12);color:var(--success);border-color:rgba(63,185,80,0.25);">✓ New</span>
      <?php else: ?><span class="review-destination-badge"><?= htmlspecialchars($r['destination']) ?></span><?php endif; ?>
      <div class="review-stars" style="margin-bottom:10px;">
        <?php for($s=1;$s<=5;$s++): ?>
          <span class="<?= $s<=$r['rating']?'star':'star empty' ?>"><?= $s<=$r['rating']?'★':'☆' ?></span>
        <?php endfor; ?>
      </div>
      <?php if (!empty($r['title'])): ?>
        <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:600;margin-bottom:8px;"><?= htmlspecialchars($r['title']) ?></div>
      <?php endif; ?>
      <p class="review-text">"<?= htmlspecialchars($r['body']) ?>"</p>
      <div class="review-author">
        <div class="review-avatar-placeholder"><?= $initials ?></div>
        <div>
          <div class="review-name"><?= htmlspecialchars($r['reviewer_name']) ?></div>
          <div class="review-meta">
            <?= htmlspecialchars($r['destination']) ?> ·
            <?= $r['verified'] ? '✓ Verified · ' : '' ?>
            <?= date('M Y', strtotime($r['submitted'])) ?>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Rating summary -->
  <?php
  $dist = [5=>0,4=>0,3=>0,2=>0,1=>0];
  foreach ($allReviews as $r) $dist[(int)$r['rating']] = ($dist[(int)$r['rating']]??0)+1;
  $colors = [5=>'var(--success)',4=>'var(--gold)',3=>'#58a6ff',2=>'var(--muted)',1=>'var(--danger)'];
  ?>
  <div style="margin-top:60px;background:var(--card);border-radius:var(--radius);border:1px solid rgba(201,168,76,0.15);padding:36px 40px;display:flex;gap:48px;flex-wrap:wrap;align-items:center;justify-content:center;">
    <div style="text-align:center;">
      <div style="font-family:'Playfair Display',serif;font-size:3.5rem;font-weight:700;color:var(--gold);line-height:1;"><?= $avgRating ?></div>
      <div style="color:var(--gold);font-size:1.2rem;margin:4px 0;">★★★★★</div>
      <div style="color:var(--muted);font-size:0.82rem;letter-spacing:1px;text-transform:uppercase;">Average Rating</div>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px;min-width:220px;">
      <?php foreach ([5,4,3,2,1] as $s):
        $pct = $totalCount ? round($dist[$s]/$totalCount*100) : 0; ?>
      <div style="display:flex;align-items:center;gap:12px;font-size:0.82rem;">
        <span style="color:var(--muted);width:48px;"><?= $s ?> star<?= $s>1?'s':'' ?></span>
        <div style="flex:1;height:6px;background:rgba(255,255,255,0.06);border-radius:100px;overflow:hidden;">
          <div style="width:<?= $pct ?>%;height:100%;background:<?= $colors[$s] ?>;border-radius:100px;transition:width 1s;"></div>
        </div>
        <span style="color:var(--muted);width:28px;text-align:right;"><?= $dist[$s] ?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;">
      <div style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--text);"><?= $totalCount ?>+</div>
      <div style="color:var(--muted);font-size:0.82rem;letter-spacing:1px;text-transform:uppercase;margin-top:4px;">Total Reviews</div>
      <button onclick="openReviewModal()" class="btn-outline"
              style="margin-top:16px;border-radius:8px;padding:9px 22px;font-size:0.8rem;">
        + Add Yours
      </button>
    </div>
  </div>
</section>

<!-- ── REVIEW MODAL ─────────────────────────────────────────────── -->
<div id="reviewModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.75);backdrop-filter:blur(6px);overflow-y:auto;padding:48px 16px;" onclick="if(event.target===this)closeReviewModal()">
  <div style="max-width:560px;margin:0 auto;background:var(--card);border-radius:16px;border:1px solid rgba(201,168,76,0.2);overflow:hidden;animation:fadeUp 0.35s ease;">
    <!-- Modal header -->
    <div style="padding:28px 32px 0;display:flex;justify-content:space-between;align-items:flex-start;">
      <div>
        <h3 style="font-family:'Playfair Display',serif;font-size:1.4rem;margin-bottom:4px;">Share Your Experience</h3>
        <p style="color:var(--muted);font-size:0.88rem;">Help fellow travellers discover the best journeys.</p>
      </div>
      <button onclick="closeReviewModal()" style="background:rgba(255,255,255,0.06);border:none;color:var(--muted);width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:1.1rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.12)'" onmouseout="this.style.background='rgba(255,255,255,0.06)'">✕</button>
    </div>

    <!-- Success state -->
    <div id="modalSuccess" style="display:none;padding:40px 32px;text-align:center;">
      <div style="font-size:3rem;margin-bottom:12px;">🎉</div>
      <h3 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--success);margin-bottom:8px;">Review Published!</h3>
      <p style="color:var(--muted);font-size:0.9rem;margin-bottom:24px;">Your review is now live on the homepage. Thank you!</p>
      <button onclick="closeReviewModal()" class="btn-primary" style="border-radius:8px;padding:11px 32px;">Close</button>
    </div>

    <!-- Form -->
    <form id="reviewForm" style="padding:24px 32px 32px;" novalidate>
      <div id="modalErr" style="display:none;background:rgba(248,81,73,0.08);border:1px solid rgba(248,81,73,0.25);border-radius:8px;padding:12px 16px;color:var(--danger);font-size:0.85rem;margin-bottom:20px;"></div>

      <!-- Star rating picker -->
      <div class="form-group">
        <label>Your Rating *</label>
        <div class="star-picker" id="starPicker">
          <?php for($i=1;$i<=5;$i++): ?>
            <span class="star-pick" data-val="<?=$i?>" onclick="setRating(<?=$i?>)" title="<?=$i?> star<?=$i>1?'s':''?>">☆</span>
          <?php endfor; ?>
        </div>
        <input type="hidden" id="modal_rating" value="0">
        <div class="form-error" id="err_mrating">Please select a rating.</div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="modal_name">Your Name *</label>
          <input type="text" id="modal_name" placeholder="e.g. Ravi Sharma" value="<?= htmlspecialchars($_SESSION['full_name'] ?? ucfirst($currentUser)) ?>">
          <div class="form-error" id="err_mname">Name is required.</div>
        </div>
        <div class="form-group">
          <label for="modal_dest">Destination *</label>
          <select id="modal_dest">
            <option value="">Select destination</option>
            <?php foreach(['Kashmir','Manali','Rishikesh','Mathura','Varanshi','Leh Ladakh','Goa','Jaishmere','Darjeeling'] as $d): ?>
              <option value="<?=$d?>"><?=$d?></option>
            <?php endforeach; ?>
          </select>
          <div class="form-error" id="err_mdest">Please select a destination.</div>
        </div>
      </div>

      <div class="form-group">
        <label for="modal_title">Review Title</label>
        <input type="text" id="modal_title" placeholder="Give your review a headline...">
      </div>

      <div class="form-group">
        <label for="modal_body">Your Review *</label>
        <textarea id="modal_body" style="min-height:110px;" placeholder="Tell us about your experience — what did you love? What made it special? (min 20 chars)"></textarea>
        <div style="font-size:0.75rem;color:var(--muted);margin-top:4px;" id="charCount">0 / 20 minimum</div>
        <div class="form-error" id="err_mbody">Please write at least 20 characters.</div>
      </div>

      <button type="submit" id="reviewSubmitBtn" class="btn-primary" style="width:100%;border-radius:8px;padding:14px;">
        Publish Review →
      </button>
    </form>
  </div>
</div>

<!-- ── FOOTER ─────────────────────────────────────────────────── -->
<?php require 'footer.php'; ?>

<script src="main.js"></script>
<script>
/* ── Base URL (PHP-generated, always correct regardless of folder depth) ── */
const BASE_URL = '<?= rtrim(dirname($_SERVER['PHP_SELF']), '/\\') ?>/';

/* ── Review modal ──────────────────────────────────────────────── */
function openReviewModal() {
  document.getElementById('reviewModal').style.display = 'block';
  document.body.style.overflow = 'hidden';
}
function closeReviewModal() {
  document.getElementById('reviewModal').style.display = 'none';
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeReviewModal(); });

/* Star picker */
let selectedRating = 0;
function setRating(val) {
  selectedRating = val;
  document.getElementById('modal_rating').value = val;
  document.querySelectorAll('.star-pick').forEach((el, i) => {
    el.textContent = i < val ? '★' : '☆';
    el.style.color = i < val ? 'var(--gold)' : 'var(--muted)';
  });
}
// hover effect
document.querySelectorAll('.star-pick').forEach((el, i, arr) => {
  el.addEventListener('mouseenter', () => {
    arr.forEach((s, j) => {
      s.textContent = j <= i ? '★' : '☆';
      s.style.color = j <= i ? 'var(--gold-light)' : 'var(--muted)';
    });
  });
  el.addEventListener('mouseleave', () => setRating(selectedRating));
});

/* Char counter */
document.getElementById('modal_body')?.addEventListener('input', function() {
  const len = this.value.trim().length;
  const el = document.getElementById('charCount');
  el.textContent = len + ' / 20 minimum';
  el.style.color = len >= 20 ? 'var(--success)' : 'var(--muted)';
});

/* Form submit */
document.getElementById('reviewForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  document.querySelectorAll('#reviewForm .form-error').forEach(el => el.style.display='none');
  document.getElementById('modalErr').style.display = 'none';

  const name  = document.getElementById('modal_name').value.trim();
  const dest  = document.getElementById('modal_dest').value;
  const rating= parseInt(document.getElementById('modal_rating').value);
  const title = document.getElementById('modal_title').value.trim();
  const body  = document.getElementById('modal_body').value.trim();

  let valid = true;
  const showE = id => { document.getElementById(id).style.display='block'; valid=false; };
  if (rating < 1)       showE('err_mrating');
  if (!name)            showE('err_mname');
  if (!dest)            showE('err_mdest');
  if (body.length < 20) showE('err_mbody');
  if (!valid) return;

  const btn = document.getElementById('reviewSubmitBtn');
  btn.disabled = true; btn.textContent = 'Publishing…';

  try {
    const fd = new FormData();
    fd.append('reviewer_name', name);
    fd.append('destination',   dest);
    fd.append('rating',        rating);
    fd.append('title',         title);
    fd.append('body',          body);

    const resp = await fetch(BASE_URL + 'submitreview.php', { method:'POST', body: fd });
    const text = await resp.text();           // read raw first
    let data;
    try { data = JSON.parse(text); }
    catch(e) {
      // PHP returned HTML (error page / redirect) — show snippet
      const el = document.getElementById('modalErr');
      el.style.display = 'block';
      el.textContent = 'Server error: ' + text.replace(/<[^>]+>/g,'').trim().slice(0,200);
      btn.disabled = false; btn.textContent = 'Publish Review →';
      return;
    }

    if (data.success) {
      document.getElementById('reviewForm').style.display  = 'none';
      document.getElementById('modalSuccess').style.display = 'block';
      prependReviewCard(data.review);
    } else {
      const el = document.getElementById('modalErr');
      el.style.display = 'block';
      el.textContent = data.message || 'Something went wrong.';
    }
  } catch(err) {
    const el = document.getElementById('modalErr');
    el.style.display = 'block';
    el.textContent = 'Could not reach server. Check your connection or PHP setup.';
  }
  btn.disabled = false; btn.textContent = 'Publish Review →';
});

/* Prepend new review card to grid without page reload */
function prependReviewCard(r) {
  const grid = document.getElementById('reviewsGrid');
  const stars = '★'.repeat(r.rating) + '☆'.repeat(5 - r.rating);
  const initials = r.reviewer_name.charAt(0).toUpperCase();
  const date = new Date(r.submitted).toLocaleDateString('en-IN',{month:'short',year:'numeric'});
  const card = document.createElement('div');
  card.className = 'review-card featured-review fade-in visible';
  card.innerHTML = `
    <span class="review-destination-badge" style="background:rgba(63,185,80,0.12);color:var(--success);border-color:rgba(63,185,80,0.25);">✓ New</span>
    <div class="review-stars" style="margin-bottom:10px;">${[...stars].map((s,i)=>`<span class="${i<r.rating?'star':'star empty'}">${s}</span>`).join('')}</div>
    ${r.title ? `<div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:600;margin-bottom:8px;">${esc(r.title)}</div>` : ''}
    <p class="review-text">"${esc(r.body)}"</p>
    <div class="review-author">
      <div class="review-avatar-placeholder">${initials}</div>
      <div>
        <div class="review-name">${esc(r.reviewer_name)}</div>
        <div class="review-meta">${esc(r.destination)} · ✓ Verified · ${date}</div>
      </div>
    </div>`;
  grid.insertBefore(card, grid.firstChild);
}
function esc(s) {
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
</body>
</html>