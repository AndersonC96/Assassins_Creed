<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assassin's Creed - Database</title>
    <meta name="description" content="Portal dedicado ao universo Assassin's Creed no estilo Animus.">
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        /* ============ ANIMUS VIDEO PLAYER ============ */
        .animus-player {
            position: relative;
            background: #000;
            overflow: hidden;
            margin-bottom: 2em;
        }
        
        .animus-player video {
            width: 100%;
            display: block;
            cursor: pointer;
        }
        
        /* Header do Player */
        .player-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.8), transparent);
            padding: 1em 1.25em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 10;
        }
        
        .animus-player:hover .player-header,
        .animus-player.paused .player-header {
            opacity: 1;
        }
        
        .player-title {
            display: flex;
            align-items: center;
            gap: 0.75em;
        }
        
        .player-title i {
            color: var(--accent-red);
            font-size: 1.25rem;
        }
        
        .player-title span {
            color: #fff;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        .player-status {
            display: flex;
            align-items: center;
            gap: 0.5em;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
            text-transform: uppercase;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            background: var(--accent-red);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
        
        /* Overlay Central de Play */
        .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: rgba(112, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            opacity: 0;
            z-index: 10;
        }
        
        .animus-player.paused .play-overlay {
            opacity: 1;
        }
        
        .play-overlay:hover {
            background: var(--accent-red);
            transform: translate(-50%, -50%) scale(1.1);
        }
        
        .play-overlay i {
            color: #fff;
            font-size: 2rem;
            margin-left: 4px;
        }
        
        /* Controles Inferiores */
        .player-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            padding: 1.5em 1.25em 1em;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 10;
        }
        
        .animus-player:hover .player-controls,
        .animus-player.paused .player-controls {
            opacity: 1;
        }
        
        /* Barra de Progresso */
        .progress-container {
            position: relative;
            height: 4px;
            background: rgba(255,255,255,0.2);
            cursor: pointer;
            margin-bottom: 0.75em;
            transition: height 0.2s;
        }
        
        .progress-container:hover {
            height: 8px;
        }
        
        .progress-bar {
            height: 100%;
            background: var(--accent-red);
            width: 0%;
            position: relative;
            transition: width 0.1s linear;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 12px;
            height: 12px;
            background: #fff;
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        .progress-container:hover .progress-bar::after {
            opacity: 1;
        }
        
        .buffer-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: rgba(255,255,255,0.3);
            pointer-events: none;
        }
        
        /* Preview de Tempo */
        .time-preview {
            position: absolute;
            bottom: 20px;
            background: rgba(0,0,0,0.9);
            color: #fff;
            padding: 0.25em 0.5em;
            font-size: 0.75rem;
            transform: translateX(-50%);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        
        .progress-container:hover .time-preview {
            opacity: 1;
        }
        
        /* Botões de Controle */
        .controls-row {
            display: flex;
            align-items: center;
            gap: 1em;
        }
        
        .control-btn {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            padding: 0.25em;
            font-size: 1.25rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .control-btn:hover {
            color: var(--accent-red);
            transform: scale(1.1);
        }
        
        .time-display {
            color: rgba(255,255,255,0.8);
            font-size: 0.8rem;
            font-family: 'Roboto Mono', monospace;
            letter-spacing: 0.05em;
        }
        
        .controls-spacer {
            flex: 1;
        }
        
        /* Volume Control */
        .volume-control {
            display: flex;
            align-items: center;
            gap: 0.5em;
        }
        
        .volume-slider {
            width: 0;
            opacity: 0;
            transition: all 0.3s;
            -webkit-appearance: none;
            height: 4px;
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
            cursor: pointer;
        }
        
        .volume-control:hover .volume-slider {
            width: 80px;
            opacity: 1;
        }
        
        .volume-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 12px;
            height: 12px;
            background: var(--accent-red);
            border-radius: 50%;
            cursor: pointer;
        }
        
        /* Efeito Glitch/Scanlines */
        .scanlines {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            background: repeating-linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.1),
                rgba(0, 0, 0, 0.1) 1px,
                transparent 1px,
                transparent 2px
            );
            z-index: 5;
            opacity: 0.3;
        }
        
        /* Efeito de Glitch no início */
        @keyframes glitch {
            0% { transform: translate(0); filter: hue-rotate(0deg); }
            20% { transform: translate(-2px, 2px); filter: hue-rotate(90deg); }
            40% { transform: translate(2px, -2px); filter: hue-rotate(180deg); }
            60% { transform: translate(-1px, 1px); filter: hue-rotate(270deg); }
            80% { transform: translate(1px, -1px); filter: hue-rotate(360deg); }
            100% { transform: translate(0); filter: hue-rotate(0deg); }
        }
        
        .animus-player.glitching video {
            animation: glitch 0.3s ease-in-out;
        }
        
        /* Indicador de Loading */
        .loading-indicator {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            z-index: 15;
        }
        
        .loading-indicator.active {
            display: block;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255,255,255,0.2);
            border-top-color: var(--accent-red);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        
        /* Modo Fullscreen */
        .animus-player:fullscreen {
            background: #000;
        }
        
        .animus-player:fullscreen video {
            height: 100vh;
            object-fit: contain;
        }

        /* Botões de velocidade */
        .speed-control {
            position: relative;
        }
        
        .speed-menu {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.95);
            padding: 0.5em;
            display: none;
            min-width: 80px;
        }
        
        .speed-control:hover .speed-menu {
            display: block;
        }
        
        .speed-option {
            display: block;
            width: 100%;
            padding: 0.5em;
            background: none;
            border: none;
            color: #fff;
            text-align: center;
            cursor: pointer;
            font-size: 0.8rem;
        }
        
        .speed-option:hover,
        .speed-option.active {
            background: var(--accent-red);
        }
    </style>
