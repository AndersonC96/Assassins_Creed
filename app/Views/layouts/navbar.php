<?php
/**
 * Navigation Sidebar Component
 * 
 * The Animus-style sidebar menu.
 * 
 * Variables expected:
 * - $activePage (string) - Current active page key
 * 
 * @package App\Views\Layouts
 */

$activePage = $activePage ?? '';
$baseUrl = $this->config('app.url');

$menuItems = [
    'home' => ['url' => '', 'label' => 'Home', 'icon' => 'bi-house'],
    'games' => ['url' => 'games', 'label' => 'Jogos', 'icon' => 'bi-controller'],
    'characters' => ['url' => 'characters', 'label' => 'Personagens', 'icon' => 'bi-people'],
    'timeline' => ['url' => 'timeline', 'label' => 'Timeline', 'icon' => 'bi-hourglass-split'],
    'media' => ['url' => 'media', 'label' => 'Livros & Mídia', 'icon' => 'bi-book'],
];
?>
        <!-- Menu Lateral (Estilo Animus) -->
        <nav id="menu">
            <div class="title">Database</div>
            <ul class="items">
                <?php foreach ($menuItems as $key => $item): ?>
                <li>
                    <a href="<?= $baseUrl ?>/<?= $item['url'] ?>" 
                       class="item <?= $activePage === $key ? 'active' : '' ?>">
                        <i class="<?= $item['icon'] ?>"></i>
                        <?= $item['label'] ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            
            <?php if (!empty($subMenu)): ?>
            <div class="title" style="margin-top: 2em; font-size: 80%;"><?= $subMenuTitle ?? 'Navegação' ?></div>
            <ul class="items">
                <?php foreach ($subMenu as $item): ?>
                <li>
                    <a href="<?= $item['url'] ?>" class="item">
                        <?php if (!empty($item['icon'])): ?>
                        <i class="bi <?= $item['icon'] ?>"></i>
                        <?php endif; ?>
                        <?= htmlspecialchars($item['label']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </nav>
