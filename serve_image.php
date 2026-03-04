<?php

while (ob_get_level() > 0) {
    ob_end_clean();
}

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use MongoDB\Client as MongoClient;
use MongoDB\BSON\ObjectId;

if (file_exists(__DIR__ . '/.env')) {
    Dotenv::createImmutable(__DIR__)->safeLoad();
}
$rawId = trim($_GET['id'] ?? '');

if (!preg_match('/^[a-f0-9]{24}$/i', $rawId)) {
    http_response_code(400);
    exit;
}

try {
    $mongo  = new MongoClient($_ENV['MONGODB_URI'] ?? getenv('MONGODB_URI'));
    $db     = $mongo->selectDatabase($_ENV['MONGODB_DATABASE'] ?? getenv('MONGODB_DATABASE'));
    $bucket = $db->selectGridFSBucket();
    $fileId = new ObjectId($rawId);

    $file = $bucket->findOne(['_id' => $fileId]);

    if (!$file) {
        http_response_code(404);
        exit;
    }

    $contentType = $file->metadata['contentType']
                ?? $file->contentType
                ?? 'application/octet-stream';

    if (!str_starts_with(strtolower($contentType), 'image/')) {
        http_response_code(403);
        exit;
    }

    $etag    = '"' . $rawId . '-' . $file->length . '"';
    $uploadTs = isset($file->uploadDate)
        ? $file->uploadDate->toDateTime()->getTimestamp()
        : 0;
    $lastMod = $uploadTs ? gmdate('D, d M Y H:i:s', $uploadTs) . ' GMT' : null;

    $clientEtag = trim($_SERVER['HTTP_IF_NONE_MATCH'] ?? '');
    if ($clientEtag && ($clientEtag === $etag || $clientEtag === '*')) {
        http_response_code(304);
        exit;
    }

    $clientIms = $_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '';
    if ($clientIms && $uploadTs && strtotime($clientIms) >= $uploadTs) {
        http_response_code(304);
        exit;
    }

    header('Content-Type: '   . $contentType);
    header('Content-Length: ' . $file->length);
    header('Cache-Control: public, max-age=31536000, immutable');
    header('ETag: ' . $etag);
    if ($lastMod) {
        header('Last-Modified: ' . $lastMod);
    }
    header('Content-Disposition: inline; filename="' . $rawId . '"');

    $stream = $bucket->openDownloadStream($fileId);
    fpassthru($stream);
    fclose($stream);

} catch (Exception $e) {
    error_log('serve_image [' . $rawId . ']: ' . $e->getMessage());
    if (!headers_sent()) {
        http_response_code(500);
    }
    exit;
}
