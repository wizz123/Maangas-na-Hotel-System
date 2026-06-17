<?php
session_start();
require 'db.php';

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([3]); // hardcoded ID 2 for now
$guest = $stmt->fetch();

// if (!$guest) {
//     header("Location: login.php");
//     exit;
// }

$initials     = implode('', array_map(fn($w) => strtoupper($w[0]), explode(' ', $guest['fullname'])));
$member_since = date('F Y', strtotime($guest['created_at']));
$is_staff     = $guest['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Guest Profile — The Royal Suites</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --gold:        #C9A84C;
      --gold-light:  #E2C97E;
      --gold-glow:   rgba(201,168,76,.18);
      --gold-dim:    rgba(201,168,76,.08);
      --bg:          #0E0E0F;
      --bg-card:     #141416;
      --bg-card2:    #1A1A1D;
      --border:      rgba(201,168,76,.18);
      --border-sub:  hsla(0, 0%, 100%, 0.07);
      --text:        #F0EBE0;
      --text-mid:    #A09880;
      --text-soft:   #5C5848;
      --white:       #FFFFFF;
      --staff:       #2A4A7F;
      --danger:      #8B2020;
      --success:     #1A4A2E;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Jost', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ─── Ambient background ─── */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background:
        radial-gradient(ellipse 60% 40% at 80% 10%, rgba(201,168,76,.06) 0%, transparent 60%),
        radial-gradient(ellipse 40% 30% at 10% 80%, rgba(201,168,76,.04) 0%, transparent 60%);
      pointer-events: none; z-index: 0;
    }

    /* ─── Top bar ─── */
    .topbar {
      position: sticky; top: 0; z-index: 100;
      background: rgba(14,14,15,.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      padding: 0 2.5rem;
      height: 64px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .topbar-left { display: flex; align-items: center; gap: 1.2rem; }
    .topbar-crest {
      width: 32px; height: 32px;
      border: 1px solid var(--gold);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
    }
    .topbar-crest svg { width: 16px; height: 16px; }
    .topbar-brand {
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem; font-weight: 600;
      color: var(--gold);
      letter-spacing: .14em;
      text-transform: uppercase;
    }
    .topbar-divider { width: 1px; height: 22px; background: var(--border); }
    .topbar-section { font-size: .72rem; font-weight: 500; letter-spacing: .1em; text-transform: uppercase; color: var(--text-mid); }
    .view-badge {
      font-size: .65rem; font-weight: 600;
      letter-spacing: .12em; text-transform: uppercase;
      padding: .28rem .9rem; border-radius: 999px;
    }
    .view-badge.staff { background: var(--staff); color: #b8cfff; border: 1px solid rgba(100,150,255,.2); }
    .view-badge.guest { background: var(--gold-dim); color: var(--gold); border: 1px solid var(--border); }

    /* ─── Page layout ─── */
    .page {
      position: relative; z-index: 1;
      max-width: 1120px; margin: 0 auto;
      padding: 3rem 2rem 5rem;
      display: grid;
      grid-template-columns: 310px 1fr;
      gap: 2rem;
      align-items: start;
    }

    /* ─── Sidebar ─── */
    .sidebar { display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: 84px; }

    /* Profile hero card */
    .profile-hero {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
    }
    .profile-hero-top {
      background: linear-gradient(160deg, #1C1A14 0%, #0E0E0F 100%);
      padding: 2.25rem 1.75rem 1.75rem;
      display: flex; flex-direction: column; align-items: center; gap: 1rem;
      position: relative; overflow: hidden;
    }
    .profile-hero-top::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0; height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }
    .profile-hero-top::after {
      content: '';
      position: absolute; bottom: -40px; left: 50%; transform: translateX(-50%);
      width: 200px; height: 80px;
      background: var(--gold-glow);
      border-radius: 50%;
      filter: blur(24px);
    }
    .avatar-wrap { position: relative; z-index: 1; }
    .avatar-ring {
      width: 86px; height: 86px; border-radius: 50%;
      background: conic-gradient(var(--gold) 0deg, var(--gold-light) 90deg, var(--gold) 180deg, #7a5e28 270deg, var(--gold) 360deg);
      padding: 2px;
      display: flex; align-items: center; justify-content: center;
    }
    .avatar {
      width: 100%; height: 100%; border-radius: 50%;
      background: #1C1A14;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Playfair Display', serif;
      font-size: 1.6rem; font-weight: 700;
      color: var(--gold);
      letter-spacing: .05em;
    }
    .profile-name {
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem; font-weight: 600;
      color: var(--text); text-align: center;
      position: relative; z-index: 1;
    }
    .profile-id {
      font-size: .68rem; font-weight: 500;
      letter-spacing: .12em; text-transform: uppercase;
      color: var(--gold); position: relative; z-index: 1;
    }
    .profile-since {
      font-size: .68rem; color: var(--text-soft);
      letter-spacing: .06em; position: relative; z-index: 1;
    }

    .profile-hero-body { padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: .85rem; }
    .p-row { display: flex; flex-direction: column; gap: .18rem; }
    .p-label { font-size: .62rem; font-weight: 500; text-transform: uppercase; letter-spacing: .1em; color: var(--text-soft); }
    .p-val { font-size: .87rem; color: var(--text); }
    .p-val a { color: var(--gold); text-decoration: none; }
    .p-val a:hover { color: var(--gold-light); }
    .p-sep { height: 1px; background: var(--border-sub); }

    .id-status {
      display: flex; align-items: center; gap: .5rem;
      padding: .55rem .85rem; border-radius: 8px;
      font-size: .75rem; font-weight: 500;
    }
    .id-status.ok  { background: rgba(30,80,50,.4); color: #6fcf97; border: 1px solid rgba(111,207,151,.15); }
    .id-status.no  { background: rgba(80,60,10,.4); color: var(--gold-light); border: 1px solid rgba(201,168,76,.15); }

    /* Loyalty card */
    .loyalty-card {
      background: linear-gradient(145deg, #1A1710 0%, #0E0E0F 100%);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 1.5rem;
      position: relative; overflow: hidden;
    }
    .loyalty-card::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0; height: 1px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }
    .loyalty-card::after {
      content: '';
      position: absolute; top: -20px; right: -20px;
      width: 100px; height: 100px;
      background: var(--gold-glow); border-radius: 50%;
      filter: blur(20px);
    }
    .loyalty-eyebrow {
      font-size: .62rem; font-weight: 600; letter-spacing: .15em;
      text-transform: uppercase; color: var(--gold);
      margin-bottom: .5rem; position: relative; z-index: 1;
    }
    .loyalty-tier-name {
      font-family: 'Playfair Display', serif;
      font-size: 1.6rem; font-weight: 700;
      color: var(--text); line-height: 1;
      margin-bottom: .2rem; position: relative; z-index: 1;
    }
    .loyalty-tier-sub { font-size: .72rem; color: var(--text-soft); margin-bottom: 1.1rem; position: relative; z-index: 1; }
    .loyalty-pts {
      font-size: 2.4rem; font-weight: 300;
      color: var(--gold-light); line-height: 1;
      position: relative; z-index: 1;
    }
    .loyalty-pts span { font-size: .72rem; font-weight: 500; color: var(--text-soft); margin-left: .3rem; vertical-align: middle; }
    .loyalty-track { margin-top: 1rem; position: relative; z-index: 1; }
    .loyalty-bar-bg {
      height: 3px; background: rgba(255,255,255,.07);
      border-radius: 2px; overflow: hidden;
    }
    .loyalty-bar-fill {
      height: 100%; width: 36%;
      background: linear-gradient(90deg, var(--gold), var(--gold-light));
    }
    .loyalty-bar-labels {
      display: flex; justify-content: space-between;
      margin-top: .4rem; font-size: .63rem; color: var(--text-soft);
    }

    /* ─── Main ─── */
    .main { display: flex; flex-direction: column; gap: 1.5rem; }

    /* Page heading */
    .page-heading {
      display: flex; align-items: flex-end; justify-content: space-between;
      padding-bottom: 1.25rem;
      border-bottom: 1px solid var(--border-sub);
      margin-bottom: .25rem;
    }
    .page-heading-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.9rem; font-weight: 600; color: var(--text);
      line-height: 1.15;
    }
    .page-heading-title em { color: var(--gold); font-style: italic; }
    .page-heading-sub { font-size: .8rem; color: var(--text-soft); margin-top: .25rem; }

    /* Section cards */
    .sec {
      background: var(--bg-card);
      border: 1px solid var(--border-sub);
      border-radius: 16px;
      overflow: hidden;
      transition: border-color .3s;
    }
    .sec:hover { border-color: var(--border); }

    .sec-head {
      padding: 1.2rem 1.75rem;
      border-bottom: 1px solid var(--border-sub);
      display: flex; align-items: center; justify-content: space-between;
    }
    .sec-head-left { display: flex; align-items: center; gap: .75rem; }
    .sec-icon {
      width: 32px; height: 32px; border-radius: 8px;
      background: var(--gold-dim); border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .sec-icon svg { width: 15px; height: 15px; color: var(--gold); }
    .sec-title {
      font-family: 'Playfair Display', serif;
      font-size: 1rem; font-weight: 600; color: var(--text);
      letter-spacing: .02em;
    }
    .sec-body { padding: 1.75rem; }

    /* Edit button */
    .btn {
      font-family: 'Jost', sans-serif;
      font-size: .7rem; font-weight: 500;
      letter-spacing: .08em; text-transform: uppercase;
      padding: .35rem .9rem; border-radius: 7px;
      border: 1px solid var(--border);
      background: transparent; color: var(--gold);
      cursor: pointer; transition: background .2s, border-color .2s;
    }
    .btn:hover { background: var(--gold-dim); border-color: var(--gold); }
    .btn-primary {
      background: var(--gold); color: var(--bg);
      border-color: var(--gold); font-weight: 600;
    }
    .btn-primary:hover { background: var(--gold-light); border-color: var(--gold-light); }

    /* Info grid */
    .info-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 1.5rem 2.5rem;
    }
    .field-label {
      font-size: .63rem; font-weight: 500;
      text-transform: uppercase; letter-spacing: .1em;
      color: var(--text-soft); margin-bottom: .3rem;
    }
    .field-val { font-size: .9rem; color: var(--text); }
    .field-val a { color: var(--gold); text-decoration: none; }

    /* Staff note */
    .staff-note {
      margin-top: 1.5rem;
      background: rgba(42,74,127,.15);
      border: 1px solid rgba(100,150,255,.12);
      border-radius: 10px;
      padding: .9rem 1.1rem;
    }
    .staff-note-label {
      font-size: .6rem; font-weight: 600; letter-spacing: .12em;
      text-transform: uppercase; color: #6fa0e0; margin-bottom: .3rem;
    }
    .staff-note-text { font-size: .82rem; color: #8aafd8; }

    /* Reservation table */
    .res-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: .85rem; }
    thead th {
      font-size: .63rem; font-weight: 500;
      text-transform: uppercase; letter-spacing: .09em;
      color: var(--text-soft);
      padding: 0 1.25rem .85rem 0;
      border-bottom: 1px solid var(--border-sub);
      text-align: left;
    }
    tbody td {
      padding: 1rem 1.25rem 1rem 0;
      border-bottom: 1px solid var(--border-sub);
      color: var(--text); vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr { transition: background .2s; }
    tbody tr:hover { background: var(--gold-dim); }

    .pill {
      display: inline-block; padding: .22rem .7rem;
      border-radius: 999px; font-size: .67rem; font-weight: 500;
      letter-spacing: .05em; text-transform: uppercase;
    }
    .pill.upcoming  { background: rgba(30,60,120,.4); color: #82b4ff; border: 1px solid rgba(100,150,255,.2); }
    .pill.completed { background: rgba(20,60,35,.4); color: #6fcf97; border: 1px solid rgba(111,207,151,.15); }
    .pill.cancelled { background: rgba(80,20,20,.4); color: #eb8080; border: 1px solid rgba(220,80,80,.15); }

    /* Preferences grid */
    .pref-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .pref-item {
      background: var(--bg-card2);
      border: 1px solid var(--border-sub);
      border-radius: 10px;
      padding: 1rem 1.1rem;
      transition: border-color .2s;
    }
    .pref-item:hover { border-color: var(--border); }
    .pref-item-label {
      font-size: .62rem; font-weight: 500;
      text-transform: uppercase; letter-spacing: .1em;
      color: var(--text-soft); margin-bottom: .35rem;
    }
    .pref-item-val { font-size: .85rem; color: var(--text); }
    .pref-item-val.empty { color: var(--text-soft); font-style: italic; }
    .pref-wide { grid-column: 1 / -1; }

    /* Responsive */
    @media (max-width: 860px) {
      .page { grid-template-columns: 1fr; }
      .sidebar { position: static; }
      .info-grid { grid-template-columns: 1fr; gap: 1rem; }
      .pref-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 540px) {
      .topbar { padding: 0 1rem; }
      .page { padding: 1.5rem 1rem 4rem; }
      .pref-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<!-- ── Topbar ── -->
<header class="topbar">
  <div class="topbar-left">
    <div class="topbar-crest">
      <svg viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/>
      </svg>
    </div>
    <span class="topbar-brand">The Royal Suites</span>
    <div class="topbar-divider"></div>
    <span class="topbar-section">Guest Profile</span>
  </div>
  <?php if ($is_staff): ?>
    <span class="view-badge staff">Staff View</span>
  <?php else: ?>
    <span class="view-badge guest">Guest Portal</span>
  <?php endif; ?>
</header>

<div class="page">

  <!-- ── Sidebar ── -->
  <aside class="sidebar">

    <div class="profile-hero">
      <div class="profile-hero-top">
        <div class="avatar-wrap">
          <div class="avatar-ring">
            <div class="avatar"><?= htmlspecialchars($initials) ?></div>
          </div>
        </div>
        <div class="profile-name"><?= htmlspecialchars($guest['fullname']) ?></div>
        <div class="profile-id">Guest #<?= str_pad($guest['id'], 5, '0', STR_PAD_LEFT) ?></div>
        <div class="profile-since">Member since <?= $member_since ?></div>
      </div>
      <div class="profile-hero-body">
        <div class="p-row">
          <span class="p-label">Email</span>
          <span class="p-val"><a href="mailto:<?= htmlspecialchars($guest['email']) ?>"><?= htmlspecialchars($guest['email']) ?></a></span>
        </div>
        <div class="p-sep"></div>
        <div class="p-row">
          <span class="p-label">Phone</span>
          <span class="p-val"><?= $guest['phone'] ? htmlspecialchars($guest['phone']) : '—' ?></span>
        </div>
        <div class="p-sep"></div>
        <div class="p-row">
          <span class="p-label">Valid ID</span>
          <?php if ($guest['valid_id']): ?>
            <div class="id-status ok">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Verified on file
            </div>
          <?php else: ?>
            <div class="id-status no">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
              No ID uploaded
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Loyalty -->
    <div class="loyalty-card">
      <div class="loyalty-eyebrow">Loyalty Programme</div>
      <div class="loyalty-tier-name">Silver</div>
      <div class="loyalty-tier-sub">The Royal Suites Rewards</div>
      <div class="loyalty-pts">1,250 <span>points</span></div>
      <div class="loyalty-track">
        <div class="loyalty-bar-bg"><div class="loyalty-bar-fill"></div></div>
        <div class="loyalty-bar-labels">
          <span>Silver</span><span>Gold · 3,500 pts</span>
        </div>
      </div>
      <!-- TODO: Connect to loyalty_points table -->
    </div>

  </aside>

  <!-- ── Main ── -->
  <main class="main">

    <div class="page-heading">
      <div>
        <div class="page-heading-title">Welcome back, <em><?= explode(' ', $guest['fullname'])[0] ?></em></div>
        <div class="page-heading-sub">Manage your profile, view your stays, and set your preferences.</div>
      </div>
      <?php if ($is_staff): ?>
        <button class="btn btn-primary">+ New Booking</button>
      <?php endif; ?>
    </div>

    <!-- Personal Information -->
    <div class="sec">
      <div class="sec-head">
        <div class="sec-head-left">
          <div class="sec-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
          <span class="sec-title">Personal Information</span>
        </div>
        <button class="btn">Edit Profile</button>
      </div>
      <div class="sec-body">
        <div class="info-grid">
          <div>
            <div class="field-label">Full Name</div>
            <div class="field-val"><?= htmlspecialchars($guest['fullname']) ?></div>
          </div>
          <div>
            <div class="field-label">Email Address</div>
            <div class="field-val"><a href="mailto:<?= htmlspecialchars($guest['email']) ?>"><?= htmlspecialchars($guest['email']) ?></a></div>
          </div>
          <div>
            <div class="field-label">Phone Number</div>
            <div class="field-val"><?= $guest['phone'] ? htmlspecialchars($guest['phone']) : '—' ?></div>
          </div>
          <div>
            <div class="field-label">Member Since</div>
            <div class="field-val"><?= date('F d, Y', strtotime($guest['created_at'])) ?></div>
          </div>
          <div>
            <div class="field-label">Valid ID</div>
            <div class="field-val"><?= $guest['valid_id'] ? '<a href="#">View document ↗</a>' : 'Not uploaded' ?></div>
          </div>
          <div>
            <div class="field-label">Account Type</div>
            <div class="field-val" style="text-transform:capitalize"><?= htmlspecialchars($guest['role']) ?></div>
          </div>
        </div>
        <?php if ($is_staff): ?>
        <div class="staff-note">
          <div class="staff-note-label">Staff Note</div>
          <div class="staff-note-text">No flags on this account. Registered <?= date('M d, Y', strtotime($guest['created_at'])) ?>. Valid ID pending upload.</div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Upcoming Reservations -->
    <div class="sec">
      <div class="sec-head">
        <div class="sec-head-left">
          <div class="sec-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
          </div>
          <span class="sec-title">Upcoming Reservations</span>
        </div>
        <?php if ($is_staff): ?><button class="btn">Add Booking</button><?php endif; ?>
      </div>
      <div class="sec-body">
        <!-- TODO: Replace with query from reservations table -->
        <div class="res-wrap">
          <table>
            <thead>
              <tr>
                <th>Booking</th><th>Room</th><th>Check-in</th><th>Check-out</th><th>Nights</th><th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="color:var(--gold)">#00821</td>
                <td>Deluxe King · Suite 301</td>
                <td>Jul 10, 2026</td>
                <td>Jul 13, 2026</td>
                <td>3</td>
                <td><span class="pill upcoming">Upcoming</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Stay History -->
    <div class="sec">
      <div class="sec-head">
        <div class="sec-head-left">
          <div class="sec-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
            </svg>
          </div>
          <span class="sec-title">Stay History</span>
        </div>
      </div>
      <div class="sec-body">
        <!-- TODO: Replace with query from reservations / stay_history table -->
        <div class="res-wrap">
          <table>
            <thead>
              <tr>
                <th>Booking</th><th>Room</th><th>Check-in</th><th>Check-out</th><th>Nights</th><th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="color:var(--gold)">#00714</td>
                <td>Superior Twin · Room 210</td>
                <td>Apr 2, 2026</td>
                <td>Apr 5, 2026</td>
                <td>3</td>
                <td><span class="pill completed">Completed</span></td>
              </tr>
              <tr>
                <td style="color:var(--gold)">#00588</td>
                <td>Deluxe King · Suite 305</td>
                <td>Jan 18, 2026</td>
                <td>Jan 20, 2026</td>
                <td>2</td>
                <td><span class="pill completed">Completed</span></td>
              </tr>
              <tr>
                <td style="color:var(--gold)">#00491</td>
                <td>Standard · Room 112</td>
                <td>Nov 1, 2025</td>
                <td>Nov 3, 2025</td>
                <td>2</td>
                <td><span class="pill cancelled">Cancelled</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Preferences -->
    <div class="sec">
      <div class="sec-head">
        <div class="sec-head-left">
          <div class="sec-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>
            </svg>
          </div>
          <span class="sec-title">Guest Preferences</span>
        </div>
        <button class="btn">Edit Preferences</button>
      </div>
      <div class="sec-body">
        <!-- TODO: Connect to guest_preferences table once created -->
        <div class="pref-grid">
          <div class="pref-item">
            <div class="pref-item-label">Room Type</div>
            <div class="pref-item-val empty">Not set</div>
          </div>
          <div class="pref-item">
            <div class="pref-item-label">Bed Type</div>
            <div class="pref-item-val empty">Not set</div>
          </div>
          <div class="pref-item">
            <div class="pref-item-label">Floor Preference</div>
            <div class="pref-item-val empty">Not set</div>
          </div>
          <div class="pref-item">
            <div class="pref-item-label">Pillow Type</div>
            <div class="pref-item-val empty">Not set</div>
          </div>
          <div class="pref-item">
            <div class="pref-item-label">Amenities</div>
            <div class="pref-item-val empty">Not set</div>
          </div>
          <div class="pref-item">
            <div class="pref-item-label">Dietary Notes</div>
            <div class="pref-item-val empty">Not set</div>
          </div>
          <div class="pref-item pref-wide">
            <div class="pref-item-label">Special Requests</div>
            <div class="pref-item-val empty">No special requests recorded</div>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

</body>
</html>