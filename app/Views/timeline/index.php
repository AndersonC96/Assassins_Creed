<div class="title">Timeline Completa</div>

<div class="description">
    <p>Acompanhe a cronologia do universo Assassin's Creed através dos séculos, desde a Era Isu até os dias modernos.</p>
</div>

<!-- Controles da Timeline -->
<div class="timeline-controls">
    <button class="timeline-btn active" onclick="switchTimeline('historica')">
        <i class="bi bi-clock-history"></i> Cronologia Histórica
    </button>
    <button class="timeline-btn" onclick="switchTimeline('lancamentos')">
        <i class="bi bi-calendar-check"></i> Ordem de Lançamento
    </button>
</div>

<!-- Timeline Histórica -->
<div id="timeline-historica" class="timeline-container">
    <div class="timeline">
        <?php foreach ($timelineHistorica as $evento): 
            $isGame = isset($evento['tipo']) && $evento['tipo'] === 'jogo';
            $side = $isGame ? 'right' : 'left';
        ?>
        <div class="timeline-item <?= $side ?>">
            <div class="timeline-content">
                <div class="timeline-date"><?= $evento['ano'] ?></div>
                <div class="timeline-title">
                    <?php if (isset($evento['icone'])): ?>
                    <i class="bi bi-<?= $evento['icone'] ?>"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($evento['titulo']) ?>
                </div>
                <p><?= htmlspecialchars($evento['descricao']) ?></p>
                
                <?php if (isset($evento['protagonista'])): ?>
                <div class="timeline-meta">
                    <i class="bi bi-person"></i> <?= htmlspecialchars($evento['protagonista']) ?>
                </div>
                <?php endif; ?>
                
                <?php if ($isGame): ?>
                <span class="type-badge game">Jogo Principal</span>
                <?php elseif (isset($evento['tipo'])): ?>
                <span class="type-badge <?= $evento['tipo'] ?>"><?= ucfirst($evento['tipo']) ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Timeline Lançamentos -->
<div id="timeline-lancamentos" class="timeline-container hidden">
    <div class="release-grid">
        <?php foreach ($timelineLancamentos as $ano => $jogos): ?>
        <div class="release-year">
            <div class="year-header"><?= $ano ?></div>
            <div class="year-content">
                <?php foreach ($jogos as $jogo): ?>
                <div class="release-card">
                    <div class="release-title"><?= htmlspecialchars($jogo['titulo']) ?></div>
                    <div class="release-date">
                        <i class="bi bi-calendar"></i> <?= htmlspecialchars($jogo['data']) ?>
                    </div>
                    <div class="release-platforms">
                        <?php foreach ($jogo['plataformas'] as $plat): ?>
                        <span class="plat-badge"><?= $plat ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function switchTimeline(type) {
        const historica = document.getElementById('timeline-historica');
        const lancamentos = document.getElementById('timeline-lancamentos');
        const btns = document.querySelectorAll('.timeline-btn');
        
        if (type === 'historica') {
            historica.classList.remove('hidden');
            lancamentos.classList.add('hidden');
            btns[0].classList.add('active');
            btns[1].classList.remove('active');
        } else {
            hisorica.classList.add('hidden');
            lancamentos.classList.remove('hidden');
            btns[0].classList.remove('active');
            btns[1].classList.add('active');
        }
    }
</script>
