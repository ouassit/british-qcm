<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Placement Test Platform</title>
    <link href="{{ asset('css/bootstrap.min.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <style>
        :root {
            --ink: #12213a;
            --muted: #64748b;
            --line: #dbe5f1;
            --blue: #2563eb;
            --teal: #0f8276;
            --green: #16a34a;
            --orange: #d97706;
            --soft: #f5f9ff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--ink);
            background: #fff;
            font-family: Nunito, Arial, sans-serif;
        }

        a {
            text-decoration: none;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(10px);
        }

        .site-nav {
            width: min(1180px, calc(100% - 32px));
            min-height: 72px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--ink);
            font-weight: 800;
            font-size: 18px;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), var(--teal));
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.25);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .nav-link {
            color: #475569;
            font-weight: 700;
            padding: 10px 12px;
        }

        .btn-main,
        .btn-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            border-radius: 8px;
            padding: 0 18px;
            font-weight: 800;
        }

        .btn-main {
            color: #fff;
            background: var(--blue);
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.22);
        }

        .btn-soft {
            color: var(--blue);
            background: #eef4ff;
        }

        .hero {
            background: linear-gradient(135deg, #eef6ff 0%, #fff 52%, #edfdf8 100%);
            border-bottom: 1px solid var(--line);
        }

        .hero-inner {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 70px 0 48px;
            display: grid;
            grid-template-columns: minmax(0, 0.95fr) minmax(360px, 1.05fr);
            align-items: center;
            gap: 48px;
        }

        .eyebrow {
            margin: 0 0 12px;
            color: var(--teal);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0;
        }

        h1 {
            margin: 0;
            color: var(--ink);
            font-size: clamp(38px, 5vw, 66px);
            line-height: 1.02;
            font-weight: 800;
        }

        .hero-copy {
            max-width: 620px;
            margin: 20px 0 0;
            color: #475569;
            font-size: 19px;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        .hero-points {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 28px;
            max-width: 620px;
        }

        .hero-point {
            border-left: 4px solid var(--green);
            background: #fff;
            padding: 14px;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
        }

        .hero-point strong,
        .gallery-caption strong {
            display: block;
            font-weight: 800;
        }

        .hero-point span,
        .gallery-caption span {
            display: block;
            margin-top: 4px;
            color: var(--muted);
        }

        .screen-stack {
            position: relative;
            min-height: 430px;
        }

        .screen,
        .gallery-item {
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.16);
        }

        .screen {
            position: absolute;
        }

        .screen img,
        .gallery-item img {
            display: block;
            width: 100%;
            object-fit: cover;
            object-position: top left;
        }

        .screen img {
            height: 100%;
        }

        .screen-main {
            top: 0;
            right: 0;
            width: 92%;
            aspect-ratio: 2.18 / 1;
        }

        .screen-small {
            left: 0;
            bottom: 0;
            width: 62%;
            aspect-ratio: 2 / 1;
        }

        .section {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 64px 0;
        }

        .section-head {
            max-width: 720px;
            margin-bottom: 30px;
        }

        h2 {
            margin: 0;
            font-size: clamp(28px, 3.4vw, 42px);
            line-height: 1.15;
            font-weight: 800;
        }

        .section-head p,
        .feature p,
        .step p,
        .mode p,
        .cta-inner p {
            color: var(--muted);
            line-height: 1.65;
        }

        .section-head p {
            margin: 14px 0 0;
            font-size: 17px;
        }

        .feature-grid,
        .steps-grid,
        .modes-grid,
        .gallery {
            display: grid;
            gap: 16px;
        }

        .feature-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .steps-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .modes-grid,
        .gallery {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .feature,
        .step,
        .mode {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            padding: 24px;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.05);
        }

        .feature-icon,
        .step-number,
        .mode-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-bottom: 16px;
            font-weight: 800;
        }

        .feature-icon,
        .step-number {
            width: 42px;
            height: 42px;
        }

        .feature-icon {
            color: var(--blue);
            background: #eef4ff;
            font-size: 20px;
        }

        .step-number {
            color: #fff;
            background: var(--teal);
        }

        .mode-icon {
            width: 52px;
            height: 52px;
            color: #fff;
            background: var(--orange);
            font-size: 24px;
            flex: 0 0 auto;
        }

        .mode:nth-child(2) .mode-icon {
            background: var(--blue);
        }

        .feature h3,
        .step h3,
        .mode h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
        }

        .feature p,
        .step p,
        .mode p {
            margin: 10px 0 0;
        }

        .modes-band {
            background: var(--soft);
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        .mode {
            display: flex;
            gap: 18px;
            align-items: flex-start;
        }

        .gallery-item {
            margin: 0;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
        }

        .gallery-item img {
            aspect-ratio: 2.2 / 1;
        }

        .gallery-caption {
            padding: 16px 18px;
        }

        .cta-band {
            background: linear-gradient(135deg, var(--ink), var(--teal));
            color: #fff;
        }

        .cta-inner {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 54px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
        }

        .cta-inner h2 {
            color: #fff;
        }

        .cta-inner p {
            margin: 12px 0 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 17px;
        }

        .site-footer {
            padding: 26px 0;
            text-align: center;
            color: var(--muted);
            background: #fff;
        }

        @media (max-width: 920px) {
            .hero-inner,
            .feature-grid,
            .modes-grid,
            .steps-grid,
            .gallery {
                grid-template-columns: 1fr;
            }

            .screen-stack {
                min-height: auto;
                display: grid;
                gap: 14px;
            }

            .screen {
                position: static;
                width: 100%;
            }

            .hero-points {
                grid-template-columns: 1fr;
            }

            .cta-inner {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 620px) {
            .site-nav {
                align-items: flex-start;
                flex-direction: column;
                padding: 14px 0;
            }

            .nav-actions {
                justify-content: flex-start;
            }

            .hero-inner {
                padding-top: 44px;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <nav class="site-nav" aria-label="Main navigation">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark">PT</span>
                <span>Placement Test Platform</span>
            </a>
            <div class="nav-actions">
                <a class="nav-link" href="#features">Features</a>
                <a class="nav-link" href="#how-it-works">How it works</a>
                @auth
                    <a class="btn-soft" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a class="btn-soft" href="{{ route('login') }}">Login</a>
                    <a class="btn-main" href="{{ route('register') }}">Create account</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-inner">
                <div>
                    <p class="eyebrow">Placement test management</p>
                    <h1>Run English placement tests in center or at distance.</h1>
                    <p class="hero-copy">
                        Create categories, build tests, assign access codes, follow progress, and export student results from one clear dashboard.
                    </p>
                    <div class="hero-actions">
                        <a class="btn-main" href="{{ route('register') }}">Start with a demo account</a>
                        <a class="btn-soft" href="{{ route('login') }}">Access dashboard</a>
                    </div>
                    <div class="hero-points">
                        <div class="hero-point">
                            <strong>On site</strong>
                            <span>Give students a tablet or computer and start tests at your center.</span>
                        </div>
                        <div class="hero-point">
                            <strong>Remote</strong>
                            <span>Share an access code so candidates can complete the placement test online.</span>
                        </div>
                        <div class="hero-point">
                            <strong>Fast setup</strong>
                            <span>New accounts include demo categories, a demo test, and sample questions.</span>
                        </div>
                    </div>
                </div>

                <div class="screen-stack" aria-label="Product screenshots">
                    <div class="screen screen-main">
                        <img src="{{ asset('images/1.png') }}?v={{ time() }}" alt="Placement Test Platform dashboard">
                    </div>
                    <div class="screen screen-small">
                        <img src="{{ asset('images/4.png') }}?v={{ time() }}" alt="Students tests management screen">
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="features">
            <div class="section-head">
                <h2>Everything a center needs to manage placement tests.</h2>
                <p>Keep the test bank organized, assign tests quickly, and use results to place students in the right level.</p>
            </div>
            <div class="feature-grid">
                <article class="feature">
                    <span class="feature-icon">C</span>
                    <h3>Question categories</h3>
                    <p>Organize your bank by skills such as Grammar, Listening, Reading, or any structure your school uses.</p>
                </article>
                <article class="feature">
                    <span class="feature-icon">T</span>
                    <h3>Custom tests</h3>
                    <p>Create timed placement tests, connect questions, and control the content students receive.</p>
                </article>
                <article class="feature">
                    <span class="feature-icon">R</span>
                    <h3>Results tracking</h3>
                    <p>Follow completed, active, and assigned tests, then print or export results when needed.</p>
                </article>
            </div>
        </section>

        <section class="modes-band">
            <div class="section">
                <div class="section-head">
                    <h2>Use it in place or at distance.</h2>
                    <p>The same workflow supports students in your center and candidates testing remotely before they arrive.</p>
                </div>
                <div class="modes-grid">
                    <article class="mode">
                        <span class="mode-icon">1</span>
                        <div>
                            <h3>In-place placement tests</h3>
                            <p>Register the student at reception, start the test on a shared device, and review the score as soon as they finish.</p>
                        </div>
                    </article>
                    <article class="mode">
                        <span class="mode-icon">2</span>
                        <div>
                            <h3>Distance placement tests</h3>
                            <p>Create a student test, send the access code, and let the candidate complete the test from home.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="how-it-works">
            <div class="section-head">
                <h2>How it works.</h2>
                <p>New clients can start from the demo content, then adapt the question bank to their own placement process.</p>
            </div>
            <div class="steps-grid">
                <article class="step">
                    <span class="step-number">1</span>
                    <h3>Create account</h3>
                    <p>Sign up and get demo Grammar and Listening categories with sample questions.</p>
                </article>
                <article class="step">
                    <span class="step-number">2</span>
                    <h3>Build tests</h3>
                    <p>Edit the demo test or create your own tests with the duration and questions you need.</p>
                </article>
                <article class="step">
                    <span class="step-number">3</span>
                    <h3>Assign students</h3>
                    <p>Create one or many student tests and share the generated access codes.</p>
                </article>
                <article class="step">
                    <span class="step-number">4</span>
                    <h3>Review results</h3>
                    <p>Monitor progress from the dashboard and export results for your team.</p>
                </article>
            </div>
        </section>

        <section class="section">
            <div class="section-head">
                <h2>Dashboard screens.</h2>
                <p>Your screenshots show the real management areas a new client will use every day.</p>
            </div>
            <div class="gallery">
                <figure class="gallery-item">
                    <img src="{{ asset('images/1.png') }}?v={{ time() }}" alt="Dashboard overview">
                    <figcaption class="gallery-caption">
                        <strong>Dashboard overview</strong>
                        <span>Track assigned tests, completion rate, average score, and content volume.</span>
                    </figcaption>
                </figure>
                <figure class="gallery-item">
                    <img src="{{ asset('images/2.png') }}?v={{ time() }}" alt="Categories management">
                    <figcaption class="gallery-caption">
                        <strong>Categories</strong>
                        <span>Group questions by skills and keep the test bank clean.</span>
                    </figcaption>
                </figure>
                <figure class="gallery-item">
                    <img src="{{ asset('images/3.png') }}?v={{ time() }}" alt="Questions management">
                    <figcaption class="gallery-caption">
                        <strong>Questions</strong>
                        <span>Create questions, choices, correct answers, and test filters.</span>
                    </figcaption>
                </figure>
                <figure class="gallery-item">
                    <img src="{{ asset('images/4.png') }}?v={{ time() }}" alt="Students tests management">
                    <figcaption class="gallery-caption">
                        <strong>Students tests</strong>
                        <span>Search, assign, print, export, and manage student placement attempts.</span>
                    </figcaption>
                </figure>
            </div>
        </section>

        <section class="cta-band">
            <div class="cta-inner">
                <div>
                    <h2>Start with ready-made demo content.</h2>
                    <p>Create your account and explore the dashboard with sample categories, a demo test, and demo questions already loaded.</p>
                </div>
                <a class="btn-main" href="{{ route('register') }}">Create account</a>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        Placement Test Platform
    </footer>
</body>
</html>
