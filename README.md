# ✈️ Travel World — Tour & Travel Management System

A modern, responsive **Tour & Travel Management System** built with **PHP, HTML5, CSS3, and Vanilla JavaScript**. It uses **JSON files** as storage (no MySQL required), making it lightweight, portable, and perfect for a college final-year project or a developer portfolio piece.

Users can explore destinations, browse tour packages, book trips, cancel bookings, submit star-rated reviews, and message the team. Admins get a dashboard to manage all bookings, view revenue, and read every contact message.

---

## 🌟 Features

### 👤 User
- 🔐 **Auth** — Register / Login / Logout with **bcrypt** password hashing + sessions
- ✅ Live **username availability check** on the register form
- 🏔️ **Destinations** — Handpicked spots (Manali, Kashmir, Goa, Jaipur, Kerala, Ladakh, Andaman, Darjeeling, Rishikesh, Jaisalmer, Mathura…)
- 🎒 **Tour Packages** — Pricing, nights/days, features, "Most Popular" badge
- 📅 **Booking** — Guest details, check-in/out, adults/children, room type, meal plan, special requests, auto-generated reference number
- ❌ **Cancel Booking** — Users can cancel future trips with a reason; admin can cancel any
- ⭐ **Reviews** — Submit 1–5 star reviews for destinations (AJAX, no page reload)
- 📞 **Contact** — Send messages; view your own message history

### 🛠️ Admin (`admin` user)
- 👥 View **all bookings** across all users
- 💰 Live stats: total bookings, confirmed, cancelled, active revenue, total travellers
- 📩 Read **all contact messages**
- 🔒 Role-based access — enforced server-side on every action

### 🎨 UI / UX
- 🌙 Dark theme with **gold** accents (`Playfair Display` + `Raleway`)
- 📱 Fully responsive with hamburger mobile nav
- ✨ Hero image slider (auto-rotating), scroll fade-in animations, sticky navbar shadow
- 💎 Glassmorphism cards & modal cancel confirmation

---

## 🧰 Tech Stack

| Layer     | Technology                                          |
| --------- | --------------------------------------------------- |
| Frontend  | HTML5, CSS3, Vanilla JavaScript (no frameworks)     |
| Backend   | PHP 8+                                              |
| Storage   | JSON files — **no MySQL, no external DB**           |
| Auth      | PHP Sessions + `password_hash` (bcrypt)             |
| Fonts     | Google Fonts — Playfair Display & Raleway           |

---

## 📁 Project Structure

```
travel-world/
│
├── index.php               # Home (hero slider, stats, featured destinations)
├── auth.php                # Session guard — require on every protected page
│
├── login.html              # Login + Register tabs (single-page auth UI)
├── login.php               # Login handler (built-in accounts + JSON users)
├── register.php            # Registration + AJAX username-availability API
├── logout.php              # Destroy session
│
├── destinations.php        # Grid of all destinations
├── packages.php            # Tour packages with pricing & features
├── booking.php             # Booking form + save to bookings.json
├── my-bookings.php         # User trips / Admin all-bookings dashboard
├── cancel-booking.php      # AJAX cancel endpoint (JSON response)
│
├── reviews.php             # Reviews listing + submit form
├── submit-review.php       # AJAX endpoint — save review to reviews.json
│
├── contact.php             # Contact form + message history
│
├── nav.php                 # Reusable navbar (with active-page highlight)
├── footer.php              # Reusable footer (links, newsletter, social)
│
├── style.css               # Global dark-gold theme (~1500 lines)
├── main.js                 # Hero slider, fade-in, sticky nav, mobile menu
│
└── data/                   # JSON "database" — auto-created on first write
    ├── users.json          # Registered users (bcrypt hashes)
    ├── bookings.json       # All bookings
    ├── reviews.json        # User-submitted reviews
    └── contacts.json       # Contact-form messages
```

---

## ⚙️ Installation & Setup

### Requirements
- **PHP 8.0+** (with `json` + `session` extensions)
- A local web server — **XAMPP / WAMP / MAMP / LAMP** — or PHP's built-in server
- A modern browser (Chrome, Edge, Firefox, Safari)

