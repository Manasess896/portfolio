<?php
$pageTitle = "Page Not Found | Manases Kamau";

$baseDir = str_replace('\\', '/', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));
$baseUrl = !empty($baseDir) ? $baseDir . '/' : '/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Page Not Found - MK website solutions ">
  <meta name="author" content="Manases Kamau">
  <base href="<?php echo htmlspecialchars($baseUrl); ?>">
  <link rel="icon" href="images/company_logo.png" type="image/jpeg">
  <title><?php echo $pageTitle; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
</head>

<body>

  <div class="container main-document d-flex flex-column justify-content-center align-items-center text-center" style="min-height: 80vh;">

    <h1 class="display-1 fw-bold serif-font mb-4">404</h1>
    <h2 class="h4 mb-4 text-uppercase ls-1">Page Not Found</h2>

    <p class="lead text-secondary mb-5" style="max-width: 500px;">
      The page you are looking for does not exist or has been moved.
    </p>

    <a href="home" class="btn btn-outline-dark rounded-0 px-4 py-2 text-uppercase ls-1" style="font-size: 0.9rem;">
      &larr; Return to home page
    </a>

    <div class="mt-5 pt-5 border-top w-50">
      <div class="mb-3">
        <a href="https://wa.me/+254114471302" class="text-secondary mx-2 fs-5" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="https://www.instagram.com/manases___/" class="text-secondary mx-2 fs-5" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="mailto:manasesskamau1053@gmail.com" class="text-secondary mx-2 fs-5"><i class="fas fa-envelope"></i></a>
        <a href="https://www.linkedin.com/in/manases-kamau-5a6837294?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" class="text-secondary mx-2 fs-5" target="_blank"><i class="fab fa-linkedin"></i></a>
        <a href="https://github.com/Manasess896/" class="text-secondary mx-2 fs-5" target="_blank"><i class="fab fa-github"></i></a>
      </div>
      <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
        <img src="images/company_logo.png" alt="Code Craft Logo" style="width: 24px; height: 24px; border-radius: 4px;">
        <span class="small fw-semibold text-uppercase ls-1">MK website solutions </span>
      </div>

      <p class="small text-muted mb-0">&copy; <?php echo date("Y"); ?> Manases Kamau. All rights reserved.</p>
    </div>




</body>

</html>