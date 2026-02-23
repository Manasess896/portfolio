<?php
$pageTitle = "Contact | Manases Kamau";

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Function to get real user IP address
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

// Function to log visitor data to MongoDB
function logVisitorToMongoDB() {
    try {
        $url = $_ENV['MONGODB_URI'] ?? getenv('MONGODB_URI');
        $mydatabase = $_ENV['MONGODB_DATABASE'] ?? getenv('MONGODB_DATABASE');
        
        if (empty($url) || empty($mydatabase)) {
            error_log('MongoDB configuration not found in environment variables');
            return;
        }

        // Create MongoDB client
        $client = new Client($url);
        $collection = $client->selectCollection($mydatabase, 'dev-logs');
        
        // Prepare visitor data
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
        
        // Insert into MongoDB
        $collection->insertOne($visitorData);
        
    } catch (Exception $e) {
        // Silently fail to not disrupt user experience
        error_log('MongoDB logging error: ' . $e->getMessage());
    }
}

// Log the visitor
logVisitorToMongoDB();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Contact Manases Kamau at MK website solutions  Let's discuss your next web system, API integration, or automation project.">
  <meta name="author" content="Manases Kamau">
  <meta name="keywords" content="Contact Web Developer, Hire Backend Developer, Kenya Web Design, Code Craft Contact">
  <meta property="og:title" content="Contact | Manases Kamau">
  <meta property="og:description" content="Get in touch for professional web development and system automation services.">
  <meta property="og:url" content="https://code-craft-website-solutions.onrender.com/contact-us">
  <link rel="icon" href="/images/company_logo.jpg" type="image/jpeg">
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
          <span class="small text-muted text-uppercase ls-1">MK website solutions /span>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="home" class="nav-link px-3 text-dark">Home</a></li>
        <li><a href="projects" class="nav-link px-3 text-dark">Projects</a></li>
      </ul>
    </header>

    <section class="py-5 doc-section">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h1 class="mb-4 serif-font">Get in Touch</h1>
          <p class="lead mb-5">Ready to build secure, scalable systems? Send a message.</p>

          <form id="contactForm" action="https://formspree.io/f/moqgpbjg" method="POST" class="needs-validation" novalidate>
            <div class="mb-4">
              <label for="name" class="form-label text-uppercase small ls-1 fw-bold text-secondary">Name</label>
              <input type="text" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 border-bottom bg-transparent px-0" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="mb-4">
              <label for="email" class="form-label text-uppercase small ls-1 fw-bold text-secondary">Email</label>
              <input type="email" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 border-bottom bg-transparent px-0" id="email" name="email" placeholder="name@example.com" required>
            </div>

            <div class="mb-5">
              <label for="message" class="form-label text-uppercase small ls-1 fw-bold text-secondary">Message</label>
              <textarea class="form-control rounded-0 border-top-0 border-start-0 border-end-0 border-bottom bg-transparent px-0" id="message" name="message" style="height: 150px" placeholder="Tell me about your project..." required></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <button type="submit" class="btn btn-dark rounded-0 px-5 py-2 text-uppercase ls-1" style="font-size: 0.8rem;">Send Message</button>

              <div class="contact-links small">
                <a href="mailto:contact@manases.infohub18.tech" class="text-decoration-none text-secondary me-3">Email</a>
                <a href="https://wa.me/+254106159887" class="text-decoration-none text-secondary">WhatsApp</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>

    <hr class="my-5 doc-divider">

    <section class="py-4 text-center">
      <div class="mb-3">
        <a href="https://wa.me/+254114471302" class="text-secondary mx-2 fs-5" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="https://www.instagram.com/manases___/" class="text-secondary mx-2 fs-5" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="mailto:manasesskamau1053@gmail.com" class="text-secondary mx-2 fs-5"><i class="fas fa-envelope"></i></a>
        <a href="https://www.linkedin.com/in/manases-kamau-5a6837294?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" class="text-secondary mx-2 fs-5" target="_blank"><i class="fab fa-linkedin"></i></a>
        <a href="https://github.com/Manasess896/" class="text-secondary mx-2 fs-5" target="_blank"><i class="fab fa-github"></i></a>
      </div>
      <p class="small text-muted">&copy; <?php echo date("Y"); ?> Manases Kamau / MK website solutions </p>
    </section>
    <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
      <img src="images/company_logo.jpg" alt="Code Craft Logo" style="width: 24px; height: 24px; border-radius: 4px;">
      <span class="small fw-semibold text-uppercase ls-1">MK website solutions /span>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  
    (function() {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>

</body>

</html>