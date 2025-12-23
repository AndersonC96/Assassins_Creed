<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Game;

/**
 * Games Controller
 * 
 * Handles games listing and details.
 * 
 * @package App\Controllers
 */
class GamesController extends Controller
{
    private Game $gameModel;

    public function __construct()
    {
        parent::__construct();
        $this->gameModel = new Game();
    }

    /**
     * Display games list
     */
    public function index(): void
    {
        $categories = $this->gameModel->getAllByCategory();
        
        $subMenu = [];
        foreach ($categories as $key => $cat) {
            $subMenu[] = [
                'url' => '#' . $key,
                'label' => $cat['titulo'],
            ];
        }
        
        $this->view('games/index', [
            'pageTitle' => 'Jogos da Saga',
            'pageDescription' => 'Todos os jogos da franquia Assassin\'s Creed.',
            'activePage' => 'games',
            'categories' => $categories,
            'subMenu' => $subMenu,
            'subMenuTitle' => 'Categorias',
        ]);
    }

    /**
     * Display single game details
     */
    public function show(): void
    {
        $id = (int) $this->input('id', 0);
        
        if ($id <= 0) {
            $this->redirect('games');
            return;
        }
        
        $game = $this->gameModel->find($id);
        
        if (!$game) {
            $this->redirect('404');
            return;
        }
        
        $this->view('games/show', [
            'pageTitle' => $game['name'],
            'pageDescription' => $game['summary'] ?? 'Detalhes do jogo ' . $game['name'],
            'activePage' => 'games',
            'game' => $game,
        ]);
    }
}
