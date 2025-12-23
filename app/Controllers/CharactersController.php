<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Character;

/**
 * Characters Controller
 * 
 * Handles characters listing.
 * 
 * @package App\Controllers
 */
class CharactersController extends Controller
{
    /**
     * Display characters list
     */
    public function index(): void
    {
        $characterModel = new Character();
        $characters = $characterModel->getAllByCategory();
        $categories = $characterModel->getCategories();
        
        $subMenu = [];
        foreach ($categories as $key => $cat) {
            $subMenu[] = [
                'url' => '#' . $key,
                'label' => $cat['titulo'],
                'icon' => $cat['icon'],
            ];
        }
        
        $this->view('characters/index', [
            'pageTitle' => 'Personagens',
            'pageDescription' => 'Todos os personagens do universo Assassin\'s Creed.',
            'activePage' => 'characters',
            'characters' => $characters,
            'categories' => $categories,
            'subMenu' => $subMenu,
            'subMenuTitle' => 'Categorias',
        ]);
    }
}
