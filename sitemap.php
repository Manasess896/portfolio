<?php
header("Content-type: application/xml; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

$blogUrls = [];
try {
    require_once __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    $mongoUri = $_ENV['MONGODB_URI'] ?? getenv('MONGODB_URI');
    $mongoDb  = $_ENV['MONGODB_DATABASE'] ?? getenv('MONGODB_DATABASE');
    if ($mongoUri && $mongoDb) {
        $client = new MongoDB\Client($mongoUri);
        $db     = $client->selectDatabase($mongoDb);
        $blogs  = $db->blogs->find(
            ['status' => 'published'],
            ['projection' => ['_id' => 1, 'title' => 1, 'updated_at' => 1, 'created_at' => 1], 'sort' => ['created_at' => -1]]
        );
        foreach ($blogs as $b) {
            $slug   = preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($b['title'] ?? 'post')));
            $slug   = trim($slug, '-');
            $lastmod = isset($b['updated_at']) ? $b['updated_at']->toDateTime()->format('Y-m-d')
                     : (isset($b['created_at']) ? $b['created_at']->toDateTime()->format('Y-m-d') : date('Y-m-d'));
            $blogUrls[] = [
                'loc'     => 'https://manases.space/blog/' . (string)$b['_id'] . '/' . $slug,
                'lastmod' => $lastmod,
            ];
        }
    }
} catch (Exception $e) {
   
}
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
  <url>
    <loc>https://manases.space/</loc>
    <lastmod><?php echo date('Y-m-d'); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>https://manases.space/projects</loc>
    <lastmod><?php echo date('Y-m-d'); ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://manases.space/blog</loc>
    <lastmod><?php echo date('Y-m-d'); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
  </url>
  <url>
    <loc>https://manases.space/contact-us</loc>
    <lastmod><?php echo date('Y-m-d'); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
  <url>
    <loc>https://manases.space/ai/terms-of-service</loc>
    <lastmod><?php echo date('Y-m-d'); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>https://manases.space/ai/privacy-policy</loc>
    <lastmod><?php echo date('Y-m-d'); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
  <?php foreach ($blogUrls as $bu): ?>
  <url>
    <loc><?php echo htmlspecialchars($bu['loc']); ?></loc>
    <lastmod><?php echo $bu['lastmod']; ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>
  <?php endforeach; ?>
</urlset>
