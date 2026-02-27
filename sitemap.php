<?php 
header("Content-type: application/xml; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://manases.space/</loc>
    <lastmod><?php echo date("Y-m-d"); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>https://manases.space/projects</loc>
    <lastmod><?php echo date("Y-m-d"); ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://manases.space/contact-us</loc>
    <lastmod><?php echo date("Y-m-d"); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
    <url>
    <loc>https://manases.space/ai/terms-of-service</loc>
    <lastmod><?php echo date("Y-m-d"); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
    <url>
    <loc>https://manases.space/ai/privacy-policy</loc>
    <lastmod><?php echo date("Y-m-d"); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
</urlset>
