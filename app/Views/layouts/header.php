<?php
/**
 * Header Layout Component
 * 
 * Included at the top of every page.
 * 
 * Variables expected:
 * - $pageTitle (string) - Page title
 * - $pageDescription (string) - Meta description
 * 
 * @package App\Views\Layouts
 */

$pageTitle = $pageTitle ?? 'AC Database';
$pageDescription = $pageDescription ?? 'Portal dedicado ao universo Assassin\'s Creed no estilo Animus.';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - AC Database</title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?> - AC Database">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $baseUrl ?>">
    
    <!-- Favicon -->
    <link rel="icon" href="<?= $baseUrl ?>/IMG/favicon.png" type="image/x-icon">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/CSS/style.css">
</head>
<body>
    <div class="container">
