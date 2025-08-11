// Menjalankan script setelah seluruh konten DOM dimuat
document.addEventListener("DOMContentLoaded", () => {
  // --- Three.js Enhanced 3D Portrait ---
  let scene, camera, renderer, portrait, particles;
  let mouseX = 0,
    mouseY = 0;
  let targetX = 0,
    targetY = 0;
  const windowHalfX = window.innerWidth / 2;
  const windowHalfY = window.innerHeight / 2;

  function init3D() {
    const container = document.getElementById("canvas-container");
    if (!container) return; // Keluar jika container tidak ditemukan

    // Scene setup
    scene = new THREE.Scene();
    scene.fog = new THREE.Fog(0x0a0a0a, 100, 1000);

    // Camera setup
    camera = new THREE.PerspectiveCamera(
      75,
      window.innerWidth / window.innerHeight,
      0.1,
      1000
    );
    camera.position.z = 5;

    // Renderer setup
    renderer = new THREE.WebGLRenderer({
      antialias: true,
      alpha: true,
      powerPreference: "high-performance",
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    container.appendChild(renderer.domElement);

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.3);
    scene.add(ambientLight);
    const pointLight1 = new THREE.PointLight(0xd4af37, 1.2);
    pointLight1.position.set(5, 5, 5);
    scene.add(pointLight1);
    const pointLight2 = new THREE.PointLight(0xc0c0c0, 0.8);
    pointLight2.position.set(-5, -5, -5);
    scene.add(pointLight2);

    // Portrait Group
    const portraitGroup = new THREE.Group();
    const headGeometry = new THREE.SphereGeometry(1, 64, 64);
    const headMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xd4af37,
      metalness: 0.7,
      roughness: 0.2,
      clearcoat: 1,
      clearcoatRoughness: 0.1,
      emissive: 0x444444,
      emissiveIntensity: 0.2,
    });
    const head = new THREE.Mesh(headGeometry, headMaterial);
    portraitGroup.add(head);

    // Wireframe layers
    for (let i = 0; i < 3; i++) {
      const wireframeMaterial = new THREE.MeshBasicMaterial({
        color: i === 0 ? 0xc0c0c0 : i === 1 ? 0x9b59b6 : 0x3498db,
        wireframe: true,
        transparent: true,
        opacity: 0.3 - i * 0.1,
      });
      const wireframe = new THREE.Mesh(headGeometry, wireframeMaterial);
      wireframe.scale.set(1.01 + i * 0.02, 1.01 + i * 0.02, 1.01 + i * 0.02);
      portraitGroup.add(wireframe);
    }

    // Particle system
    const particlesGeometry = new THREE.BufferGeometry();
    const particlesCount = 1000;
    const posArray = new Float32Array(particlesCount * 3);
    for (let i = 0; i < particlesCount * 3; i += 3) {
      const radius = 2 + Math.random() * 3;
      const theta = Math.random() * Math.PI * 2;
      const phi = Math.random() * Math.PI;
      posArray[i] = radius * Math.sin(phi) * Math.cos(theta);
      posArray[i + 1] = radius * Math.sin(phi) * Math.sin(theta);
      posArray[i + 2] = radius * Math.cos(phi);
    }
    particlesGeometry.setAttribute(
      "position",
      new THREE.BufferAttribute(posArray, 3)
    );
    const particlesMaterial = new THREE.PointsMaterial({
      size: 0.01,
      transparent: true,
      opacity: 0.8,
      blending: THREE.AdditiveBlending,
    });
    particles = new THREE.Points(particlesGeometry, particlesMaterial);
    portraitGroup.add(particles);

    portrait = portraitGroup;
    scene.add(portrait);

    document.addEventListener("mousemove", onDocumentMouseMove);
    window.addEventListener("resize", onWindowResize);

    animate(); // Memulai animasi
  }

  function onDocumentMouseMove(event) {
    mouseX = (event.clientX - windowHalfX) / 100;
    mouseY = (event.clientY - windowHalfY) / 100;
  }

  function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  }

  function animate() {
    requestAnimationFrame(animate);
    targetX += (mouseX - targetX) * 0.05;
    targetY += (mouseY - targetY) * 0.05;

    if (portrait) {
      portrait.rotation.y = targetX * 0.5;
      portrait.rotation.x = targetY * 0.3;
      if (particles) {
        particles.rotation.y += 0.001;
        particles.rotation.x += 0.0005;
      }
    }
    renderer.render(scene, camera);
  }

  // --- Custom Cursor ---
  const cursor = document.querySelector(".cursor");
  const cursorFollower = document.querySelector(".cursor-follower");
  if (cursor && cursorFollower) {
    let cursorX = 0,
      cursorY = 0,
      followerX = 0,
      followerY = 0;

    window.addEventListener("mousemove", (e) => {
      cursorX = e.clientX;
      cursorY = e.clientY;
    });

    function animateCursor() {
      followerX += (cursorX - followerX) * 0.1;
      followerY += (cursorY - followerY) * 0.1;

      cursor.style.left = cursorX + "px";
      cursor.style.top = cursorY + "px";
      cursorFollower.style.left = followerX + "px";
      cursorFollower.style.top = followerY + "px";

      requestAnimationFrame(animateCursor);
    }
    animateCursor();

    document
      .querySelectorAll(
        "a, button, .skill-card, .stat-card, .timeline-content, .contact-item, .social-link"
      )
      .forEach((el) => {
        el.addEventListener("mouseenter", () => cursor.classList.add("hover"));
        el.addEventListener("mouseleave", () =>
          cursor.classList.remove("hover")
        );
      });
  }

  // --- Scroll Animations (Intersection Observer) ---
  const observerOptions = { threshold: 0.1, rootMargin: "0px 0px -50px 0px" };
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");
        if (entry.target.classList.contains("skill-card")) {
          const progressFill = entry.target.querySelector(".progress-fill");
          if (progressFill) {
            setTimeout(() => {
              progressFill.style.width =
                progressFill.style.getPropertyValue("--progress");
            }, 300);
          }
        }
        observer.unobserve(entry.target); // Optimasi: berhenti mengamati setelah animasi berjalan
      }
    });
  }, observerOptions);

  document
    .querySelectorAll(
      ".about-text, .about-image, .skill-card, .stat-card, .timeline-item"
    )
    .forEach((el) => {
      observer.observe(el);
    });

  // --- Navbar & FAB Scroll Effects ---
  const navbar = document.getElementById("navbar");
  const fab = document.getElementById("fab");
  if (navbar && fab) {
    let lastScroll = 0;
    window.addEventListener("scroll", () => {
      const currentScroll = window.scrollY;

      navbar.classList.toggle("scrolled", currentScroll > 50);
      fab.classList.toggle("show", currentScroll > 500);

      if (currentScroll > lastScroll && currentScroll > 500) {
        navbar.style.transform = "translateY(-100%)";
      } else {
        navbar.style.transform = "translateY(0)";
      }
      lastScroll = currentScroll <= 0 ? 0 : currentScroll;
    });
  }

  // --- Mobile Menu Toggle ---
  const mobileToggle = document.getElementById("mobileToggle");
  const navLinks = document.getElementById("navLinks");
  if (mobileToggle && navLinks) {
    mobileToggle.addEventListener("click", () => {
      mobileToggle.classList.toggle("active");
      navLinks.classList.toggle("active");
      document.body.style.overflow = navLinks.classList.contains("active")
        ? "hidden"
        : "";
    });

    document.querySelectorAll(".nav-links a").forEach((link) => {
      link.addEventListener("click", () => {
        mobileToggle.classList.remove("active");
        navLinks.classList.remove("active");
        document.body.style.overflow = "";
      });
    });
  }

  // --- Contact Form Handler ---
  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    contactForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const form = e.target;
      const status = document.getElementById("formStatus");
      const data = new FormData(form);

      status.style.color = "var(--text-muted)";
      status.textContent = "Sending...";
      status.classList.add("show");

      try {
        const response = await fetch(form.action, {
          method: form.method,
          body: data,
          headers: { Accept: "application/json" },
        });

        if (response.ok) {
          status.textContent = "Thanks for your message!";
          status.style.color = "#4ade80"; // Green
          form.reset();
        } else {
          const responseData = await response.json();
          if (Object.hasOwn(responseData, "errors")) {
            status.textContent = responseData["errors"]
              .map((error) => error["message"])
              .join(", ");
          } else {
            status.textContent =
              "Oops! There was a problem submitting your form";
          }
          status.style.color = "#ff6b6b"; // Red
        }
      } catch (error) {
        status.textContent = "Oops! There was a problem submitting your form";
        status.style.color = "#ff6b6b"; // Red
      } finally {
        setTimeout(() => {
          status.classList.remove("show");
        }, 5000);
      }
    });
  }

  // --- Dynamic Copyright Year ---
  const copyrightYear = document.getElementById("copyright-year");
  if (copyrightYear) {
    copyrightYear.textContent = new Date().getFullYear();
  }

  // --- Preloader ---
  const preloader = document.getElementById("preloader");
  if (preloader) {
    window.addEventListener("load", () => {
      setTimeout(() => {
        preloader.classList.add("hidden");
      }, 500); // Mengurangi delay untuk pengalaman pengguna yang lebih cepat
    });
  }

  // --- Initialize 3D Scene ---
  init3D();
});
