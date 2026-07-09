<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destinations — Travel World</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require 'nav.php'; ?>

<div class="page-header">
  <span class="section-label">Where Will You Go?</span>
  <h1 class="section-title">Our Destinations</h1>
  <p class="section-sub" style="margin:0 auto;color:var(--muted);max-width:500px;">
    Handpicked locations across every continent — from tropical paradises to ancient civilisations.
  </p>
</div>

<section class="section">
  <div class="grid-4">

    <?php
    $destinations = [
      [
        'img'  => 'https://images.unsplash.com/photo-1593181629936-11c609b8db9b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8bWFuYWxpfGVufDB8fDB8fHww',
        'tag'  => 'Manali',
        'name' => 'Manali',
        'desc' => 'Explore Manali in style—ride bikes through the hills, cruise to Solang Valley, and chase thrills at Rohtang Pass',
        'days' => '5–7 days',
        'from' => '₹65,000',
      ],
      [
        'img'  => 'https://images.unsplash.com/photo-1595815771614-ade9d652a65d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8a2FzaG1pcnxlbnwwfHwwfHx8MA%3D%3D',
        'tag'  => 'Kashmir',
        'name' => 'Kashmir',
        'desc' => 'Experience the natural beauty of Kashmir — snow-capped mountains, pristine lakes, and vibrant culture.',
        'days' => '6–8 days',
        'from' => '₹80,000',
      ],
      [
        'img'  => 'https://plus.unsplash.com/premium_photo-1697729701846-e34563b06d47?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8R29hfGVufDB8fDB8fHww',
        'tag'  => ' Goa',
        'name' => 'Goa',
        'desc' => 'Sun, sand, and surf in equal measure. Explore historic churches, vibrant nightlife, and pristine beaches.',
        'days' => '4–5 days',
        'from' => '₹60,000',
      ],
      [
        'img'  => 'https://images.unsplash.com/photo-1603262110263-fb0112e7cc33?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8amFpcHVyfGVufDB8fDB8fHww',
        'tag'  => 'Jaipur',
        'name' => 'Jaipur',
        'desc' => 'The Pink City of Rajasthan — a blend of royal heritage, vibrant culture, and architectural marvels.',
        'days' => '4–5 days',
        'from' => '₹55,000',
      ],
      [
        'img'  => 'https://images.unsplash.com/photo-1662376107358-21296a9234f1?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJlbSUyMG1hbmRpcnxlbnwwfHwwfHx8MA%3D%3D',
        'tag'  => 'Mathura',
        'name' => 'Mathura',
        'desc' => 'Experience the spiritual heart of India — ancient temples, vibrant festivals, and the birthplace of Lord Krishna.',
        'days' => '3–4 days',
        'from' => '₹40,000',
      ],
      [
        'img'  => 'https://images.unsplash.com/photo-1581793745862-99fde7fa73d2?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bGVoJTIwbGFkYWtofGVufDB8fDB8fHww',
        'tag'  => 'Leh-Ladakh',
        'name' => 'Leh-Ladakh',
        'desc' => 'Experience the breathtaking landscapes of Ladakh — ancient monasteries, crystal-clear lakes, and the world\'s highest motorable roads.',
        'days' => '7–10 days',
        'from' => '₹90,000',
      ],
      [
        'img'  => 'https://plus.unsplash.com/premium_photo-1697729600773-5b039ef17f3b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8a2VyZWxhfGVufDB8fDB8fHww',
        'tag'  => 'Kerala',
        'name' => 'Kerala',
        'desc' => 'Experience the natural beauty of Kerala — backwaters, tea plantations, and vibrant culture.',
        'days' => '6–8 days',
        'from' => '₹80,000',
      ],
       [
        'img'  => 'https://images.unsplash.com/photo-1642498232612-a837df233825?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8YW5kYW1hbiUyMGFuZCUyMG5pY29iYXIlMjBpc2xhbmRzfGVufDB8fDB8fHww',
        'tag'  => 'Andaman and Nicobar',
        'name' => 'Andaman and Nicobar',
        'desc' => 'Experience the pristine beaches and rich marine life of the Andaman and Nicobar Islands.',
        'days' => '5–7 days',
        'from' => '₹70,000',
      ],
       [
        'img'  => 'https://images.unsplash.com/photo-1671711847762-b8308b444a42?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8ZGFyamVlbGluZ3xlbnwwfHwwfHx8MA%3D%3D',
        'tag'  => 'Darjeeling',
        'name' => 'Darjeeling',
        'desc' => 'Experience the natural beauty of Darjeeling — tea plantations, mountain views, and colonial architecture.',
        'days' => '4–5 days',
        'from' => '₹50,000',
      ],
       [
        'img'  => 'https://images.unsplash.com/photo-1712510817140-917938f92e5b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8cmlzaGlrZXNofGVufDB8fDB8fHww',
        'tag'  => 'Rishikesh',
        'name' => 'Rishikesh',
        'desc' => 'Experience the spiritual heart of India — ancient temples, vibrant festivals, and the birthplace of Lord Krishna.',
        'days' => '3–4 days',
        'from' => '₹40,000',
      ],
       [
        'img'  => 'https://images.unsplash.com/photo-1676193361626-debc2960b1c4?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGphaXNhbG1lcnxlbnwwfHwwfHx8MA%3D%3D',
        'tag'  => 'Jaisalmer',
        'name' => 'Jaisalmer',
        'desc' => 'Experience the golden sand dunes and historic forts of Jaisalmer — a desert city with a rich cultural heritage.',
        'days' => '4–5 days',
        'from' => '₹60,000',
      ],
    ];

    foreach ($destinations as $d): ?>
    <div class="dest-card fade-in">
      <div style="overflow:hidden">
        <img class="dest-img" src="<?= $d['img'] ?>" alt="<?= $d['name'] ?>">
      </div>
      <div class="dest-body">
        <span class="dest-tag"><?= $d['tag'] ?></span>
        <div class="dest-name"><?= $d['name'] ?></div>
        <p class="dest-desc"><?= $d['desc'] ?></p>
        <div class="dest-meta">
          <span>⏱ <?= $d['days'] ?></span>
          <span>💰 <?= $d['from'] ?></span>
        </div>
        <div style="margin-top:20px;">
          <a href="packages.php" class="btn-primary" style="font-size:0.8rem;padding:10px 24px;border-radius:8px;">
            View Packages →
          </a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

  </div>
</section>

<?php require 'footer.php'; ?>
<script src="main.js"></script>
</body>
</html>
