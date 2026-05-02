/**
 * Particle Background Animation
 * Creates a beautiful network-like particle effect
 */
(function() {
    const canvas = document.getElementById('particleCanvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    let particles = [];
    let animationId;
    let width, height;
    
    const CONFIG = {
        particleCount: 60,
        maxDistance: 150,
        speed: 0.3,
        particleSize: 2,
        colors: [
            'rgba(168, 85, 247, 0.5)',   // purple
            'rgba(99, 102, 241, 0.5)',    // indigo
            'rgba(59, 130, 246, 0.4)',    // blue
            'rgba(6, 182, 212, 0.4)',     // cyan
            'rgba(16, 185, 129, 0.3)',    // emerald
        ],
        lineColor: 'rgba(99, 102, 241, 0.08)',
    };
    
    function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }
    
    function createParticle() {
        return {
            x: Math.random() * width,
            y: Math.random() * height,
            vx: (Math.random() - 0.5) * CONFIG.speed,
            vy: (Math.random() - 0.5) * CONFIG.speed,
            size: Math.random() * CONFIG.particleSize + 0.5,
            color: CONFIG.colors[Math.floor(Math.random() * CONFIG.colors.length)],
            alpha: Math.random() * 0.5 + 0.2,
        };
    }
    
    function init() {
        resize();
        particles = [];
        for (let i = 0; i < CONFIG.particleCount; i++) {
            particles.push(createParticle());
        }
    }
    
    function update() {
        particles.forEach(p => {
            p.x += p.vx;
            p.y += p.vy;
            
            if (p.x < 0 || p.x > width) p.vx *= -1;
            if (p.y < 0 || p.y > height) p.vy *= -1;
        });
    }
    
    function draw() {
        ctx.clearRect(0, 0, width, height);
        
        // Draw connections
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                
                if (dist < CONFIG.maxDistance) {
                    const opacity = (1 - dist / CONFIG.maxDistance) * 0.15;
                    ctx.strokeStyle = `rgba(99, 102, 241, ${opacity})`;
                    ctx.lineWidth = 0.5;
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        
        // Draw particles
        particles.forEach(p => {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            ctx.fillStyle = p.color;
            ctx.globalAlpha = p.alpha;
            ctx.fill();
            ctx.globalAlpha = 1;
        });
    }
    
    function animate() {
        update();
        draw();
        animationId = requestAnimationFrame(animate);
    }
    
    window.addEventListener('resize', () => {
        resize();
    });
    
    init();
    animate();
})();
