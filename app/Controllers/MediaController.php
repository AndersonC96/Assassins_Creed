<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Media;

/**
 * Media Controller
 * 
 * Handles books / media page.
 * 
 * @package App\Controllers
 */
class MediaController extends Controller
{
    /**
     * Display media (books, comics, films)
     */
    public function index(): void
    {
        $mediaModel = new Media();
        
        $this->view('media/index', [
            'pageTitle' => 'Livros & Mídia',
            'pageDescription' => 'Romances, comics, filmes e materiais do universo Assassin\'s Creed.',
            'activePage' => 'media',
            'romances' => $mediaModel->getRomances(),
            'comics' => $mediaModel->getComics(),
            'filmes' => $mediaModel->getFilms(),
            'outros' => $mediaModel->getOthers(),
        ]);
    }
}
