<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

/**
 * Error Controller
 * 
 * Handles error pages.
 * 
 * @package App\Controllers
 */
class ErrorController extends Controller
{
    /**
     * Display 404 page
     */
    public function notFound(): void
    {
        http_response_code(404);
        
        $this->view('errors/404', [
            'pageTitle' => 'Página Não Encontrada',
            'pageDescription' => 'A página que você procura não foi encontrada.',
            'activePage' => '',
        ]);
    }
}
