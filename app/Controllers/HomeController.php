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
    public function index(): void
    {
        $this->view('home/index', [
            'pageTitle' => 'Animus Database',
            'pageDescription' => 'Portal dedicado ao universo Assassin\'s Creed no estilo Animus.',
            'activePage' => 'home',
        ]);
    }
}