### Option A — XAMPP / WAMP / MAMP
1. Copy the project folder into `htdocs/` (e.g. `htdocs/travel-world`)
2. Start **Apache** from the control panel
3. Make sure the `data/` folder is writable  
   *Linux / macOS:* `chmod -R 775 data/`
4. Open <http://localhost/travel-world/>

### Option B — PHP Built-in Server
```bash
cd travel-world
php -S localhost:8000
```
Then open <http://localhost:8000>

---

## 🔑 Default Login Credentials

| Role  | Username | Password     |
| ----- | -------- | ------------ |
| Admin | `admin`  | `travel123`  |
| Guest | `guest`  | `explore789` |

You can also **register your own account** via `login.html` → *Create Account* tab. New users are saved to `data/users.json` with bcrypt-hashed passwords.

> ⚠️ **Change the admin password before deploying anywhere public.**

---

## 💾 Data Storage (JSON)

All persistent data lives in the `data/` folder as human-readable JSON:

| File            | Purpose                                                                     |
| --------------- | --------------------------------------------------------------------------- |
| `users.json`    | Registered users (`id`, `username`, `password_hash`, `email`, `role`, …)    |
| `bookings.json` | Bookings (`ref_no`, `package_name`, `check_in`, `total_price`, `status`, …) |
| `reviews.json`  | Reviews (`reviewer_name`, `destination`, `rating`, `title`, `body`, …)      |
| `contacts.json` | Messages (`name`, `email`, `subject`, `message`, `status`, …)               |

### Backing up your data
```bash
cp -r data/ backups/data-$(date +%F)/
```

---

## 🧭 App Flow

```
 Register / Login
        │
        ▼
 Home ── Destinations ── Packages
                             │
                             ▼
                         Booking Form
                             │
                             ▼
                        My Bookings ── Cancel (future trips only)
                             │
                             ▼
                         Submit Review
                             │
                             ▼
                       Contact / Support
```

**Admin login** → *My Bookings* shows **every** user's bookings with revenue stats; *Contact* shows **every** message.

---

## 🛡️ Security Notes

- Passwords hashed with `password_hash($pw, PASSWORD_BCRYPT)`
- Sessions used for auth — `auth.php` guards every protected page
- AJAX endpoints (`cancel-booking.php`, `submit-review.php`) verify session **manually** and return JSON — no redirects
- Server-side validation on register, booking, review, cancel, and contact
- Case-insensitive username & email uniqueness
- Reserved usernames (`admin`, `user`, `guest`) blocked at registration
- Regular users cannot cancel someone else's booking (server-side check)

> For production, add HTTPS, CSRF tokens, rate limiting, and stricter permissions on `data/`.

---

## 📸 Pages Overview

| Page               | Description                                                     |
| ------------------ | --------------------------------------------------------------- |
| `index.php`        | Hero slider, stats bar, featured destinations                   |
| `destinations.php` | Grid of all travel destinations                                 |
| `packages.php`     | Detailed package cards with pricing, features, "Most Popular"   |
| `booking.php`      | Booking form → generates ref no. → saves to `bookings.json`     |
| `my-bookings.php`  | User trips (or admin-wide dashboard) with filter tabs           |
| `reviews.php`      | Read reviews + submit new review (AJAX)                         |
| `contact.php`      | Send message + view your message history                        |

---

## 🚀 Future Enhancements

- 📧 Email confirmation on booking (PHPMailer)
- 💳 Payment gateway (Razorpay / Stripe)
- 🗺️ Interactive destination map (Leaflet.js)
- 🌐 Multi-language support (Hindi / English)
- 📊 Admin analytics dashboard with charts
- 🔄 Optional migration path to MySQL / PostgreSQL

---



## 👨‍💻 Author

Nikhil Singh


Built as a **final-year college project** and portfolio piece.  
Feel free to fork ⭐, improve, and use it in your own portfolio.

---

## 📜 License

Released under the **MIT License** — free to use, modify, and distribute.

---

> ✈️ *"The world is a book, and those who do not travel read only one page."* — **Travel World**
