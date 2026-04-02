<?php
require_once 'session_setup.php';

use MongoDB\BSON\UTCDateTime;

function slugify($text, string $divider = '-')
{
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, $divider);
    $text = preg_replace('~-+~', $divider, $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}



try {
    $db = getAdminDb();

    $totalCount     = $db->blogs->countDocuments([]);
    $publishedCount = $db->blogs->countDocuments(['status' => 'published']);

    $debugInfo['total_docs_in_blogs']     = $totalCount;
    $debugInfo['published_docs_in_blogs'] = $publishedCount;

    

    $blogs = $db->blogs->find(
        ['status' => 'published'],
        ['sort' => ['created_at' => -1], 'limit' => 100]
    );
    $debugInfo['count'] = $publishedCount;

} catch (Exception $e) {
    $debugInfo['error'] = $e->getMessage();
    $blogs = [];
}

$baseUrl = $_ENV['BASE_URL'] ?? getenv('BASE_URL') ?? 'https://manases.space/';
$baseUrl = rtrim($baseUrl, '/') . '/';
$pageTitle = "Blog - Manases Kamau";
$pageDesc = "Read the latest insights on Web Development, Automation, and Tech from Manases Kamau. Tutorials, case studies, and industry trends.";
$pageUrl = $baseUrl . "blog";
$pageImage = $baseUrl . "images/company_logo.jpeg";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Manases Kamau</title>
    <meta name="description" content="Read the latest insights on Web Development, Automation, and Tech from Manases Kamau. Tutorials, case studies, and industry trends.">
    <meta name="author" content="Manases Kamau">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDesc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDesc) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">
    <link rel="icon" href="<?= htmlspecialchars($pageImage) ?>" type="image/jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
    <script src="https://5gvci.com/act/files/tag.min.js?z=10819561" data-cfasync="false" async></script>
    <script>(function(s){s.dataset.zone='10817677',s.src='https://al5sm.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
</head>
<body>


<div class="container main-document">
    <header class="d-flex flex-wrap justify-content-between align-items-center py-4 mb-5 border-bottom">
        <div class="col-md-6 mb-2 mb-md-0">
            <a href="/" class="d-inline-flex flex-column link-body-emphasis text-decoration-none">
                <span class="fs-4 fw-bold text-uppercase name-brand">Manases Kamau</span>
                <span class="small text-muted text-uppercase ls-1">Full Stack Developer</span>
            </a>
        </div>
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="home" class="nav-link px-3 text-dark">Home</a></li>
            <li><a href="projects" class="nav-link px-3 text-dark">Work</a></li>
            <li><a href="contact-us" class="nav-link px-3 text-dark">Contact</a></li>
            <li><a href="assets/Manases_Kamau_CV.pdf" class="nav-link px-3 text-dark" download><span >Download CV</span></a></li>
            
        </ul>
    </header>

    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="display-5 fw-normal mb-4 serif-font">Latest Writings</h1>
             <p class="lead text-secondary">Thoughts on software engineering, automation systems, and building digital products.</p>
        </div>
        <div class="col-lg-4 text-end align-self-end">
            <?php if (isset($_SESSION['user_id'])): ?>
              
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($blogs)): ?>
        <div class="row g-5">
            <?php foreach ($blogs as $blog): ?>
                <?php
                    $excerpt = $blog['excerpt'] ?? '';
                    if ($excerpt === '' && !empty($blog['content'])) {
                        $excerpt = substr(strip_tags((string)$blog['content']), 0, 180) . '...';
                    }
                    $blogLink = "blog/" . (string)$blog['_id'] . "/" . (!empty($blog['slug']) ? urlencode($blog['slug']) : slugify($blog['title'] ?? 'untitled'));
                ?>
                <div class="col-md-12 border-bottom pb-4 mb-4">
                    <div class="mb-2 text-uppercase small ls-1 text-muted">
                        <?= isset($blog['created_at']) ? $blog['created_at']->toDateTime()->format('M j, Y') : '' ?>
                        · <?= htmlspecialchars($blog['category'] ?? 'General') ?>
                    </div>
                    
                    <?php if (!empty($blog['featured_image_id'])): ?>
                    <div style="margin-bottom: 1rem;">
                        <a href="<?= $blogLink ?>">
                            <img src="serve_image.php?id=<?= htmlspecialchars((string)$blog['featured_image_id']) ?>" alt="<?= htmlspecialchars($blog['title'] ?? 'Blog image') ?>" style="width: 100%; height: 240px; object-fit: cover; border-radius: 8px;">
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <h2 class="serif-font mb-2">
                        <a class="text-dark text-decoration-none hover-underline" href="<?= $blogLink ?>">
                            <?= htmlspecialchars($blog['title'] ?? 'Untitled') ?>
                        </a>
                    </h2>
                    <p class="mb-3 text-secondary"><?= htmlspecialchars($excerpt) ?></p>

                    <?php if (!empty($blog['tags']) && is_array($blog['tags'])): ?>
                        <div class="mb-3">
                            <?php foreach ($blog['tags'] as $tag): ?>
                                <span class="stack-badge"><?= htmlspecialchars((string)$tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <a href="<?= $blogLink ?>" class="text-decoration-none small fw-bold text-uppercase ls-1 text-dark">Read Article &rarr;</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-light border">No published blogs yet.</div>
    <?php endif; ?>
    
    <footer class="pt-5 mt-5 text-muted border-top">
        <div class="row">
            <div class="col-6">
                &copy; <?= date('Y') ?> Manases Kamau.
            </div>
            <div class="col-6 text-end">
                <a href="#" class="text-muted text-decoration-none">Back to top</a>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
