<?php
require_once 'session_setup.php';

use MongoDB\BSON\ObjectId;
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

$blog = null;
$recommended = [];

try {
    $db = getAdminDb();
    $id = $_GET['id'] ?? '';

    if ($id !== '') {
        try {
            $objectId = new ObjectId($id);
        } catch (Exception $e) {
            $objectId = null;
        }
    } else {
        $objectId = null;
    }

    if ($objectId !== null) {
        $blog = $db->blogs->findOne([
            '_id' => $objectId,
            'status' => 'published'
        ]);

        if ($blog) {
            $db->blogs->updateOne(
                ['_id' => $blog['_id']],
                ['$inc' => ['views' => 1], '$set' => ['last_viewed_at' => new UTCDateTime()]]
            );

            $category = $blog['category'] ?? 'General';
            $recommendedCursor = $db->blogs->find(
                [
                    '_id' => ['$ne' => $blog['_id']],
                    'status' => 'published',
                    'category' => $category
                ],
                ['sort' => ['created_at' => -1], 'limit' => 4]
            );

            $recommended = iterator_to_array($recommendedCursor);

            if (count($recommended) < 4) {
                $fillCursor = $db->blogs->find(
                    [
                        '_id' => ['$ne' => $blog['_id']],
                        'status' => 'published'
                    ],
                    ['sort' => ['created_at' => -1], 'limit' => 6]
                );

                foreach ($fillCursor as $item) {
                    $exists = false;
                    foreach ($recommended as $rec) {
                        if ((string)$rec['_id'] === (string)$item['_id']) {
                            $exists = true;
                            break;
                        }
                    }
                    if (!$exists) {
                        $recommended[] = $item;
                    }
                    if (count($recommended) >= 4) {
                        break;
                    }
                }
            }
        }
    }
} catch (Exception $e) {
    $blog = null;
}

$pageTitle = $blog ? htmlspecialchars($blog['title'] ?? 'Blog') . " - Manases Kamau" : 'Blog Not Found';
$pageDesc = $blog ? substr(strip_tags((string)($blog['content'] ?? '')), 0, 160) : 'Read insightful articles.';
$pageUrl = "https://" . ($_SERVER['HTTP_HOST'] ?? 'manases.space') . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDesc) ?>">
    <meta name="author" content="<?= htmlspecialchars($blog['author_name'] ?? 'Manases Kamau') ?>">
    
    <meta property="og:title" content="<?= $pageTitle ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDesc) ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= $pageUrl ?>">
    <link rel="icon" href="/images/company_logo.jpeg" type="image/jpeg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
    <style>
        .blog-content { line-height: 1.85; font-size: 1.1rem; color: #333; }
        .blog-content p { margin-bottom: 1.5rem; }
        .blog-content h2 { margin-top: 2rem; margin-bottom: 1rem; font-family: 'Merriweather', serif; font-weight: 700; }
        .blog-content h3 { margin-top: 1.5rem; margin-bottom: 1rem; font-family: 'Merriweather', serif; font-weight: 700; }
        .blog-content img { max-width: 100%; height: auto; border-radius: 4px; margin: 1.5rem 0; }
        .blog-content ul, .blog-content ol { margin-bottom: 1.5rem; padding-left: 2rem; }
        .blog-content li { margin-bottom: 0.5rem; }
        .blog-content blockquote { border-left: 4px solid #333; padding-left: 1rem; font-style: italic; color: #555; margin: 1.5rem 0; }
        .blog-content pre { background: #f4f4f4; padding: 1rem; border-radius: 4px; overflow-x: auto; margin-bottom: 1.5rem; }
    </style>
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
            <li><a href="projects" class="nav-link px-3 text-dark">Work</a></li>
            <li><a href="blog" class="nav-link px-3 text-dark fw-bold border-bottom border-dark">Blog</a></li>
            <li><a href="contact-us" class="nav-link px-3 text-dark">Contact</a></li>
             <li><a href="assets/Manases_Kamau_CV.pdf" class="nav-link px-3 text-dark" download><span class="border-bottom border-secondary">Download CV</span></a></li>
        </ul>
    </header>

    <?php if (!$blog): ?>
        <div class="alert alert-light border rounded-0">Blog not found or not published. <a href="blog" class="alert-link">Return to Blog</a></div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <article>
                    <div class="mb-3 text-uppercase small ls-1 text-muted">
                         <a href="blog" class="text-decoration-none text-muted">&larr; Back to Blog</a> 
                         &nbsp;&middot;&nbsp; 
                        <?= isset($blog['created_at']) ? $blog['created_at']->toDateTime()->format('M j, Y') : '' ?>
                        &middot; <?= htmlspecialchars($blog['category'] ?? 'General') ?>
                    </div>
                
                    <h1 class="display-5 serif-font mb-4"><?= htmlspecialchars($blog['title'] ?? 'Untitled') ?></h1>
                    
                    <div class="mb-4 pb-4 border-bottom">
                         <div class="d-flex align-items-center">
                            <span class="small text-secondary">By <strong><?= htmlspecialchars($blog['author_name'] ?? 'Manases Kamau') ?></strong></span>
                         </div>
                    </div>

                    <div class="mb-4">
                        <?php if (!empty($blog['tags']) && is_array($blog['tags'])): ?>
                            <?php foreach ($blog['tags'] as $tag): ?>
                                <span class="stack-badge"><?= htmlspecialchars((string)$tag) ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="blog-content">
                        <?= (string)($blog['content'] ?? '') ?>
                    </div>
                </article>
                
                <div class="mt-5 pt-5 border-top">
                     <h4 class="serif-font mb-3">Share this article</h4>
                     <!-- Add share buttons here if needed -->
                     <a href="https://twitter.com/intent/tweet?text=<?= urlencode($blog['title']) ?>&url=<?= urlencode($pageUrl) ?>" target="_blank" class="btn btn-sm btn-outline-dark rounded-0 me-2">Share on Twitter</a>
                     <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($pageUrl) ?>" target="_blank" class="btn btn-sm btn-outline-dark rounded-0">Share on LinkedIn</a>
                </div>

            </div>

            <div class="col-lg-4 ps-lg-5 mt-5 mt-lg-0">
                <div class="sticky-top" style="top: 2rem;">
                    <h5 class="serif-font mb-3">More to Read</h5>
                    <?php if (!empty($recommended)): ?>
                        <ul class="list-unstyled">
                        <?php foreach ($recommended as $rec): ?>
                            <?php $recLink = "blog/" . (string)$rec['_id'] . "/" . slugify($rec['title'] ?? 'untitled'); ?>
                            <li class="mb-3 pb-3 border-bottom">
                                <a class="text-dark text-decoration-none fw-bold d-block mb-1 hover-underline" href="<?= $recLink ?>">
                                    <?= htmlspecialchars($rec['title'] ?? 'Untitled') ?>
                                </a>
                                <small class="text-muted">
                                    <?= isset($rec['created_at']) ? $rec['created_at']->toDateTime()->format('M j, Y') : '' ?>
                                </small>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-secondary small">No recommendations yet.</div>
                    <?php endif; ?>
                    
                    <div class="mt-4">
                        <a href="blog" class="btn btn-outline-dark w-100 rounded-0">View All Articles</a>
                    </div>
                </div>
            </div>
        </div>
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
