/* ── main.js ── Travel World ── */

// ── Hero Image Slider ──────────────────────────────────────────────
(function () {
  const slides = document.querySelectorAll('.slide');
  const dots   = document.querySelectorAll('.dot');
  if (!slides.length) return;

  let current = 0;
  let timer;

  function goTo(n) {
    slides[current].classList.remove('active');
    dots[current] && dots[current].classList.remove('active');
    current = (n + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current] && dots[current].classList.add('active');
  }

  function next() { goTo(current + 1); }

  function startAuto() {
    clearInterval(timer);
    timer = setInterval(next, 5000);
  }

  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      goTo(parseInt(dot.dataset.slide));
      startAuto();
    });
  });

  startAuto();
})();

// ── Scroll Fade-In Animations ─────────────────────────────────────
(function () {
  const els = document.querySelectorAll('.fade-in');
  if (!els.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        // Stagger delay based on position in group
        const siblings = entry.target.parentElement.querySelectorAll('.fade-in');
        let idx = 0;
        siblings.forEach((el, j) => { if (el === entry.target) idx = j; });
        setTimeout(() => {
          entry.target.classList.add('visible');
        }, idx * 80);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  els.forEach(el => observer.observe(el));
})();

// ── Book Now Alert ────────────────────────────────────────────────
function bookNow(packageName, price) {
  const msg =
    `🎉 Awesome choice!\n\n` +
    `Package: ${packageName}\n` +
    `Price: ${price} per person\n\n` +
    `Our travel consultant will contact you within 24 hours to confirm your booking and arrange payment details.\n\n` +
    `Thank you for choosing Travel World! ✈`;
  alert(msg);
}

// ── Sticky Navbar Shadow ──────────────────────────────────────────
(function () {
  const nav = document.querySelector('nav');
  if (!nav) return;
  window.addEventListener('scroll', () => {
    nav.style.boxShadow = window.scrollY > 40
      ? '0 4px 24px rgba(0,0,0,0.5)'
      : 'none';
  });
})();

// ── Close mobile nav on link click ───────────────────────────────
(function () {
  const links = document.querySelectorAll('.nav-links a');
  const navLinks = document.getElementById('navLinks');
  links.forEach(a => {
    a.addEventListener('click', () => {
      navLinks && navLinks.classList.remove('open');
    });
  });
})();
