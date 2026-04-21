<?php
/**
 * Template Name: Sterling Support Landing Page
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supporting Sterling | Overcoming the Stutter</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0ea5e9; --primary-dark: #0284c7; --secondary: #6366f1; --accent: #f43f5e; --bg-color: #0f172a; --text-main: #f8fafc; --text-muted: #cbd5e1; --glass-bg: rgba(30, 41, 59, 0.7); --glass-border: rgba(255, 255, 255, 0.1); --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background-color: var(--bg-color); color: var(--text-main); line-height: 1.6; overflow-x: hidden; position: relative; min-height: 100vh; }
        h1, h2, h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; }
        .blob { position: absolute; filter: blur(80px); z-index: -1; opacity: 0.6; animation: float 20s infinite ease-in-out alternate; }
        .blob-1 { top: -10%; left: -10%; width: 600px; height: 600px; background: radial-gradient(circle, var(--primary) 0%, transparent 70%); }
        .blob-2 { bottom: -10%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, var(--secondary) 0%, transparent 70%); animation-delay: -5s; }
        .blob-3 { top: 40%; left: 40%; width: 400px; height: 400px; background: radial-gradient(circle, var(--accent) 0%, transparent 70%); animation-delay: -10s; opacity: 0.3; }
        @keyframes float { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(50px, 50px) scale(1.1); } }
        .animate-up { opacity: 0; transform: translateY(30px); animation: slideUp 0.8s forwards cubic-bezier(0.16, 1, 0.3, 1); }
        .delay-1 { animation-delay: 0.2s; } .delay-2 { animation-delay: 0.4s; }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        .glass-nav { position: fixed; top: 0; width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 5%; background: var(--glass-bg); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border); z-index: 1000; }
        .logo { font-size: 1.5rem; font-weight: 800; background: linear-gradient(to right, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links a { color: var(--text-main); text-decoration: none; margin-left: 2rem; font-weight: 600; transition: color 0.3s; }
        .nav-links a:hover { color: var(--primary); }
        .hero { min-height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 0 5%; padding-top: 100px; }
        .hero-content { max-width: 800px; }
        h1 { font-size: 4.5rem; margin-bottom: 1rem; line-height: 1.1; }
        .highlight { background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .subtitle { font-size: 1.25rem; color: var(--text-muted); margin-bottom: 2.5rem; }
        .btn { display: inline-block; padding: 1rem 2rem; border-radius: 50px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; cursor: pointer; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4); border: none; }
        .btn-primary:hover { box-shadow: 0 6px 20px rgba(14, 165, 233, 0.6); transform: translateY(-2px); }
        .btn-secondary { background: rgba(255, 255, 255, 0.1); color: white; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); margin-left: 1rem; }
        .btn-secondary:hover { background: rgba(255, 255, 255, 0.2); transform: translateY(-2px); }
        .section-container { padding: 5rem 5%; max-width: 1400px; margin: 0 auto; }
        .section-header { margin-bottom: 3rem; text-align: center; }
        .section-header h2 { font-size: 2.5rem; margin-bottom: 1rem; }
        .section-header p { color: var(--text-muted); max-width: 600px; margin: 0 auto; }
        .glass-card { background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 24px; box-shadow: var(--glass-shadow); backdrop-filter: blur(20px); }
        .grid-layout { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; }
        .trigger-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 2rem; transition: transform 0.3s, background 0.3s; }
        .trigger-card:hover { transform: translateY(-5px); background: rgba(255,255,255,0.08); }
        .trigger-letter { font-size: 3rem; font-weight: 800; color: var(--accent); margin-bottom: 1rem; }
        .trigger-words li { margin-bottom: 0.5rem; color: var(--text-muted); font-size: 1.1rem; list-style: none; }
        .video-card { border-radius: 16px; overflow: hidden; background: rgba(0,0,0,0.4); box-shadow: var(--glass-shadow); border: 1px solid var(--glass-border); transition: transform 0.3s; }
        .video-card:hover { transform: scale(1.03); }
        .video-card video { width: 100%; height: 200px; object-fit: cover; display: block; cursor: pointer; }
        .video-info { padding: 1.5rem; }
        .video-info h3 { font-size: 1.2rem; margin-bottom: 0.5rem; }
        .video-info p { color: var(--text-muted); font-size: 0.9rem; }
        footer { text-align: center; padding: 3rem; border-top: 1px solid var(--glass-border); color: var(--text-muted); background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(10px); }
        @media (max-width: 768px) { h1 { font-size: 3rem; } .nav-links { display: none; } .btn-secondary { margin-left: 0; margin-top: 1rem; display: block; } }
    </style>
</head>
<body>
    <div class="blob blob-1"></div><div class="blob blob-2"></div><div class="blob blob-3"></div>

    <nav class="glass-nav">
        <div class="logo">Sterling's Support Core</div>
        <div class="nav-links">
            <a href="#about">Goals & Vision</a>
            <a href="#how-to-assist">How to Assist</a>
            <a href="#worksheets">iPad Worksheets</a>
            <a href="#upload">Upload Center</a>
            <a href="#videos">Video Log</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1 class="animate-up">Assisting <span class="highlight">Sterling</span></h1>
            <p class="subtitle animate-up delay-1">Creating a seamless, supportive learning environment to help him navigate through stuttering cycles. A central hub recognizing trigger words, tracking progress, and enabling iPad learning.</p>
            <div class="cta-group animate-up delay-2">
                <a href="#about" class="btn btn-primary">Our Goals</a>
                <a href="#worksheets" class="btn btn-secondary">Download Worksheets</a>
            </div>
        </div>
    </header>

    <main>
        <section id="about" class="glass-card section-container" style="margin-bottom: 2rem;">
            <div class="section-header">
                <h2>Page Goals & Vision</h2>
                <p>What we aim to achieve with Sterling's support hub.</p>
            </div>
            <div style="color: var(--text-muted); font-size: 1.1rem; line-height: 1.8; max-width: 900px; margin: 0 auto; background: rgba(255,255,255,0.05); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                <p><strong>Primary Goal:</strong> To create a unified, stress-free ecosystem for Sterling's progress. This portal allows his support network to easily understand his current needs, recognize stuttering triggers, and apply the correct assistance techniques without adding pressure.</p>
                <br>
                <p><strong>The iPad Tracing Initiative:</strong> We are building a continuous pipeline of educational resources. By uploading physical worksheets to this portal, they will eventually be converted into digital, traceable documents specifically optimized for iPad and Apple Pencil interaction, helping train cognitive and motor skills seamlessly.</p>
                <br>
                <p><strong>Long-Term Gamification:</strong> As Sterling progresses, these static exercises will evolve into interactive games directly accessible on his devices, turning speech adaptation and learning into an engaging, rewarding experience.</p>
            </div>
        </section>

        <section id="how-to-assist" class="glass-card section-container" style="margin-bottom: 2rem;">
            <div class="section-header">
                <h2>How to Assist Sterling</h2>
                <p>Actionable techniques to support him when his stuttering kicks up.</p>
            </div>
            <div class="grid-layout trigger-grid">
                <div class="trigger-card" style="background: rgba(99, 102, 241, 0.1);">
                    <div class="trigger-letter">⏳</div>
                    <h3>Maintain Natural Eye Contact</h3>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">Don't look away or show distress when he stutters. Patiently wait for him to finish his sentence without interrupting or finishing his words for him.</p>
                </div>
                <div class="trigger-card" style="background: rgba(14, 165, 233, 0.1);">
                    <div class="trigger-letter">👂</div>
                    <h3>Focus on 'What' Not 'How'</h3>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">Listen intently to the message he is conveying rather than the manner in which he is speaking. React entirely to the content of his sentence.</p>
                </div>
                <div class="trigger-card" style="background: rgba(244, 63, 94, 0.1);">
                    <div class="trigger-letter">🛑</div>
                    <h3>Avoid Unhelpful Advice</h3>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">Refrain from saying things like "slow down," "take a breath," or "relax." While well-meaning, these commands often increase pressure and self-consciousness.</p>
                </div>
            </div>
        </section>

        <section id="worksheets" class="section-container" style="margin-bottom: 2rem;">
            <div class="section-header">
                <h2>iPad Worksheets & Tracing Library</h2>
                <p>Downloadable files customized for iPad Apple Pencil use.</p>
            </div>
            <div class="grid-layout" style="display: flex; gap: 2rem; justify-content: center; flex-wrap: wrap;">
                <div class="glass-card" style="padding: 2rem; text-align: center; width: 300px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
                    <h3 style="margin-bottom: 0.5rem;">Letter Tracing Pack</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Digital trace-and-write module focusing on current trigger letters.</p>
                    <a href="#" class="btn btn-secondary" style="width: 100%; margin: 0;">Download PDF</a>
                </div>
                <div class="glass-card" style="padding: 2rem; text-align: center; width: 300px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">✍️</div>
                    <h3 style="margin-bottom: 0.5rem;">Daily Practice Log</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Blank writing templates for morning routines on the tablet.</p>
                    <a href="#" class="btn btn-secondary" style="width: 100%; margin: 0;">Download PDF</a>
                </div>
            </div>
        </section>

        <!-- NEW GAMIFICATION MODULE PROTOTYPE -->
        <section id="interactive-games" class="glass-card section-container" style="margin-bottom: 2rem; text-align: center;">
            <div class="section-header">
                <h2>Live Apple Pencil Game (Beta Protocol)</h2>
                <p>This is a live test of converting an uploaded document into a web game! Use your mouse or iPad Pencil on the canvas below to trace.</p>
            </div>
            <div style="background: rgba(0,0,0,0.5); padding: 2rem; border-radius: 16px; display: inline-block;">
                <h3 style="margin-bottom: 1rem; color: var(--primary);">Trace the Letter: 'S'</h3>
                <!-- The Canvas for Tracing -->
                <canvas id="tracingCanvas" width="400" height="400" style="background: #ffffff; border-radius: 12px; cursor: crosshair; touch-action: none; box-shadow: inset 0 0 20px rgba(0,0,0,0.5);"></canvas>
                
                <div style="margin-top: 1.5rem;">
                    <button class="btn btn-secondary" onclick="clearCanvas()">Clear Canvas</button>
                    <button class="btn btn-primary" onclick="alert('Great job Sterling! Progress Saved.')">Finish Tracing</button>
                </div>
            </div>
        </section>
        <!-- END GAMIFICATION MODULE -->

        <section id="upload" class="glass-card section-container" style="margin-bottom: 2rem; text-align: center;">
            <div class="section-header">
                <h2>Upload Center</h2>
                <p>Upload new videos or scanned documents to be added to Sterling's database.</p>
            </div>
            <div style="background: rgba(0,0,0,0.3); padding: 4rem; border-radius: 16px; border: 2px dashed rgba(255,255,255,0.2); max-width: 600px; margin: 0 auto; transition: background 0.3s;" id="dropzone">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📁</div>
                <h3 style="margin-bottom: 1rem;">Drag & Drop Files Here</h3>
                <p style="color: var(--text-muted); margin-bottom: 2rem;">Supports .mp4 videos for the video log, or image/PDF scans to be converted into iPad worksheets.</p>
                <label for="file-upload" class="btn btn-primary" style="cursor: pointer;">
                    Browse Computer
                </label>
                <input id="file-upload" type="file" style="display: none;" multiple accept="video/*, image/*, .pdf">
            </div>
        </section>

        <section id="triggers" class="glass-card section-container" style="margin-bottom: 2rem;">
            <div class="section-header">
                <h2>Identified Trigger Words</h2>
                <p>These words and starting letters have been identified as current stuttering triggers for Sterling based on recent evaluations.</p>
            </div>
            <div class="grid-layout trigger-grid" id="triggerContainer">
                <div class="trigger-card">
                    <div class="trigger-letter">...</div>
                    <ul class="trigger-words">
                        <li>(Waiting for document text...)</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="videos" class="section-container">
            <div class="section-header">
                <h2>Video Progress & Logs</h2>
                <p>Recent footage of Sterling capturing conversational patterns, struggles, and breakthroughs.</p>
            </div>
            <div class="grid-layout video-grid" id="videoContainer"></div>
        </section>
    </main>

    <footer>
        <p>Built for the friends, family, and support team surrounding Sterling. We're in this together.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const videos = [
                { file: "video_2026-04-21_08-50-38.mp4", date: "April 21, 2026 08:50 AM" },
                { file: "video_2026-04-21_08-51-43.mp4", date: "April 21, 2026 08:51 AM" },
                { file: "video_2026-04-21_08-51-48.mp4", date: "April 21, 2026 08:51 AM" },
                { file: "video_2026-04-21_08-51-52.mp4", date: "April 21, 2026 08:51 AM" },
                { file: "video_2026-04-21_08-52-17.mp4", date: "April 21, 2026 08:52 AM" },
                { file: "video_2026-04-21_08-52-22.mp4", date: "April 21, 2026 08:52 AM" }
            ];

            const videoContainer = document.getElementById("videoContainer");
            const wpUploadPath = "<?php echo get_stylesheet_directory_uri(); ?>/assets/videos/"; 

            videos.forEach((vid, index) => {
                const card = document.createElement("div");
                card.className = "video-card animate-up";
                card.style.animationDelay = `${0.1 * index}s`;

                const videoSrc = window.location.hostname === "" ? `videos/${vid.file}` : `${wpUploadPath}${vid.file}`;

                card.innerHTML = `
                    <video src="${videoSrc}" controls preload="metadata"></video>
                    <div class="video-info">
                        <h3>Video Log #${index + 1}</h3>
                        <p>Recorded: ${vid.date}</p>
                    </div>
                `;
                videoContainer.appendChild(card);
            });

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if(target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            // --- CANVAS DRAWING LOGIC FOR iPAD PENCIL/GAMIFICATION ---
            const canvas = document.getElementById("tracingCanvas");
            if(canvas) {
                const ctx = canvas.getContext("2d");
                let isDrawing = false;
                
                // Draw a faint guide letter "S" for him to trace
                function drawGuide() {
                    ctx.font = "bold 300px 'Outfit', sans-serif";
                    ctx.fillStyle = "rgba(220, 220, 220, 0.5)"; // Light grey guide
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText("S", canvas.width/2, canvas.height/2 + 20);
                }
                drawGuide();

                // Start drawing
                const startDrawing = (e) => {
                    isDrawing = true;
                    ctx.beginPath();
                    const { x, y } = getCoord(e);
                    ctx.moveTo(x, y);
                    e.preventDefault(); // Prevent scrolling on iPad while drawing
                };

                // Draw
                const draw = (e) => {
                    if (!isDrawing) return;
                    e.preventDefault();
                    const { x, y } = getCoord(e);
                    ctx.lineTo(x, y);
                    ctx.strokeStyle = "#0ea5e9"; // Blue ink
                    ctx.lineWidth = 15; // Thick stroke for kids
                    ctx.lineCap = "round";
                    ctx.lineJoin = "round";
                    ctx.stroke();
                };

                // Stop drawing
                const stopDrawing = () => { isDrawing = false; };

                // Get correct coordinate whether mouse or touch/pencil
                const getCoord = (e) => {
                    const rect = canvas.getBoundingClientRect();
                    if (e.touches && e.touches.length > 0) {
                        return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
                    }
                    return { x: e.clientX - rect.left, y: e.clientY - rect.top };
                };

                // Event Listeners for Apple Pencil / Touch / Mouse
                canvas.addEventListener("mousedown", startDrawing);
                canvas.addEventListener("mousemove", draw);
                canvas.addEventListener("mouseup", stopDrawing);
                canvas.addEventListener("mouseout", stopDrawing);
                
                canvas.addEventListener("touchstart", startDrawing, {passive: false});
                canvas.addEventListener("touchmove", draw, {passive: false});
                canvas.addEventListener("touchend", stopDrawing);
                
                // Global Clear Canvas Function
                window.clearCanvas = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    drawGuide();
                };
            }
        });
    </script>
</body>
</html>
