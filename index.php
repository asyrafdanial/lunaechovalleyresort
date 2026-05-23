<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luna Echo Valley - Premium Interactive Map with Navigation</title>
    <style>
        :root {
            --bg: #0b1329;
            --panel-bg: #1c2541;
            --border: #3a506b;
            --accent: #48cae4;
            --accent-glow: rgba(72, 202, 228, 0.6);
            --text-main: #f8fafc;
            --text-sub: #cbd5e1;
        }
        
        body {
            font-family: 'SF Pro Display', -apple-system, sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            margin: 0;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-x: hidden;
        }

        h1 {
            margin: 15px 0 5px 0;
            font-size: 22px;
            color: #fff;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-align: center;
        }

        .subtitle {
            margin: 0 0 15px 0;
            color: #64748b;
            font-size: 13px;
            text-align: center;
            padding: 0 10px;
        }

        .btn-fullmap {
            background: rgba(28, 37, 65, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid #3a506b;
            color: #48cae4;
            padding: 12px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            transition: all 0.2s;
            margin-bottom: 20px;
        }

        @media (min-width: 1025px) {
            .btn-fullmap {
                position: fixed;
                top: 25px;
                right: 25px;
                margin-bottom: 0;
                z-index: 9999;
            }
        }

        .main-layout {
            max-width: 1400px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 20px;
        }

        @media (max-width: 1024px) {
            body { padding: 10px; }
            .main-layout { 
                grid-template-columns: 1fr;
                gap: 15px;
            }
            h1 { font-size: 20px; }
            .card-info { padding: 20px !important; }
        }

        .map-viewport {
            position: relative;
            background: #000;
            border-radius: 12px;
            overflow-x: auto;
            border: 1px solid var(--border);
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
            -webkit-overflow-scrolling: touch;
        }

        .map-wrapper {
            position: relative;
            min-width: 700px;
            width: 100%;
        }

        @media (min-width: 1025px) {
            .map-wrapper { min-width: auto; }
        }

        .map-viewport img {
            width: 100%;
            height: auto;
            display: block;
            transition: filter 0.4s ease;
        }

        .map-viewport.dimmed img {
            filter: brightness(0.4) contrast(1.1);
        }

        /* --- SVG NAVIGATION LAYER --- */
        .nav-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9;
        }

        .route-line {
            fill: none;
            stroke: #ff3366;
            stroke-width: 5;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: 0;
            transition: opacity 0.3s ease;
            stroke-dasharray: 8, 8;
            animation: dash 1s linear infinite;
        }

        .route-line.active {
            opacity: 1;
        }

        @keyframes dash {
            to {
                stroke-dashoffset: -20;
            }
        }

        .hotspot-pin {
            position: absolute;
            width: 24px;
            height: 24px;
            background-color: var(--accent);
            border-radius: 50%;
            border: 2px solid #fff;
            cursor: pointer;
            z-index: 10;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            transition: transform 0.2s ease, background-color 0.3s;
        }

        .hotspot-pin::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            width: 24px;
            height: 24px;
            border: 2px solid var(--accent);
            border-radius: 50%;
            animation: pulse-ring 1.8s cubic-bezier(0.215, 0.610, 0.355, 1) infinite;
        }

        .hotspot-pin:hover, .hotspot-pin.active {
            transform: translate(-50%, -50%) scale(1.2);
            background-color: #fff;
            border-color: var(--accent);
            box-shadow: 0 0 20px var(--accent-glow);
        }

        /* LOKASI LOBBY / ANDA DI SINI */
        .lobby-pin {
            position: absolute;
            width: 28px;
            height: 28px;
            background-color: #ffcc00;
            border-radius: 50%;
            border: 2px solid #fff;
            z-index: 11;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 15px rgba(255,204,0,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.7); opacity: 1; }
            80%, 100% { transform: scale(2.2); opacity: 0; }
        }

        .card-info {
            background: var(--panel-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        .info-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .buka { background: rgba(46, 204, 113, 0.2); color: #2ecc71; border: 1px solid #2ecc71; }
        .penuh { background: rgba(231, 76, 60, 0.2); color: #e74c3c; border: 1px solid #e74c3c; }

        .meta-tag {
            font-size: 11px;
            color: #94a3b8;
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-desc {
            font-size: 14px;
            line-height: 1.5;
            color: var(--text-sub);
            margin-bottom: 20px;
        }

        .text-section { margin-bottom: 15px; }
        .text-section h4 {
            margin: 0 0 4px 0;
            font-size: 11px;
            text-transform: uppercase;
            color: var(--accent);
            letter-spacing: 0.5px;
        }
        .text-section p {
            margin: 0;
            font-size: 13.5px;
            line-height: 1.5;
            color: #edf2f7;
        }

        /* BUTTON TUNJUK JALAN */
        .btn-nav-trigger {
            background: #ff3366;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(255,51,102,0.3);
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-nav-trigger:hover {
            background: #ff5588;
        }
        .btn-nav-trigger:active {
            transform: scale(0.98);
        }

        .placeholder {
            text-align: center;
            color: #64748b;
            font-style: italic;
            font-size: 13.5px;
        }

        .audio-hud {
            position: fixed;
            bottom: 15px;
            right: 15px;
            background: rgba(28, 37, 65, 0.95);
            border: 1px solid var(--border);
            padding: 8px 12px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            color: var(--text-sub);
            z-index: 9999;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
            backdrop-filter: blur(8px);
        }
        .audio-hud button {
            background: var(--accent);
            border: none;
            color: #090d16;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 700;
            cursor: pointer;
            font-size: 10px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="audio-hud">
        <span>🎵 BGM:</span>
        <button id="bgm-toggle-btn" onclick="toggleAmbientBGM()">Play</button>
    </div>

    <h1>Luna Echo Valley Resort & Eco Garden</h1>
    <p class="subtitle">Tap any pulsing hotspot on the map to display facility details and routes.</p>

    <a href="map-full.html" class="btn-fullmap" onclick="playClickSound()">
        Full Map Mode (Laser Focus) ➔
    </a>

    <div class="main-layout">
        <div class="map-viewport" id="map-viewport">
            <div class="map-wrapper">
                <img src="map.jpg" alt="Resort Map">

                <svg class="nav-layer" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path id="route-moraia-suites" class="route-line" d="M 55,50 L 65,40 L 81.3,29" />
                    <path id="route-selene-villas" class="route-line" d="M 55,50 L 70,35 L 91.5,22.8" />
                    <path id="route-pavilion-restaurant" class="route-line" d="M 55,50 L 66.8,35" />
                    <path id="route-amora-spa" class="route-line" d="M 55,50 L 68,55 L 80.5,57.5" />
                    <path id="route-luna-hot-springs" class="route-line" d="M 55,50 L 65,65 L 77.2,70" />
                    <path id="route-tennis-courts" class="route-line" d="M 55,50 L 70,70 L 88.5,78.5" />
                    
                    <path id="route-orchid-greenhouse" class="route-line" d="M 55,50 L 38,45 L 21.8,42.5" />
                    <path id="route-butterfly-sanctuary" class="route-line" d="M 55,50 L 35,55 L 20.2,59.5" />
                    <path id="route-organic-farm" class="route-line" d="M 55,50 L 42.2,52.8" />
                    <path id="route-horse-stable" class="route-line" d="M 55,50 L 48.2,33.8" />
                </svg>

                <div class="lobby-pin" style="top: 50%; left: 55%;">⛺</div>

                <div class="hotspot-pin" style="top: 29%; left: 81.3%;" onclick="paparInfo(this, 'moraia-suites')"></div>
                <div class="hotspot-pin" style="top: 22.8%; left: 91.5%;" onclick="paparInfo(this, 'selene-villas')"></div>
                <div class="hotspot-pin" style="top: 35%; left: 66.8%;" onclick="paparInfo(this, 'pavilion-restaurant')"></div>
                <div class="hotspot-pin" style="top: 57.5%; left: 80.5%;" onclick="paparInfo(this, 'amora-spa')"></div>
                <div class="hotspot-pin" style="top: 70%; left: 77.2%;" onclick="paparInfo(this, 'luna-hot-springs')"></div>
                <div class="hotspot-pin" style="top: 78.5%; left: 88.5%;" onclick="paparInfo(this, 'tennis-courts')"></div>
                
                <div class="hotspot-pin" style="top: 42.5%; left: 21.8%;" onclick="paparInfo(this, 'orchid-greenhouse')"></div>
                <div class="hotspot-pin" style="top: 59.5%; left: 20.2%;" onclick="paparInfo(this, 'butterfly-sanctuary')"></div>
                <div class="hotspot-pin" style="top: 52.8%; left: 42.2%;" onclick="paparInfo(this, 'organic-farm')"></div>
                <div class="hotspot-pin" style="top: 33.8%; left: 48.2%;" onclick="paparInfo(this, 'horse-stable')"></div>
            </div>
        </div>

        <div class="card-info" id="card-info">
            <div id="info-content" class="placeholder">
                Select a pulsing pin on the map to explore features and routes.
            </div>
        </div>
    </div>

    <script src="map-data.js"></script>
    <script>
        let audioCtx = null;
        let bgmInterval = null;
        let isPlayingBGM = false;

        function startAmbientBGM() {
            if (!audioCtx) { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); }
            const notes = [261.63, 293.66, 329.63, 392.00, 440.00, 523.25];
            function playSoftTone() {
                if (!isPlayingBGM) return;
                let osc = audioCtx.createOscillator();
                let gain = audioCtx.createGain();
                let randomNote = notes[Math.floor(Math.random() * notes.length)];
                osc.frequency.setValueAtTime(randomNote / 2, audioCtx.currentTime);
                osc.type = 'triangle';
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.04, audioCtx.currentTime + 1.5);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 4.5);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start();
                osc.stop(audioCtx.currentTime + 4.5);
            }
            isPlayingBGM = true;
            playSoftTone();
            bgmInterval = setInterval(playSoftTone, 2500);
        }

        function stopAmbientBGM() { isPlayingBGM = false; clearInterval(bgmInterval); }

        function toggleAmbientBGM() {
            const btn = document.getElementById('bgm-toggle-btn');
            if (!isPlayingBGM) {
                startAmbientBGM();
                btn.innerText = "Mute";
                btn.style.background = "#e74c3c";
                btn.style.color = "#fff";
            } else {
                stopAmbientBGM();
                btn.innerText = "Play";
                btn.style.background = "var(--accent)";
                btn.style.color = "#090d16";
            }
        }

        function playClickSound() {
            let context = new (window.AudioContext || window.webkitAudioContext)();
            let osc = context.createOscillator();
            let gain = context.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(800, context.currentTime); 
            gain.gain.setValueAtTime(0.1, context.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, context.currentTime + 0.1);
            osc.connect(gain);
            gain.connect(context.destination);
            osc.start();
            osc.stop(context.currentTime + 0.1);
        }

        function speakDescription(text) {
            window.speechSynthesis.cancel(); 
            let utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'en-US'; 
            window.speechSynthesis.speak(utterance);
        }

        function tunjukJalan(slug, namaTempat) {
            playClickSound();
            // Padam semua laluan aktif sebelum ni
            document.querySelectorAll('.route-line').forEach(line => line.classList.remove('active'));
            
            // Aktifkan laluan spesifik untuk tempat ni
            const targetRoute = document.getElementById('route-' + slug);
            if(targetRoute) {
                targetRoute.classList.add('active');
                speakDescription(`Showing navigation route from Lobby to ${namaTempat}. Please follow the highlighted red path.`);
            }
        }

        function paparInfo(pin, slug) {
            playClickSound(); 
            if(!isPlayingBGM) { toggleAmbientBGM(); }

            // Padam laluan lama bila tukar pin
            document.querySelectorAll('.route-line').forEach(line => line.classList.remove('active'));

            document.querySelectorAll('.hotspot-pin').forEach(p => p.classList.remove('active'));
            pin.classList.add('active');
            
            document.getElementById('map-viewport').classList.add('dimmed');
            const cardInfo = document.getElementById('card-info');

            const data = resortData[slug];

            if(!data) {
                cardInfo.innerHTML = `<div class="placeholder" style="color:#e74c3c;">Zone data not found.</div>`;
                return;
            }

            const badgeClass = data.status === 'Available' ? 'buka' : 'penuh';

            // DAH DITAMBAH: BUTANG GET DIRECTIONS DI LINE 302
            cardInfo.innerHTML = `
                <div id="info-content">
                    <div class="info-header">
                        <div class="info-title">${data.name}</div>
                        <span class="badge-status ${badgeClass}">${data.status}</span>
                    </div>
                    <div class="meta-tag">Operation: ${data.operating_hours}</div>
                    <div class="info-desc">${data.desc}</div>
                    <div class="text-section">
                        <h4>Available Facilities</h4>
                        <p>${data.fac}</p>
                    </div>
                    <div class="text-section">
                        <h4>Key Activities</h4>
                        <p>${data.act}</p>
                    </div>
                    
                    <button class="btn-nav-trigger" onclick="tunjukJalan('${slug}', '${data.name}')">
                        📍 Get Directions From Lobby
                    </button>
                </div>
            `;

            if(window.innerWidth <= 1024) {
                cardInfo.scrollIntoView({ behavior: 'smooth' });
            }

            let voiceText = `Welcome to ${data.name}.`;
            speakDescription(voiceText);
        }

        document.querySelector('.map-viewport img').addEventListener('click', function(e) {
            window.speechSynthesis.cancel(); 
            document.getElementById('map-viewport').classList.remove('dimmed');
            document.querySelectorAll('.hotspot-pin').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.route-line').forEach(line => line.classList.remove('active'));
            document.getElementById('card-info').innerHTML = `<div class="placeholder">Select a zone to explore features and routes.</div>`;
            e.stopPropagation();
        });
    </script>
</body>
</html>
