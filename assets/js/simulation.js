/**
 * OSI Explorer — Data Transmission Simulation
 * Simulates how data travels through all 7 OSI layers
 */

const SIMULATION_STEPS = {
    sender: [
        {
            layer: 7, name: "Application",
            action: "Membuat data aplikasi",
            detail: (msg, proto) => `Aplikasi membuat request ${proto} dengan pesan: "${msg}"`,
            encapLabel: `${''} App Header`,
            encapColor: "#a855f7"
        },
        {
            layer: 6, name: "Presentation",
            action: "Enkripsi & format data",
            detail: (msg, proto) => `Data di-encode (UTF-8) dan dienkripsi dengan SSL/TLS`,
            encapLabel: "Pres. Header",
            encapColor: "#6366f1"
        },
        {
            layer: 5, name: "Session",
            action: "Membuat sesi koneksi",
            detail: (msg, proto) => `Session ID dibuat: SID-${Math.random().toString(36).substr(2, 8).toUpperCase()}`,
            encapLabel: "Session Header",
            encapColor: "#3b82f6"
        },
        {
            layer: 4, name: "Transport",
            action: "Segmentasi & port assignment",
            detail: (msg, proto) => {
                const ports = { HTTP: 80, FTP: 21, SMTP: 25, DNS: 53 };
                return `Data disegmentasi → Port Sumber: ${1024 + Math.floor(Math.random() * 64000)}, Port Tujuan: ${ports[proto] || 80} (${proto})`;
            },
            encapLabel: "TCP/UDP Header",
            encapColor: "#06b6d4"
        },
        {
            layer: 3, name: "Network",
            action: "Routing & IP addressing",
            detail: (msg, proto) => `IP Sumber: 192.168.1.${Math.floor(Math.random()*254)+1} → IP Tujuan: 203.0.113.${Math.floor(Math.random()*254)+1} | TTL: 64`,
            encapLabel: "IP Header",
            encapColor: "#10b981"
        },
        {
            layer: 2, name: "Data Link",
            action: "Framing & MAC addressing",
            detail: (msg, proto) => {
                const mac = () => Array.from({length:6}, () => Math.floor(Math.random()*256).toString(16).padStart(2,'0')).join(':');
                return `MAC Src: ${mac()} → MAC Dst: ${mac()} | FCS (CRC-32) ditambahkan`;
            },
            encapLabel: "ETH Header",
            encapTrailer: "FCS",
            encapColor: "#f59e0b"
        },
        {
            layer: 1, name: "Physical",
            action: "Konversi ke sinyal",
            detail: (msg, proto) => `Data dikonversi menjadi sinyal listrik/optik → Bit stream: ${Array.from({length: 24}, () => Math.round(Math.random())).join('')}...`,
            encapLabel: "Bits",
            encapColor: "#ef4444"
        }
    ],
    receiver: [
        {
            layer: 1, name: "Physical",
            action: "Menerima sinyal",
            detail: () => `Sinyal listrik/optik diterima dan dikonversi kembali menjadi bit stream digital`
        },
        {
            layer: 2, name: "Data Link",
            action: "Dekapsulasi frame",
            detail: () => `MAC address diverifikasi ✓ | FCS checked: Integrity OK ✓ | Ethernet header dilepas`
        },
        {
            layer: 3, name: "Network",
            action: "Dekapsulasi packet",
            detail: () => `IP address tujuan diverifikasi ✓ | IP header dilepas | Paket ditemukan`
        },
        {
            layer: 4, name: "Transport",
            action: "Reassembly segment",
            detail: () => `Port tujuan diverifikasi ✓ | Segmen di-reassemble | TCP/UDP header dilepas | ACK dikirim`
        },
        {
            layer: 5, name: "Session",
            action: "Verifikasi sesi",
            detail: () => `Session ID diverifikasi ✓ | Sesi aktif | Session header dilepas`
        },
        {
            layer: 6, name: "Presentation",
            action: "Dekripsi & decode data",
            detail: () => `Data didekripsi (SSL/TLS) ✓ | Format didecode (UTF-8) ✓ | Presentation header dilepas`
        },
        {
            layer: 7, name: "Application",
            action: "Data diterima aplikasi",
            detail: (msg, proto) => `Aplikasi menerima data: "${msg}" melalui protokol ${proto} ✅`
        }
    ]
};

let simRunning = false;
let simTimeout = null;

