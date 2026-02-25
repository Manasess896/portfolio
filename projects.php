<?php
$pageTitle = "Projects | Manases Kamau";

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

function getUserIP() {
    $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
}

function logVisitorToMongoDB() {
    try {
        $url = $_ENV['MONGODB_URI'] ?? getenv('MONGODB_URI');
        $mydatabase = $_ENV['MONGODB_DATABASE'] ?? getenv('MONGODB_DATABASE');
        
        if (empty($url) || empty($mydatabase)) {
            error_log('MongoDB configuration not found in environment variables');
            return;
        }

        $client = new Client($url);
        $collection = $client->selectCollection($mydatabase, 'dev-logs');
        
        $visitorData = [
            'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
            'full_url' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? ''),
            'ip_address' => getUserIP(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'device_info' => [
                'browser' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
                'platform' => php_uname('s') ?? 'Unknown',
                'accept_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Unknown',
            ],
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct',
            'timestamp' => new MongoDB\BSON\UTCDateTime(),
            'server_name' => $_SERVER['SERVER_NAME'] ?? 'Unknown',
            'query_string' => $_SERVER['QUERY_STRING'] ?? '',
            'http_host' => $_SERVER['HTTP_HOST'] ?? 'Unknown',
            'remote_port' => $_SERVER['REMOTE_PORT'] ?? 'Unknown',
        ];
        
        $collection->insertOne($visitorData);
        
    } catch (Exception $e) {
    
        error_log('MongoDB logging error: ' . $e->getMessage());
    }
}

