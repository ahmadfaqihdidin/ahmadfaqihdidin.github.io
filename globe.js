import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js';

(function contactGlobe() {
    const wrap = document.getElementById('globe-wrap');
    const canvas = document.getElementById('globe-canvas');
    if (!wrap || !canvas) return;

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
    } catch (e) {
        wrap.style.display = 'none';
        document.getElementById('faqih-photo')?.classList.remove('hidden');
        return;
    }
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 100);
    camera.position.set(0, 0.4, 7.4);

    // --- Globe: dots distributed on a sphere ---
    const RADIUS = 2.6;
    const DOTS = 5200;
    const positions = new Float32Array(DOTS * 3);
    const colors = new Float32Array(DOTS * 3);
    const cBlue = new THREE.Color('#2563EB');
    const cNavy = new THREE.Color('#1E3A8A');
    const cLight = new THREE.Color('#93C5FD');
    for (let i = 0; i < DOTS; i++) {
        // Even distribution: Fibonacci sphere
        const y = 1 - (i / (DOTS - 1)) * 2;
        const r = Math.sqrt(1 - y * y);
        const theta = i * 2.399963229728653; // golden angle
        const x = Math.cos(theta) * r;
        const z = Math.sin(theta) * r;
        positions[i * 3] = x * RADIUS;
        positions[i * 3 + 1] = y * RADIUS;
        positions[i * 3 + 2] = z * RADIUS;
        const c = Math.random() < 0.7 ? cBlue : (Math.random() < 0.5 ? cNavy : cLight);
        colors[i * 3] = c.r; colors[i * 3 + 1] = c.g; colors[i * 3 + 2] = c.b;
    }
    const dotsGeo = new THREE.BufferGeometry();
    dotsGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    dotsGeo.setAttribute('color', new THREE.BufferAttribute(colors, 3));
    const globe = new THREE.Points(dotsGeo, new THREE.PointsMaterial({
        size: 0.045, vertexColors: true, transparent: true, opacity: 0.9, depthWrite: false
    }));
    scene.add(globe);

    // Faint solid core so back-side dots dim naturally
    const core = new THREE.Mesh(
        new THREE.SphereGeometry(RADIUS * 0.985, 48, 48),
        new THREE.MeshBasicMaterial({ color: 0xffffff, transparent: true, opacity: 0.88 })
    );
    scene.add(core);

    // --- Pulsing location marker: Semarang, Indonesia (lat -6.99, lon 110.42) ---
    const lat = -6.99 * Math.PI / 180;
    const lon = 110.42 * Math.PI / 180;
    const mx = RADIUS * Math.cos(lat) * Math.cos(lon);
    const my = RADIUS * Math.sin(lat);
    const mz = -RADIUS * Math.cos(lat) * Math.sin(lon);
    const marker = new THREE.Mesh(
        new THREE.SphereGeometry(0.07, 16, 16),
        new THREE.MeshBasicMaterial({ color: 0xF59E0B })
    );
    marker.position.set(mx, my, mz);
    globe.add(marker);
    // Pulse rings around the marker
    const rings = [];
    for (let i = 0; i < 2; i++) {
        const ring = new THREE.Mesh(
            new THREE.RingGeometry(0.12, 0.135, 32),
            new THREE.MeshBasicMaterial({ color: 0xF59E0B, transparent: true, opacity: 0.7, side: THREE.DoubleSide, depthWrite: false })
        );
        ring.position.copy(marker.position);
        // Orient the ring tangent to the sphere: its normal points outward along the radius
        ring.lookAt(marker.position.x * 2, marker.position.y * 2, marker.position.z * 2);
        ring.userData.offset = i * 0.5;
        globe.add(ring);
        rings.push(ring);
    }

    // --- Floating wireframe accents ---
    const accents = [];
    function addAccent(geo, color, pos, scale, speed) {
        const m = new THREE.Mesh(geo, new THREE.MeshBasicMaterial({ color, wireframe: true, transparent: true, opacity: 0.35 }));
        m.position.set(pos[0], pos[1], pos[2]);
        m.scale.setScalar(scale);
        m.userData.speed = speed;
        accents.push(m);
        scene.add(m);
    }
    addAccent(new THREE.TorusGeometry(0.5, 0.06, 8, 24), '#2563EB', [-3.4, 1.9, -1], 1, 0.006);
    addAccent(new THREE.IcosahedronGeometry(0.45, 0), '#F59E0B', [3.5, -1.7, -1], 1, -0.005);
    addAccent(new THREE.OctahedronGeometry(0.4, 0), '#1E3A8A', [3.1, 2.0, -2], 1, 0.004);

    // --- Interaction: drag to rotate ---
    let dragging = false, lastX = 0, dragVel = 0;
    canvas.addEventListener('pointerdown', (e) => { dragging = true; lastX = e.clientX; canvas.setPointerCapture(e.pointerId); });
    window.addEventListener('pointerup', () => { dragging = false; });
    window.addEventListener('pointermove', (e) => {
        if (!dragging) return;
        const dx = e.clientX - lastX;
        lastX = e.clientX;
        globe.rotation.y += dx * 0.005;
        dragVel = dx * 0.005;
    });

    // --- Resize ---
    function resize() {
        const w = wrap.clientWidth, h = wrap.clientHeight;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
    }
    resize();
    if (window.ResizeObserver) new ResizeObserver(resize).observe(wrap);
    else window.addEventListener('resize', resize);

    // --- Render loop (pause when offscreen) ---
    let visible = true;
    new IntersectionObserver((entries) => { visible = entries[0].isIntersecting; }, { threshold: 0 }).observe(wrap);

    const clock = new THREE.Clock();
    (function animate() {
        requestAnimationFrame(animate);
        if (!visible) return;
        const t = clock.getElapsedTime();

        // Idle spin + momentum after drag
        if (!dragging) {
            globe.rotation.y += 0.0022 + dragVel;
            dragVel *= 0.94;
        }
        globe.position.y = Math.sin(t * 0.8) * 0.12;

        // Pulse rings expand & fade
        rings.forEach(r => {
            const p = ((t + r.userData.offset) % 1.6) / 1.6;
            r.scale.setScalar(1 + p * 2.2);
            r.material.opacity = 0.65 * (1 - p);
        });

        accents.forEach(a => {
            a.rotation.x += a.userData.speed;
            a.rotation.y += a.userData.speed * 1.3;
            a.position.y += Math.sin(t + a.position.x) * 0.001;
        });

        renderer.render(scene, camera);
    })();
})();
