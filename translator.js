// ==========================================================================
// BILINGUAL TRANSLATION SYSTEM (ENGLISH & BAHASA INDONESIA)
// Ahmad Faqih Imaduddin - HSE & Training Professional Portfolio
// ==========================================================================

document.addEventListener("DOMContentLoaded", function () {
    const translations = {
        en: {
            // Navigation
            navAbout: "About",
            navSkills: "Skills",
            navServices: "Services",
            navExperience: "Experience",
            navPortfolio: "Portfolio",
            navCredentials: "Credentials",
            navContact: "Contact",
            navGetInTouch: "Get in touch",

            // Hero Section
            heroStatus: "Ready for HSE Leadership",
            heroTitle: "I'M<br/>AHMAD FAQIH I.",
            heroGreeting: "A proactive, data-driven Safety and People Development Specialist & AI Enthusiast with over 4 years of experience in the mining sector. Passionate about simplifying workflows, integrating advanced AI reasoning models, and transforming safety performance.",
            heroBtnDiscuss: "Let's Discuss",
            heroBtnExp: "View Experience",
            heroFollow: "Professional Profiles",
            heroSpecialtyTag: "Specialization",
            heroRole: "HSE SYSTEM &<br/>AI WORKFLOW SPECIALIST",
            heroSubGreeting: "Bridging compliance, operational safety, high-performance talent, and AI workflow automation.",

            // About Section
            aboutBadge: "Practical Training & SMKP Mining Audits",
            aboutMeLabel: "ABOUT ME",
            aboutTitle: "Driving Safety with Purpose, Simplifying Workflows with AI.",
            aboutDesc: "A dedicated HR, Training, and HSE professional and passionate AI Enthusiast. I specialize in simplifying complex business workflows, developing practical training curricula (SMKP, JSA, HIRA-DC), leading behavioral safety culture transformations, and digitizing competency evaluations through modern LMS and reasoning AI models (Claude, Gemini, ChatGPT). Demonstrates a proven track record of reducing basic safety competency gaps from 90% to 40% within 6 months.",
            aboutHighlight1Title: "Safety Standards",
            aboutHighlight1Desc: "AK3 Umum, POP First Line Supervisor, SMKP Minerba, ISO 45001 & ISO 14001 readiness.",
            aboutHighlight2Title: "Talent & L&D",
            aboutHighlight2Desc: "Young Leadership Program (YLP), TNA, TOT KKNI Lvl 4, QCC Six Sigma problem solving.",
            aboutHighlight3Title: "AI & Digital Builder",
            aboutHighlight3Desc: "AI Workflow Simplifier (Claude, Gemini, ChatGPT), LMS Platforms, GAMITAS HRIS, and Mobile Apps.",
            aboutReadMore: "Explore Career History",

            // Key Metrics
            stat1Label: "Years of Experience",
            stat1Sub: "Mining & Heavy Industry",
            stat2Label: "Key Initiatives",
            stat2Sub: "LMS, Programs & Audits",
            stat3Label: "Gap Reduction",
            stat3Sub: "From 90% down to 40% in 6 Mo",

            // Skills & Competency Matrix
            skillsTag: "Competency Matrix",
            skillsTitle: "Skills & Professional Mastery",
            skillsSub: "Proven proficiency across occupational safety, AI workflow automation, instructional design, and talent frameworks.",
            skill1: "HSE Training, Induction & SMKP Compliance",
            skill2: "Training Needs Analysis (TNA) & Curriculum Design",
            skill3: "AI Reasoning, Thinking Models & Workflow Simplification",
            skill4: "Recruitment & Talent Management Architecture",
            skill5: "LMS & Digital Learning Platform Development",
            skill6: "Quality Control Circle (QCC) & Lean Six Sigma",

            skillGroup1Title: "HSE & Risk Tools",
            skillGroup1List: `<li>• HIRA-DC / IBPR &amp; JSA Analysis</li><li>• SMKP Internal Audits &amp; Inspections</li><li>• Accident Investigation &amp; PICA</li><li>• Safety Campaign &amp; Communications</li><li>• P2K3 &amp; Emergency Response</li>`,
            skillGroup2Title: "Data & Analytics",
            skillGroup2List: `<li>• Google Spreadsheet (Expert)</li><li>• Microsoft Excel (Expert)</li><li>• Power BI / Looker Studio (Advanced)</li><li>• Competency &amp; Training Analytics</li><li>• Data Entry &amp; Audit Trail (Expert)</li>`,
            skillGroup3Title: "System & Dev",
            skillGroup3List: `<li>• LMS Platform Architecting</li><li>• Flutter / Kotlin Mobile Apps</li><li>• Laravel, PHP &amp; React / Vite</li><li>• SAP ERP &amp; HRIS Workflow</li><li>• AI Agentic Systems &amp; APIs</li>`,
            skillGroup4Title: "AI & Reasoning Models",
            skillGroup4List: `<div class="space-y-2"><div class="flex flex-wrap gap-1.5 mb-2"><span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-amber-50 text-amber-900 border border-amber-200 text-[10px] font-semibold"><svg class="w-3 h-3 text-[#CC785C]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L14.4 8.6L21 11L14.4 13.4L12 20L9.6 13.4L3 11L9.6 8.6L12 2Z"/></svg>Claude</span><span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-blue-50 text-blue-900 border border-blue-200 text-[10px] font-semibold"><svg class="w-3 h-3 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C12 7.5 7.5 12 2 12C7.5 12 12 16.5 12 22C12 16.5 16.5 12 22 12C16.5 12 12 7.5 12 2Z"/></svg>Gemini</span><span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-900 border border-emerald-200 text-[10px] font-semibold"><svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="currentColor"><path d="M22.28 10.37a5.55 5.55 0 0 0-.48-4.6 5.64 5.64 0 0 0-3.92-2.73 5.57 5.57 0 0 0-4.6.48 5.65 5.65 0 0 0-6.65 1.15 5.6 5.6 0 0 0-1.87 4.25 5.54 5.54 0 0 0 .48 4.6 5.64 5.64 0 0 0 3.92 2.73 5.57 5.57 0 0 0 4.6-.48 5.65 5.65 0 0 0 6.65-1.15 5.6 5.6 0 0 0 1.87-4.25z"/></svg>ChatGPT</span></div><ul class="text-xs text-slate-600 space-y-1"><li>• Workflow Automation &amp; Simplification</li><li>• Chain-of-Thought &amp; Deep Reasoning</li><li>• AI Prompt Engineering &amp; Agentic Flows</li><li>• Autonomous SOP &amp; Curriculum Generation</li></ul></div>`,

            // Services Section
            servicesTag: "Key Value Pillars",
            servicesTitle: "Services & Core Capabilities",
            servicesSubTitle: "Delivering structured frameworks that elevate human capabilities while enforcing bulletproof mining safety.",
            serviceCard1Title: "HSE System & Training",
            serviceCard1Desc: "Designing proprietary safety modules (JSA, HIRA-DC, Incident Investigation) and mandatory SMKP-aligned induction curriculums.",
            serviceCard2Title: "People Development",
            serviceCard2Desc: "Facilitating leadership acceleration (Young Leadership Program), succession pipelines, and continuous competency calibration.",
            serviceCard3Title: "System & LMS Dev",
            serviceCard3Desc: "Architecting web LMS platforms, digitizing assessments, competency matrix integration, and SAP ERP workflow synchronization.",
            serviceCard4Title: "HR & Recruitment",
            serviceCard4Desc: "End-to-end recruitment operations, psychological profiling, compensation grading benchmarks, and organizational change policies.",

            // Experience Section
            experienceTag: "Track Record",
            experienceTitle: "Professional Journey",
            experienceSubTitle: "Demonstrated accountability in mining safety governance and organizational human capital operations.",
            
            exp1Title: "Foreman - System, Compliance & Training, Promotion",
            exp1Company: "HSE (Health Safety Environment) - PT Ganda Alam Makmur",
            exp1Date: "12/2024 - Present",
            exp1List: `<li>Developed and delivered core internal HSE training modules: JSA, HIRA-DC, Incident Investigation, and Safety Communication.</li><li>Orchestrated mandatory safety inductions for newly joined employees and site contractor personnel aligned with SMKP standards.</li><li>Prepared and aligned internal audits for SMKP readiness, ISO 45001 (Safety), and ISO 14001 (Environment).</li><li><strong>Highlight:</strong> Drastically narrowed Basic Safety competency gaps from 90% to 40% within 6 months.</li><li><strong>Highlight:</strong> Designed and implemented a dedicated Practical Field Test Area for realistic vehicle driving assessments.</li><li><strong>Highlight:</strong> Co-engineered ECU remapping initiatives yielding a proven 15% fuel burn reduction on heavy dump fleets.</li>`,

            exp2Title: "Supervisor - People Development",
            exp2Company: "HRGA - PT Manoor Bulatn Lestari",
            exp2Date: "05/2024 - 12/2024",
            exp2List: `<li>Spearheaded comprehensive talent management frameworks, organizational career development, and change management.</li><li>Executed full-cycle recruitment workflows and oversaw digital pipeline transitions from screening to onboarding.</li><li>Conducted Training Needs Analysis (TNA) and delivered tailored programs to bridge workforce skill gaps.</li><li><strong>Highlight:</strong> Conceptualized and launched the 1-year "YLP - Young Leadership Program" for 24 high-caliber university graduates.</li><li><strong>Highlight:</strong> Standardized PKWT/PKWTT contracts for Fresh Graduates with 100% alignment to Indonesian labor regulations.</li>`,

            exp3Title: "Group Leader - System & Training, People Development",
            exp3Company: "HRGA - PT Putra Perkasa Abadi",
            exp3Date: "03/2022 - 12/2023",
            exp3List: `<li>Served as master trainer for company-wide QCC (Quality Control Circle) continuous improvement conventions.</li><li>Architected an internal web-based LMS complete with dynamic course modules, user accounts, and automated assessment tracking.</li><li>Formulated competency frameworks for all positions and managed orientation programs for fresh graduates and promotions.</li><li>Managed SAP/HRIS data entry, employee attendance ratios (ATR), and PPE workshop safety compliance checks.</li>`,

            // Testimonials Section
            testiTag: "Endorsements",
            testimonialsTitle: "What Industry Colleagues Say",
            testimonial1Text: `"Ahmad is a rare professional who bridges technical mining regulations with deeply engaging adult-learning pedagogy. His modules made safety personal, cutting our operational compliance gaps in half."`,
            testimonial1Name: "Mining Safety Superintendent",
            testimonial1Role: "PT Ganda Alam Makmur",
            testimonial2Text: `"The Young Leadership Program Ahmad structured was transformative. His clarity in career leveling and grading structures set a new standard for our organizational development."`,
            testimonial2Name: "Head of Human Capital",
            testimonial2Role: "PT Manoor Bulatn Lestari",

            // Portfolio Section
            portfolioTag: "Featured Initiatives",
            portfolioTitle: "High-Impact Projects & Digital Systems",
            portfolioSubTitle: "A showcase of engineering safety infrastructure, corporate talent programs, hardware IoT, and custom web & mobile platforms.",
            filterAll: "All Projects (10)",
            filterSafety: "Mining & Safety",
            filterTalent: "Talent & Leadership",
            filterDigital: "Digital Systems & LMS",
            viewDetails: "View Details",

            project1Cat: "Talent & Leadership",
            project1Title: "Young Leadership Program (YLP) & FGDP",
            project1DescShort: "Structured graduate mentorship & QCC operational projects with campus hiring at UGM/ITB.",

            project2Cat: "Mining Safety Infrastructure",
            project2Title: "LV Practical Field Test Area",
            project2DescShort: "Real-world competency verification circuit drastically reducing vehicle collision rates.",

            project3Cat: "LMS & HR Platform",
            project3Title: "GAMITAS LMS & HRIS Platform",
            project3DescShort: "Interactive syllabus builder, simulator analytics, and manpower competency evaluation.",

            project4Cat: "Safety Analytics & RCA",
            project4Title: "Safe Our Life - Performance Dashboard",
            project4DescShort: "Real-time TRIR/LTIR analytics, accident investigation 4M RCA, and multi-site compliance.",

            project5Cat: "Mobile App Engineering",
            project5Title: "Mobile HSE & Mining App",
            project5DescShort: "Mobile daily P2H inspection checklist, digital induction passport, and Emergency SOS.",

            project6Cat: "Master Trainer Delivery",
            project6Title: "Safety Training & Keynote Delivery",
            project6DescShort: "Hybrid keynote events, JSA/HIRA modules, LOTO, APAR, and safety mindset transformation.",

            project7Cat: "IoT & Hardware Safety",
            project7Title: "On Board Fleet Safe Assist (ESP32-S3 IoT)",
            project7DescShort: "Low-cost industrial hardware safety prototype for mining haul trucks with real-time fatigue monitoring & collision warning.",

            project8Cat: "Continuous Improvement & QCC",
            project8Title: "QCC Operational Improvement & Workshop Streamlining",
            project8DescShort: "8-step PDCA root-cause elimination & SOP standardization saving operational costs in heavy equipment workshop.",

            project9Cat: "Digital Platform Blueprint",
            project9Title: "NikahMudah.com - Digital Marketplace Blueprint",
            project9DescShort: "1st Place Winner in Business Model Canvas Competition for an affordable digital wedding vendor platform.",

            project10Cat: "Data Intelligence & BI",
            project10Title: "Looker Studio & Power BI HR Analytics Hub",
            project10DescShort: "Automated reporting suite tracking employee attendance ratios (ATR), training ROI, and competency coverage.",

            // Credentials & Education
            eduTag: "Academic",
            educationTitle: "Education",
            educationDegree: "Bachelor's Degree in Management",
            educationUniversity: "Universitas Islam Indonesia (UII)",
            educationDesc: `<li>Specialized in Risk Management, People Development &amp; Operations.</li><li>Awarded <strong>1st Place Champion</strong> in Faculty Business Model Canvas Competition (NikahMudah.com platform).</li><li>Public Relations Officer — Himpunan Mahasiswa Jurusan Manajemen (HMJM UII).</li><li>Committee Member for University New Student Orientation &amp; Documentation.</li>`,

            certsTag: "Verified Credentials",
            certsTitle: "Professional Certifications",
            cert1Title: "AK3 UMUM",
            cert1Issuer: "BNSP / Kemenaker RI",
            cert2Title: "Trainer (TOT) KKNI Level 4",
            cert2Issuer: "Badan Nasional Sertifikasi Profesi (BNSP)",
            cert3Title: "POP First Line Supervisor",
            cert3Issuer: "BNSP / KESDM Minerba",
            cert4Title: "Implementasi SMKP",
            cert4Issuer: "PPSDM Geominerba",
            cert5Title: "Staf Sumber Daya Manusia (SDM)",
            cert5Issuer: "Badan Nasional Sertifikasi Profesi (BNSP)",
            cert6Title: "Six Sigma (White Belt / QCC)",
            cert6Issuer: "ERZ Consultrain",

            // Contact Section
            contactTag: "Get In Touch",
            contactTitle: "Let's Build Something Amazing Together.",
            contactSubtitle: "Based in Semarang, Indonesia — open to opportunities worldwide.",
            contactLocationNote: "Available for full-time leadership, corporate safety consulting, LMS architecting, and industrial training keynote delivery.",
            contactHqNote: "Primary operations hub for mining safety training & organizational human resource programs.",
            contactEmailLabel: "Email Address",
            contactPhoneLabel: "Phone / WhatsApp",
            contactPhoneCensored: "(If interested, please contact via email)",
            contactLinkedInLabel: "LinkedIn Network",
            contactLocationLabel: "Location & Operations",
            contactAvailBadge: "Available for High-Impact Roles",
            contactAvailTitle: "Ready to Elevate Your Safety Culture & Talent Standards?",
            contactAvailDesc: "Whether you require certified SMKP minerba implementation, TOT competency training, corporate LMS architecture, or end-to-end HR frameworks, let's connect.",
            contactBtn: "Start a Conversation",

            // Footer Section
            footerRole: "HSE & Training Professional specialized in mining safety systems, talent frameworks, and operational competence.",
            footerLinksTitle: "Navigation",
            footerServicesTitle: "Core Expertise",
            footerLinkAbout: "About Me",
            footerLinkSkills: "Skills & Competence",
            footerLinkExperience: "Career Experience",
            footerLinkPortfolio: "Featured Initiatives",
            footerLinkCredentials: "Verified Credentials",
            footerContactTitle: "Direct Contact",
            footerContactPhone: "Phone: +62 821-••••-•••• (If interested, please contact via email)",
            footerContactLocation: "Location: Semarang, Central Java, Indonesia",
            footerRights: "All rights reserved.",
            footerMadeWith: "Made with 💕 by Istri Cantikku (Mimma M A)."
        },
        id: {
            // Navigation
            navAbout: "Tentang",
            navSkills: "Keahlian",
            navServices: "Layanan",
            navExperience: "Pengalaman",
            navPortfolio: "Portofolio",
            navCredentials: "Sertifikasi",
            navContact: "Kontak",
            navGetInTouch: "Hubungi Saya",

            // Hero Section
            heroStatus: "Siap untuk Kepemimpinan HSE",
            heroTitle: "SAYA<br/>AHMAD FAQIH I.",
            heroGreeting: "Spesialis K3, Pengembangan SDM & AI Enthusiast berbasis data dengan pengalaman lebih dari 4 tahun di sektor pertambangan dan alat berat. Bersemangat menyederhanakan alur kerja (workflow automation), mengintegrasikan model penalaran AI modern, dan mentransformasi keselamatan kerja.",
            heroBtnDiscuss: "Mari Berdiskusi",
            heroBtnExp: "Lihat Pengalaman",
            heroFollow: "Profil Profesional",
            heroSpecialtyTag: "Spesialisasi",
            heroRole: "PAKAR SISTEM HSE &<br/>OTOMASI WORKFLOW AI",
            heroSubGreeting: "Menghubungkan kepatuhan keselamatan operasional, talenta unggul, dan otomasi alur kerja cerdas.",

            // About Section
            aboutBadge: "Pelatihan Praktik & Audit SMKP Minerba",
            aboutMeLabel: "TENTANG SAYA",
            aboutTitle: "Mendorong Keselamatan Penuh Makna, Menyederhanakan Workflow dengan AI.",
            aboutDesc: "Profesional HR, Pelatihan, dan HSE serta seorang AI Enthusiast yang bersemangat. Spesialis dalam menyederhanakan alur kerja (workflow) yang rumit, merancang kurikulum K3 aplikatif (SMKP, JSA, HIRA-DC), memimpin transformasi budaya keselamatan kerja, serta digitalisasi evaluasi kompetensi melalui platform LMS dan model penalaran AI (Claude, Gemini, ChatGPT). Terbukti memangkas kesenjangan kompetensi dasar dari 90% menjadi 40% dalam 6 bulan.",
            aboutHighlight1Title: "Standar Keselamatan",
            aboutHighlight1Desc: "AK3 Umum, Pengawas Operasional Pertama (POP), SMKP Minerba, kesiapan audit ISO 45001 & ISO 14001.",
            aboutHighlight2Title: "Talenta & L&D",
            aboutHighlight2Desc: "Program Kepemimpinan Muda (YLP), TNA, TOT KKNI Lvl 4, pemecahan masalah GKM (QCC) Six Sigma.",
            aboutHighlight3Title: "AI & Pembangun Digital",
            aboutHighlight3Desc: "Penyederhana Workflow AI (Claude, Gemini, ChatGPT), Platform LMS, HRIS GAMITAS, dan Aplikasi Mobile.",
            aboutReadMore: "Lihat Riwayat Karier",

            // Key Metrics
            stat1Label: "Tahun Pengalaman",
            stat1Sub: "Tambang & Industri Berat",
            stat2Label: "Inisiatif Utama",
            stat2Sub: "LMS, Program & Audit",
            stat3Label: "Penurunan Gap",
            stat3Sub: "Dari 90% turun ke 40% dlm 6 Bln",

            // Skills & Competency Matrix
            skillsTag: "Matriks Kompetensi",
            skillsTitle: "Keahlian & Penguasaan Profesional",
            skillsSub: "Kemahiran teruji dalam keselamatan kerja pertambangan, otomasi workflow AI, desain instruksional, dan manajemen talenta.",
            skill1: "Pelatihan HSE, Induksi & Kepatuhan SMKP",
            skill2: "Analisis Kebutuhan Pelatihan (TNA) & Kurikulum",
            skill3: "Penalaran AI, Model Thinking & Otomasi Workflow",
            skill4: "Rekrutmen & Manajemen Talenta Karyawan",
            skill5: "Pengembangan Platform LMS & Pembelajaran Digital",
            skill6: "Gugus Kendali Mutu (QCC) & Lean Six Sigma",

            skillGroup1Title: "K3 & Manajemen Risiko",
            skillGroup1List: `<li>• Analisis HIRA-DC / IBPR &amp; JSA</li><li>• Audit Internal SMKP &amp; Inspeksi Lapangan</li><li>• Investigasi Insiden &amp; Formulasi PICA</li><li>• Kampanye &amp; Komunikasi Keselamatan Kerja</li><li>• Pengelolaan P2K3 &amp; Tanggap Darurat</li>`,
            skillGroup2Title: "Pengolahan Data & Analitik",
            skillGroup2List: `<li>• Google Spreadsheet (Tingkat Ahli)</li><li>• Microsoft Excel (Tingkat Ahli)</li><li>• Power BI / Looker Studio (Lanjutan)</li><li>• Analitik Kompetensi &amp; Efektivitas Training</li><li>• Entri Data &amp; Rekam Jejak Audit (Ahli)</li>`,
            skillGroup3Title: "Pengembangan Sistem",
            skillGroup3List: `<li>• Perancangan Platform Web LMS</li><li>• Aplikasi Mobile Flutter / Kotlin</li><li>• Laravel, PHP &amp; React / Vite</li><li>• Alur Kerja SAP ERP &amp; HRIS</li><li>• Sistem AI Agen &amp; API Orchestration</li>`,
            skillGroup4Title: "AI & Model Penalaran (Reasoning)",
            skillGroup4List: `<div class="space-y-2"><div class="flex flex-wrap gap-1.5 mb-2"><span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-amber-50 text-amber-900 border border-amber-200 text-[10px] font-semibold"><svg class="w-3 h-3 text-[#CC785C]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L14.4 8.6L21 11L14.4 13.4L12 20L9.6 13.4L3 11L9.6 8.6L12 2Z"/></svg>Claude</span><span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-blue-50 text-blue-900 border border-blue-200 text-[10px] font-semibold"><svg class="w-3 h-3 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C12 7.5 7.5 12 2 12C7.5 12 12 16.5 12 22C12 16.5 16.5 12 22 12C16.5 12 12 7.5 12 2Z"/></svg>Gemini</span><span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-900 border border-emerald-200 text-[10px] font-semibold"><svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="currentColor"><path d="M22.28 10.37a5.55 5.55 0 0 0-.48-4.6 5.64 5.64 0 0 0-3.92-2.73 5.57 5.57 0 0 0-4.6.48 5.65 5.65 0 0 0 6.65-1.15 5.6 5.6 0 0 0 1.87-4.25z"/></svg>ChatGPT</span></div><ul class="text-xs text-slate-600 space-y-1"><li>• Penyederhanaan &amp; Otomasi Workflow</li><li>• Penalaran Mendalam &amp; Chain-of-Thought</li><li>• Prompt Engineering &amp; Integrasi AI Agent</li><li>• Pembuatan SOP &amp; Silabus Otomatis</li></ul></div>`,

            // Services Section
            servicesTag: "Pilar Nilai Utama",
            servicesTitle: "Layanan & Kapabilitas Utama",
            servicesSubTitle: "Menghadirkan kerangka kerja terstruktur untuk meningkatkan kapabilitas SDM sekaligus menegakkan keselamatan tambang yang kokoh.",
            serviceCard1Title: "Sistem & Pelatihan HSE",
            serviceCard1Desc: "Menyusun modul internal (JSA, HIRA-DC, Investigasi Insiden) dan kurikulum induksi keselamatan kerja berbasis SMKP.",
            serviceCard2Title: "Pengembangan SDM",
            serviceCard2Desc: "Memfasilitasi akselerasi kepemimpinan (Young Leadership Program), jalur suksesi, dan kalibrasi kompetensi berkelanjutan.",
            serviceCard3Title: "Sistem & Pengembangan LMS",
            serviceCard3Desc: "Membangun platform LMS berbasis web, digitalisasi penilaian kerja, integrasi matriks kompetensi, dan sinkronisasi SAP ERP.",
            serviceCard4Title: "HR & Rekrutmen",
            serviceCard4Desc: "Operasional rekrutmen end-to-end, psikotes kerja, standarisasi jenjang kepangkatan dan gaji, serta manajemen perubahan.",

            // Experience Section
            experienceTag: "Rekam Jejak",
            experienceTitle: "Perjalanan Profesional",
            experienceSubTitle: "Tanggung jawab nyata dalam tata kelola keselamatan pertambangan dan operasional sumber daya manusia.",
            
            exp1Title: "Foreman - System, Compliance & Training, Promotion",
            exp1Company: "HSE (Health Safety Environment) - PT Ganda Alam Makmur",
            exp1Date: "12/2024 - Sekarang",
            exp1List: `<li>Mengembangkan dan menyampaikan modul pelatihan K3 internal: JSA, HIRA-DC, Investigasi Insiden, dan Komunikasi Keselamatan.</li><li>Memimpin induksi keselamatan kerja wajib bagi karyawan baru dan kontraktor selaras dengan standar SMKP.</li><li>Mengoordinasikan audit internal SMKP dan kesiapan sertifikasi ISO 45001 (K3) serta ISO 14001 (Lingkungan).</li><li><strong>Pencapaian:</strong> Memangkas kesenjangan kompetensi Basic Safety dari 90% menjadi 40% dalam tempo 6 bulan.</li><li><strong>Pencapaian:</strong> Merancang dan merealisasikan Area Uji Praktik Lapangan (Field Test Area) untuk simulasi berkendara nyata.</li><li><strong>Pencapaian:</strong> Bersinergi dalam inisiatif remapping ECU armada dump truck yang menghemat konsumsi BBM sebesar 15%.</li>`,

            exp2Title: "Supervisor - People Development",
            exp2Company: "HRGA - PT Manoor Bulatn Lestari",
            exp2Date: "05/2024 - 12/2024",
            exp2List: `<li>Memimpin strategi manajemen talenta, jalur kepemimpinan, dan penyusunan sasaran kinerja organisasi.</li><li>Mengelola rekrutmen end-to-end dan memimpin transisi digitalisasi alur kerja dari penyaringan hingga orientasi.</li><li>Melakukan Analisis Kebutuhan Pelatihan (TNA) dan menyusun program terfokus guna menutup kesenjangan keahlian.</li><li><strong>Pencapaian:</strong> Merancang dan meluncurkan "YLP - Program Kepemimpinan Muda" 1 tahun bagi 24 lulusan universitas terkemuka.</li><li><strong>Pencapaian:</strong> Menstandarisasi kontrak kerja PKWT/PKWTT bagi Fresh Graduate selaras 100% dengan regulasi ketenagakerjaan.</li>`,

            exp3Title: "Group Leader - System & Training, People Development",
            exp3Company: "HRGA - PT Putra Perkasa Abadi",
            exp3Date: "03/2022 - 12/2023",
            exp3List: `<li>Bertindak sebagai trainer utama pada konvensi Gugus Kendali Mutu (GKM/QCC) tingkat perusahaan.</li><li>Merancang platform LMS internal berbasis web lengkap dengan modul dinamis, akun pengguna, dan evaluasi otomatis.</li><li>Menyusun kamus kompetensi jabatan dan memandu orientasi lulusan baru serta promosi staf.</li><li>Mengelola entri data SAP/HRIS, rasio absensi (ATR), serta inspeksi kepatuhan APD area workshop.</li>`,

            // Testimonials Section
            testiTag: "Testimoni Rekan",
            testimonialsTitle: "Apa Kata Rekan Profesional",
            testimonial1Text: `"Ahmad adalah profesional berkarakter langka yang mampu menerjemahkan regulasi tambang yang rumit menjadi modul pelatihan yang sangat aplikatif. Pendekatan ini memangkas gap kompetensi kami hingga separuhnya."`,
            testimonial1Name: "Superintendent Keselamatan Tambang",
            testimonial1Role: "PT Ganda Alam Makmur",
            testimonial2Text: `"Program Young Leadership yang dirancang Ahmad memberikan dampak nyata. Kejelian beliau dalam menyusun leveling jabatan dan grading gaji menjadi standar baru manajemen SDM kami."`,
            testimonial2Name: "Head of Human Capital",
            testimonial2Role: "PT Manoor Bulatn Lestari",

            // Portfolio Section
            portfolioTag: "Inisiatif Unggulan",
            portfolioTitle: "Proyek Berdampak Tinggi & Sistem Digital",
            portfolioSubTitle: "Dokumentasi rekayasa infrastruktur keselamatan, program kepemimpinan talenta, hardware IoT, dan platform web serta mobile mandiri.",
            filterAll: "Semua Proyek (10)",
            filterSafety: "Tambang & K3",
            filterTalent: "Talenta & Kepemimpinan",
            filterDigital: "Sistem Digital & LMS",
            viewDetails: "Lihat Detail",

            project1Cat: "Talenta & Kepemimpinan",
            project1Title: "Program Kepemimpinan Muda (YLP) & FGDP",
            project1DescShort: "Mentoring terstruktur lulusan terbaik & proyek efisiensi GKM melalui campus hiring UGM/ITB.",

            project2Cat: "Infrastruktur Keselamatan Tambang",
            project2Title: "Area Uji Praktik Lapangan Light Vehicle (LV)",
            project2DescShort: "Sirkuit verifikasi kompetensi mengemudi nyata guna menekan insiden tabrakan kendaraan tambang.",

            project3Cat: "Platform LMS & HR",
            project3Title: "GAMITAS - Platform HRIS & LMS Terpadu",
            project3DescShort: "Syllabus builder interaktif, analitik simulator alat berat, dan evaluasi kompetensi manpower.",

            project4Cat: "Analitik K3 & Investigasi RCA",
            project4Title: "Safe Our Life - Dashboard Performa K3",
            project4DescShort: "Analitik TRIR/LTIR real-time, investigasi insiden metode 4M RCA, dan kepatuhan multi-site.",

            project5Cat: "Rekayasa Aplikasi Mobile",
            project5Title: "Aplikasi Mobile HSE Tambang",
            project5DescShort: "Checklist inspeksi harian P2H mobile, paspor induksi digital, dan tombol Darurat SOS.",

            project6Cat: "Master Trainer & Pembicara",
            project6Title: "Pelatihan Keselamatan Korporat & Keynote",
            project6DescShort: "Event hybrid korporat, modul JSA/HIRA, LOTO, APAR, dan transformasi mindset K3.",

            project7Cat: "IoT & Perangkat K3 Cerdas",
            project7Title: "On Board Fleet Safe Assist (ESP32-S3 IoT)",
            project7DescShort: "Prototipe perangkat keras keselamatan cerdas untuk truk tambang dengan monitoring kelelahan operator real-time.",

            project8Cat: "Continuous Improvement & GKM",
            project8Title: "Peningkatan Operasional GKM & Efisiensi Workshop",
            project8DescShort: "Metodologi 8 langkah PDCA eliminasi akar masalah & standardisasi SOP yang menghemat biaya operasional workshop.",

            project9Cat: "Arsitektur Platform Digital",
            project9Title: "NikahMudah.com - Platform Marketplace Digital",
            project9DescShort: "Juara 1 Kompetisi Business Model Canvas untuk platform digital agregasi vendor pernikahan terjangkau.",

            project10Cat: "Intelijen Data & Analitik BI",
            project10Title: "Hub Analitik Looker Studio & Power BI",
            project10DescShort: "Dashboard pelaporan otomatis memantau rasio kehadiran karyawan (ATR), ROI pelatihan, dan matriks kompetensi.",

            // Credentials & Education
            eduTag: "Akademik",
            educationTitle: "Pendidikan Formal",
            educationDegree: "Sarjana Manajemen (S.M)",
            educationUniversity: "Universitas Islam Indonesia (UII)",
            educationDesc: `<li>Spesialisasi Manajemen Risiko, Pengembangan SDM &amp; Operasional.</li><li>Meraih <strong>Juara 1</strong> Kompetisi Business Model Canvas Tingkat Fakultas (Platform NikahMudah.com).</li><li>Divisi Hubungan Masyarakat — Himpunan Mahasiswa Jurusan Manajemen (HMJM UII).</li><li>Panitia Acara Orientasi Mahasiswa Baru &amp; Dokumentasi Universitas.</li>`,

            certsTag: "Sertifikasi Resmi",
            certsTitle: "Sertifikasi Profesi",
            cert1Title: "AK3 UMUM",
            cert1Issuer: "BNSP / Kemenaker RI",
            cert2Title: "Trainer (TOT) KKNI Level 4",
            cert2Issuer: "Badan Nasional Sertifikasi Profesi (BNSP)",
            cert3Title: "POP Pengawas Operasional Pertama",
            cert3Issuer: "BNSP / KESDM Minerba",
            cert4Title: "Implementasi SMKP",
            cert4Issuer: "PPSDM Geominerba",
            cert5Title: "Staf Sumber Daya Manusia (SDM)",
            cert5Issuer: "Badan Nasional Sertifikasi Profesi (BNSP)",
            cert6Title: "Six Sigma (White Belt / QCC)",
            cert6Issuer: "ERZ Consultrain",

            // Contact Section
            contactTag: "Mari Terhubung",
            contactTitle: "Mari Ciptakan Karya Hebat Bersama.",
            contactSubtitle: "Berbasis di Semarang, Indonesia — terbuka untuk peluang kepemimpinan K3 & konsultasi di seluruh dunia.",
            contactLocationNote: "Tersedia untuk kepemimpinan penuh waktu, konsultasi K3 perusahaan, arsitektur LMS, dan pemateri pelatihan industri.",
            contactHqNote: "Pusat operasional utama untuk pelatihan keselamatan tambang & program pengembangan SDM.",
            contactEmailLabel: "Alamat Email",
            contactPhoneLabel: "Telepon / WhatsApp",
            contactPhoneCensored: "(Jika tertarik, silakan hubungi via email)",
            contactLinkedInLabel: "Jaringan LinkedIn",
            contactLocationLabel: "Lokasi & Operasional",
            contactAvailBadge: "Terbuka untuk Peran Berdampak Tinggi",
            contactAvailTitle: "Siap Meningkatkan Budaya Keselamatan & Standar Talenta Anda?",
            contactAvailDesc: "Baik Anda memerlukan implementasi tersertifikasi SMKP minerba, pelatihan kompetensi TOT, arsitektur LMS korporat, atau kerangka kerja HR menyeluruh, mari terhubung.",
            contactBtn: "Mulai Percakapan",

            // Footer Section
            footerRole: "Profesional HSE & Pelatihan berfokus pada sistem keselamatan tambang, kerangka kerja SDM, dan kompetensi operasional.",
            footerLinksTitle: "Navigasi Cepat",
            footerServicesTitle: "Keahlian Utama",
            footerLinkAbout: "Tentang Saya",
            footerLinkSkills: "Keahlian & Kompetensi",
            footerLinkExperience: "Pengalaman Kerja",
            footerLinkPortfolio: "Inisiatif Unggulan",
            footerLinkCredentials: "Sertifikasi Resmi",
            footerContactTitle: "Kontak Langsung",
            footerContactPhone: "Telepon: +62 821-••••-•••• (Jika tertarik, silakan hubungi via email)",
            footerContactLocation: "Lokasi: Semarang, Jawa Tengah, Indonesia",
            footerRights: "Hak cipta dilindungi undang-undang.",
            footerMadeWith: "Dibuat dengan 💕 oleh Istri Cantikku (Mimma M A)."
        }
    };

    window.currentLang = 'en';

    function setLanguage(lang) {
        window.currentLang = lang;
        const dict = translations[lang];
        if (!dict) return;

        document.documentElement.lang = lang;

        document.querySelectorAll('[data-lang-key]').forEach(el => {
            const key = el.getAttribute('data-lang-key');
            if (dict[key]) {
                el.innerHTML = dict[key];
            }
        });

        const indDesktop = document.getElementById('lang-indicator');
        const indMobile = document.getElementById('lang-indicator-mobile');
        if (indDesktop) indDesktop.textContent = lang === 'en' ? 'ID' : 'EN';
        if (indMobile) indMobile.textContent = lang === 'en' ? 'Bahasa Indonesia (ID)' : 'English (EN)';

        document.querySelectorAll('.lang-indicator-compact').forEach(el => {
            el.textContent = lang === 'en' ? 'ID' : 'EN';
        });

        window.dispatchEvent(new CustomEvent('langchange', { detail: { lang } }));
        document.dispatchEvent(new CustomEvent('langchange', { detail: { lang } }));
    }

    // Toggle button event bindings
    document.querySelectorAll('.btn-translate-toggle').forEach(btn => {
        btn.addEventListener('click', () => setLanguage(window.currentLang === 'en' ? 'id' : 'en'));
    });

    const btnTranslate = document.getElementById('translate-button');
    if (btnTranslate) btnTranslate.addEventListener('click', () => setLanguage(window.currentLang === 'en' ? 'id' : 'en'));

    const btnTranslateMobile = document.getElementById('translate-button-mobile');
    if (btnTranslateMobile) btnTranslateMobile.addEventListener('click', () => setLanguage(window.currentLang === 'en' ? 'id' : 'en'));

    const btnTranslateHeaderMobile = document.getElementById('translate-button-header-mobile');
    if (btnTranslateHeaderMobile) btnTranslateHeaderMobile.addEventListener('click', () => setLanguage(window.currentLang === 'en' ? 'id' : 'en'));

    // Set initial language to English
    setLanguage('en');
});
