<footer>

  <!-- Main footer grid -->
  <div class="footer-top">

    <!-- Brand column -->
    <div class="footer-brand-block">
      <div class="footer-brand-logo">
        <span>&#9992;</span> TravelWorld
      </div>
      <p class="footer-tagline">
        Crafting unforgettable journeys since 2025. We believe travel is the greatest education, the finest therapy, and the most beautiful form of freedom.
      </p>
      <div class="footer-social">
        <a class="social-btn" href="#" title="Instagram" onclick="return false">&#128247;</a>
        <a class="social-btn" href="#" title="Facebook"  onclick="return false">&#128100;</a>
        <a class="social-btn" href="#" title="YouTube"   onclick="return false">&#127916;</a>
        <a class="social-btn" href="#" title="Twitter"   onclick="return false">&#128038;</a>
        <a class="social-btn" href="#" title="WhatsApp"  onclick="return false">&#128172;</a>
      </div>

      <!-- Newsletter -->
      <div class="footer-newsletter">
        <p>&#128140; Get travel deals straight to your inbox</p>
        <div class="newsletter-form">
          <input class="newsletter-input" type="email" id="footerEmail" placeholder="your@email.com">
          <button class="newsletter-btn" onclick="subscribeNewsletter()">Subscribe</button>
        </div>
        <div id="nlMsg" style="font-size:0.78rem;margin-top:8px;display:none;"></div>
      </div>
    </div>

    <!-- Explore links -->
    <div>
      <div class="footer-col-title">Explore</div>
      <ul class="footer-nav">
        <li><a href="index.php"><span class="arr">&#8250;</span> Home</a></li>
        <li><a href="destinations.php"><span class="arr">&#8250;</span> Destinations</a></li>
        <li><a href="packages.php"><span class="arr">&#8250;</span> Packages</a></li>
        <li><a href="my-bookings.php"><span class="arr">&#8250;</span> My Bookings</a></li>
        <li><a href="contact.php"><span class="arr">&#8250;</span> Contact Us</a></li>
        <li><a href="logout.php" style="color:var(--danger);"><span class="arr">&#8250;</span> Sign Out</a></li>
      </ul>
    </div>

    <!-- Popular destinations -->
    <div>
      <div class="footer-col-title">Popular Spots</div>
      <ul class="footer-nav">
        <li><a href="destinations.php"><span class="arr">&#8250;</span> Kashmir</a></li>
        <li><a href="destinations.php"><span class="arr">&#8250;</span> Kerla</a></li>
        <li><a href="destinations.php"><span class="arr">&#8250;</span> Manali</a></li>
        <li><a href="destinations.php"><span class="arr">&#8250;</span> Rishikesh</a></li>
        <li><a href="destinations.php"><span class="arr">&#8250;</span> Leh Ladak</a></li>
        <li><a href="destinations.php"><span class="arr">&#8250;</span> Mathura</a></li>
      </ul>
    </div>

    <!-- Contact info -->
    <div>
      <div class="footer-col-title">Get in Touch</div>

      <div class="footer-contact-item">
        <span class="footer-contact-icon">&#128205;</span>
        <p>Tikhampur, Ballia <br>Uttar Pradesh — 277001, India</p>
      </div>
      <div class="footer-contact-item">
        <span class="footer-contact-icon">&#128222;</span>
        <p><a href="tel:+919876543210">+91 7989270049</a><br><span style="font-size:0.78rem;">Mon–Sat · 9 AM – 7 PM IST</span></p>
      </div>
      <div class="footer-contact-item">
        <span class="footer-contact-icon">&#9993;</span>
        <p><a href="mailto:hello@travelworld.in">hello@travelworld.in</a><br><span style="font-size:0.78rem;">Reply within 24 hours</span></p>
      </div>
      <div class="footer-contact-item">
        <span class="footer-contact-icon">&#128172;</span>
        <p><a href="#">WhatsApp us instantly</a></p>
      </div>
    </div>

  </div>

  <hr class="footer-divider">

  <!-- Trust badges strip -->
  <div class="footer-middle">
    <div class="footer-badge">
      <span class="footer-badge-icon">&#127942;</span>
      <div><strong>Award Winning</strong>N/A</div>
    </div>
    <div class="footer-badge">
      <span class="footer-badge-icon">&#128100;</span>
      <div><strong>48,000+ Travellers</strong>Trust us worldwide</div>
    </div>
    <div class="footer-badge">
      <span class="footer-badge-icon">&#9733;</span>
      <div><strong>4.9 / 5 Rating</strong>On Google & Trustpilot</div>
    </div>
    <div class="footer-badge">
      <span class="footer-badge-icon">&#128272;</span>
      <div><strong>Secure Payments</strong>SSL encrypted checkout</div>
    </div>
    <div class="footer-badge">
      <span class="footer-badge-icon">&#9992;</span>
      <div><strong>20+ Destinations</strong></div>
    </div>
  </div>

  <hr class="footer-divider">

  <!-- Bottom bar -->
  <div class="footer-bottom">
    <span>&#169; <?= date('Y') ?> TravelWorld Pvt. Ltd. All rights reserved.</span>
    <div class="footer-bottom-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Refund Policy</a>
      <a href="contact.php">Support</a>
    </div>
    <span>Made with &#10084; in India</span>
  </div>

</footer>

<script>
function subscribeNewsletter() {
  const email = document.getElementById('footerEmail').value.trim();
  const msg   = document.getElementById('nlMsg');
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    msg.style.display = 'block';
    msg.style.color   = 'var(--danger)';
    msg.textContent   = 'Please enter a valid email address.';
    return;
  }
  msg.style.display = 'block';
  msg.style.color   = 'var(--success)';
  msg.textContent   = '&#10003; You\'re subscribed! Watch your inbox for great deals.';
  document.getElementById('footerEmail').value = '';
  setTimeout(() => { msg.style.display = 'none'; }, 4000);
}
// Allow Enter key in newsletter
document.getElementById('footerEmail')?.addEventListener('keydown', e => {
  if (e.key === 'Enter') subscribeNewsletter();
});
</script>