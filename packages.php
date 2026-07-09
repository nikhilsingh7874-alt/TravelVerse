<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Packages — Travel World</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require 'nav.php'; ?>

<div class="page-header">
  <span class="section-label">Travel Made Easy</span>
  <h1 class="section-title">Our Travel Packages</h1>
  <p class="section-sub" style="margin:0 auto;color:var(--muted);max-width:520px;">
    All-inclusive packages with flights, hotels, transfers and guided tours — everything sorted for you.
  </p>
</div>

<section class="section">

  <?php
  $packages = [
    [
      'key'      => 'manali',
      'img'      => 'https://images.unsplash.com/photo-1593181629936-11c609b8db9b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8bWFuYWxpfGVufDB8fDB8fHww',
      'name'     => 'Manali',
      'desc'     => 'Experience the beauty of the Himalayas — snow-capped peaks, lush valleys, and thrilling adventures.',
      'price'    => '₹80,000',
      'nights'   => '5 Nights',
      'days'     => '8 Days',
      'features' => ['Snowy peaks & valleys',
                    'Adventure sports',
                    'Cool weather',
                    'Scenic beauty'],
      'featured' => false,
    ],
    [
      'key'      => 'Kashmir',
      'img'      => 'https://images.unsplash.com/photo-1595815771614-ade9d652a65d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8a2FzaG1pcnxlbnwwfHwwfHx8MA%3D%3D',
      'name'     => 'Kashmir',
      'desc'     => 'Discover the natural beauty of Kashmir — snow-capped mountains, serene lakes, and vibrant culture.',
      'price'    => '₹90,000',
      'nights'   => '7 Nights',
      'days'     => '15 Days',
      'features' => ['Snow-capped mountains',
                    'Serene lakes',
                    'Green valleys',
                    'Rich heritage'],
      'featured' => true,
    ],
    [
      'key'      => 'Goa',
      'img'      => 'https://plus.unsplash.com/premium_photo-1697729701846-e34563b06d47?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8R29hfGVufDB8fDB8fHww',
      'name'     => 'Goa',
      'desc'     => 'Experience the vibrant beaches and rich culture of Goa — from bustling markets to serene temples.',
      'price'    => '₹60,000',
      'nights'   => '5 Nights',
      'days'     => '9 Days',
      'features' => ['Sandy beaches',
                      'Nightlife vibes',
                      'Water sports',
                      'Coastal culture'],
      'featured' => false,
    ],
    [
      'key'      => 'Jaipur',
      'img'      => 'https://images.unsplash.com/photo-1603262110263-fb0112e7cc33?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8amFpcHVyfGVufDB8fDB8fHww',
      'name'     => 'Jaipur',
      'desc'     => 'Explore the pink city of Jaipur — majestic palaces, vibrant markets, and rich cultural heritage.',
      'price'    => '₹50,000',
      'nights'   => '4 Nights',
      'days'     => '11 Days',
      'features' => ['Royal palaces',
                    'Historic forts',
                    'Vibrant bazaars',
                    'Cultural heritage'],
      'featured' => false,
    ],
    [
      'key'      => 'Mathura',
      'img'      => 'https://images.unsplash.com/photo-1662376107358-21296a9234f1?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJlbSUyMG1hbmRpcnxlbnwwfHwwfHx8MA%3D%3D',
      'name'     => 'Mathura',
      'desc'     => 'Experience the spiritual heart of India — ancient temples, vibrant festivals, and the birthplace of Lord Krishna.',
      'price'    => '₹40,000',
      'nights'   => '3 Nights',
      'days'     => '5 Days',
      'features' =>  ['Spiritual temples & heritage',
                    'Birthplace of Lord Krishna',
                    'Festive culture & ghats',
                    'Peaceful religious vibe'],
      'featured' => false,
    ],
    [
      'key'      => 'Leh-Ladakh',
      'img'      => 'https://images.unsplash.com/photo-1581793745862-99fde7fa73d2?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bGVoJTIwbGFkYWtofGVufDB8fDB8fHww',
      'name'     => 'Leh-Ladakh',
      'desc'     => 'Experience the breathtaking landscapes of Ladakh — ancient monasteries, crystal-clear lakes, and the world\'s highest motorable roads.',
      'price'    => '₹90,000',
      'nights'   => '7 Nights',
      'days'     => '10 Days',
      'features' =>  ['Snowy mountains & highways',
                    'Scenic lakes & valleys',
                    'Monasteries & culture',
                    'Adventure bike rides'],
      'featured' => false,
    ],
    [
      'key'      => 'Kerala',
      'img'      => 'https://plus.unsplash.com/premium_photo-1697729600773-5b039ef17f3b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8a2VyZWxhfGVufDB8fDB8fHww',
      'name'     => 'Kerala',
      'desc'     => 'Discover the serene backwaters of Kerala — houseboat stays, Ayurvedic treatments, and traditional Kathakali performances.',
      'price'    => '₹80,000',
      'nights'   => '6 Nights',
      'days'     => '10 Days',
      'features' => ['Backwaters & houseboats',
                    'Green landscapes',
                    'Ayurveda & relaxation',
                    'Beaches & culture'],
      'featured' => false,
    ],
    [
      'key'      => 'Andaman and Nicobar',
      'img'      => 'https://images.unsplash.com/photo-1642498232612-a837df233825?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8YW5kYW1hbiUyMGFuZCUyMG5pY29iYXIlMjBpc2xhbmRzfGVufDB8fDB8fHww',
      'name'     => 'Andaman and Nicobar',
      'desc'     => 'Unwind on pristine beaches and explore the rich marine life of the Andaman Islands.',
      'price'    => '₹70,000',
      'nights'   => '5 Nights',
      'days'     => '10 Days',
      'features' => ['Crystal-clear beaches',
                    'Island hopping',
                    'Water sports & diving',
                    'Peaceful tropical vibe'],
      'featured' => false,
    ],
    [
      'key'      => 'Darjeeling',
      'img'      => 'https://images.unsplash.com/photo-1671711847762-b8308b444a42?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8ZGFyamVlbGluZ3xlbnwwfHwwfHx8MA%3D%3D',
      'name'     => 'Darjeeling',
      'desc'     => 'Experience the charm of Darjeeling — tea plantations, mountain views, and colonial architecture.',
      'price'    => '₹50,000',
      'nights'   => '4 Nights',
      'days'     => '10 Days',
      'features' => ['Tea gardens & hills',
                    'Cool climate views',
                    'Toy train experience',
                    'Sunrise at Tiger Hill'],
      'featured' => false,
    ],
    [
      'key'      => 'Rishikesh',
      'img'      => 'https://images.unsplash.com/photo-1712510817140-917938f92e5b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8cmlzaGlrZXNofGVufDB8fDB8fHww',
      'name'     => 'Rishikesh',
      'desc'     => 'Immerse yourself in the spiritual ambiance of Rishikesh — yoga classes, meditation sessions, and Ganges river rafting.',
      'price'    => '₹60,000',
      'nights'   => '5 Nights',
      'days'     => '10 Days',
      'features' => ['Yoga & meditation',
                    'Ganga river rafting',
                    'Spiritual atmosphere',
                    'Adventure activities'],
      'featured' => false,
    ],
    [
      'key'      => 'Jaisalmere',
      'img'      => 'https://images.unsplash.com/photo-1676193361626-debc2960b1c4?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGphaXNhbG1lcnxlbnwwfHwwfHx8MA%3D%3D',
      'name'     => 'Jaisalmere',
      'desc'     => 'Experience the magic of the Thar Desert — camel safaris, traditional folk performances, and stargazing under the clear night sky.',
      'price'    => '₹70,000',
      'nights'   => '5 Nights',
      'days'     => '10 Days',
      'features' => ['Desert safari & camels',
                    'Golden sand dunes',
                    'Historic forts',
                    'Cultural folk nights'],
      'featured' => false,
    ],
  ];
  ?>

  <div class="grid-3">
    <?php foreach ($packages as $p): ?>
    <div class="pkg-card fade-in <?= $p['featured'] ? 'featured' : '' ?>">
      <?php if ($p['featured']): ?>
        <span class="pkg-badge">Most Popular</span>
      <?php endif; ?>
      <img class="pkg-img" src="<?= $p['img'] ?>" alt="<?= $p['name'] ?>">
      <div class="pkg-body">
        <div class="pkg-name"><?= $p['name'] ?></div>
        <p class="pkg-desc"><?= $p['desc'] ?></p>
        <div class="pkg-details">
          <div class="pkg-price"><?= $p['price'] ?><sub>/person</sub></div>
          <div class="pkg-dur"><strong><?= $p['nights'] ?></strong><?= $p['days'] ?></div>
        </div>
        <ul class="pkg-features">
          <?php foreach ($p['features'] as $f): ?>
            <li><?= $f ?></li>
          <?php endforeach; ?>
        </ul>
        <a href="booking.php?pkg=<?= urlencode($p['key']) ?>" class="btn-book" style="text-align:center;text-decoration:none;display:block;">
          Book Now →
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

</section>

<!-- Call to action -->
<div style="background:var(--card);border-top:1px solid rgba(201,168,76,0.15);padding:72px 48px;text-align:center;">
  <span class="section-label">Need Something Custom?</span>
  <h2 class="section-title" style="margin-bottom:16px;">Build Your Dream Trip</h2>
  <p style="color:var(--muted);max-width:440px;margin:0 auto 32px;font-size:0.95rem;">
    Can't find exactly what you're looking for? Our travel experts will craft a bespoke itinerary just for you.
  </p>
  <a href="contact.php" class="btn-primary">Talk to an Expert</a>
</div>

<?php require 'footer.php'; ?>
<script src="main.js"></script>
</body>
</html>