logVisitorToMongoDB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse the portfolio of MK Website Solutions. Featuring Full Stack projects, efficient automation tools, AI-powered WhatsApp bots, secure authentication systems, and custom e-commerce platforms. See how we solve complex problems.">
    <meta name="author" content="Manases Kamau">
    <meta name="keywords" content="Web Development Portfolio, Full Stack Projects, Automation Tools, AI Bots, WhatsApp Bot, PHP Authentication, Python Automation, Custom E-commerce, API Integration Examples, Software Development Projects, MK Website Solutions">
    <meta property="og:title" content="Project Portfolio | Full Stack & Automation Projects | MK Website Solutions">
    <meta property="og:description" content="Explore a curated list of technical projects: Custom Websites, Social Media Automation, AI Chatbots, and Secure Web Platforms built by Manases Kamau.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mk-website-solutions.onrender.com/projects">
    <link rel="icon" href="/images/company_logo.png" type="image/jpeg">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container main-document">
        <header class="d-flex flex-wrap justify-content-between align-items-center py-4 mb-5 border-bottom">
            <div class="col-md-6 mb-2 mb-md-0">
                <a href="/" class="d-inline-flex flex-column link-body-emphasis text-decoration-none">
                    <span class="fs-4 fw-bold text-uppercase name-brand">Manases Kamau</span>
                    <span class="small text-muted text-uppercase ls-1">MK website solutions </span>
                </a>
            </div>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="home" class="nav-link px-3 text-dark">Home</a></li>
                <li><a href="contact-us" class="nav-link px-3 text-dark">Contact</a></li>
            </ul>
        </header>
        <div id="project-display-area" style="display: none;">
             <button class="btn btn-sm btn-outline-secondary mb-3 rounded-0" onclick="closeProjectView()">&larr; Back into List</button>
             <div id="project-content">
             </div>
        </div>

        <section id="projects-list-section" class="py-5 doc-section">
            <h1 class="mb-5 serif-font">Complete Project Archive</h1>
            
            <p class="lead mb-5">A detailed collection of systems, automation tools, and web platforms built for performance.</p>
            <div class="row mb-5 project-item">
                <div class="col-md-9 border-start ps-4">
                    <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('whatsapp-bot'); return false;">
                        <h3 class="h4 hover-underline">Advanced AI WhatsApp Bot</h3>
                    </a>
                    <p class="text-secondary small text-uppercase mb-2">Flask · Groq API · MongoDB</p>
                    <p class="mb-3">A context-aware WhatsApp bot powered by Groq's LLaMA models. Features intelligent conversations.</p>
                     <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('whatsapp-bot'); return false;">View Details</a>
                        <a href="https://wa.me/+254106159887" class="text-dark text-decoration-underline small me-3">Try Bot</a>
                    </div>
                </div>
            </div>
            <div class="row mb-5 project-item">
                <div class="col-md-9 border-start ps-4">
                     <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('php-auth'); return false;">
                        <h3 class="h4 hover-underline">Secure PHP Auth System</h3>
                    </a>
                    <p class="text-secondary small text-uppercase mb-2">PHP · MongoDB · 2FA/TOTP</p>
                    <p class="mb-3">A secure, modular authentication template featuring PHPMailer, TOTP-based 2FA, Google reCAPTCHA.</p>
                     <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('php-auth'); return false;">View Details</a>
                        <a href="https://github.com/Manasess896/PHP-AUTHENTICATON-SYSTEM" class="text-dark text-decoration-underline small">View Code</a>
                    </div>
                </div>
            </div>
            <div class="row mb-5 project-item">
                <div class="col-md-9 border-start ps-4">
                    <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('bouquets'); return false;">
                        <h3 class="h4 hover-underline">Bouquets by Lynn</h3>
                    </a>
                    <p class="text-secondary small text-uppercase mb-2">E-commerce · Smart Links</p>
                    <p class="mb-3">Custom e-commerce solution with admin panel and WhatsApp ordering integration.</p>
                     <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('bouquets'); return false;">View Details</a>
                         <a href="https://bouquetsbylynn.onrender.com" class="text-dark text-decoration-underline small me-3">View Live</a>
                    </div>
                </div>
            </div>
            <div class="row mb-5 project-item">
                <div class="col-md-9 border-start ps-4">
                     <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('just-share'); return false;">
                        <h3 class="h4 hover-underline">Just Share</h3>
                    </a>
                    <p class="text-secondary small text-uppercase mb-2">Secure File Sharing</p>
                    <p class="mb-3">Public/private file upload platform with unique passcode ownership rights.</p>
                     <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('just-share'); return false;">View Details</a>
                         <a href="https://just-share-arac.onrender.com/" class="text-dark text-decoration-underline small me-3">View Live</a>
                    </div>
                </div>
            </div>
            <div class="row mb-5 project-item">
                <div class="col-md-9 border-start ps-4">
                    <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('watchlist'); return false;">
                        <h3 class="h4 hover-underline">Watchlist</h3>
                    </a>
                    <p class="text-secondary small text-uppercase mb-2">Media Tracking · Google OAuth · TMDB API</p>
                    <p class="mb-3">Comprehensive media tracking application allowing users to track movies/TV shows using TMDB/IMDB data and Google OAuth.</p>
                     <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('watchlist'); return false;">View Details</a>
                         <a href="https://watchlist-tv-39458b9629cc.herokuapp.com/contact-us" class="text-dark text-decoration-underline small me-3">View Live</a>
                    </div>
                </div>
            </div>
            <div class="row mb-5 project-item">
                <div class="col-md-9 border-start ps-4">
                    <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('tmdb-explorer'); return false;">
                        <h3 class="h4 hover-underline">TMDB Explorer</h3>
                    </a>
                    <p class="text-secondary small text-uppercase mb-2">PHP · API Integration · Data Presentation</p>
                    <p class="mb-3">A PHP web app that consumes The Movie Database (TMDB) API to display movies, series, and actor details.</p>
                     <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('tmdb-explorer'); return false;">View Details</a>
                         <a href="https://tmdb-explorer-7dc5031211d9.herokuapp.com/" class="text-dark text-decoration-underline small me-3">View Live</a>
                    </div>
                </div>
            </div>
             <div class="row mb-5 project-item">
                 <div class="col-md-9 border-start ps-4">
                    <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('whatsapp-otp'); return false;">
                        <h3 class="h4 hover-underline">WhatsApp OTP System</h3>
                    </a>
                     <p class="text-secondary small text-uppercase mb-2">Meta API · PHP</p>
                     <p class="mb-3">Direct implementation of Meta's WhatsApp Business API for sending One-Time Passwords, replacing expensive SMS gateways.</p>
                      <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('whatsapp-otp'); return false;">View Details</a>
                         <a href="https://github.com/Manasess896/otp-verification-using-whatsapp" class="text-dark text-decoration-underline small">View Code</a>
                    </div>
                 </div>
             </div>
             <div class="row mb-5 project-item">
                 <div class="col-md-9 border-start ps-4">
                     <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('x-bot'); return false;">
                        <h3 class="h4 hover-underline">X-Bot (Twitter Automation)</h3>
                    </a>
                      <p class="text-secondary small text-uppercase mb-2">Python · Automation · APIs</p>
                     <p class="mb-3">A multifunctional Twitter bot that posts weather updates, recipes, movie details, and trivia automatically.</p>
                      <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('x-bot'); return false;">View Details</a>
                         <a href="https://github.com/Manasess896/X-bot" class="text-dark text-decoration-underline small">View Code</a>
                    </div>
                 </div>
             </div>
             <div class="row mb-5 project-item">
                 <div class="col-md-9 border-start ps-4">
                     <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('weather'); return false;">
                        <h3 class="h4 hover-underline">WeatherVoyager</h3>
                    </a>
                     <p class="text-secondary small text-uppercase mb-2">Algorithms · Weather Data</p>
                     <p class="mb-3">Web app analyzing weather to recommend travel destinations based on user preferences.</p>
                      <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('weather'); return false;">View Details</a>
                        <a href="https://weather1-0.onrender.com/" class="text-dark text-decoration-underline small me-3">View Live</a>
                    </div>
                 </div>
             </div>
             <div class="row mb-5 project-item">
                 <div class="col-md-9 border-start ps-4">
                     <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('lime-vtc'); return false;">
                        <h3 class="h4 hover-underline">LIME VTC Platform</h3>
                    </a>
                     <p class="text-secondary small text-uppercase mb-2">TruckersMP API · PHP · Admin Panel</p>
                     <p class="mb-3">Comprehensive Virtual Trucking Company site with VTC Gallery, member info fetching via TruckersMP API, and internal admin communication.</p>
                      <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('lime-vtc'); return false;">View Details</a>
                        <a href="https://lime-g8zh.onrender.com" class="text-dark text-decoration-underline small me-3">View Live</a>
                    </div>
                 </div>
             </div>
             <div class="row mb-5 project-item">
                 <div class="col-md-9 border-start ps-4">
                     <a href="#" class="text-decoration-none text-dark" onclick="loadProjectDetail('school-template'); return false;">
                        <h3 class="h4 hover-underline">School Website Template</h3>
                    </a>
                     <p class="text-secondary small text-uppercase mb-2">PHP 8.2 · MongoDB · Security</p>
                     <p class="mb-3">A secure school website featuring GridFS for media, TOTP 2FA for admins, and PHPMailer SMTP integration.</p>
                      <div>
                        <a href="#" class="text-dark text-decoration-underline small me-3" onclick="loadProjectDetail('school-template'); return false;">View Details</a>
                        <a href="https://school-website-template-18iy.onrender.com" class="text-dark text-decoration-underline small me-3">View Live</a>
                    </div>
                 </div>
             </div>

        </section>

        <section id="view-more-list" class="py-5 border-top d-none">
            <h5 class="serif-font mb-4 text-muted">More Projects</h5>
            <div class="row" id="mini-project-list">
            </div>
        </section>


        <hr class="my-5 doc-divider">

         <section class="py-4 text-center">
            
            <div class="profile-socials mb-4 d-flex justify-content-center gap-4">
                <a href="https://wa.me/+254114471302" class="text-dark hover-opacity" aria-label="WhatsApp" target="_blank">
                    <i class="fab fa-whatsapp fa-lg"></i>
                </a>
                <a href="https://www.instagram.com/manases___/" class="text-dark hover-opacity" aria-label="Instagram" target="_blank">
                    <i class="fab fa-instagram fa-lg"></i>
                </a>
                <a href="mailto:manasesskamau1053@gmail.com" class="text-dark hover-opacity" aria-label="Email">
                    <i class="fas fa-envelope fa-lg"></i>
                </a>
                <a href="https://github.com/Manasess896/" class="text-dark hover-opacity" aria-label="GitHub" target="_blank">
                    <i class="fab fa-github fa-lg"></i>
                </a>
                <a href="https://www.linkedin.com/in/manases-kamau-5a6837294?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" class="text-dark hover-opacity" aria-label="LinkedIn" target="_blank">
                    <i class="fab fa-linkedin fa-lg"></i>
                </a>
            </div>

            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                <img src="images/company_logo.png" alt="MK Website Solutions Logo" style="width: 24px; height: 24px; border-radius: 4px;">
                <span class="small fw-semibold text-uppercase ls-1">MK website solutions </span>
            </div>
            
            <p class="small text-muted mb-0">&copy; <?php echo date("Y"); ?> Manases Kamau. All rights reserved.</p>
        </section>
    </div>
    <script>
        const projectsData = {
            'whatsapp-bot': {
                title: "Advanced AI WhatsApp Bot",
                stack: "Flask · Groq API · MongoDB Compass",
                desc: "A WhatsApp bot powered by Groq's high-performance LLaMA models and OpenAI. Features context-aware intelligent conversations utilizing persistent memory (MongoDB) to remember user history, smart memory management, and automatic location detection.",
                techFocus: "Built with Flask, employing webhooks for real-time messaging. Uses MongoDB Compass for storing conversation integers to enable 'memory' of past interactions. Includes graceful fallback handling and configurable message history limits.",
                links: [
                    {text: "Try Bot", url: "https://wa.me/+254106159887"},
                    {text: "View Code", url: "https://github.com/Manasess896/advanced-ai-whatsapp-bot"}
                ],
                iframe: null 
            },
            'php-auth': {
                title: "Secure PHP Account Management",
                stack: "PHP · MongoDB · 2FA/TOTP · PHPMailer",
                desc: "A modular authentication system optimized for non-framework PHP environments. Features secure hashing, Google reCAPTCHA v2, CSRF protection, and Two-Factor Authentication (TOTP).",
                techFocus: "Production-ready security architecture implementing session hardening, HTTP-only cookies, and secure user verification flows.",
                links: [
                    {text: "View Code", url: "https://github.com/Manasess896/PHP-AUTHENTICATON-SYSTEM"}
                ],
                 iframe: null 
            },
             'bouquets': {
                title: "Bouquets by Lynn",
                stack: "PHP · reCAPTCHA · Smart Links",
                desc: "Custom e-commerce solution with a dedicated admin panel. Uses reCAPTCHA for form security and HTTP-only cookies for session management. Features 'Smart Links' for direct WhatsApp ordering.",
                techFocus: "Integration of security best practices (reCAPTCHA, Secure Cookies) in a custom PHP application.",
                links: [
                    {text: "View Live", url: "https://bouquetsbylynn.onrender.com"},
                    {text: "View Code", url: "https://github.com/Manasess896/Bouquetsbylynn"}
                ],
                 iframe: "https://bouquetsbylynn.onrender.com"
            },
            'just-share': {
                title: "Just Share",
                stack: "PHP · MongoDB · Crypto Libraries",
                desc: "Anonymous file sharing platform. Users upload files publicly (deletion code provided) or privately (opening pass-code + deletion code provided). No account creation required.",
                techFocus: "Utilizes MongoDB for metadata and custom PHP logic for verified content deletion. Libraries: vlucas/phpdotenv, setasign/fpdi.",
                links: [
                      {text: "View Live", url: "https://just-share-arac.onrender.com/"}
                ],
                 iframe: "https://just-share-arac.onrender.com/"
            },
             'watchlist': {
                title: "Watchlist",
                stack: "TMDB API · Google Sign-In · Security",
                desc: "Comprehensive media tracking app using both email/password hashing and Google Account linking. Features reCAPTCHA security and detailed movie/TV data via TMDB.",
                techFocus: "Complex authentication implementation merging OAuth social login with traditional hashed password accounts.",
                links: [
                     {text: "View Live", url: "https://watchlist-tv-39458b9629cc.herokuapp.com/contact-us"}
                ],
                 iframe: "https://watchlist-tv-39458b9629cc.herokuapp.com/contact-us"
            },
            'tmdb-explorer': {
                title: "TMDB Explorer",
                stack: "PHP · TMDB API · Data",
                desc: "A PHP web application consuming the TMDB API to display movies, series, and actor details with search functionality.",
                techFocus: "Robust API consumption and dynamic data rendering in a user-friendly interface.",
                links: [
                     {text: "View Live", url: "https://tmdb-explorer-7dc5031211d9.herokuapp.com/"}
                ],
                 iframe: "https://tmdb-explorer-7dc5031211d9.herokuapp.com/"
            },
             'whatsapp-otp': {
                title: "WhatsApp OTP System",
                stack: "Meta API · PHP · Security",
                desc: "Direct implementation of Meta's WhatsApp Business API for sending One-Time Passwords, replacing expensive SMS gateways. Uses MongoDB for persistence.",
                techFocus: "Secure user verification flow design and API authentication handshake.",
                links: [
                     {text: "View Code", url: "https://github.com/Manasess896/otp-verification-using-whatsapp"}
                ],
                 iframe: null
            },
             'x-bot': {
                title: "X-Bot (Twitter Automation)",
                stack: "Python · Flask · Twitter API · Automation",
                desc: "A multifunctional bot using Twitter API, OpenExchangeRates, MeteoSource, OMDB/TMDB. Posts daily weather/currency updates, recipes, movie details, and trivia.",
                techFocus: "Integration of 5+ different external APIs into a coherent scheduled automation workflow.",
                links: [
                     {text: "View Code", url: "https://github.com/Manasess896/X-bot"}
                ],
                 iframe: null
            },
             'weather': {
                title: "WeatherVoyager",
                stack: "PHP · HTML/CSS · Weather APIs",
                desc: "Sophisticated web application designed to help travelers discover destinations with ideal weather conditions by integrating real-time weather APIs.",
                techFocus: "Strong frontend design and accurate recommendation algorithms based on live data.",
                links: [
                     {text: "View Live", url: "https://weather1-0.onrender.com/"}
                ],
                 iframe: "https://weather1-0.onrender.com/" 
            },
            'lime-vtc': {
                title: "LIME VTC Platform",
                stack: "PHP · TruckersMP API · Admin Panel",
                desc: "A full VTC (Virtual Trucking Company) website for ETS2/ATS. Fetches VTC info/members via TruckersMP API. Includes an admin panel for member management.",
                techFocus: "External game API integration and custom internal administration dashboard.",
                links: [
                     {text: "View Live", url: "https://lime-g8zh.onrender.com"},
                     {text: "View Code", url: "https://github.com/Manasess896/LIME"}
                ],
                 iframe: "https://lime-g8zh.onrender.com" 
            },
            'school-template': {
                title: "School Website Template",
                stack: "PHP 8.2 · MongoDB GridFS · PHPMailer",
                desc: "Secure school website with public pages and admin dashboard. Features MongoDB GridFS for media, TOTP 2FA, reCAPTCHA, and Docker support.",
                techFocus: "Advanced PHP architecture using Composer, Dotenv, and MongoDB GridFS for efficient media streaming.",
                links: [
                     {text: "View Live", url: "https://school-website-template-18iy.onrender.com"},
                     {text: "View Code", url: "https://github.com/Manasess896/school-website-template"}
                ],
                 iframe: "https://school-website-template-18iy.onrender.com" 
            }
        };

        function loadProjectDetail(projectId) {
            const project = projectsData[projectId];
            if(!project) return;
            document.getElementById('projects-list-section').style.display = 'none';
            document.getElementById('project-display-area').style.display = 'block';
            document.getElementById('view-more-list').classList.remove('d-none');
            let html = `
                <h2 class="mb-2 serif-font">${project.title}</h2>
                <p class="text-secondary text-uppercase small ls-1 mb-4">${project.stack}</p>
                <div class="row">
                    <div class="col-md-7">
                         <p class="lead mb-4">${project.desc}</p>
                         <div class="bg-light p-4 border mb-4">
                            <h6 class="fw-bold small text-uppercase mb-2">Technical Focus</h6>
                            <p class="small text-secondary mb-0">${project.techFocus}</p>
                         </div>
                         <div class="d-flex gap-3 mb-4">
                            ${project.links.map(link => `<a href="${link.url}" target="_blank" class="btn btn-dark rounded-0 btn-sm px-4">${link.text}</a>`).join('')}
                         </div>
                    </div>
                    <div class="col-md-5">
                        ${project.iframe ? 
                            `<div class="border p-1 bg-white shadow-sm" style="height: 400px;">
                                <iframe src="${project.iframe}" style="width:100%; height:100%; border:none;" title="Project Preview"></iframe>
                                <div class="text-center bg-light list-group-item small py-1 text-muted">Live Preview</div>
                             </div>` 
                            : 
                            `<div class="h-100 d-flex align-items-center justify-content-center bg-light border text-muted p-5 text-center">
                                <div>
                                    <i class="fas fa-code fa-3x mb-3 opacity-25"></i>
                                    <p>Live preview not available for this system type ( Backend / Bot / Auth).</p>
                                </div>
                             </div>`
                        }
                    </div>
                </div>
            `;
            document.getElementById('project-content').innerHTML = html;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            const miniList = document.getElementById('mini-project-list');
            miniList.innerHTML = '';
            
            for (const [key, p] of Object.entries(projectsData)) {
                if(key !== projectId) {
                    miniList.innerHTML += `
                        <div class="col-md-3 mb-3">
                             <a href="#" onclick="loadProjectDetail('${key}'); return false;" class="text-decoration-none text-dark d-block border p-3 h-100 hover-shadow transition">
                                <h6 class="mb-1 small fw-bold">${p.title}</h6>
                                <span class="text-muted" style="font-size: 0.75rem;">View Details &rarr;</span>
                             </a>
                        </div>
                    `;
                }
            }
        }

        function closeProjectView() {
             document.getElementById('projects-list-section').style.display = 'block';
             document.getElementById('project-display-area').style.display = 'none';
             document.getElementById('view-more-list').classList.add('d-none');
              window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
