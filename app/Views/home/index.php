<!-- Conteúdo Principal -->
<div class="title">Animus Database</div>

<div class="description">
    <p>Bem-vindo ao <strong>Animus Database</strong>. Explore a história oculta da humanidade através das memórias genéticas dos Assassinos.</p>
    <p>Acesse informações detalhadas sobre jogos, personagens, timeline histórica e mídias expandidas do universo <em>Assassin's Creed</em>.</p>
</div>

<!-- ANIMUS VIDEO PLAYER -->
<div class="animus-player">
    <div class="scanlines"></div>
    <div class="vignette"></div>
    <div class="noise"></div>
    
    <div class="video-container" id="videoContainer">
        <!-- Thumbnail/Overlay Inicial -->
        <div class="video-overlay" id="videoOverlay" style="background-image: url('https://files.igdb.com/t_original/ar2v.jpg');">
            <div class="play-button">
                <div class="play-icon"></div>
            </div>
            <div class="video-info">
                <div class="video-title">
                    <span class="animus-text">SIMULATION_01</span>
                    <h1>Assassin's Creed Shadows - Official Cinematic Trailer</h1>
                </div>
            </div>
        </div>
        
        <!-- YouTube Iframe (Carregado sob demanda) -->
        <div id="player"></div>
    </div>

    <!-- Interface do Player Animus -->
    <div class="player-controls">
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
            <div class="buffer-bar" style="width: 0%"></div>
        </div>
        
        <div class="controls-row">
            <button class="control-btn" id="playPauseBtn" aria-label="Play/Pause">
                <i class="bi bi-play-fill"></i>
            </button>
            
            <div class="time-display">
                <span id="currentTime">00:00</span> / <span id="duration">00:00</span>
            </div>
            
            <div class="controls-spacer"></div>
            
            <div class="animus-status">
                <span class="status-dot"></span>
                SYNC_STABLE
            </div>
            
            <button class="control-btn" id="muteBtn" aria-label="Mute/Unmute">
                <i class="bi bi-volume-up-fill"></i>
            </button>
            
            <button class="control-btn" id="fullscreenBtn" aria-label="Fullscreen">
                <i class="bi bi-fullscreen"></i>
            </button>
        </div>
    </div>
</div>

<!-- Cards de Navegação -->
<div class="cards-grid">
    <a href="<?= $baseUrl ?>/games" class="card">
        <div class="card-icon gradient-1">
            <i class="bi bi-controller"></i>
        </div>
        <div class="card-content">
            <h3>JOGOS</h3>
            <p>Todos os títulos da franquia, de Altaïr a Basim.</p>
            <span class="btn-text">ACESSAR</span>
        </div>
    </a>

    <a href="<?= $baseUrl ?>/characters" class="card">
        <div class="card-icon gradient-2">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="card-content">
            <h3>PERSONAGENS</h3>
            <p>Os assassinos lendários que moldaram a história.</p>
            <span class="btn-text">ACESSAR</span>
        </div>
    </a>

    <a href="<?= $baseUrl ?>/timeline" class="card">
        <div class="card-icon gradient-3">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div class="card-content">
            <h3>TIMELINE</h3>
            <p>Cronologia completa do universo AC.</p>
            <span class="btn-text">ACESSAR</span>
        </div>
    </a>
    
    <a href="<?= $baseUrl ?>/media" class="card">
        <div class="card-icon gradient-4">
            <i class="bi bi-book-fill"></i>
        </div>
        <div class="card-content">
            <h3>LIVROS & MÍDIA</h3>
            <p>Romances, comics, filmes e materiais expandidos.</p>
            <span class="btn-text">ACESSAR</span>
        </div>
    </a>
</div>

<!-- Inline Script for Video Player -->
<script>
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            videoId: 'vovkzbtYBC8', // AC Shadows Trailer
            playerVars: {
                'playsinline': 1,
                'controls': 0,
                'modestbranding': 1,
                'rel': 0,
                'showinfo': 0,
                'iv_load_policy': 3
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    // Player Logic (Simplified for View)
    function onPlayerReady(event) {
        // Elements
        const playBtn = document.getElementById('playPauseBtn');
        const muteBtn = document.getElementById('muteBtn');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const overlay = document.getElementById('videoOverlay');
        const fill = document.querySelector('.progress-fill');
        
        // Duration
        // ... (standard player logic)
        
        overlay.addEventListener('click', function() {
            overlay.style.opacity = '0';
            setTimeout(() => overlay.style.display = 'none', 500);
            player.playVideo();
        });
        
        playBtn.addEventListener('click', function() {
            if (player.getPlayerState() == 1) {
                player.pauseVideo();
            } else {
                player.playVideo();
            }
        });
    }

    function onPlayerStateChange(event) {
        const playBtn = document.getElementById('playPauseBtn');
        if (event.data == YT.PlayerState.PLAYING) {
            playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
        } else {
            playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
        }
    }
</script>
