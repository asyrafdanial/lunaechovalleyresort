<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luna Echo Valley - Full Map Laser Focus</title>
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

        /* --- BUTTON BACK (DAH ADA SEMULA & RESPONSIVE) --- */
        .btn-back {
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
            margin-bottom: 20px; /* Jarak untuk mobile view */
            align-self: center;
        }

        /* Kedudukan di PC (Melayang kiri atas) */
        @media (min-width: 1025px) {
            .btn-back {
                position: fixed;
                top: 25px;
                left: 25px;
                margin-bottom: 0;
                z-index: 9999;
                align-self: flex-start;
            }
        }

        /* --- FULL MAP RESPONSIVE LAYOUT --- */
        .fullmap-layout {
            max-width: 1600px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 25px;
            margin-top: 10px;
        }

        @media (max-width: 1024px) {
            .fullmap-layout {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .card-info {
                padding: 20px !important;
                width: 100%;
                box-sizing: border-box;
            }
        }

        /* --- MAP VIEWPORT (SCROLLABLE ON MOBILE) --- */
        .map-viewport {
            position: relative;
            background: #000;
            border-radius: 12px;
            overflow-x: auto;
            border: 1px solid var(--border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            -webkit-overflow-scrolling: touch;
        }

        .map-wrapper {
            position: relative;
            min-width: 800px;
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
            filter: brightness(0.35) contrast(1.1);
        }

        /* --- HOTSPOT PINS --- */
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
            box-shadow: 0 0 12px rgba(0,0,0,0.6);
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
            transform: translate(-50%, -50%) scale(1.25);
            background-color: #fff;
            border-color: var(--accent);
            box-shadow: 0 0 25px var(--accent-glow);
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.7); opacity: 1; }
            80%, 100% { transform: scale(2.2); opacity: 0; }
        }

        /* --- CARD INFO TABLE/BOX (FIXED) --- */
        .card-info {
            background: var(--panel-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-self: start;
        }

        .info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        .info-title {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
        }

        .badge-status {
            padding: 4px 12px;
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
            margin-bottom: 18px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-desc {
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-sub);
            margin-bottom: 22px;
        }

        .text-section {
            margin-bottom: 18px;
            animation: slideIn 0.4s ease forwards;
        }

        .text-section h4 {
            margin: 0 0 5px 0;
            font-size: 11px;
            text-transform: uppercase;
            color: var(--accent);
            letter-spacing: 0.5px;
        }

        .text-section p {
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
            color: #edf2f7;
        }

        .placeholder {
            text-align: center;
            color: #64748b;
            font-style: italic;
            font-size: 14px;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <a href="index.php" class="btn-back" onclick="playClickSound()">
        ⬅ Back to Dashboard
    </a>

    <div class="fullmap-layout">
        
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
                Tap on any pulsing point on the full map to inspect real-time facility logistics.
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

            let voiceText = `Inspecting ${localData.name}.`;
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
    document.getElementById('card-info').innerHTML = `<div class="placeholder">Tap on any pulsing point on the full map to inspect real-time facility logistics.</div>`;
    e.stopPropagation();
});
</script>

</body>
</html>