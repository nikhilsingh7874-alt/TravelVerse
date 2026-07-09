<?php
// nav.php — reusable navbar (include after auth.php)
$page = basename($_SERVER['PHP_SELF'], '.php');
?>
<nav>
  <a class="nav-brand" href="index.php">✈ Travel<span>World</span></a>

  <button class="hamburger" id="hamburger" aria-label="Toggle menu">
    <span></span><span></span><span></span>
  </button>

  <ul class="nav-links" id="navLinks">
    <li><a href="index.php"        class="<?= $page==='index'        ? 'active' : '' ?>">Home</a></li>
    <li><a href="destinations.php" class="<?= $page==='destinations'  ? 'active' : '' ?>">Destinations</a></li>
    <li><a href="packages.php"     class="<?= $page==='packages'      ? 'active' : '' ?>">Packages</a></li>
    <li><a href="my-bookings.php"  class="<?= $page==='my-bookings'   ? 'active' : '' ?>">My Bookings</a></li>
    <li><a href="contact.php"      class="<?= $page==='contact'       ? 'active' : '' ?>">Contact</a></li>
    <li><a href="logout.php" class="logout">Logout</a></li>
  </ul>
</nav>

<script>
  document.getElementById('hamburger').addEventListener('click', () => {
    document.getElementById('navLinks').classList.toggle('open');
  });
</script>