document.addEventListener('DOMContentLoaded', () => {
    const btnStart = document.getElementById('btnStartSim');
    const btnReset = document.getElementById('btnResetSim');
    const btnClearLog = document.getElementById('btnClearLog');

    if (btnStart) btnStart.addEventListener('click', startSimulation);
    if (btnReset) btnReset.addEventListener('click', resetSimulation);
    if (btnClearLog) btnClearLog.addEventListener('click', clearLog);
});

function getSimSpeed() {
    const speed = document.getElementById('simSpeed')?.value || 'normal';
    return { slow: 1500, normal: 800, fast: 350 }[speed];
}

async function startSimulation() {
    if (simRunning) return;
    simRunning = true;

    const message = document.getElementById('simMessage')?.value || 'Hello World!';
    const protocol = document.getElementById('simProtocol')?.value || 'HTTP';
    const delay = getSimSpeed();

    // Disable button
    const btnStart = document.getElementById('btnStartSim');
    btnStart.disabled = true;
    btnStart.innerHTML = '<span>Simulasi Berjalan...</span>';

    // Reset visual states
    resetLayerVisuals();
    clearLog();
    resetEncapViewer();

    // Log the start
    addLog('info', `🚀 Memulai simulasi pengiriman data "${message}" via ${protocol}`);

    // Send to PHP for processing
    const phpData = await sendToPHP(message, protocol);
    if (phpData) {
        addLog('info', `📡 Server response: ${phpData.message || 'OK'}`);
    }

    // === SENDER SIDE (Enkapsulasi) ===
    addLog('info', '━━━ FASE ENKAPSULASI (Pengirim) ━━━');

    const encapLayers = [];

    for (let i = 0; i < SIMULATION_STEPS.sender.length; i++) {
        const step = SIMULATION_STEPS.sender[i];
        const layerEl = document.querySelector(`.sim-layer[data-layer="${step.layer}"][data-side="sender"]`);

        if (layerEl) {
            layerEl.classList.add('processing');
            layerEl.querySelector('.sl-status').textContent = '⚡ Processing...';
        }

        addLog('send', `Layer ${step.layer} (${step.name}): ${step.detail(message, protocol)}`);

        // Build encapsulation visualization
        encapLayers.push(step);
        updateEncapViewer(encapLayers, message);

        await sleep(delay);

        if (layerEl) {
            layerEl.classList.remove('processing');
            layerEl.classList.add('done');
            layerEl.querySelector('.sl-status').textContent = '✓ Done';
        }
    }

    // === NETWORK TRANSMISSION ===
    addLog('network', '━━━ TRANSMISI DATA MELALUI MEDIA ━━━');
    addLog('network', '📦 Paket data dikirim melalui media transmisi (kabel/wireless)...');

    const dataPacket = document.getElementById('dataPacket');
    if (dataPacket) {
        dataPacket.classList.add('visible');
    }

    await sleep(delay * 2);

    if (dataPacket) {
        dataPacket.classList.remove('visible');
    }

    // === RECEIVER SIDE (Dekapsulasi) ===
    addLog('info', '━━━ FASE DEKAPSULASI (Penerima) ━━━');

    for (let i = 0; i < SIMULATION_STEPS.receiver.length; i++) {
        const step = SIMULATION_STEPS.receiver[i];
        const layerEl = document.querySelector(`.sim-layer[data-layer="${step.layer}"][data-side="receiver"]`);

        if (layerEl) {
            layerEl.classList.add('processing');
            layerEl.querySelector('.sl-status').textContent = '⚡ Processing...';
        }

        addLog('receive', `Layer ${step.layer} (${step.name}): ${step.detail(message, protocol)}`);

        // Remove encapsulation layers
        if (encapLayers.length > 0) {
            encapLayers.pop();
            updateEncapViewer(encapLayers, message, true);
        }

        await sleep(delay);

        if (layerEl) {
            layerEl.classList.remove('processing');
            layerEl.classList.add('done');
            layerEl.querySelector('.sl-status').textContent = '✓ Done';
        }
    }

    // === COMPLETE ===
    addLog('success', `✅ Data "${message}" berhasil dikirim dari pengirim ke penerima melalui 7 layer OSI!`);
    
    showFinalEncap(message);

    simRunning = false;
    btnStart.disabled = false;
    btnStart.innerHTML = `
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        <span>Mulai Simulasi</span>
    `;
}

async function sendToPHP(message, protocol) {
    try {
        const response = await fetch('api/simulate.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message, protocol })
        });
        if (response.ok) {
            return await response.json();
        }
    } catch (e) {
        console.log('PHP Simulation API not available');
    }
    return null;
}

