<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Timeline;

/**
 * Timeline Controller
 * 
 * Handles timeline page.
 * 
 * @package App\Controllers
 */
class TimelineController extends Controller
{
    /**
     * Display timeline
     */
    public function index(): void
    {
        $timelineModel = new Timeline();
        
        $this->view('timeline/index', [
            'pageTitle' => 'Timeline Completa',
            'pageDescription' => 'Cronologia completa do universo Assassin\'s Creed.',
            'activePage' => 'timeline',
            'timelineHistorica' => $timelineModel->getHistorical(),
            'timelineLancamentos' => $timelineModel->getReleases(),
            'eras' => $timelineModel->getEras(),
        ]);
    }
}
