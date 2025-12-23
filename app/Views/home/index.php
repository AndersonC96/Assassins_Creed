<!-- Conteúdo Principal -->
<div class="title">Animus Database</div>

<div class="description">
    <p>Bem-vindo ao <strong>Animus Database</strong>. Explore a história oculta da humanidade através das memórias genéticas dos Assassinos.</p>
    <p>Acesse informações detalhadas sobre jogos, personagens, timeline histórica e mídias expandidas do universo <em>Assassin's Creed</em>.</p>
</div>

<?php
// Logic for Video Source (Local vs YouTube)
$isLocal = false;
$videoSrc = '';
$videoCover = 'https://files.igdb.com/t_original/ar2v.jpg'; // Default Shadows
$videoTitle = "Assassin's Creed Shadows - Official Cinematic Trailer";
$simId = '01';

if (isset($featuredVideo) && !empty($featuredVideo)) {
    // Local Video Strategy
    $isLocal = true;
    $videoSrc = $featuredVideo['url'];
    $videoTitle = $featuredVideo['title'];
    
    // Check if cover exists, otherwise use default pattern or specific API cover if mapped
    if (file_exists(str_replace('http://localhost/Assassins_Creed/public/../', __DIR__ . '/../../../', $featuredVideo['cover']))) {
         $videoCover = $featuredVideo['cover'];
    } else {
         // Fallback cover based on title keyword to IGDB if possible, or generic
         // For now, keep generic or specific if mapped manually in controller
         $videoCover = $featuredVideo['cover']; 
    }
    
    // Random SIM ID
    $simId = str_pad((string)rand(1, 99), 2, '0', STR_PAD_LEFT);
} else {
    // YouTube Strategy (Original Fallback)
    $videoId = 'vovkzbtYBC8'; // AC Shadows
}
?>

<!-- ANIMUS VIDEO PLAYER -->
<div class="animus-player">
    <div class="scanlines"></div>
    <div class="vignette"></div>
    <div class="noise"></div>
    
    <div class="video-container" id="videoContainer">
        <!-- Thumbnail/Overlay Inicial -->
        <div class="video-overlay" id="videoOverlay" style="background-image: url('<?= $videoCover ?>');">
            <div class="play-button">
                <div class="play-icon"></div>
            </div>
            <div class="video-info">
                <div class="video-title">
                    <span class="animus-text">SIMULATION_<?= $simId ?></span>
                    <h1><?= htmlspecialchars($videoTitle) ?></h1>
                </div>
            </div>
        </div>
        
        <?php if ($isLocal): ?>
            <!-- HTML5 Local Player -->
            <video id="player" style="width: 100%; height: 100%; object-fit: cover;" playsinline>
                <source src="<?= $videoSrc ?>" type="video/mp4">
                Seu navegador não suporta vídeos HTML5.
            </video>
        <?php else: ?>
            <!-- YouTube Iframe -->
            <div id="player-yt"></div>
        <?php endif; ?>
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
            
            <button class="control-btn" id="speedBtn" aria-label="Speed" style="width: auto; min-width: 40px; font-size: 0.8rem; letter-spacing: 0;">
                1x
            </button>
            
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

<!-- Player Scripts -->
<script>
    const isLocal = <?= $isLocal ? 'true' : 'false' ?>;
    
    // UI Elements
    const playBtn = document.getElementById('playPauseBtn');
    const muteBtn = document.getElementById('muteBtn');
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const speedBtn = document.getElementById('speedBtn');
    const overlay = document.getElementById('videoOverlay');
    const progressFill = document.querySelector('.progress-fill');
    const currentTimeEl = document.getElementById('currentTime');
    const durationEl = document.getElementById('duration');
    const videoContainer = document.getElementById('videoContainer');

    function formatTime(seconds) {
        const min = Math.floor(seconds / 60);
        const sec = Math.floor(seconds % 60);
        return `${min.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;
    }

    if (isLocal) {
        // HTML5 Player Logic
        const video = document.getElementById('player');
        
        // Init
        video.addEventListener('loadedmetadata', () => {
            durationEl.innerText = formatTime(video.duration);
        });
        
        video.addEventListener('timeupdate', () => {
            const percent = (video.currentTime / video.duration) * 100;
            progressFill.style.width = percent + '%';
            currentTimeEl.innerText = formatTime(video.currentTime);
        });
        
        // Overlay Click
        overlay.addEventListener('click', () => {
            overlay.style.opacity = '0';
            setTimeout(() => overlay.style.display = 'none', 500);
            video.play();
            playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
        });
        
        // Controls
        playBtn.addEventListener('click', () => {
            if (video.paused) {
                video.play();
                playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
            } else {
                video.pause();
                playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
            }
        });
        
        muteBtn.addEventListener('click', () => {
            video.muted = !video.muted;
            muteBtn.innerHTML = video.muted ? '<i class="bi bi-volume-mute-fill"></i>' : '<i class="bi bi-volume-up-fill"></i>';
        });

        // Speed Control
        const speeds = [0.5, 1, 1.5, 2];
        let currentSpeedIdx = 1;

        speedBtn.addEventListener('click', () => {
            currentSpeedIdx = (currentSpeedIdx + 1) % speeds.length;
            const newSpeed = speeds[currentSpeedIdx];
            video.playbackRate = newSpeed;
            speedBtn.innerText = newSpeed + 'x';
        });
        
        fullscreenBtn.addEventListener('click', () => {
            if (video.requestFullscreen) video.requestFullscreen();
            else if (video.webkitRequestFullscreen) video.webkitRequestFullscreen();
        });
        
    } else {
        // YouTube Player Logic (Legacy)
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        window.onYouTubeIframeAPIReady = function() {
            player = new YT.Player('player-yt', {
                videoId: '<?= $videoId ?? '' ?>',
                playerVars: { 'playsinline': 1, 'controls': 0, 'modestbranding': 1, 'rel': 0, 'showinfo': 0 },
                events: {
                    'onReady': onYtReady,
                    'onStateChange': onYtStateChange
                }
            });
        };

        function onYtReady(event) {
            overlay.addEventListener('click', function() {
                overlay.style.opacity = '0';
                setTimeout(() => overlay.style.display = 'none', 500);
                player.playVideo();
            });
            
            playBtn.addEventListener('click', function() {
                if (player.getPlayerState() == 1) player.pauseVideo();
                else player.playVideo();
            });

            // Speed Control for YouTube
            const speeds = [0.5, 1, 1.5, 2];
            let currentSpeedIdx = 1;
            speedBtn.addEventListener('click', () => {
                currentSpeedIdx = (currentSpeedIdx + 1) % speeds.length;
                const newSpeed = speeds[currentSpeedIdx];
                player.setPlaybackRate(newSpeed);
                speedBtn.innerText = newSpeed + 'x';
            });
            
            // Sync Loop
            setInterval(() => {
                if (player && player.getCurrentTime) {
                    const duration = player.getDuration();
                    const current = player.getCurrentTime();
                    if (duration > 0) {
                        progressFill.style.width = ((current / duration) * 100) + '%';
                        currentTimeEl.innerText = formatTime(current);
                        durationEl.innerText = formatTime(duration);
                    }
                }
            }, 500);
        }

        function onYtStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING) {
                playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
            } else {
                playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
            }
        }
    }
</script>
