<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Character;

/**
 * Characters Controller
 * 
 * Handles characters listing and details.
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
    
    /**
     * Display single character details
     */
    public function show(): void
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $this->redirect('/characters');
            return;
        }
        
        $characterModel = new Character();
        $character = $characterModel->find($id);
        
        if (!$character) {
            $this->view('errors/404', [
                'pageTitle' => 'Personagem Não Encontrado',
                'activePage' => 'characters',
            ]);
            return;
        }
        
        // Get related characters from same category if available
        $relatedCharacters = [];
        $allCharacters = $characterModel->getAllByCategory();
        $characterCategory = $character['categoria'] ?? null;
        
        if ($characterCategory && isset($allCharacters[$characterCategory])) {
            $categoryChars = $allCharacters[$characterCategory]['characters'] ?? [];
            $count = 0;
            foreach ($categoryChars as $char) {
                if (($char['id'] ?? $char['nome']) !== $id && $count < 4) {
                    $relatedCharacters[] = $char;
                    $count++;
                }
            }
        }
        
        // Breadcrumbs
        $breadcrumbs = [
            ['label' => 'Home', 'url' => $this->config('app.url')],
            ['label' => 'Personagens', 'url' => $this->config('app.url') . '/characters'],
            ['label' => $character['nome'], 'url' => null],
        ];
        
        $this->view('characters/show', [
            'pageTitle' => $character['nome'],
            'pageDescription' => $character['descricao'] ?? 'Detalhes do personagem ' . $character['nome'],
            'activePage' => 'characters',
            'character' => $character,
            'relatedCharacters' => $relatedCharacters,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}

