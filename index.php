<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luna Echo Valley - Premium Interactive Map</title>
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

        /* --- FULL MAP BUTTON (DAH DIKEMBALIKAN & RESPONSIVE) --- */
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
            margin-bottom: 20px; /* Jarak untuk skrin mobile */
        }

        /* Kedudukan di PC (Melayang bucu kanan atas) */
        @media (min-width: 1025px) {
            .btn-fullmap {
                position: fixed;
                top: 25px;
                right: 25px;
                margin-bottom: 0;
                z-index: 9999;
            }
        }

        /* --- RESPONSIVE LAYOUT SYSTEM --- */
        .main-layout {
            max-width: 1400px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 20px;
        }

        @media (max-width: 1024px) {
            body {
                padding: 10px;
            }
            .main-layout { 
                grid-template-columns: 1fr;
                gap: 15px;
            }
            h1 { font-size: 20px; }
            .card-info { padding: 20px !important; }
        }

        /* --- MAP CONTAINER WITH SCROLL FOR MOBILE --- */
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
            .map-wrapper {
                min-width: auto;
            }
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

        /* --- HOTSPOT PINS WITH TOUCH OPTIMIZATION --- */
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
            opacity: 1;
        }

        .hotspot-pin:hover, .hotspot-pin.active {
            transform: translate(-50%, -50%) scale(1.2);
            background-color: #fff;
            border-color: var(--accent);
            box-shadow: 0 0 20px var(--accent-glow);
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.7); opacity: 1; }
            80%, 100% { transform: scale(2.2); opacity: 0; }
        }

        /* --- CLEAN TEXT SIDE PANEL --- */
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

        .text-section {
            margin-bottom: 15px;
        }

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

        .placeholder {
            text-align: center;
            color: #64748b;
            font-style: italic;
            font-size: 13.5px;
            line-height: 1.5;
        }

        /* --- FLOATING MASCOTS --- */
        .mascot {
            position: absolute;
            font-size: 32px;
            z-index: 50;
            pointer-events: none;
            user-select: none;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.5));
        }

        .cute-bear {
            bottom: -10px;
            left: -20px;
            animation: floatBear 6s ease-in-out infinite;
        }

        .cute-horse {
            top: -40px;
            right: 10px;
            animation: floatHorse 8s ease-in-out infinite;
        }

        @media (max-width: 768px) {
            .mascot { display: none; }
        }

        @keyframes floatBear {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(8deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        @keyframes floatHorse {
            0% { transform: translate(0px, 0px) rotate(0deg); }
            50% { transform: translate(-10px, -15px) rotate(-6deg); }
            100% { transform: translate(0px, 0px) rotate(0deg); }
        }

        /* AUDIO HUD */
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
    <p class="subtitle">Tap any pulsing hotspot on the map to display facility details with Voice guidance.</p>

    <a href="map-full.php" class="btn-fullmap" onclick="playClickSound()">
        Full Map Mode (Laser Focus) ➔
    </a>

    <div class="main-layout">
        
        <div class="mascot cute-bear">🧸</div>
        <div class="mascot cute-horse">🐴</div>
        
        <div class="map-viewport" id="map-viewport">
            <div class="map-wrapper">
                <img src="map.jpg" alt="Resort Map">

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
                Select a pulsing pin on the map to explore its features.
            </div>
        </div>

    </div>

<script>
const englishTranslations = {
    'moraia-suites': {
        name: 'Moraia Suites Wing',
        desc: 'The main accommodation wing offering luxurious rooms with panoramic hill views and natural forest scenery.',
        fac: 'King-sized beds, private balconies, smart room controls, premium en-suite bathrooms.',
        act: 'Relaxing, enjoying sunsets, room-service dining.'
    },
    'selene-villas': {
        name: 'Selene Villas',
        desc: 'Exclusive, private premium villas nested at the highest point of the resort grounds for maximum seclusion.',
        fac: 'Private plunge pools, dedicated butler service, outdoor rain showers, mini-bars.',
        act: 'Private retreats, honey-moon stays, stargazing.'
    },
    'pavilion-restaurant': {
        name: 'The Pavilion Restaurant',
        desc: 'An open-air dining pavilion offering exquisite organic farm-to-table culinary dishes and refreshments.',
        fac: 'Spacious dining hall, live kitchen counter, buffet island, lounge seating.',
        act: 'Gourmet dining, food tasting, evening beverage social hours.'
    },
    'amora-spa': {
        name: 'Amora Spa & Wellness Center',
        desc: 'A premium relaxation center offering authentic traditional body massages and holistic aromatherapy.',
        fac: 'Therapy rooms, sauna cabins, massage decks, relaxation lounges.',
        act: 'Traditional massages, skin treatments, deep meditation sessions.'
    },
    'luna-hot-springs': {
        name: 'Luna Natural Hot Springs',
        desc: 'Natural geothermal pools rich with healthy minerals, perfect for relaxing your body and sore muscles.',
        fac: 'Thermostatic spring pools, changing lockers, clean shower stations, seating benches.',
        act: 'Mineral soaking, thermal hydrotherapy, evening relaxation.'
    },
    'tennis-courts': {
        name: 'Tennis Courts & Fitness Pavilion',
        desc: 'Outdoor sport layouts and recreation spaces for guests looking to maintain an active lifestyle.',
        fac: 'Standard regulation tennis courts, sports gear rental lockers, night floodlighting.',
        act: 'Tennis matches, morning drills, physical workouts.'
    },
    'orchid-greenhouse': {
        name: 'Orchid Greenhouse',
        desc: 'A climate-controlled glass facility housing a breathtaking collection of rare exotic orchid species.',
        fac: 'Misting irrigation lines, plant information plaques, display walk-paths.',
        act: 'Botanical photography, educational tours, nature walking.'
    },
    'butterfly-sanctuary': {
        name: 'Butterfly Sanctuary',
        desc: 'An enclosed botanical dome filled with thousands of vibrant, free-flying native butterfly species.',
        fac: 'Enclosed netted dome, nectar feeding stations, beautiful floral pathways.',
        act: 'Insect macro photography, educational group tours, lepidoptera observation.'
    },
    'organic-farm': {
        name: 'Organic Farm & Apiary',
        desc: 'An eco-friendly agriculture plot producing fresh organic vegetables and premium natural honey.',
        fac: 'Vegetable vegetable patches, honey-bee apiary boxes, composting bays.',
        act: 'Agricultural harvesting tours, fresh honey sampling, eco-farming workshops.'
    },
    'horse-stable': {
        name: 'Horse Stable & Riding Trail',
        desc: 'Equestrian facilities managing well-trained horses with scenic trail pathways through the resort forest.',
        fac: 'Fenced horse paddocks, riding gear lockers, training rings, natural wilderness trails.',
        act: 'Guided horse riding, stable feeding sessions, equestrian photo shoots.'
    }
};

let audioCtx = null;
let bgmInterval = null;
let isPlayingBGM = false;

function startAmbientBGM() {
    if (!audioCtx) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
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

function stopAmbientBGM() {
    isPlayingBGM = false;
    clearInterval(bgmInterval);
}

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

function paparInfo(pin, slug) {
    playClickSound(); 
    if(!isPlayingBGM) { toggleAmbientBGM(); }

    document.querySelectorAll('.hotspot-pin').forEach(p => p.classList.remove('active'));
    pin.classList.add('active');
    
    const viewport = document.getElementById('map-viewport');
    viewport.classList.add('dimmed');

    const cardInfo = document.getElementById('card-info');

    fetch('get_zone.php?slug=' + slug)
        .then(response => response.json())
        .then(data => {
            if(data.error) {
                cardInfo.innerHTML = `<div class="placeholder" style="color:#e74c3c;">${data.error}</div>`;
                return;
            }
            
            const localData = englishTranslations[slug] || {
                name: data.name,
                desc: data.description,
                fac: data.facilities,
                act: data.activities
            };

            const badgeClass = data.status.toLowerCase() === 'buka' ? 'buka' : 'penuh';
            const statusLabel = data.status.toLowerCase() === 'buka' ? 'Available' : 'Fully Booked';

            cardInfo.innerHTML = `
                <div id="info-content">
                    <div class="info-header">
                        <div class="info-title">${localData.name}</div>
                        <span class="badge-status ${badgeClass}">${statusLabel}</span>
                    </div>
                    <div class="meta-tag">Operation: ${data.operating_hours || '8:00 AM - 10:00 PM'}</div>
                    <div class="info-desc">${localData.desc}</div>
                    <div class="text-section">
                        <h4>Available Facilities</h4>
                        <p>${localData.fac}</p>
                    </div>
                    <div class="text-section">
                        <h4>Key Activities</h4>
                        <p>${localData.act}</p>
                    </div>
                </div>
            `;

            if(window.innerWidth <= 1024) {
                cardInfo.scrollIntoView({ behavior: 'smooth' });
            }

            let voiceText = `Welcome to ${localData.name}. ${localData.desc}`;
            speakDescription(voiceText);
        })
        .catch(() => {
            cardInfo.innerHTML = `<div class="placeholder" style="color:#e74c3c;">Error communicating with the server.</div>`;
        });
}

document.querySelector('.map-viewport img').addEventListener('click', function(e) {
    window.speechSynthesis.cancel(); 
    document.getElementById('map-viewport').classList.remove('dimmed');
    document.querySelectorAll('.hotspot-pin').forEach(p => p.classList.remove('active'));
    document.getElementById('card-info').innerHTML = `<div class="placeholder">Select a zone to explore.</div>`;
    e.stopPropagation();
});
</script>

</body>
</html>