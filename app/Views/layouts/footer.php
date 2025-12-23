<?php
/**
 * Footer Layout Component
 * 
 * Included at the bottom of every page.
 * Contains footer content and JavaScript includes.
 * 
 * @package App\Views\Layouts
 */

$baseUrl = $this->config('app.url');
?>
        </main>
        
        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-content">
                <div class="ac-symbol"></div>
                <div class="footer-logo">Animus <span>Database</span></div>
                <div class="footer-tagline">"Nothing is true, everything is permitted."</div>
                <nav class="footer-nav">
                    <a href="<?= $baseUrl ?>/">Home</a>
                    <a href="<?= $baseUrl ?>/games">Jogos</a>
                    <a href="<?= $baseUrl ?>/characters">Personagens</a>
                    <a href="<?= $baseUrl ?>/timeline">Timeline</a>
                    <a href="<?= $baseUrl ?>/media">Livros</a>
                </nav>
                <div class="footer-credits">
                    Desenvolvido com <span style="color: var(--accent-red);">❤</span> para fãs da franquia.<br>
                    Dados via <a href="https://www.igdb.com/" target="_blank">IGDB API</a>. Assassin's Creed © Ubisoft.
                </div>
            </div>
        </footer>
        
    </div><!-- /.container -->

    <!-- Global JavaScript -->
    <script src="<?= $baseUrl ?>/JS/main.js"></script>
    
    <?php if (!empty($pageScripts)): ?>
    <!-- Page-specific Scripts -->
    <?php foreach ($pageScripts as $script): ?>
    <script src="<?= $baseUrl ?>/JS/<?= $script ?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (!empty($inlineScript)): ?>
    <script>
        <?= $inlineScript ?>
    </script>
    <?php endif; ?>
</body>
</html>
