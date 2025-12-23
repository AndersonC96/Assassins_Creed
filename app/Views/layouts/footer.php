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


<!-- Footer -->
<footer class="site-footer">
    <div class="footer-content">
        <img src="https://purepng.com/public/uploads/large/71502582544mhfduaiq0ewor7uzuho0txqimxxjbd5btxseylkm61vnpxcbmcjfhjl606crojnnwwxtfogdtqkmmceyockcjdtv0e8ctxer5dg7.png" alt="AC Logo" class="ac-symbol">
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
            Desenvolvido por <a href="https://www.linkedin.com/in/andersoncavalcante96/" target="_blank">Anderson Cavalcante</a><br>
            Dados via <a href="https://www.igdb.com/" target="_blank">IGDB API</a>. Assassin's Creed © Ubisoft.
        </div>
        </img>
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