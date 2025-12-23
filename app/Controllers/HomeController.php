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
        // LOGIC FOR LOCAL VIDEOS (Requested by User)
        $videoDir = __DIR__ . '/../../Videos/';
        $publicVideoPath = $this->app->config('app.url') . '/../Videos/';
        
        $localVideos = glob($videoDir . '*.mp4');
        $featuredVideo = null;
        
        if (!empty($localVideos)) {
            // Pick random video
            $randomVideoPath = $localVideos[array_rand($localVideos)];
            $filename = basename($randomVideoPath);
            
            // Generate title from filename (e.g. AC_Shadows.mp4 -> Assassin's Creed Shadows)
            $namePart = pathinfo($filename, PATHINFO_FILENAME);
            $prettyName = str_replace(['AC_', '_'], ['Assassin\'s Creed ', ': '], $namePart);
            
            // Correction for specific filenames if needed
            if ($namePart == 'AC_II') $prettyName = "Assassin's Creed II";
            if ($namePart == 'AC_III') $prettyName = "Assassin's Creed III";
            if ($namePart == 'AC_IV') $prettyName = "Assassin's Creed IV: Black Flag";
            if ($namePart == 'AC_BH') $prettyName = "Assassin's Creed: Brotherhood";
            if ($namePart == 'AC_R') $prettyName = "Assassin's Creed: Revelations";
            if ($namePart == 'AC_M') $prettyName = "Assassin's Creed Mirage";
            if ($namePart == 'AC_V') $prettyName = "Assassin's Creed Valhalla";
            if ($namePart == 'AC_U') $prettyName = "Assassin's Creed Unity";
            if ($namePart == 'AC_S') $prettyName = "Assassin's Creed Syndicate"; // Assuming S is Syndicate based on age, Shadows is new
            if ($namePart == 'AC_Shadows') $prettyName = "Assassin's Creed Shadows";
            
            $featuredVideo = [
                'url' => $publicVideoPath . $filename,
                'title' => $prettyName,
                'cover' => str_replace('.mp4', '.jpg', $publicVideoPath . $filename) // Try to guess cover
            ];
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