</head>
<body>
    <div class="container clearfix">
        <!-- Menu Lateral (Estilo Animus) -->
        <nav id="menu">
            <div class="title">Database</div>
            <ul class="items">
                <li><a href="index.php" class="item active">Home</a></li>
                <li><a href="jogos.php" class="item">Jogos</a></li>
                <li><a href="personagens.php" class="item">Personagens</a></li>
                <li><a href="timeline.php" class="item">Timeline</a></li>
                <li><a href="livros.php" class="item">Livros & Mídia</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Animus Database</div>
            
            <div class="description">
                <p>Bem-vindo ao <strong>Animus Database</strong>, o portal dedicado ao universo <em>Assassin's Creed</em>.</p>
                <p>Explore as memórias genéticas de lendários Assassinos através das eras. <strong>Selecione</strong> uma opção no menu para começar.</p>
            </div>

            <!-- ANIMUS VIDEO PLAYER -->
            <?php if (isset($video) && $video): ?>
            <div class="animus-player paused" id="animusPlayer">
                <!-- Scanlines Effect -->
                <div class="scanlines"></div>
                
                <!-- Header -->
                <div class="player-header">
                    <div class="player-title">
                        <i class="bi bi-film"></i>
                        <span><?= htmlspecialchars($video['titulo'] ?? 'Memory Fragment') ?></span>
                    </div>
                    <div class="player-status">
                        <div class="status-dot"></div>
                        <span>Synchronizing</span>
                    </div>
                </div>
                
                <!-- Video Element -->
                <video id="videoPlayer">
                    <source src="<?= htmlspecialchars($video['url'] ?? '') ?>" type="video/mp4">
                    Seu navegador não suporta vídeo.
                </video>
                
                <!-- Play Overlay -->
                <div class="play-overlay" id="playOverlay">
                    <i class="bi bi-play-fill"></i>
                </div>
                
                <!-- Loading Indicator -->
                <div class="loading-indicator" id="loadingIndicator">
                    <div class="loading-spinner"></div>
                </div>
                
                <!-- Controls -->
                <div class="player-controls">
                    <!-- Progress Bar -->
                    <div class="progress-container" id="progressContainer">
                        <div class="buffer-bar" id="bufferBar"></div>
                        <div class="progress-bar" id="progressBar"></div>
                        <div class="time-preview" id="timePreview">0:00</div>
                    </div>
                    
                    <!-- Control Buttons -->
                    <div class="controls-row">
                        <button class="control-btn" id="playPauseBtn" title="Play/Pause">
                            <i class="bi bi-play-fill"></i>
                        </button>
                        
                        <button class="control-btn" id="skipBackBtn" title="Voltar 10s">
                            <i class="bi bi-skip-backward-fill"></i>
                        </button>
                        
                        <button class="control-btn" id="skipForwardBtn" title="Avançar 10s">
                            <i class="bi bi-skip-forward-fill"></i>
                        </button>
                        
                        <span class="time-display">
                            <span id="currentTime">0:00</span> / <span id="totalTime">0:00</span>
                        </span>
                        
                        <div class="controls-spacer"></div>
                        
                        <div class="volume-control">
                            <button class="control-btn" id="volumeBtn" title="Volume">
                                <i class="bi bi-volume-up-fill"></i>
                            </button>
                            <input type="range" class="volume-slider" id="volumeSlider" min="0" max="1" step="0.1" value="1">
                        </div>
                        
                        <div class="speed-control">
                            <button class="control-btn" id="speedBtn" title="Velocidade">
                                <i class="bi bi-speedometer2"></i>
                            </button>
                            <div class="speed-menu">
                                <button class="speed-option" data-speed="0.5">0.5x</button>
                                <button class="speed-option" data-speed="0.75">0.75x</button>
                                <button class="speed-option active" data-speed="1">1x</button>
                                <button class="speed-option" data-speed="1.25">1.25x</button>
                                <button class="speed-option" data-speed="1.5">1.5x</button>
                                <button class="speed-option" data-speed="2">2x</button>
                            </div>
                        </div>
                        
                        <button class="control-btn" id="fullscreenBtn" title="Tela Cheia">
                            <i class="bi bi-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Quick Access Cards -->
            <div class="cards-grid">
                <div class="card">
                    <div style="height: 120px; background: linear-gradient(135deg, var(--accent-red) 0%, #333 100%); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-controller" style="font-size: 3rem; color: #fff;"></i>
                    </div>
                    <div class="card-content">
                        <div class="card-title">Jogos</div>
                        <div class="card-desc">Todos os títulos da franquia, de Altaïr a Basim.</div>
                        <a href="jogos.php" class="card-btn">Acessar</a>
                    </div>
                </div>

                <div class="card">
                    <div style="height: 120px; background: linear-gradient(135deg, #2563eb 0%, #333 100%); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people-fill" style="font-size: 3rem; color: #fff;"></i>
                    </div>
                    <div class="card-content">
                        <div class="card-title">Personagens</div>
                        <div class="card-desc">Os assassinos lendários que moldaram a história.</div>
                        <a href="personagens.php" class="card-btn">Acessar</a>
                    </div>
                </div>

                <div class="card">
                    <div style="height: 120px; background: linear-gradient(135deg, #059669 0%, #333 100%); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-hourglass-split" style="font-size: 3rem; color: #fff;"></i>
                    </div>
                    <div class="card-content">
                        <div class="card-title">Timeline</div>
                        <div class="card-desc">Cronologia completa do universo AC.</div>
                        <a href="timeline.php" class="card-btn">Acessar</a>
                    </div>
                </div>

                <div class="card">
                    <div style="height: 120px; background: linear-gradient(135deg, #7c3aed 0%, #333 100%); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-book-fill" style="font-size: 3rem; color: #fff;"></i>
                    </div>
                    <div class="card-content">
                        <div class="card-title">Livros & Mídia</div>
                        <div class="card-desc">Romances, comics, filmes e materiais expandidos.</div>
                        <a href="livros.php" class="card-btn">Acessar</a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="site-footer">
                <div class="footer-content">
                    <div class="ac-symbol"></div>
                    <div class="footer-logo">Animus <span>Database</span></div>
                    <div class="footer-tagline">"Nothing is true, everything is permitted."</div>
                    <nav class="footer-nav">
                        <a href="index.php">Home</a>
                        <a href="jogos.php">Jogos</a>
                        <a href="personagens.php">Personagens</a>
                        <a href="timeline.php">Timeline</a>
                        <a href="livros.php">Livros</a>
                    </nav>
                    <div class="footer-credits">
                        Desenvolvido com <span style="color: var(--accent-red);">❤</span> para fãs da franquia.<br>
                        Dados via <a href="https://www.igdb.com/" target="_blank">IGDB API</a>. Assassin's Creed © Ubisoft.
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <script>
        // Animus Video Player Controller
        (function() {
            const player = document.getElementById('animusPlayer');
            const video = document.getElementById('videoPlayer');
            if (!player || !video) return;
            
            // Elements
            const playPauseBtn = document.getElementById('playPauseBtn');
            const playOverlay = document.getElementById('playOverlay');
            const progressContainer = document.getElementById('progressContainer');
            const progressBar = document.getElementById('progressBar');
            const bufferBar = document.getElementById('bufferBar');
            const timePreview = document.getElementById('timePreview');
            const currentTimeEl = document.getElementById('currentTime');
            const totalTimeEl = document.getElementById('totalTime');
            const volumeBtn = document.getElementById('volumeBtn');
            const volumeSlider = document.getElementById('volumeSlider');
            const skipBackBtn = document.getElementById('skipBackBtn');
            const skipForwardBtn = document.getElementById('skipForwardBtn');
            const fullscreenBtn = document.getElementById('fullscreenBtn');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const speedOptions = document.querySelectorAll('.speed-option');
            
            // Format time helper
            function formatTime(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${mins}:${secs.toString().padStart(2, '0')}`;
            }
            
            // Toggle Play/Pause
            function togglePlay() {
                if (video.paused || video.ended) {
                    video.play();
                    player.classList.add('glitching');
                    setTimeout(() => player.classList.remove('glitching'), 300);
                } else {
                    video.pause();
                }
            }
            
            // Update Play State
            function updatePlayState() {
                const icon = playPauseBtn.querySelector('i');
                if (video.paused || video.ended) {
                    player.classList.add('paused');
                    icon.className = 'bi bi-play-fill';
                } else {
                    player.classList.remove('paused');
                    icon.className = 'bi bi-pause-fill';
                }
            }
            
            // Update Progress
            function updateProgress() {
                const percent = (video.currentTime / video.duration) * 100;
                progressBar.style.width = percent + '%';
                currentTimeEl.textContent = formatTime(video.currentTime);
            }
            
            // Update Buffer
            function updateBuffer() {
                if (video.buffered.length > 0) {
                    const bufferedEnd = video.buffered.end(video.buffered.length - 1);
                    const percent = (bufferedEnd / video.duration) * 100;
                    bufferBar.style.width = percent + '%';
                }
            }
            
            // Seek
            function seek(e) {
                const rect = progressContainer.getBoundingClientRect();
                const percent = (e.clientX - rect.left) / rect.width;
                video.currentTime = percent * video.duration;
            }
            
            // Preview Time on Hover
            function showTimePreview(e) {
                const rect = progressContainer.getBoundingClientRect();
                const percent = (e.clientX - rect.left) / rect.width;
                const time = percent * video.duration;
                timePreview.textContent = formatTime(time);
                timePreview.style.left = (e.clientX - rect.left) + 'px';
            }
            
            // Volume
            function updateVolume() {
                video.volume = volumeSlider.value;
                const icon = volumeBtn.querySelector('i');
                if (video.volume === 0 || video.muted) {
                    icon.className = 'bi bi-volume-mute-fill';
                } else if (video.volume < 0.5) {
                    icon.className = 'bi bi-volume-down-fill';
                } else {
                    icon.className = 'bi bi-volume-up-fill';
                }
            }
            
            function toggleMute() {
                video.muted = !video.muted;
                volumeSlider.value = video.muted ? 0 : video.volume;
                updateVolume();
            }
            
            // Skip
            function skipBack() {
                video.currentTime = Math.max(0, video.currentTime - 10);
            }
            
            function skipForward() {
                video.currentTime = Math.min(video.duration, video.currentTime + 10);
            }
            
            // Fullscreen
            function toggleFullscreen() {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                } else {
                    player.requestFullscreen();
                }
            }
            
            function updateFullscreenIcon() {
                const icon = fullscreenBtn.querySelector('i');
                if (document.fullscreenElement) {
                    icon.className = 'bi bi-fullscreen-exit';
                } else {
                    icon.className = 'bi bi-fullscreen';
                }
            }
            
            // Speed
            speedOptions.forEach(option => {
                option.addEventListener('click', () => {
                    speedOptions.forEach(o => o.classList.remove('active'));
                    option.classList.add('active');
                    video.playbackRate = parseFloat(option.dataset.speed);
                });
            });
            
            // Event Listeners
            playPauseBtn.addEventListener('click', togglePlay);
            playOverlay.addEventListener('click', togglePlay);
            video.addEventListener('click', togglePlay);
            video.addEventListener('play', updatePlayState);
            video.addEventListener('pause', updatePlayState);
            video.addEventListener('ended', updatePlayState);
            video.addEventListener('timeupdate', updateProgress);
            video.addEventListener('progress', updateBuffer);
            video.addEventListener('loadedmetadata', () => {
                totalTimeEl.textContent = formatTime(video.duration);
            });
            video.addEventListener('waiting', () => loadingIndicator.classList.add('active'));
            video.addEventListener('playing', () => loadingIndicator.classList.remove('active'));
            
            progressContainer.addEventListener('click', seek);
            progressContainer.addEventListener('mousemove', showTimePreview);
            
            volumeBtn.addEventListener('click', toggleMute);
            volumeSlider.addEventListener('input', updateVolume);
            
            skipBackBtn.addEventListener('click', skipBack);
            skipForwardBtn.addEventListener('click', skipForward);
            
            fullscreenBtn.addEventListener('click', toggleFullscreen);
            document.addEventListener('fullscreenchange', updateFullscreenIcon);
            
            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if (e.target.tagName === 'INPUT') return;
                
                switch(e.key) {
                    case ' ':
                    case 'k':
                        e.preventDefault();
                        togglePlay();
                        break;
                    case 'ArrowLeft':
                        skipBack();
                        break;
                    case 'ArrowRight':
                        skipForward();
                        break;
                    case 'ArrowUp':
                        video.volume = Math.min(1, video.volume + 0.1);
                        volumeSlider.value = video.volume;
                        updateVolume();
                        break;
                    case 'ArrowDown':
                        video.volume = Math.max(0, video.volume - 0.1);
                        volumeSlider.value = video.volume;
                        updateVolume();
                        break;
                    case 'f':
                        toggleFullscreen();
                        break;
                    case 'm':
                        toggleMute();
                        break;
                }
            });
        })();
    </script>
    <script src="./JS/main.js"></script>
</body>
</html>
