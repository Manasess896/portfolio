<?php
$pageTitle = "Page Not Found | Manases Kamau";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Page Not Found - Code Craft Website Solutions.">
  <meta name="author" content="Manases Kamau">
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
      The page  you are looking for does not exist or has been moved.
    </p>

    <a href="home" class="btn btn-outline-dark rounded-0 px-4 py-2 text-uppercase ls-1" style="font-size: 0.9rem;">
      &larr; Return to home page 
    </a>

    <div class="mt-5 pt-5 border-top w-50">
      <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
        <img src="images/company_logo_.jpg" alt="Code Craft Logo" style="width: 24px; height: 24px; border-radius: 4px;">
        <span class="small fw-semibold text-uppercase ls-1">Code Craft Website Solutions</span>
      </div>

      <p class="small text-muted mb-0">&copy; <?php echo date("Y"); ?> Manases Kamau. All rights reserved.</p>
    </div>
   



</body>

</html>