function resetSimulation() {
    simRunning = false;
    if (simTimeout) clearTimeout(simTimeout);

    const btnStart = document.getElementById('btnStartSim');
    if (btnStart) {
        btnStart.disabled = false;
        btnStart.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            <span>Mulai Simulasi</span>
        `;
    }

    resetLayerVisuals();
    clearLog();
    resetEncapViewer();

    addLog('info', 'Simulasi direset. Siap untuk simulasi baru.');
}

function resetLayerVisuals() {
    document.querySelectorAll('.sim-layer').forEach(el => {
        el.classList.remove('processing', 'done');
        el.querySelector('.sl-status').textContent = '';
    });

    const dataPacket = document.getElementById('dataPacket');
    if (dataPacket) dataPacket.classList.remove('visible');
}

function resetEncapViewer() {
    const display = document.getElementById('encapDisplay');
    if (display) {
        display.innerHTML = '<div class="encap-initial"><p>Mulai simulasi untuk melihat proses enkapsulasi data secara real-time</p></div>';
    }
}

function updateEncapViewer(layers, message, decap = false) {
    const display = document.getElementById('encapDisplay');
    if (!display) return;

    if (layers.length === 0) {
        display.innerHTML = `
            <div class="encap-visual">
                <div class="encap-label">${decap ? '🔓 Dekapsulasi selesai — Data asli diterima' : ''}</div>
                <div class="encap-row">
                    <div class="encap-data-block" style="border-color: #a855f7; text-align: center; justify-content: center; padding: 16px;">
                        📄 "${message}"
                    </div>
                </div>
            </div>
        `;
        return;
    }

    let html = '<div class="encap-visual">';
    html += `<div class="encap-label">${decap ? '🔓 Proses Dekapsulasi' : '🔒 Proses Enkapsulasi'} — Layer ${layers.length === 1 ? layers[0].layer : layers[layers.length - 1].layer + ' → ' + layers[0].layer}</div>`;

    // Build the encapsulation visualization
    html += '<div class="encap-row">';

    // Headers from outermost to innermost
    const reversed = [...layers].reverse();
    reversed.forEach(layer => {
        html += `<div class="encap-header-block" style="background: ${layer.encapColor}22; color: ${layer.encapColor}; border: 1px solid ${layer.encapColor}33;">${layer.encapLabel}</div>`;
    });

    // Data
    html += `<div class="encap-data-block">📄 "${message}"</div>`;

    // Trailer (only for Data Link)
    const hasTrailer = layers.some(l => l.encapTrailer);
    if (hasTrailer) {
        const trailerLayer = layers.find(l => l.encapTrailer);
        html += `<div class="encap-trailer-block" style="background: ${trailerLayer.encapColor}22; color: ${trailerLayer.encapColor}; border: 1px solid ${trailerLayer.encapColor}33;">${trailerLayer.encapTrailer}</div>`;
    }

    html += '</div></div>';
    display.innerHTML = html;
}

function showFinalEncap(message) {
    const display = document.getElementById('encapDisplay');
    if (!display) return;

    display.innerHTML = `
        <div class="encap-visual">
            <div class="encap-label">✅ Transmisi berhasil — Data diterima oleh aplikasi!</div>
            <div class="encap-row" style="justify-content: center;">
                <div class="encap-data-block" style="border-color: #10b981; text-align: center; justify-content: center; padding: 20px; background: rgba(16, 185, 129, 0.05);">
                    ✅ 📄 "${message}"
                </div>
            </div>
        </div>
    `;
}

/* =============================================
   LOGGING SYSTEM
   ============================================= */
function addLog(type, msg) {
    const logBody = document.getElementById('logBody');
    if (!logBody) return;

    const now = new Date();
    const time = now.toTimeString().split(' ')[0];

    const entry = document.createElement('div');
    entry.className = `log-entry log-${type}`;
    entry.innerHTML = `
        <span class="log-time">${time}</span>
        <span class="log-msg">${msg}</span>
    `;

    logBody.appendChild(entry);
    logBody.scrollTop = logBody.scrollHeight;
}

function clearLog() {
    const logBody = document.getElementById('logBody');
    if (logBody) logBody.innerHTML = '';
}

/* =============================================
   UTILITIES
   ============================================= */
function sleep(ms) {
    return new Promise(resolve => {
        simTimeout = setTimeout(resolve, ms);
    });
}
