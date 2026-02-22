<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita Dinas Kesehatan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navy: #0a2463;
            --navy-deep: #061539;
            --blue: #1e6ff0;
            --blue-light: #3d8ef7;
            --gold: #f0a500;
            --gold-light: #f5bf45;
            --white: #ffffff;
            --grey-100: #f0f4f8;
            --grey-200: #dde4ed;
            --grey-400: #8899aa;
            --grey-600: #556677;
            --text-dark: #1a2332;
            --text-body: #3d5060;
            --radius: 10px;
            --shadow-card: 0 4px 24px rgba(10,36,99,0.08);
            --shadow-hover: 0 12px 40px rgba(10,36,99,0.18);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text-body);
            background: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ============ TOP BAR ============ */
        .topbar {
            background: var(--navy-deep);
            color: rgba(255,255,255,0.75);
            font-size: 0.78rem;
            padding: 0.55rem 0;
            letter-spacing: 0.3px;
        }
        .topbar .container { display: flex; justify-content: space-between; align-items: center; max-width: 1320px; margin: 0 auto; padding: 0 1.2rem; flex-wrap: wrap; gap: 0.5rem; }
        .topbar-left, .topbar-right { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; }
        .topbar a { color: inherit; text-decoration: none; transition: color .2s; }
        .topbar a:hover { color: var(--gold); }
        .topbar i { margin-right: 0.35rem; color: var(--gold); }
        .topbar-right a {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 0.3rem 0.75rem;
            border-radius: 4px;
            font-weight: 500;
            transition: all .2s;
        }
        .topbar-right a:hover { background: var(--gold); color: var(--navy-deep); border-color: var(--gold); }

        /* ============ MAIN NAV ============ */
        .nav-main {
            background: var(--white);
            box-shadow: 0 2px 20px rgba(10,36,99,0.07);
            position: sticky;
            top: 0;
            z-index: 900;
            transition: box-shadow .3s;
        }
        .nav-main.scrolled { box-shadow: 0 4px 30px rgba(10,36,99,0.12); }
        .nav-inner { max-width: 1320px; margin: 0 auto; padding: 0 1.2rem; display: flex; align-items: center; justify-content: space-between; height: 72px; }

        .nav-brand { display: flex; align-items: center; gap: 0.85rem; text-decoration: none; flex-shrink: 0; }
        .nav-brand-logo {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--navy), var(--blue));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.3rem;
            box-shadow: 0 3px 12px rgba(30,111,240,0.35);
        }
        .nav-brand-text h1 { font-family: 'Playfair Display', serif; font-size: 1.15rem; color: var(--navy); font-weight: 700; line-height: 1.2; }
        .nav-brand-text span { font-size: 0.68rem; color: var(--grey-400); text-transform: uppercase; letter-spacing: 1px; }

        .nav-links { display: flex; align-items: center; gap: 0.25rem; list-style: none; }
        .nav-links > li { position: relative; }
        .nav-links > li > a {
            display: flex; align-items: center; gap: 0.3rem;
            padding: 0.55rem 0.75rem;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all .2s;
            white-space: nowrap;
        }
        .nav-links > li > a:hover, .nav-links > li > a.active { background: var(--navy); color: white; }
        .nav-links > li > a .arrow { font-size: 0.55rem; transition: transform .2s; }
        .nav-links > li:hover > a .arrow { transform: rotate(180deg); }

        /* Dropdown */
        .dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%) translateY(8px);
            background: white;
            border-radius: 12px;
            box-shadow: 0 16px 48px rgba(10,36,99,0.15);
            min-width: 240px;
            opacity: 0;
            visibility: hidden;
            transition: all .25s cubic-bezier(.4,0,.2,1);
            border: 1px solid rgba(10,36,99,0.06);
            overflow: hidden;
            z-index: 100;
        }
        .nav-links > li:hover .dropdown { opacity: 1; visibility: visible; transform: translateX(-50%) translateY(0); }

        .dropdown-item {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.6rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 500;
            transition: all .15s;
            position: relative;
        }
        .dropdown-item:hover { background: #eef3ff; color: var(--blue); padding-left: 1.2rem; }
        .dropdown-item i { width: 16px; text-align: center; color: var(--blue); font-size: 0.72rem; }

        /* Sub-dropdown (level 3) */
        .has-sub { position: relative; }
        .has-sub .arrow-sub { font-size: 0.55rem; margin-left: auto; color: var(--grey-400); transition: transform .2s; }
        .has-sub:hover .arrow-sub { transform: rotate(90deg); }

        .sub-dropdown {
            position: absolute;
            left: 100%;
            top: 0;
            min-width: 230px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 12px 36px rgba(10,36,99,0.14);
            opacity: 0; visibility: hidden;
            transform: translateX(-6px);
            transition: all .2s;
            border: 1px solid rgba(10,36,99,0.06);
            overflow: hidden;
        }
        .has-sub:hover .sub-dropdown { opacity: 1; visibility: visible; transform: translateX(0); }

        /* Mobile nav toggle */
        .nav-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 0.5rem; }
        .nav-toggle span { width: 24px; height: 2px; background: var(--navy); border-radius: 2px; transition: all .3s; }

        /* ============ HERO SLIDESHOW ============ */
        .hero {
            position: relative;
            height: 580px;
            min-height: 420px;
            overflow: hidden;
        }

        /* Slide track — each .slide sits absolutely, fades in/out */
        .slide {
            position: absolute; inset: 0;
            opacity: 0;
            transition: opacity .9s ease;
            z-index: 1;
        }
        .slide.active { opacity: 1; z-index: 2; }

        /* Background image layer */
        .slide-img {
            position: absolute; inset: 0;
            background-size: cover;
            background-position: center;
            /* Ken-Burns subtle zoom */
            animation: kenBurns 12s ease-in-out infinite alternate;
        }
        @keyframes kenBurns {
            from { transform: scale(1); }
            to   { transform: scale(1.08); }
        }

        /* Dark gradient overlay so text stays readable */
        .slide-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(
                to right,
                rgba(6,21,57,0.82) 0%,
                rgba(10,36,99,0.65) 45%,
                rgba(10,36,99,0.30) 100%
            );
        }

        /* Content positioned over overlay */
        .slide-content {
            position: relative; z-index: 3;
            max-width: 1320px; margin: 0 auto; padding: 0 1.2rem;
            height: 100%; display: flex; flex-direction: column; justify-content: center;
            /* stagger-in when slide becomes .active */
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .55s ease .35s, transform .55s ease .35s;
        }
        .slide.active .slide-content { opacity: 1; transform: translateY(0); }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(240,165,0,0.15);
            border: 1px solid rgba(240,165,0,0.3);
            color: var(--gold-light);
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: fit-content;
            margin-bottom: 1rem;
        }
        .hero-badge i { font-size: 0.65rem; }

        .slide-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 5vw, 3.3rem);
            color: white;
            font-weight: 800;
            line-height: 1.18;
            max-width: 660px;
        }
        .slide-content h1 em { font-style: normal; color: var(--gold); }

        .slide-content .hero-sub {
            color: rgba(255,255,255,0.62);
            font-size: 0.93rem;
            max-width: 540px;
            margin-top: 0.85rem;
            line-height: 1.65;
        }

        .hero-actions {
            display: flex; gap: 1rem; margin-top: 1.8rem; flex-wrap: wrap;
        }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: var(--gold);
            color: var(--navy-deep);
            padding: 0.78rem 1.5rem;
            border-radius: 8px;
            font-weight: 700; font-size: 0.8rem;
            text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;
            transition: all .25s;
            box-shadow: 0 4px 16px rgba(240,165,0,0.35);
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(240,165,0,0.45); }
        .btn-hero-outline {
            display: inline-flex; align-items: center; gap: 0.5rem;
            border: 1.5px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.76rem 1.4rem;
            border-radius: 8px;
            font-weight: 600; font-size: 0.8rem;
            text-decoration: none;
            transition: all .25s;
        }
        .btn-hero-outline:hover { border-color: white; background: rgba(255,255,255,0.08); }

        /* ---- Slideshow controls ---- */
        /* Prev / Next arrows */
        .slide-arrow {
            position: absolute; top: 50%; z-index: 10;
            transform: translateY(-50%);
            width: 42px; height: 42px;
            background: rgba(255,255,255,0.12);
            border: 1.5px solid rgba(255,255,255,0.22);
            border-radius: 50%;
            color: white; font-size: 0.85rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all .22s;
            backdrop-filter: blur(4px);
        }
        .slide-arrow:hover { background: rgba(255,255,255,0.28); border-color: rgba(255,255,255,0.5); }
        .slide-arrow-prev { left: 1.2rem; }
        .slide-arrow-next { right: 1.2rem; }

        /* Dot indicators */
        .slide-dots {
            position: absolute; bottom: 5.8rem; left: 50%; z-index: 10;
            transform: translateX(-50%);
            display: flex; gap: 0.55rem; align-items: center;
        }
        .slide-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            border: none; cursor: pointer;
            transition: all .3s;
        }
        .slide-dot.active {
            background: var(--gold);
            box-shadow: 0 0 8px rgba(240,165,0,0.5);
            transform: scale(1.25);
        }
        .slide-dot:hover { background: rgba(255,255,255,0.6); }

        /* Play / Pause toggle */
        .slide-play-pause {
            position: absolute; bottom: 5.6rem; right: 1.4rem; z-index: 10;
            width: 34px; height: 34px;
            background: rgba(255,255,255,0.12);
            border: 1.5px solid rgba(255,255,255,0.22);
            border-radius: 50%;
            color: white; font-size: 0.7rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all .22s;
            backdrop-filter: blur(4px);
        }
        .slide-play-pause:hover { background: rgba(255,255,255,0.28); }

        /* Hero stats bar */
        .hero-stats {
            position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
            background: rgba(6,21,57,0.85);
            backdrop-filter: blur(8px);
        }
        .hero-stats-inner {
            max-width: 1320px; margin: 0 auto; padding: 0 1.2rem;
            display: grid; grid-template-columns: repeat(4, 1fr);
        }
        .hero-stat {
            padding: 1.2rem 1rem;
            border-right: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; gap: 0.85rem;
        }
        .hero-stat:last-child { border-right: none; }
        .hero-stat-icon {
            width: 38px; height: 38px;
            background: rgba(30,111,240,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--blue-light); font-size: 0.95rem;
            flex-shrink: 0;
        }
        .hero-stat-value { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: white; font-weight: 700; line-height: 1.1; }
        .hero-stat-label { font-size: 0.7rem; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 0.8px; margin-top: 0.15rem; }

        /* ============ SECTION COMMON ============ */
        .section { padding: 5rem 0; }
        .section-alt { background: var(--grey-100); }
        .container { max-width: 1320px; margin: 0 auto; padding: 0 1.2rem; }

        .section-header { text-align: center; margin-bottom: 2.8rem; }
        .section-tag {
            display: inline-block;
            background: rgba(30,111,240,0.08);
            color: var(--blue);
            font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.5px;
            padding: 0.3rem 0.8rem; border-radius: 4px;
            margin-bottom: 0.8rem;
        }
        .section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.7rem, 3vw, 2.2rem);
            color: var(--navy);
            font-weight: 700;
        }
        .section-header p { color: var(--grey-400); font-size: 0.88rem; margin-top: 0.5rem; max-width: 560px; margin-left: auto; margin-right: auto; }

        /* ============ FASYANKES SECTION ============ */
        .fasyankes-filter {
            display: flex; justify-content: center; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 2.2rem;
        }
        .filter-btn {
            padding: 0.45rem 1.1rem;
            border-radius: 20px;
            border: 1.5px solid var(--grey-200);
            background: white;
            color: var(--grey-600);
            font-size: 0.77rem; font-weight: 600;
            cursor: pointer; transition: all .2s;
            font-family: inherit;
        }
        .filter-btn:hover, .filter-btn.active { border-color: var(--blue); background: var(--blue); color: white; }

        .fasyankes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.3rem;
        }
        .fasyankes-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            transition: all .3s cubic-bezier(.4,0,.2,1);
            border: 1px solid rgba(10,36,99,0.05);
            display: flex; flex-direction: column;
        }
        .fasyankes-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); }

        .card-header-strip {
            height: 5px;
        }
        .strip-rs { background: linear-gradient(90deg, #e74c3c, #c0392b); }
        .strip-puskesmas { background: linear-gradient(90deg, #27ae60, #2ecc71); }
        .strip-klinik { background: linear-gradient(90deg, #3498db, #2980b9); }
        .strip-apotek { background: linear-gradient(90deg, #f39c12, #e67e22); }
        .strip-lab { background: linear-gradient(90deg, #9b59b6, #8e44ad); }

        .card-body { padding: 1.2rem; flex: 1; display: flex; flex-direction: column; }
        .card-category {
            display: inline-flex; align-items: center; gap: 0.3rem;
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.8px; margin-bottom: 0.5rem;
        }
        .cat-rs { color: #e74c3c; } .cat-puskesmas { color: #27ae60; }
        .cat-klinik { color: #3498db; } .cat-apotek { color: #f39c12; } .cat-lab { color: #9b59b6; }

        .card-body h3 { font-size: 0.88rem; color: var(--text-dark); font-weight: 600; line-height: 1.4; margin-bottom: 0.6rem; }
        .card-meta { display: flex; flex-direction: column; gap: 0.3rem; margin-top: auto; }
        .card-meta-item { font-size: 0.73rem; color: var(--grey-400); display: flex; align-items: flex-start; gap: 0.4rem; }
        .card-meta-item i { color: var(--blue); font-size: 0.68rem; margin-top: 1px; flex-shrink: 0; width: 12px; text-align: center; }

        .card-footer {
            padding: 0.85rem 1.2rem;
            border-top: 1px solid var(--grey-200);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-footer a {
            font-size: 0.75rem; color: var(--blue); font-weight: 600;
            text-decoration: none; display: flex; align-items: center; gap: 0.3rem;
            transition: gap .2s;
        }
        .card-footer a:hover { gap: 0.55rem; }

        .map-btn {
            width: 32px; height: 32px;
            background: #eef3ff; border: none; border-radius: 6px;
            color: var(--blue); cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all .2s; font-size: 0.8rem;
        }
        .map-btn:hover { background: var(--blue); color: white; }

        /* Load more btn */
        .load-more-wrap { text-align: center; margin-top: 2.5rem; }
        .btn-load-more {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.7rem 2rem;
            border: 2px solid var(--navy);
            background: transparent;
            color: var(--navy);
            border-radius: 8px;
            font-size: 0.8rem; font-weight: 700;
            cursor: pointer; transition: all .25s;
            font-family: inherit; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .btn-load-more:hover { background: var(--navy); color: white; }

        /* ============ QUICK ACCESS ============ */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
        }
        .quick-card {
            background: white;
            border: 1px solid var(--grey-200);
            border-radius: var(--radius);
            padding: 1.5rem 1rem;
            text-align: center;
            text-decoration: none;
            transition: all .25s;
            display: flex; flex-direction: column; align-items: center; gap: 0.7rem;
        }
        .quick-card:hover { border-color: var(--blue); box-shadow: var(--shadow-card); transform: translateY(-3px); }
        .quick-card-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #eef3ff, #dce8ff);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: var(--blue); font-size: 1.1rem;
        }
        .quick-card span { font-size: 0.75rem; color: var(--text-dark); font-weight: 600; line-height: 1.3; }

        /* ============ FOOTER ============ */
        .footer { background: var(--navy-deep); color: rgba(255,255,255,0.6); padding: 3.5rem 0 0; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 2.5rem; }

        .footer h4 { color: white; font-family: 'Playfair Display', serif; font-size: 0.95rem; margin-bottom: 1rem; font-weight: 600; }
        .footer p, .footer li { font-size: 0.76rem; line-height: 1.7; }
        .footer ul { list-style: none; }
        .footer ul li a { color: inherit; text-decoration: none; transition: color .2s; display: flex; align-items: center; gap: 0.35rem; }
        .footer ul li a:hover { color: var(--gold); }
        .footer ul li a i { font-size: 0.6rem; color: var(--gold); }

        .footer-brand { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; }
        .footer-brand-logo {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--navy), var(--blue));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.1rem;
        }
        .footer-brand-text h3 { color: white; font-family: 'Playfair Display', serif; font-size: 0.95rem; font-weight: 700; }
        .footer-brand-text span { font-size: 0.65rem; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 1px; }

        .footer-contact-item { display: flex; gap: 0.6rem; margin-bottom: 0.7rem; font-size: 0.76rem; }
        .footer-contact-item i { color: var(--gold); width: 14px; text-align: center; margin-top: 2px; flex-shrink: 0; }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: 2.5rem; padding: 1.2rem 0;
            display: flex; justify-content: space-between; align-items: center;
            font-size: 0.72rem;
        }
        .footer-socials { display: flex; gap: 0.6rem; }
        .footer-socials a {
            width: 30px; height: 30px;
            background: rgba(255,255,255,0.07);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.5);
            text-decoration: none; transition: all .2s; font-size: 0.72rem;
        }
        .footer-socials a:hover { background: var(--gold); color: var(--navy-deep); }

        /* ============ ANIMATIONS ============ */
        @keyframes fadeInUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeInDown { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }

        .reveal { opacity: 0; transform: translateY(28px); transition: opacity .6s ease, transform .6s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 1024px) {
            .hero-stats-inner { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-toggle { display: flex; }
            .hero { height: auto; padding: 4rem 0 7rem; }
            .hero-stats-inner { grid-template-columns: repeat(2, 1fr); }
            .section { padding: 3.5rem 0; }
            .quick-grid { grid-template-columns: repeat(3, 1fr); }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 0.8rem; text-align: center; }
        }
        @media (max-width: 480px) {
            .hero-stats-inner { grid-template-columns: 1fr 1fr; }
            .quick-grid { grid-template-columns: repeat(2, 1fr); }
            .fasyankes-grid { grid-template-columns: 1fr; }
        }

        /* Mobile Menu Overlay */
        .mobile-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 850; }
        .mobile-overlay.show { display: block; }
        .mobile-nav {
            position: fixed; top: 0; right: -100%; width: 280px; height: 100%;
            background: white; z-index: 901; transition: right .3s ease;
            overflow-y: auto; padding: 1.5rem 1rem;
            box-shadow: -8px 0 30px rgba(0,0,0,0.12);
        }
        .mobile-nav.show { right: 0; }
        .mobile-nav-close { background: none; border: none; font-size: 1.4rem; color: var(--navy); cursor: pointer; float: right; }
        .mobile-nav a { display: block; padding: 0.6rem 0.8rem; color: var(--text-dark); text-decoration: none; font-size: 0.82rem; font-weight: 500; border-radius: 6px; transition: background .15s; }
        .mobile-nav a:hover { background: #eef3ff; color: var(--blue); }
        .mobile-nav .mobile-section-title { font-size: 0.68rem; color: var(--grey-400); text-transform: uppercase; letter-spacing: 1px; padding: 0.8rem 0.8rem 0.3rem; font-weight: 700; }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <div class="container">
        <div class="topbar-left">
            <a href="#"><i class="fas fa-map-marker-alt"></i> Jl. MT. Hariyono No. 29 Ungaran</a>
            <a href="#"><i class="fas fa-envelope"></i> <span class="__cf_email__" data-cfemail="2a4e4344414f596a5a4f4741455e04594f474b584b444d044d4504434e">[email&#160;protected]</span></a>
            <a href="#"><i class="fas fa-phone"></i> (024) 6923955</a>
        </div>
        <div class="topbar-right">
            <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login Admin</a>
        </div>
    </div>
</div>

<!-- MAIN NAV -->
<nav class="nav-main" id="navMain">
    <div class="nav-inner">
        <a href="#" class="nav-brand">
            <div class="nav-brand-logo"><i class="fas fa-hospital"></i></div>
            <div class="nav-brand-text">
                <h1>DINAS KESEHATAN</h1>
                <span>Kabupaten Semarang</span>
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="#" class="active">Home</a></li>

            <!-- PROFIL -->
            <li>
                <a href="#">Profil <span class="arrow"><i class="fas fa-chevron-down"></i></span></a>
                <div class="dropdown">
                    <a href="#" class="dropdown-item"><i class="fas fa-sitemap"></i> Struktur Organisasi</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-tasks"></i> Tupoksi</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-eye"></i> Visi, Misi & Motto</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-user-tie"></i> Profil Pejabat Struktural</a>
                </div>
            </li>

            <!-- PPID -->
            <li>
                <a href="#">PPID <span class="arrow"><i class="fas fa-chevron-down"></i></span></a>
                <div class="dropdown">
                    <a href="#" class="dropdown-item has-sub">
                        <i class="fas fa-file-alt"></i> Informasi Publik
                        <span class="arrow-sub"><i class="fas fa-chevron-right"></i></span>
                        <div class="sub-dropdown">
                            <a href="#" class="dropdown-item"><i class="fas fa-list"></i> Daftar Informasi Publik</a>
                            <a href="#" class="dropdown-item"><i class="fas fa-calendar-alt"></i> Informasi Berkala</a>
                            <a href="#" class="dropdown-item"><i class="fas fa-bolt"></i> Informasi Serta Merta</a>
                            <a href="#" class="dropdown-item"><i class="fas fa-lock"></i> Informasi Dikecualikan</a>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item"><i class="fas fa-clipboard-list"></i> Permohonan Informasi</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-route"></i> Alur Permohonan Informasi</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-forward"></i> Tindak Lanjut Permohonan</a>
                    <a href="#" class="dropdown-item has-sub">
                        <i class="fas fa-file-signature"></i> SK PPID
                        <span class="arrow-sub"><i class="fas fa-chevron-right"></i></span>
                        <div class="sub-dropdown">
                            <a href="#" class="dropdown-item"><i class="fas fa-file-pdf"></i> SK Daftar Info Publik</a>
                            <a href="#" class="dropdown-item"><i class="fas fa-file-pdf"></i> SK Info Dikecualikan</a>
                        </div>
                    </a>
                </div>
            </li>

            <!-- MEDIA -->
            <li>
                <a href="#">Media <span class="arrow"><i class="fas fa-chevron-down"></i></span></a>
                <div class="dropdown">
                    <a href="{{ route('admin.health-profiles.index') }}" class="dropdown-item"><i class="fas fa-book-medical"></i> Profil Kesehatan</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-newspaper"></i> Media Kesehatan</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-scale-balanced"></i> Produk Hukum</a>
                </div>
            </li>

            <!-- INFORMASI -->
            <li>
                <a href="#">Informasi <span class="arrow"><i class="fas fa-chevron-down"></i></span></a>
                <div class="dropdown">
                    <a href="#" class="dropdown-item"><i class="fas fa-newspaper"></i> Artikel</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-megaphone"></i> Pengumuman</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-clipboard-check"></i> Standar Pelayanan</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-poll"></i> Indeks Kepuasan Masyarakat</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-chart-bar"></i> Survei Kepuasan Masyarakat</a>
                </div>
            </li>

            <!-- PENGADUAN -->
            <li>
                <a href="#">Pengaduan <span class="arrow"><i class="fas fa-chevron-down"></i></span></a>
                <div class="dropdown">
                    <a href="#" class="dropdown-item"><i class="fas fa-route"></i> Alur Pengaduan</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-headset"></i> Layanan Pengaduan</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-pen-alt"></i> Form Pengaduan</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-comment-alt"></i> Form Kritik & Saran</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-chart-line"></i> Rekap Pengaduan</a>
                </div>
            </li>
        </ul>

        <div class="nav-toggle" id="navToggle">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>

<!-- MOBILE NAV -->
<div class="mobile-overlay" id="mobileOverlay"></div>
<div class="mobile-nav" id="mobileNav">
    <button class="mobile-nav-close" id="mobileNavClose"><i class="fas fa-times"></i></button>
    <div style="margin-top:1rem;">
        <a href="#">🏠 Home</a>
        <div class="mobile-section-title">Profil</div>
        <a href="#">Struktur Organisasi</a>
        <a href="#">Tupoksi</a>
        <a href="#">Visi, Misi & Motto</a>
        <a href="#">Profil Pejabat Struktural</a>
        <div class="mobile-section-title">PPID</div>
        <a href="#">Daftar Informasi Publik</a>
        <a href="#">Informasi Berkala</a>
        <a href="#">Informasi Serta Merta</a>
        <a href="#">Permohonan Informasi</a>
        <a href="#">Alur Permohonan Informasi</a>
        <a href="#">SK PPID</a>
        <div class="mobile-section-title">Media</div>
        <a href="#">Profil Kesehatan</a>
        <a href="#">Media Kesehatan</a>
        <a href="#">Produk Hukum</a>
        <div class="mobile-section-title">Informasi</div>
        <a href="#">Artikel</a>
        <a href="#">Pengumuman</a>
        <a href="#">Standar Pelayanan</a>
        <div class="mobile-section-title">Pengaduan</div>
        <a href="#">Alur Pengaduan</a>
        <a href="#">Layanan Pengaduan</a>
        <a href="#">Form Pengaduan</a>
        <a href="#">Form Kritik & Saran</a>
    </div>
</div>

<!-- ============ HERO SLIDESHOW ============ -->
    {{-- LARAVEL INTEGRATION NOTE:
    Replace the three .slide blocks below with: --}}

    @php $heroImages = App\Models\Image::active()->hero()->ordered()->get(); @endphp

    @if($heroImages->isNotEmpty())
    @foreach($heroImages as $idx => $img)
    <div class="slide {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}">
        <div class="slide-img" style="background-image: url('{{ $img->image_url }}');"></div>
        <div class="slide-overlay"></div>
        <div class="slide-content">
            <div class="hero-badge"><i class="fas fa-circle"></i> Portal Resmi Dinas Kesehatan</div>
            <h1>{{ $img->title }}</h1>
            <p class="hero-sub">{{ $img->description }}</p>
            <div class="hero-actions">
                <a href="{{ route('admin.fasyankes.index') }}" class="btn-hero-primary"><i class="fas fa-hospital"></i> Lihat Fasyankes</a>
                <a href="{{ route('admin.fasyankes.maps') }}" class="btn-hero-outline"><i class="fas fa-map-marked-alt"></i> Peta Kesehatan</a>
            </div>
        </div>
    </div>
    @endforeach
@else
    <!-- Fallback: tidak ada gambar hero di database -->
    <div class="slide active">
        <div class="slide-img" style="background: linear-gradient(135deg, #061539, #0a2463);"></div>
        <div class="slide-overlay"></div>
        <div class="slide-content">
            <div class="hero-badge"><i class="fas fa-circle"></i> Portal Resmi Dinas Kesehatan</div>
            <h1>Layanan Kesehatan <em>Terbaik</em> untuk Masyarakat Kabupaten Semarang</h1>
            <p class="hero-sub">Informasi lengkap tentang fasilitas kesehatan dan layanan publik Dinas Kesehatan.</p>
            <div class="hero-actions">
                <a href="{{ route('admin.fasyankes.index') }}" class="btn-hero-primary"><i class="fas fa-hospital"></i> Lihat Fasyankes</a>
            </div>
        </div>
    </div>
@endif
<section class="hero" id="heroSlider">
    <!-- Prev / Next arrows -->
    <button class="slide-arrow slide-arrow-prev" onclick="changeSlide(-1)" aria-label="Slide sebelumnya">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="slide-arrow slide-arrow-next" onclick="changeSlide(1)" aria-label="Slide berikutnya">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Dot indicators (auto-generated by JS) -->
    <div class="slide-dots" id="slideDots">

    </div>

    <!-- Play / Pause -->
    <button class="slide-play-pause" id="slidePlayPause" onclick="toggleAutoplay()" aria-label="Pause/Play">
        <i class="fas fa-pause" id="playPauseIcon"></i>
    </button>

    <!-- Stats bar stays fixed at bottom -->
    <div class="hero-stats">
        <div class="hero-stats-inner">
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-hospital-alt"></i></div>
                <div></div><div class="hero-stat-value">{{ $stats['klinik'] }}</div></div>
                <div class="hero-stat-label">Klinik</div>
            </div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-hospital-alt"></i></div>
                <div></div><div class="hero-stat-value">{{ $stats['rumah sakit'] }}</div></div>
                <div class="hero-stat-label">Rumah Sakit</div></div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-clinic-medical"></i></div>
                <div>
                  <div class="hero-stat-value">{{ $stats['puskesmas'] }}</div>
                <div class="hero-stat-label">Puskesmas</div></div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-pills"></i></div>
                <div>
                  <div class="hero-stat-value">{{ $stats['apotek'] }}</div>
                  <div class="hero-stat-label">Apotek</div></div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-flask"></i></div>
                <div>
                   <div class="hero-stat-value">{{ $stats['laboratorium'] }}</div>
                  <div class="hero-stat-label">Laboratorium</div></div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-flask"></i></div>
                <div>
                   <div class="hero-stat-value">{{ $stats['tpmd'] }}</div>
                  <div class="hero-stat-label">TPMD</div></div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-flask"></i></div>
                <div>
                   <div class="hero-stat-value">{{ $stats['tpmdg'] }}</div>
                  <div class="hero-stat-label">TPMDG</div></div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-flask"></i></div>
                <div>
                   <div class="hero-stat-value">{{ $stats['tpmb'] }}</div>
                  <div class="hero-stat-label">TPMB</div></div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-flask"></i></div>
                <div>
                   <div class="hero-stat-value">{{ $stats['tpmp'] }}</div>
                  <div class="hero-stat-label">TPMP</div></div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-icon"><i class="fas fa-users"></i></div>
                <div>
                  <div class="hero-stat-value">1.6M</div>
                  <div class="hero-stat-label">Penduduk Dilayani</div></div>
            </div>
        </div>
    </div>
    
</section>

<!-- ============ QUICK ACCESS ============ -->
<section class="section" style="padding-top:3rem; padding-bottom:2rem;">
    <div class="container">
        <div class="quick-grid reveal">
            <a href="{{ route('admin.fasyankes.index') }}" class="quick-card"><div class="quick-card-icon"><i class="fas fa-hospital"></i></div><span>Fasilitas Kesehatan</span></a>
            <a href="#" class="quick-card"><div class="quick-card-icon"><i class="fas fa-map-marked-alt"></i></div><span>Peta Kesehatan</span></a>
            <a href="#" class="quick-card"><div class="quick-card-icon"><i class="fas fa-file-alt"></i></div><span>Informasi Publik</span></a>
            <a href="#" class="quick-card"><div class="quick-card-icon"><i class="fas fa-newspaper"></i></div><span>Berita Terkini</span></a>
            <a href="#" class="quick-card"><div class="quick-card-icon"><i class="fas fa-pen-alt"></i></div><span>Pengaduan</span></a>
            <a href="#" class="quick-card"><div class="quick-card-icon"><i class="fas fa-clipboard-list"></i></div><span>Permohonan Info</span></a>
            <a href="#" class="quick-card"><div class="quick-card-icon"><i class="fas fa-book-medical"></i></div><span>Profil Kesehatan</span></a>
            <a href="#" class="quick-card"><div class="quick-card-icon"><i class="fas fa-poll"></i></div><span>Survei Kepuasan</span></a>
        </div>
    </div>
</section>

<!-- ============ FASYANKES ============ -->
<section class="section section-alt" id="fasyankes">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-tag"><i class="fas fa-hospital"></i> Fasilitas Kesehatan</div>
            <h2>Daftar Fasilitas Kesehatan</h2>
            <p>Temukan fasilitas kesehatan terdekat di Kota Semarang dengan informasi lengkap dan lokasi peta.</p>
        </div>

        <div class="fasyankes-filter reveal">
            <button class="filter-btn active" onclick="filterFasyankes('all', this)">Semua</button>
            <button class="filter-btn" onclick="filterFasyankes('rumah_sakit', this)"><i class="fas fa-hospital-alt"></i> Rumah Sakit</button>
            <button class="filter-btn" onclick="filterFasyankes('puskesmas', this)"><i class="fas fa-clinic-medical"></i> Puskesmas</button>
            <button class="filter-btn" onclick="filterFasyankes('klinik', this)"><i class="fas fa-user-doctor"></i> Klinik</button>
            <button class="filter-btn" onclick="filterFasyankes('apotek', this)"><i class="fas fa-pills"></i> Apotek</button>
            <button class="filter-btn" onclick="filterFasyankes('laboratorium', this)"><i class="fas fa-flask"></i> Laboratorium</button>
        </div>

        <div class="fasyankes-grid reveal" id="fasyankesGrid">
              @foreach($fasyankes as $item)
                  <div class="fasyankes-card" data-type="{{ strtolower($item->klinik->nama) == 'rumah sakit' ? 'rumah_sakit' : strtolower($item->klinik->nama) }}">
                      <div class="card-header-strip strip-{{ strtolower($item->klinik->nama) == 'rumah sakit' ? 'rumah_sakit' : strtolower($item->klinik->nama) }}"></div>
                      <div class="card-body">
                          <div class="card-category cat-{{ strtolower($item->klinik->nama) == 'rumah sakit' ? 'rumah_sakit' : strtolower($item->klinik->nama) }}">
                              <i class="fas fa-hospital"></i> {{ $item->klinik->nama }}
                          </div>
                          <h3>{{ $item->nama }}</h3>
                          <div class="card-meta">
                              <div class="card-meta-item"><i class="fas fa-hashtag"></i> Kode: {{ $item->kode }}</div>
                              <div class="card-meta-item"><i class="fas fa-map-marker-alt"></i> {{ $item->alamat }}</div>
                          </div>
                      </div>
                      <div class="card-footer">
                          <a href="#">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                          @if($item->latitude && $item->longitude)
                          <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" target="_blank" class="map-btn">
                              <i class="fas fa-map-marker-alt"></i>
                          </a>
                          @endif
                      </div>
                  </div>
              @endforeach
        </div>
        <div class="load-more-wrap">
            @if($fasyankes->hasPages())
            <div style="text-align: center; margin-top: 2.5rem;">
                {{ $fasyankes->links('pagination.tailwind') }}
            </div>
            @endif
        </div>
    </div>
</section>
<!-- ============ FOOTER ============ -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <div class="footer-brand-logo"><i class="fas fa-hospital"></i></div>
                    <div class="footer-brand-text">
                        <h3>DINAS KESEHATAN</h3>
                        <span>Kabupaten Semarang</span>
                    </div>
                </div>
                <p>Dinas Kesehatan Kabupaten Semarang Selalu Mendampingi Kesehatan Anda dan Keluarga.</p>
                <div style="margin-top:1rem;">
                    <div class="footer-contact-item"><i class="fas fa-map-marker-alt"></i> Jl. MT. Hariyono No.29, Kuncen, Ungaran, Kec. Ungaran Barat., Kabupaten Semarang, Jawa Tengah 50511</div>
                    <div class="footer-contact-item"><i class="fas fa-phone"></i> (024) 6923955</div>
                    <div class="footer-contact-item"><i class="fas fa-envelope"></i> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="791d1017121c0a39091c1412160d570a1c14180b18171e571e1657101d">[email&#160;protected]</a></div>
                    <div class="footer-contact-item"><i class="fas fa-clock"></i> Senin–Kamis: 08:00–15:30<br> Jum'at: 08:00-11.30</div>
                </div>
            </div>

            <div>
                <h4>Profil & PPID</h4>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Struktur Organisasi</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Tupoksi</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Visi, Misi & Motto</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Informasi Publik</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Permohonan Informasi</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> SK PPID</a></li>
                </ul>
            </div>

            <div>
                <h4>Media & Info</h4>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Artikel</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Pengumuman</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Profil Kesehatan</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Produk Hukum</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Standar Pelayanan</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Survei Kepuasan</a></li>
                </ul>
            </div>

            <div>
                <h4>Pengaduan & Layanan</h4>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Alur Pengaduan</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Layanan Pengaduan</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Form Pengaduan</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Form Kritik & Saran</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Rekap Pengaduan</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; 2026 Dinas Kesehatan Kabupaten Semarang.</span>
            <div class="footer-socials">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</footer>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
// Nav scroll effect
window.addEventListener('scroll', () => {
    document.getElementById('navMain').classList.toggle('scrolled', window.scrollY > 40);
});

// Mobile nav
const navToggle = document.getElementById('navToggle');
const mobileNav = document.getElementById('mobileNav');
const mobileOverlay = document.getElementById('mobileOverlay');
const mobileNavClose = document.getElementById('mobileNavClose');

function openMobileNav() { mobileNav.classList.add('show'); mobileOverlay.classList.add('show'); }
function closeMobileNav() { mobileNav.classList.remove('show'); mobileOverlay.classList.remove('show'); }

navToggle.addEventListener('click', openMobileNav);
mobileNavClose.addEventListener('click', closeMobileNav);
mobileOverlay.addEventListener('click', closeMobileNav);

// Scroll reveal
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
}, { threshold: 0.12 });
reveals.forEach(el => observer.observe(el));

// Fasyankes filter
function filterFasyankes(type, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.fasyankes-card').forEach(card => {
        if (type === 'all' || card.dataset.type === type) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

// ============ HERO SLIDESHOW ENGINE ============
(function() {
    const slides   = document.querySelectorAll('.slide');
    const dotsWrap = document.getElementById('slideDots');
    let current    = 0;
    let total      = slides.length;
    let autoTimer  = null;
    let playing    = true;
    const INTERVAL = 5000;

    // build dots
    slides.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.className = 'slide-dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.addEventListener('click', () => goTo(i));
        dotsWrap.appendChild(dot);
    });

    function getDots() { return dotsWrap.querySelectorAll('.slide-dot'); }

    function goTo(idx) {
        slides[current].classList.remove('active');
        getDots()[current].classList.remove('active');
        current = (idx + total) % total;
        slides[current].classList.add('active');
        getDots()[current].classList.add('active');
    }

    window.changeSlide = function(dir) {
        goTo(current + dir);
        resetTimer();
    };

    function startTimer() {
        autoTimer = setInterval(() => goTo(current + 1), INTERVAL);
    }
    function resetTimer() {
        if (playing) { clearInterval(autoTimer); startTimer(); }
    }
    function stopTimer() { clearInterval(autoTimer); autoTimer = null; }

    window.toggleAutoplay = function() {
        playing = !playing;
        document.getElementById('playPauseIcon').className = playing ? 'fas fa-pause' : 'fas fa-play';
        playing ? startTimer() : stopTimer();
    };

    // kick off
    startTimer();

    // pause on hover
    const hero = document.getElementById('heroSlider');
    hero.addEventListener('mouseenter', () => { if (playing) stopTimer(); });
    hero.addEventListener('mouseleave', () => { if (playing) startTimer(); });
})();
</script>
</body>
</html>