<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

/**
 * Home Controller
 * 
 * Handles the homepage.
 * 
 * @package App\Controllers
 */
class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    /**
     * Display the homepage
     */
    public function index(): void
    {
        // LOGIC FOR DATABASE VIDEOS
        $featuredVideo = null;
        
        try {
            $videoModel = new \App\Models\Video();
            $dbVideo = $videoModel->getRandomVideo();
            
            if ($dbVideo) {
                // Convert DB path to public URL
                // DB has "./Videos/AC.mp4" (relative to project root usually, or legacy)
                // We need to ensure it maps to public URL correctly.
                // If ID=1 is ./Videos/AC.mp4, and our public index is in /public,
                // we might need to adjust.
                
                $baseUrl = $this->app->config('app.url'); // http://localhost/Assassins_Creed/public
                $rootUrl = dirname($baseUrl); // http://localhost/Assassins_Creed
                
                // Remove ./ from beginning if present
                $cleanPath = ltrim($dbVideo['url'], './');
                
                $featuredVideo = [
                    'url' => $rootUrl . '/' . $cleanPath,
                    'title' => $dbVideo['titulo'],
                    'cover' => 'https://files.igdb.com/t_original/ar2v.jpg' // Default or fetch from somewhere else if needed
                ];
                
                // Try to find a cover image with same name
                $sysPath = __DIR__ . '/../../' . $cleanPath;
                $coverPath = str_replace('.mp4', '.jpg', $sysPath);
                if (file_exists($coverPath)) {
                     $featuredVideo['cover'] = $rootUrl . '/' . str_replace('.mp4', '.jpg', $cleanPath);
                }
            }
        } catch (\Exception $e) {
            // Fallback if DB fails
            $featuredVideo = null;
        }

        // Prepare view data
        $viewData = [
            'pageTitle' => 'Animus Database',
            'pageDescription' => 'Portal dedicado ao universo Assassin\'s Creed no estilo Animus.',
            'activePage' => 'home',
            'featuredVideo' => $featuredVideo
        ];

        $this->view('home/index', $viewData);
    }
}
