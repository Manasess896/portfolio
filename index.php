<?php
$pageTitle = "Manases Kamau | MK website solutions ";

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
  <meta name="description" content="MK website solutions  We create custom websites, build powerful system automation tools, and automate social media workflows. Expert web development services tailored to transform and grow your business.">
  <meta name="author" content="Manases Kamau">
  <meta name="keywords" content="Web Developer, Custom Websites, System Automation, Social Media Automation, APIs, MK website solutions  Manases Kamau, Nairobi">
  <meta property="og:title" content="Manases Kamau | MK website solutions >
  <meta property="og:description" content="Custom websites, powerful automation tools, and social media workflow solutions. Transform your business with MK website solutions ">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://code-craft-website-solutions.onrender.com/">
  <meta property="og:image" content="https://code-craft-website-solutions.onrender.com/assets/images/mainimages/IMG-20241218-WA0011[1].jpg">
  <link rel="icon" href="/images/company_logo.png" type="image/jpeg">
  <title><?php echo $pageTitle; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/style.css">
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
        <li><a href="projects" class="nav-link px-3 text-dark">Work</a></li>
        <li><a href="contact-us" class="nav-link px-3 text-dark">Contact</a></li>
        <li><a href="assets/Manases_Kamau_CV.pdf" class="nav-link px-3 text-dark" download><span class="border-bottom border-secondary">Download CV</span></a></li>
      </ul>
    </header>

    <section class="py-5 mb-5 doc-section">
      <div class="row">
        <div class="col-lg-8">
          <h1 class="display-5 fw-normal mb-4 serif-font">Web Systems Developer</h1>
          <p class="lead mb-4">
            I build secure, scalable web systems.<br>
            APIs. Automation. Admin Panels. Infrastructure.
          </p>
          <div class="d-flex gap-3">
            <a href="projects" class="btn btn-outline-dark rounded-0 px-4">View All Work</a>
            <a href="contact-us" class="btn btn-link text-dark text-decoration-none px-0">Get in Touch &rarr;</a>
          </div>
        </div>
      </div>
    </section>

    <hr class="my-5 doc-divider">

    <section class="py-5 doc-section">
      <h2 class="mb-4 serif-font">Technical Stack</h2>
      <div class="row">
        <div class="col-md-6 mb-4">
          <h6 class="text-uppercase small fw-bold text-secondary ls-1 mb-3">Frontend & Backend</h6>
          <div>
            <span class="stack-badge">HTML5</span>
            <span class="stack-badge">CSS3</span>
            <span class="stack-badge">JavaScript</span>
            <span class="stack-badge">Bootstrap 5</span>
            <span class="stack-badge">PHP</span>
            <span class="stack-badge">Python</span>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <h6 class="text-uppercase small fw-bold text-secondary ls-1 mb-3">Database & Tools</h6>
          <div>
            <span class="stack-badge">MongoDB</span>
            <span class="stack-badge">MySQL</span>
            <span class="stack-badge">PostgreSQL</span>
            <span class="stack-badge">Git</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <h6 class="text-uppercase small fw-bold text-secondary ls-1 mb-3"> specialized Services</h6>
          <div class="d-flex flex-wrap gap-2">
            <span class="stack-badge">Web Development</span>
            <span class="stack-badge">Web Design</span>
            <span class="stack-badge">Automation</span>
            <span class="stack-badge">API Integration</span>
            <span class="stack-badge">SEO Optimization</span>
            <span class="stack-badge">Domain Configuration</span>
            <span class="stack-badge">Social Media Automation</span>
            <span class="stack-badge">Website Hosting</span>
          </div>
        </div>
      </div>
    </section>

    <hr class="my-5 doc-divider">

    <section id="work" class="py-5 doc-section">
      <div class="row mb-5 align-items-end">
        <div class="col-6">
          <h2 class="mb-0 serif-font">Selected Work</h2>
        </div>
        <div class="col-6 text-end">
          <a href="projects" class="small text-muted text-decoration-none">View Archive &rarr;</a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle custom-table">
          <thead class="light-th">
            <tr>
              <th scope="col" class="fw-normal text-secondary text-uppercase small ls-1" style="width: 40%;">Project</th>
              <th scope="col" class="fw-normal text-secondary text-uppercase small ls-1">Stack</th>
              <th scope="col" class="text-end fw-normal text-secondary text-uppercase small ls-1">Link</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="py-3">
                <span class="fw-bold d-block">Advanced AI WhatsApp Bot</span>
                <span class="small text-muted">Intelligent conversational agent</span>
              </td>
              <td><span class="small font-monospace text-muted">Flask / Groq API</span></td>
              <td class="text-end"><a href="projects" class="text-dark small">&rarr;</a></td>
            </tr>
            <tr>
              <td class="py-3">
                <span class="fw-bold d-block">Secure PHP Auth System</span>
                <span class="small text-muted">Enterprise-grade security template</span>
              </td>
              <td><span class="small font-monospace text-muted">PHP / MongoDB / 2FA</span></td>
              <td class="text-end"><a href="projects" class="text-dark small">&rarr;</a></td>
            </tr>
            <tr>
              <td class="py-3">
                <span class="fw-bold d-block">Bouquets by Lynn</span>
                <span class="small text-muted">E-commerce with Smart Links</span>
              </td>
              <td><span class="small font-monospace text-muted">PHP / Custom Admin</span></td>
              <td class="text-end"><a href="projects" class="text-dark small">&rarr;</a></td>
            </tr>
          </tbody>
        </table>
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
      <img src="images/company_logo.png" alt="Code Craft Logo" style="width: 24px; height: 24px; border-radius: 4px;">
      <span class="small fw-semibold text-uppercase ls-1">MK website solutions /span>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>