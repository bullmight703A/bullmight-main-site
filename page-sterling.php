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
        @keyframes pixarFloat { 0% { transform: translateY(0px) scale(1); } 50% { transform: translateY(-8px) scale(1.02); } 100% { transform: translateY(0px) scale(1); } }
        .pixar-float { animation: pixarFloat 3s ease-in-out infinite; transform-origin: center bottom; }
        @keyframes flyAcross { 0% { transform: translate(-20vw, 50vh) rotate(15deg) scale(0.5); } 25% { transform: translate(30vw, 20vh) rotate(-10deg) scale(0.7); } 50% { transform: translate(80vw, 60vh) rotate(20deg) scale(1); } 75% { transform: translate(120vw, 10vh) rotate(-15deg) scale(0.8); } 100% { transform: translate(-20vw, 50vh) rotate(15deg) scale(0.5); } }
        .flying-astronaut { position: fixed; z-index: 999; pointer-events: none; animation: flyAcross 35s infinite linear; opacity: 0.85; filter: drop-shadow(0 0 20px rgba(14,165,233,0.8)); }
        .glass-nav { position: fixed; top: 0; left: 0; width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 5%; background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255,255,255,0.15); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5); z-index: 9999; }
        .logo { font-size: 1.5rem; font-weight: 800; background: linear-gradient(to right, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links a { color: var(--text-main); text-decoration: none; margin-left: 2rem; font-weight: 600; transition: color 0.3s; }
        .nav-links a:hover { color: var(--primary); }
        body.admin-bar .glass-nav { top: 32px; }
        @media screen and (max-width: 782px) { body.admin-bar .glass-nav { top: 46px; } }
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
        .glass-card { background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 24px; box-shadow: var(--glass-shadow); backdrop-filter: blur(20px); width: 100%; box-sizing: border-box; }
        .grid-layout { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr)); gap: 2rem; width: 100%; box-sizing: border-box; }
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
<body <?php body_class(); ?>>
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sterling_spaceman.png" class="flying-astronaut" style="width: 150px; height: auto;" alt="Flying Sterling Astronaut">
    <div class="blob blob-1"></div><div class="blob blob-2"></div><div class="blob blob-3"></div>

    <nav class="glass-nav">
        <div class="logo">Sterling's Support Core</div>
        <div class="nav-links">
            <a href="#about">Goals & Vision</a>
            <a href="#how-to-assist">How to Assist</a>
            <a href="#interactive-games">Curriculum</a>
            <a href="#progress-tracker" style="color: var(--primary);">Completed Work</a>
            <a href="#upload">Upload Center</a>
            <a href="#videos">Support Guide</a>
            <a href="#special-moments">Special Moments</a>
        </div>
    </nav>

    <header class="hero" style="position: relative;">
        <!-- Decorative Floating Sterlings -->
        <div class="pixar-float" style="position: absolute; top: 15%; left: 8%; width: 120px; height: 120px; opacity: 0.7; display: none; @media(min-width: 768px){display: block;}">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sterling_spaceman.png" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div class="pixar-float delay-1" style="position: absolute; top: 55%; right: 8%; width: 150px; height: 150px; opacity: 0.6; display: none; @media(min-width: 768px){display: block;}">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sterling_spaceman.png" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div class="pixar-float delay-2" style="position: absolute; bottom: 5%; left: 20%; width: 90px; height: 90px; opacity: 0.5; display: none; @media(min-width: 768px){display: block;}">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sterling_spaceman.png" style="width: 100%; height: 100%; object-fit: contain;">
        </div>

        <div class="hero-content" style="position: relative; z-index: 2;">
            <h1 class="animate-up">Sterling's <span class="highlight">World</span></h1>
            <p class="subtitle animate-up delay-1">Creating a seamless, supportive learning environment to help him navigate through stuttering cycles. A central hub recognizing trigger words, tracking progress, and enabling iPad learning.</p>
            <div class="cta-group animate-up delay-2">
                <a href="#about" class="btn btn-primary">Our Goals</a>
                <a href="#interactive-games" class="btn btn-secondary">Interactive Curriculum</a>
            </div>
        </div>
    </header>

    <main>
        <section id="info-section" class="section-container" style="padding-top: 2rem; padding-bottom: 1rem;">
            <div class="curriculum-accordion">
                <details id="about" class="curriculum-module glass-card">
                    <summary>🎯 Page Goals & Vision</summary>
                    <div class="module-content">
                        <div style="color: var(--text-muted); font-size: 1.1rem; line-height: 1.8; max-width: 900px; margin: 0 auto; padding: 1rem;">
                            <p style="text-align: center; margin-bottom: 2rem;">What we aim to achieve with Sterling's support hub.</p>
                            <p><strong>Primary Goal:</strong> To create a unified, stress-free ecosystem for Sterling's progress. This portal allows his support network to easily understand his current needs, recognize stuttering triggers, and apply the correct assistance techniques without adding pressure.</p>
                            <br>
                            <p><strong>The iPad Tracing Initiative:</strong> We are building a continuous pipeline of educational resources. By uploading physical worksheets to this portal, they will eventually be converted into digital, traceable documents specifically optimized for iPad and Apple Pencil interaction, helping train cognitive and motor skills seamlessly.</p>
                            <br>
                            <p><strong>Long-Term Gamification:</strong> As Sterling progresses, these static exercises will evolve into interactive games directly accessible on his devices, turning speech adaptation and learning into an engaging, rewarding experience.</p>
                        </div>
                    </div>
                </details>

                <details id="how-to-assist" class="curriculum-module glass-card">
                    <summary>🤝 How to Assist Sterling</summary>
                    <div class="module-content">
                        <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Actionable techniques to support him when his stuttering kicks up.</p>
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
                    </div>
                </details>
            </div>
        </section>



        <!-- INTERACTIVE CURRICULUM MODULE -->
        <section id="interactive-games" class="glass-card section-container" style="margin-bottom: 2rem;">
            <div class="section-header" style="text-align: center;">
                <h2>Sterling's Interactive Curriculum</h2>
                <p>Select a learning module below to begin practice.</p>
            </div>
            
            <div class="curriculum-accordion">
                <!-- Reading & Speech -->
                <details class="curriculum-module" open>
                    <summary>✍️ Reading & Speech (Tracing Catalog)</summary>
                    <div class="module-content">
                        <div style="display: flex; flex-direction: column; gap: 2rem; align-items: center; padding-top: 1rem;">
                            
                            <!-- Selection Menu -->
                            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); width: 100%; max-width: 900px;">
                                <h3 style="margin-bottom: 1rem; font-size: 1.2rem; color: var(--text-muted); text-align: center;">Select an Exercise</h3>
                                
                                <div style="margin-bottom: 1.5rem;">
                                    <strong style="color: var(--primary); display: block; margin-bottom: 0.5rem; text-align: center;">Focus Triggers</strong>
                                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;" id="focus-exercises">
                                        <!-- Populated by JS -->
                                    </div>
                                </div>

                                <div>
                                    <strong style="color: var(--secondary); display: block; margin-bottom: 0.5rem; text-align: center;">Alphabet Catalog</strong>
                                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;" id="alphabet-exercises">
                                        <!-- Populated by JS -->
                                    </div>
                                </div>
                            </div>

                            <!-- Tracing Area -->
                            <div style="background: rgba(0,0,0,0.5); padding: 2rem; border-radius: 16px; display: inline-block; width: 100%; max-width: 900px; text-align: center;">
                                <h3 id="tracing-title" style="margin-bottom: 1.5rem; color: var(--primary); font-size: 2rem;">Trace the Letter: 'S'</h3>
                                
                                <div style="display: flex; gap: 2rem; justify-content: center; align-items: flex-start; flex-wrap: wrap;">
                                    <div>
                                        <!-- The Canvas for Tracing -->
                                        <canvas id="tracingCanvas" width="400" height="400" style="background: #ffffff; border-radius: 12px; cursor: crosshair; touch-action: none; box-shadow: inset 0 0 20px rgba(0,0,0,0.5);"></canvas>
                                        
                                        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: center;">
                                            <button class="btn btn-secondary" onclick="clearCanvas()">Clear Canvas</button>
                                            <button class="btn btn-primary" onclick="finishTracing()">Finish Tracing</button>
                                        </div>
                                    </div>

                                    <!-- Reward / Practice Area (Hidden until finished) -->
                                    <div id="practice-area" style="display: none; background: rgba(255,255,255,0.05); padding: 2rem; border-radius: 16px; flex: 1; min-width: 300px; border: 1px solid rgba(255,255,255,0.1);">
                                        <h4 style="color: var(--accent); margin-bottom: 1.5rem; font-size: 1.5rem;">Great Job! Repeat after me:</h4>
                                        <div id="practice-items" style="display: flex; flex-direction: column; gap: 1rem;">
                                            <!-- Items populated by JS -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </details>

                <!-- Math & Logic -->
                <details class="curriculum-module">
                    <summary>🔢 Math & Logic (Counting)</summary>
                    <div class="module-content">
                        <div style="text-align: center; padding: 2rem;">
                            <h3 style="color: var(--primary); font-size: 2rem; margin-bottom: 1rem;">Let's Count!</h3>
                            <div id="math-problem" style="font-size: 5rem; margin-bottom: 2rem; background: rgba(0,0,0,0.3); padding: 2rem; border-radius: 16px; letter-spacing: 0.5rem;">
                                <!-- Apples injected here -->
                            </div>
                            <h4 style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 1.5rem;">How many apples are there?</h4>
                            <div id="math-options" style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;">
                                <!-- Options injected here -->
                            </div>
                            <div id="math-feedback" style="margin-top: 2rem; font-size: 1.5rem; font-weight: bold; min-height: 2rem;"></div>
                        </div>
                    </div>
                </details>

                <!-- Enunciation & Speech -->
                <details class="curriculum-module">
                    <summary>🗣️ Enunciation & Speech (Silly Sentences)</summary>
                    <div class="module-content">
                        <div style="text-align: center; padding: 2rem;">
                            <h3 style="color: var(--primary); font-size: 2rem; margin-bottom: 1rem;">Let's Practice Speaking!</h3>
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 2rem;">
                                <!-- AI Avatar Video Area -->
                                <div style="width: 100%; max-width: 400px; text-align: center;">
                                    <div id="avatar-video-placeholder" style="width: 100%; display: flex; align-items: center; justify-content: center; position: relative;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sterling_spaceman.png" class="pixar-float" style="width: 250px; height: auto; object-fit: contain;" alt="Space Man Avatar" id="avatar-img">
                                    </div>
                                    <h4 id="sentence-text" style="color: var(--text-main); font-size: 1.8rem; margin: 1.5rem 0;">"The space man"</h4>
                                    <button class="btn btn-primary" id="btn-play-avatar" onclick="playAvatarSentence()" style="width: 100%; font-size: 1.2rem;">🎙️ Listen to Avatar</button>
                                </div>
                                
                                <!-- Recording Area -->
                                <div id="your-turn-area" style="display: none; background: rgba(14, 165, 233, 0.1); padding: 2rem; border-radius: 16px; border: 1px solid var(--primary); width: 100%; max-width: 400px;">
                                    <h4 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 1rem;">Your Turn!</h4>
                                    <button class="btn btn-secondary" id="btn-record" onclick="toggleRecording()" style="width: 100%; font-size: 1.2rem; background: #f43f5e; border: none;">🔴 Start Recording</button>
                                    <p id="recording-status" style="margin-top: 1rem; color: var(--text-muted);"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </details>

                <!-- Creation Station -->
                <details class="curriculum-module">
                    <summary>🚀 Creation Station</summary>
                    <div class="module-content">
                        <div style="background-color: rgba(255, 255, 255, 0.05); padding: 2rem; border-radius: 16px; width: 100%;">
                            <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                                
                                <!-- LEFT COLUMN: Creation Station -->
                                <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 1.5rem;">
                                    <h3 style="font-size: 2rem; color: var(--primary); margin: 0; text-align: center;">Build Your Own Game!</h3>
                                    
                                    <!-- The Game Player -->
                                    <div style="flex: 1; min-height: 400px; background: rgba(0,0,0,0.3); border-radius: 1.5rem; border: 4px solid var(--primary); overflow: hidden; position: relative;">
                                        <div id="cs-loading-overlay" style="display: none; position: absolute; inset: 0; background: rgba(15, 23, 42, 0.95); flex-direction: column; align-items: center; justify-content: center; z-index: 50;">
                                            <div style="font-size: 5rem; animation: pixarFloat 2s infinite ease-in-out;">⏳</div>
                                            <h4 style="font-size: 1.8rem; font-weight: 900; color: #f97316; margin-top: 1rem; text-align: center;">Building your game!<br><span style="font-size: 1.2rem; color: var(--text-muted); font-weight: 400;">Please wait a moment...</span></h4>
                                        </div>

                                        <iframe id="cs-game-iframe" style="display: none; width: 100%; height: 100%; border: none;"></iframe>
                                        
                                        <div id="cs-idle-screen" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; padding: 2rem;">
                                            <span style="font-size: 4rem;">🎙️</span>
                                            <h4 style="font-size: 1.5rem; font-weight: bold; color: var(--text-muted); text-align: center; margin-top: 1rem;">Type or tap the mic to build!</h4>
                                        </div>
                                    </div>

                                    <!-- Dictation Controls -->
                                    <div style="background: rgba(0,0,0,0.3); border-radius: 1.5rem; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                                        <button id="cs-mic-btn" style="padding: 1rem; border-radius: 50%; background: #f43f5e; border: none; cursor: pointer; transition: transform 0.2s; box-shadow: 0 4px 15px rgba(244, 63, 94, 0.4); display: flex; align-items: center; justify-content: center; min-width: 60px; height: 60px;">
                                            <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                            </svg>
                                        </button>
                                        <input type="text" id="cs-transcript-input" placeholder="Type or say your idea..." style="flex: 1; min-width: 200px; background: rgba(255,255,255,0.1); border: 1px solid var(--glass-border); border-radius: 1rem; padding: 1rem 1.5rem; font-size: 1.1rem; color: var(--text-main); font-weight: 500; outline: none;">
                                        <button id="cs-generate-btn" class="btn btn-primary" style="padding: 1rem 2rem; border-radius: 1rem; font-size: 1.1rem;">Build It! 🚀</button>
                                    </div>
                                </div>

                                <!-- RIGHT COLUMN: Game Gallery -->
                                <div style="width: 300px; display: flex; flex-direction: column; gap: 1rem;">
                                    <h4 style="font-size: 1.25rem; font-weight: bold; color: var(--text-main); background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 1rem; margin: 0; text-align: center; border: 1px solid rgba(255,255,255,0.1);">
                                        Games Created
                                    </h4>
                                    <div id="cs-game-gallery" style="display: flex; flex-direction: column; gap: 1rem; overflow-y: auto; max-height: 500px;">
                                        <p id="cs-no-games-msg" style="color: var(--text-muted); text-align: center; font-weight: 500; margin-top: 1rem;">No games yet. Build one!</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </details>
            </div>
            
            <style>
                .curriculum-accordion {
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                }
                .curriculum-module {
                    background: rgba(255, 255, 255, 0.03);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    border-radius: 12px;
                    overflow: hidden;
                }
                .curriculum-module summary {
                    padding: 1.5rem;
                    font-size: 1.5rem;
                    font-weight: 600;
                    cursor: pointer;
                    background: rgba(0, 0, 0, 0.2);
                    list-style: none;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                    gap: 1rem;
                    position: relative;
                }
                .curriculum-module summary::-webkit-details-marker {
                    display: none;
                }
                .curriculum-module summary::after {
                    content: '▼';
                    font-size: 1.2rem;
                    color: var(--primary);
                    position: absolute;
                    right: 2rem;
                }
                .curriculum-module[open] summary::after {
                    content: '▲';
                }
                .module-content {
                    padding: 1.5rem;
                    border-top: 1px solid rgba(255, 255, 255, 0.05);
                }
            </style>
        </section>
        <!-- END CURRICULUM MODULE -->

        <section id="upload" class="glass-card section-container" style="margin-bottom: 2rem; padding: 2rem;">
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 1.5rem;">
                <div>
                    <h2 style="margin-bottom: 0.5rem; font-size: 1.5rem;">Database Upload Center</h2>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Upload .mp4 video logs or worksheet scans.</p>
                </div>
                <label for="file-upload" class="btn btn-primary" style="cursor: pointer; margin: 0; padding: 0.8rem 1.5rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <span>📁</span> Browse Computer
                </label>
                <input id="file-upload" type="file" style="display: none;" multiple accept="video/*, image/*, .pdf">
            </div>
        </section>

        <section id="triggers" class="glass-card section-container" style="margin-bottom: 2rem;">
            <div class="section-header">
                <h2>Identified Trigger Words</h2>
                <p>These words and starting letters have been identified as current stuttering triggers for Sterling based on recent evaluations.</p>
            </div>
            
            <div style="background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); max-width: 600px; margin: 0 auto 2rem auto;">
                <h3 style="margin-bottom: 1rem; font-size: 1.2rem; color: var(--text-main);">Add New Trigger Observation</h3>
                <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <input type="text" id="trigger-sound" placeholder="Trigger Sound (e.g. 'I', 'uh')" style="flex: 1; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: white; outline: none;">
                    <input type="text" id="trigger-next-word" placeholder="Word After (e.g. 'want')" style="flex: 1; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: white; outline: none;">
                    <button class="btn btn-primary" onclick="addTriggerObservation()" style="padding: 0.8rem 1.5rem;">Add</button>
                </div>
            </div>

            <div class="grid-layout trigger-grid" id="triggerContainer">
                <div class="trigger-card">
                    <div class="trigger-letter">I</div>
                    <ul class="trigger-words">
                        <li>Followed by: <strong>want</strong></li>
                    </ul>
                </div>
                <div class="trigger-card">
                    <div class="trigger-letter">uh</div>
                    <ul class="trigger-words">
                        <li>Followed by: <strong>can</strong></li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="progress-tracker" class="glass-card section-container" style="margin-bottom: 2rem;">
            <div class="section-header">
                <h2>Weekly Progress Log</h2>
                <p>Track completed exercises and measure growth week over week.</p>
            </div>
            <div style="background: rgba(0,0,0,0.3); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); overflow-x: auto;">
                <table style="width: 100%; text-align: left; border-collapse: collapse; min-width: 600px;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--glass-border); color: var(--text-muted);">
                            <th style="padding: 1rem;">Date</th>
                            <th style="padding: 1rem;">Exercise</th>
                            <th style="padding: 1rem;">Status</th>
                            <th style="padding: 1rem;">Notes</th>
                        </tr>
                    </thead>
                    <tbody id="progress-log-body">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>
        </section>

        <section id="videos" class="glass-card section-container" style="margin-bottom: 2rem;">
            <div class="section-header">
                <h2>How to Support Sterling (Real-World Examples)</h2>
                <p>What to do, and what not to do when Sterling is communicating.</p>
            </div>
            
            <div style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 2rem; align-items: stretch; padding: 1rem;">
                <div style="flex: 1; min-width: 300px;">
                    <!-- Placeholder for the single video -->
                    <div style="aspect-ratio: 16/9; background: #000; border-radius: 12px; overflow: hidden; position: relative; border: 1px solid var(--glass-border); box-shadow: var(--glass-shadow); display: flex; align-items: center; justify-content: center; height: 100%;">
                        <span style="color: var(--text-muted); font-size: 1.2rem; text-align: center; padding: 1rem;">[ Educational Video Coming Soon ]<br><small style="opacity:0.6;">(Best practices for stuttering scenarios)</small></span>
                    </div>
                </div>
                
                <div style="flex: 1; min-width: 300px; background: rgba(0,0,0,0.3); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                    <h3 style="color: var(--primary); margin-bottom: 1.5rem; font-size: 1.5rem;">The Dinner Example</h3>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-style: italic;">
                        "At dinner, a patron said the boys were so nice. Robert said 'thank you'. Sterling was excited to speak but started stuttering..."
                    </p>
                    
                    <h4 style="color: var(--text-main); margin-bottom: 1rem; font-size: 1.2rem;">The 3 Keys to Handling This:</h4>
                    <ul style="color: var(--text-muted); padding-left: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                        <li style="margin-bottom: 0.5rem;"><strong>1. Let him finish:</strong> Maintain eye contact and do not try to finish the sentence for him or rush him. Let him complete the thought at his own pace.</li>
                        <li style="margin-bottom: 0.5rem;"><strong>2. Identify the word & situation:</strong> Understand what word he is trying to get out in the context of his excitement.</li>
                        <li style="margin-bottom: 0;"><strong>3. Gentle repetition:</strong> You can allow him to say it again calmly, or you can gently say the word back to him individually without pressure.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- SPECIAL MOMENTS SECTION -->
        <section id="special-moments" class="glass-card section-container" style="margin-bottom: 2rem;">
            <div class="section-header">
                <h2>Sterling's Special Moments</h2>
                <p>Celebrating the child and the beautiful moments he has created. Select a tab below to watch.</p>
            </div>
            
            <div style="background: rgba(0,0,0,0.3); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                <!-- Tabs -->
                <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; justify-content: center;" id="moment-tabs">
                    <button class="btn btn-primary" onclick="openMoment(this, 'earth-day-video')">Earth Day Performance</button>
                    <button class="btn btn-secondary" onclick="openMoment(this, 'other-moments')">Other Moments</button>
                </div>
                
                <!-- Content -->
                <div id="moments-content" style="display: flex; justify-content: center; width: 100%;">
                    
                    <div id="earth-day-video" class="moment-panel" style="display: block; width: 100%; max-width: 800px; aspect-ratio: 16/9;">
                        <video 
                            src="<?php echo get_stylesheet_directory_uri(); ?>/videos/earth_day_performance.mp4" 
                            style="width: 100%; height: 100%; border-radius: 12px; border: 1px solid var(--glass-border); box-shadow: var(--glass-shadow);" 
                            controls preload="metadata">
                        </video>
                    </div>
                    
                    <div id="other-moments" class="moment-panel" style="display: none; width: 100%; text-align: center; padding: 4rem 2rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🌟</div>
                        <h3 style="color: var(--text-main); margin-bottom: 1rem;">More beautiful moments coming soon</h3>
                        <p style="color: var(--text-muted);">We are continually adding to Sterling's collection of special memories.</p>
                    </div>

                </div>
            </div>
        </section>
        <!-- END SPECIAL MOMENTS -->
    </main>

    <footer>
        <p>Built for the friends, family, and support team surrounding Sterling. We're in this together.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // (Video array removed as requested to be replaced by a single educational video placeholder)

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if(target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            // --- MOMENTS TABS LOGIC ---
            window.openMoment = function(btn, panelId) {
                // Update buttons
                const buttons = document.getElementById('moment-tabs').querySelectorAll('button');
                buttons.forEach(b => {
                    b.className = 'btn btn-secondary'; // Reset all to secondary
                });
                btn.className = 'btn btn-primary'; // Set active to primary

                // Update panels
                const panels = document.querySelectorAll('.moment-panel');
                panels.forEach(p => {
                    p.style.display = 'none';
                });
                document.getElementById(panelId).style.display = 'block';
            };

            // --- CANVAS DRAWING LOGIC FOR iPAD PENCIL/GAMIFICATION ---
            const canvas = document.getElementById("tracingCanvas");
            let currentExercise = 'S';
            let audioContextReady = false;

            const tracingData = {
                // Focus Triggers
                'S': { type: 'letter', text: 'S', items: [{ word: 'Snake', icon: '🐍' }, { word: 'Sky', icon: '☁️' }, { word: 'Silk', icon: '🧣' }] },
                'WH': { type: 'words', text: 'WH', items: [{ word: 'What', icon: '❓' }, { word: 'Why', icon: '🤔' }, { word: 'Where', icon: '📍' }, { word: 'When', icon: '⏰' }, { word: 'Which', icon: '🤷‍♂️' }] },
                'C': { type: 'words', text: 'C', items: [{ word: 'Can', icon: '🥫' }, { word: 'Could', icon: '💭' }] },
                'D': { type: 'words', text: 'D', items: [{ word: 'Did', icon: '✔️' }, { word: 'Do', icon: '👍' }, { word: 'Does', icon: '👌' }] },
                'W': { type: 'words', text: 'W', items: [{ word: 'Will', icon: '🔮' }, { word: 'We', icon: '🤝' }, { word: 'Would', icon: '🪵' }] },
                'TH': { type: 'words', text: 'TH', items: [{ word: 'The', icon: '⭐' }, { word: 'They', icon: '👥' }, { word: 'That', icon: '👉' }] },
                'I': { type: 'phrases', text: 'I', items: [{ word: 'I want this', icon: '👈' }, { word: 'I want that', icon: '👉' }, { word: 'I can do anything', icon: '🦸‍♂️' }] },
                
                // Kindergarten / Preschool Alphabet Dictionary
                'A': { type: 'letter', text: 'A', items: [{ word: 'Apple', icon: '🍎' }, { word: 'And', icon: '➕' }, { word: 'Ant', icon: '🐜' }] },
                'B': { type: 'letter', text: 'B', items: [{ word: 'But', icon: '✋' }, { word: 'Because', icon: '🤔' }, { word: 'Ball', icon: '⚽' }] },
                'E': { type: 'letter', text: 'E', items: [{ word: 'Elephant', icon: '🐘' }, { word: 'Egg', icon: '🥚' }] },
                'F': { type: 'letter', text: 'F', items: [{ word: 'Fish', icon: '🐟' }, { word: 'Fun', icon: '🎈' }] },
                'G': { type: 'letter', text: 'G', items: [{ word: 'Get', icon: '👐' }, { word: 'Give', icon: '🎁' }, { word: 'Go', icon: '🚦' }] },
                'H': { type: 'letter', text: 'H', items: [{ word: 'House', icon: '🏠' }, { word: 'Horse', icon: '🐎' }, { word: 'Have', icon: '🤲' }, { word: 'How', icon: '🤷' }, { word: 'Who', icon: '🦉' }] },
                'J': { type: 'letter', text: 'J', items: [{ word: 'Jump', icon: '🦘' }, { word: 'Juice', icon: '🧃' }] },
                'K': { type: 'letter', text: 'K', items: [{ word: 'Kite', icon: '🪁' }, { word: 'Key', icon: '🔑' }] },
                'L': { type: 'letter', text: 'L', items: [{ word: 'Lion', icon: '🦁' }, { word: 'Look', icon: '👀' }] },
                'M': { type: 'letter', text: 'M', items: [{ word: 'Monkey', icon: '🐒' }, { word: 'Moon', icon: '🌙' }] },
                'N': { type: 'letter', text: 'N', items: [{ word: 'No', icon: '🛑' }, { word: 'Nut', icon: '🥜' }] },
                'O': { type: 'letter', text: 'O', items: [{ word: 'Often', icon: '🔄' }, { word: 'Owl', icon: '🦉' }, { word: 'Open', icon: '🔓' }] },
                'P': { type: 'letter', text: 'P', items: [{ word: 'Pig', icon: '🐷' }, { word: 'Play', icon: '🎮' }] },
                'Q': { type: 'letter', text: 'Q', items: [{ word: 'Queen', icon: '👑' }, { word: 'Quiet', icon: '🤫' }] },
                'R': { type: 'letter', text: 'R', items: [{ word: 'Remember', icon: '🧠' }, { word: 'Run', icon: '🏃' }] },
                'T': { type: 'letter', text: 'T', items: [{ word: 'Tiger', icon: '🐅' }, { word: 'Tree', icon: '🌳' }] },
                'U': { type: 'letter', text: 'U', items: [{ word: 'Up', icon: '⬆️' }, { word: 'Under', icon: '👇' }, { word: 'Us', icon: '🫂' }] },
                'V': { type: 'letter', text: 'V', items: [{ word: 'Van', icon: '🚐' }, { word: 'Very', icon: '✨' }] },
                'X': { type: 'letter', text: 'X', items: [{ word: 'X-ray', icon: '🦴' }, { word: 'Box', icon: '📦' }] },
                'Y': { type: 'letter', text: 'Y', items: [{ word: 'Yes', icon: '✅' }, { word: 'Yellow', icon: '🟡' }] },
                'Z': { type: 'letter', text: 'Z', items: [{ word: 'Zebra', icon: '🦓' }, { word: 'Zoo', icon: '🦁' }] }
            };

            // Generate remaining Alphabet A-Z if not defined
            for(let i=65; i<=90; i++) {
                let letter = String.fromCharCode(i);
                if(!tracingData[letter]) {
                    tracingData[letter] = { type: 'letter', text: letter, items: [{ word: letter + ' word', icon: '⭐' }] };
                }
            }

            // Initialize Menu UI
            const focusContainer = document.getElementById('focus-exercises');
            const alphaContainer = document.getElementById('alphabet-exercises');
            
            const focusKeys = ['S', 'WH', 'C', 'D', 'W', 'TH', 'I'];
            
            Object.keys(tracingData).forEach(key => {
                const btn = document.createElement('button');
                btn.innerText = key;
                btn.id = 'btn-ex-' + key;
                btn.className = 'btn btn-secondary exercise-btn';
                btn.style.padding = '0.5rem 1rem';
                btn.style.margin = '0';
                btn.style.opacity = key === 'S' ? '1' : '0.5';
                btn.onclick = () => loadExercise(key);
                
                if(focusKeys.includes(key)) {
                    btn.className = 'btn btn-primary exercise-btn';
                    focusContainer.appendChild(btn);
                } else if(key.length === 1) { // Only put single letters in alphabet
                    alphaContainer.appendChild(btn);
                }
            });

            // --- HIGH FIDELITY TEXT TO SPEECH ---
            async function speakText(text) {
                // IMPORTANT: Do not commit API keys to GitHub! 
                // Paste your ElevenLabs API Key here to enable high-quality American voices.
                const ELEVENLABS_API_KEY = ''; 
                
                // Fallback to Native API if no key is provided
                if(!ELEVENLABS_API_KEY) {
                    if ('speechSynthesis' in window) {
                        const msg = new SpeechSynthesisUtterance(text);
                        const voices = window.speechSynthesis.getVoices();
                        const voice = voices.find(v => v.lang === 'en-US' && (v.name.includes('Google') || v.name.includes('Zira') || v.name.includes('Samantha')));
                        if(voice) msg.voice = voice;
                        msg.rate = 0.9;
                        window.speechSynthesis.speak(msg);
                    }
                    return;
                }

                try {
                    const response = await fetch('https://api.elevenlabs.io/v1/text-to-speech/pNInz6obpgDQGcFmaJgB', { // Adam - Standard American Male
                        method: 'POST',
                        headers: {
                            'Accept': 'audio/mpeg',
                            'xi-api-key': ELEVENLABS_API_KEY,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            text: text,
                            model_id: "eleven_monolingual_v1",
                            voice_settings: { stability: 0.5, similarity_boost: 0.5 }
                        })
                    });
                    
                    if (response.ok) {
                        const blob = await response.blob();
                        const audioUrl = URL.createObjectURL(blob);
                        const audio = new Audio(audioUrl);
                        audio.play();
                    }
                } catch(e) {
                    console.error("TTS API error:", e);
                }
            }

            // Initialize Voice API workaround for iOS/Safari
            document.body.addEventListener('touchstart', function() {
                if(!audioContextReady && 'speechSynthesis' in window) {
                    const msg = new SpeechSynthesisUtterance('');
                    window.speechSynthesis.speak(msg);
                    audioContextReady = true;
                }
            }, {once:true});

            window.loadExercise = function(key) {
                currentExercise = key;
                const data = tracingData[key];
                
                // Update Title
                let titlePrefix = data.type === 'phrases' ? "Trace Phrase Start:" : (data.type === 'words' ? "Trace Group:" : "Trace Letter:");
                document.getElementById('tracing-title').innerText = `${titlePrefix} '${data.text}'`;
                
                // Reset UI
                clearCanvas();
                document.getElementById('practice-area').style.display = 'none';
                
                // Highlight active button
                document.querySelectorAll('.exercise-btn').forEach(btn => btn.style.opacity = '0.5');
                const activeBtn = document.getElementById('btn-ex-' + key);
                if(activeBtn) activeBtn.style.opacity = '1';
            };

            window.finishTracing = function() {
                document.getElementById('practice-area').style.display = 'block';
                const data = tracingData[currentExercise];
                const container = document.getElementById('practice-items');
                container.innerHTML = '';
                
                speakText("Great job Sterling! Repeat after me.");

                data.items.forEach((item, index) => {
                    const wrap = document.createElement('div');
                    wrap.style.display = 'flex';
                    wrap.style.alignItems = 'center';
                    wrap.style.gap = '1rem';
                    wrap.style.background = 'rgba(255,255,255,0.05)';
                    wrap.style.padding = '1rem';
                    wrap.style.borderRadius = '12px';
                    wrap.style.width = '100%';

                    const textSect = document.createElement('div');
                    textSect.style.flex = '1';
                    textSect.style.fontSize = '1.5rem';
                    textSect.innerHTML = `<span style="font-size: 2rem; margin-right: 1rem;">${item.icon}</span> <strong>${item.word}</strong>`;

                    const listenBtn = document.createElement('button');
                    listenBtn.className = 'btn btn-primary';
                    listenBtn.style.padding = '0.5rem 1rem';
                    listenBtn.innerHTML = '🎙️ Listen';
                    listenBtn.onclick = () => speakText(item.word);

                    const recBtn = document.createElement('button');
                    recBtn.className = 'btn btn-secondary';
                    recBtn.style.padding = '0.5rem 1rem';
                    recBtn.style.background = '#f43f5e';
                    recBtn.style.border = 'none';
                    recBtn.innerHTML = '🔴 Record';
                    recBtn.id = 'rec-btn-' + index;

                    let isRec = false;
                    recBtn.onclick = () => {
                        if(!isRec) {
                            isRec = true;
                            startRealRecording(recBtn, `Tracing Phonics: ${item.word}`);
                        } else {
                            isRec = false;
                            stopRealRecording(recBtn);
                        }
                    };

                    wrap.appendChild(textSect);
                    wrap.appendChild(listenBtn);
                    wrap.appendChild(recBtn);
                    container.appendChild(wrap);
                });
            };

            // --- MATH GAME LOGIC ---
            let currentApples = 1;
            
            function loadMathLevel() {
                currentApples = Math.floor(Math.random() * 5) + 1; // 1 to 5
                const container = document.getElementById('math-problem');
                container.innerHTML = '🍎'.repeat(currentApples);
                
                const optionsContainer = document.getElementById('math-options');
                optionsContainer.innerHTML = '';
                document.getElementById('math-feedback').innerText = '';
                
                // Generate 3 unique options including the correct one
                let options = [currentApples];
                while(options.length < 3) {
                    let rand = Math.floor(Math.random() * 5) + 1;
                    if(!options.includes(rand)) options.push(rand);
                }
                options.sort(() => Math.random() - 0.5);
                
                options.forEach(num => {
                    const btn = document.createElement('button');
                    btn.className = 'btn btn-secondary';
                    btn.style.fontSize = '2.5rem';
                    btn.style.padding = '1rem 3rem';
                    btn.innerText = num;
                    btn.onclick = () => checkMathAnswer(num, btn);
                    optionsContainer.appendChild(btn);
                });
            }

            function checkMathAnswer(selected, btn) {
                const feedback = document.getElementById('math-feedback');
                if(selected === currentApples) {
                    btn.className = 'btn btn-primary';
                    btn.style.background = '#10b981'; // Green
                    feedback.style.color = '#10b981';
                    feedback.innerText = 'Correct! Great job Sterling!';
                    speakText(`Correct! There are ${currentApples} apples.`);
                    
                    // Add subtle visual celebration
                    btn.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        btn.style.transform = 'scale(1)';
                        loadMathLevel();
                    }, 3000);
                } else {
                    btn.style.opacity = '0.3';
                    feedback.style.color = '#ef4444'; // Red
                    feedback.innerText = 'Oops, try again!';
                    speakText("Oops, try again!");
                }
            }

            // Initialize Math
            setTimeout(loadMathLevel, 1000);

            if(canvas) {
                const ctx = canvas.getContext("2d");
                let isDrawing = false;
                
                function drawGuide() {
                    const text = tracingData[currentExercise] ? tracingData[currentExercise].text : currentExercise;
                    let fontSize = text.length > 2 ? 150 : (text.length === 2 ? 200 : 300);
                    ctx.font = `bold ${fontSize}px 'Outfit', sans-serif`;
                    ctx.fillStyle = "rgba(220, 220, 220, 0.5)"; // Light grey guide
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText(text, canvas.width/2, canvas.height/2 + 20);
                }
                
                // Initialize guide
                setTimeout(drawGuide, 100);

                const startDrawing = (e) => {
                    isDrawing = true;
                    ctx.beginPath();
                    const { x, y } = getCoord(e);
                    ctx.moveTo(x, y);
                    e.preventDefault(); 
                };

                const draw = (e) => {
                    if (!isDrawing) return;
                    e.preventDefault();
                    const { x, y } = getCoord(e);
                    ctx.lineTo(x, y);
                    ctx.strokeStyle = "#0ea5e9";
                    ctx.lineWidth = 15;
                    ctx.lineCap = "round";
                    ctx.lineJoin = "round";
                    ctx.stroke();
                };

                const stopDrawing = () => { isDrawing = false; };

                const getCoord = (e) => {
                    const rect = canvas.getBoundingClientRect();
                    if (e.touches && e.touches.length > 0) {
                        return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
                    }
                    return { x: e.clientX - rect.left, y: e.clientY - rect.top };
                };

                canvas.addEventListener("mousedown", startDrawing);
                canvas.addEventListener("mousemove", draw);
                canvas.addEventListener("mouseup", stopDrawing);
                canvas.addEventListener("mouseout", stopDrawing);
                
                canvas.addEventListener("touchstart", startDrawing, {passive: false});
                canvas.addEventListener("touchmove", draw, {passive: false});
                canvas.addEventListener("touchend", stopDrawing);
                
                window.clearCanvas = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    drawGuide();
                };
            }

            // --- REAL AUDIO RECORDING LOGIC ---
            let mediaRecorder = null;
            let audioChunks = [];

            async function startRealRecording(btnElement, exerciseName) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];
                    
                    mediaRecorder.ondataavailable = event => {
                        audioChunks.push(event.data);
                    };
                    
                    mediaRecorder.onstop = () => {
                        const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                        const audioUrl = URL.createObjectURL(audioBlob);
                        
                        // Add to progress log
                        const today = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        progressLogs.unshift({
                            date: today,
                            exercise: exerciseName,
                            status: '✅ Completed',
                            notes: 'Audio recording saved.',
                            hasAudio: true,
                            audioUrl: audioUrl
                        });
                        renderProgressLogs();
                        
                        // Release mic
                        stream.getTracks().forEach(track => track.stop());
                    };
                    
                    mediaRecorder.start();
                    btnElement.innerHTML = '⏹️ Stop Recording';
                    btnElement.style.background = '#64748b';
                } catch(err) {
                    console.error("Microphone access denied:", err);
                    alert("Please allow microphone access to record.");
                }
            }
            
            function stopRealRecording(btnElement) {
                if(mediaRecorder && mediaRecorder.state !== 'inactive') {
                    mediaRecorder.stop();
                    btnElement.innerHTML = '✅ Saved';
                    btnElement.style.background = '#10b981';
                    speakText("Great job!");
                }
            }

            window.playRealRecording = function(audioUrl) {
                if(audioUrl) {
                    const audio = new Audio(audioUrl);
                    audio.play();
                } else {
                    speakText("No recording found.");
                }
            };

            // --- PROGRESS TRACKER LOGIC ---
            const progressLogs = [
                { date: 'Apr 18, 2026', exercise: 'Math: Counting Apples', status: '✅ Completed', notes: 'Nailed the numbers 1-5.', hasAudio: false },
                { date: 'Apr 20, 2026', exercise: 'Tracing: Focus WH', status: '✅ Completed', notes: 'Struggled slightly with "Where" but pushed through.', hasAudio: true }
            ];

            function renderProgressLogs() {
                const tbody = document.getElementById('progress-log-body');
                tbody.innerHTML = '';
                progressLogs.forEach(log => {
                    const tr = document.createElement('tr');
                    tr.style.borderBottom = '1px solid rgba(255,255,255,0.05)';
                    
                    let audioBtnHTML = '';
                    if(log.hasAudio) {
                        if(log.audioUrl) {
                            audioBtnHTML = `<button class="btn btn-primary" style="padding: 0.2rem 0.6rem; font-size: 0.8rem; border-radius: 6px; margin-left: 1rem;" onclick="playRealRecording('${log.audioUrl}')">▶️ Play Recording</button>`;
                        } else {
                            audioBtnHTML = `<button class="btn btn-primary" style="padding: 0.2rem 0.6rem; font-size: 0.8rem; border-radius: 6px; margin-left: 1rem;" onclick="speakText('Playing recording of Sterling saying: ${log.exercise.split(':')[1] || log.exercise}')">▶️ Play Demo</button>`;
                        }
                    }

                    tr.innerHTML = `
                        <td style="padding: 1rem;">${log.date}</td>
                        <td style="padding: 1rem; color: var(--primary);">${log.exercise}</td>
                        <td style="padding: 1rem;">${log.status}</td>
                        <td style="padding: 1rem; color: var(--text-muted); display: flex; align-items: center;">
                            ${log.notes} ${audioBtnHTML}
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
            renderProgressLogs();

            // --- TRIGGER OBSERVATION LOGIC ---
            window.addTriggerObservation = function() {
                const soundInput = document.getElementById('trigger-sound');
                const wordInput = document.getElementById('trigger-next-word');
                
                if(!soundInput.value || !wordInput.value) {
                    alert("Please fill out both the trigger sound and the following word.");
                    return;
                }

                const container = document.getElementById('triggerContainer');
                const card = document.createElement('div');
                card.className = 'trigger-card animate-up';
                card.innerHTML = `
                    <div class="trigger-letter">${soundInput.value}</div>
                    <ul class="trigger-words">
                        <li>Followed by: <strong>${wordInput.value}</strong></li>
                    </ul>
                `;
                container.appendChild(card);

                // Clear inputs
                soundInput.value = '';
                wordInput.value = '';
            };

            // --- SILLY SENTENCES (ENUNCIATION) LOGIC ---
            window.playAvatarSentence = function() {
                const placeholder = document.getElementById('avatar-video-placeholder');
                const img = document.getElementById('avatar-img');
                placeholder.style.boxShadow = '0 0 30px rgba(14, 165, 233, 0.5)'; // change glow to simulate active
                img.style.animation = 'pixarFloat 0.5s ease-in-out infinite'; // speak faster animation
                
                speakText("The space man.");
                
                setTimeout(() => {
                    placeholder.style.boxShadow = 'none';
                    img.style.animation = 'pixarFloat 3s ease-in-out infinite'; // return to idle
                    
                    const yourTurn = document.getElementById('your-turn-area');
                    yourTurn.style.display = 'block';
                    speakText("Your turn!");
                }, 2000);
            };

            let isRecording = false;
            window.toggleRecording = function() {
                const btn = document.getElementById('btn-record');
                const status = document.getElementById('recording-status');
                
                if(!isRecording) {
                    isRecording = true;
                    status.innerText = 'Listening to Sterling...';
                    startRealRecording(btn, 'Enunciation: "The space man"');
                } else {
                    isRecording = false;
                    status.innerText = 'Recording saved!';
                    stopRealRecording(btn);
                }
            };
            // --- CREATION STATION (VOICE-TO-GAME) LOGIC ---
            let csSavedGames = [];
            let csSpeechRecog = null;
            let csRecogTimeout = null;
            
            const csMicBtn = document.getElementById('cs-mic-btn');
            const csTranscriptInput = document.getElementById('cs-transcript-input');
            const csGenerateBtn = document.getElementById('cs-generate-btn');
            
            const csLoadingOverlay = document.getElementById('cs-loading-overlay');
            const csIframe = document.getElementById('cs-game-iframe');
            const csIdleScreen = document.getElementById('cs-idle-screen');
            const csGameGallery = document.getElementById('cs-game-gallery');
            const csNoGamesMsg = document.getElementById('cs-no-games-msg');

            // Setup Speech Recognition
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                csSpeechRecog = new SpeechRecognition();
                csSpeechRecog.continuous = true;
                csSpeechRecog.interimResults = true;
                
                csSpeechRecog.onresult = function(event) {
                    let transcript = '';
                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        transcript += event.results[i][0].transcript;
                    }
                    if(transcript.trim().length > 0) {
                        csTranscriptInput.value = transcript;
                    }
                };
                
                csSpeechRecog.onend = function() {
                    csMicBtn.style.backgroundColor = '#f43f5e';
                    csMicBtn.style.transform = 'scale(1)';
                    if(csRecogTimeout) clearTimeout(csRecogTimeout);
                };
            }

            function csSpeakToChild(text) {
                if ('speechSynthesis' in window) {
                    const utterance = new SpeechSynthesisUtterance(text);
                    const voices = window.speechSynthesis.getVoices();
                    
                    // Force traditional American English voices (Microsoft Mark/David or Google US)
                    const americanVoice = voices.find(v => v.name === 'Microsoft Mark - English (United States)') ||
                                          voices.find(v => v.name === 'Microsoft David - English (United States)') ||
                                          voices.find(v => v.name === 'Google US English') ||
                                          voices.find(v => v.lang === 'en-US' && v.name.includes('English (United States)')) ||
                                          voices.find(v => v.lang === 'en-US');
                                          
                    if(americanVoice) utterance.voice = americanVoice;
                    utterance.rate = 0.9;
                    utterance.pitch = 1.0;
                    window.speechSynthesis.speak(utterance);
                }
            }

            function csRenderGallery() {
                if (csSavedGames.length > 0) {
                    if (csNoGamesMsg) csNoGamesMsg.style.display = 'none';
                }
                
                Array.from(csGameGallery.children).forEach(child => {
                    if (child.id !== 'cs-no-games-msg') child.remove();
                });

                csSavedGames.forEach(game => {
                    const card = document.createElement('div');
                    card.style.cssText = 'background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.1); border-left: 4px solid var(--primary); cursor: pointer; transition: background 0.2s;';
                    card.innerHTML = `
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">👾</div>
                        <h3 style="font-weight: bold; font-size: 1.1rem; color: var(--text-main); margin: 0;">${game.name}</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0.25rem 0 0 0;">Play again</p>
                    `;
                    
                    card.addEventListener('click', () => {
                        csIframe.src = game.url;
                        csIframe.style.display = 'block';
                        csIdleScreen.style.display = 'none';
                    });
                    
                    csGameGallery.appendChild(card);
                });
            }

            if (csMicBtn) {
                csMicBtn.addEventListener('click', () => {
                    if(!csSpeechRecog) {
                        alert("Speech recognition is not supported in this browser.");
                        return;
                    }
                    
                    // Stop if already running
                    if(csMicBtn.style.backgroundColor === 'rgb(239, 68, 68)' || csMicBtn.style.backgroundColor === '#ef4444') {
                        csSpeechRecog.stop();
                        return;
                    }

                    try {
                        csSpeechRecog.start();
                        csMicBtn.style.backgroundColor = '#ef4444'; // Red active state
                        csMicBtn.style.transform = 'scale(1.1)';
                        csTranscriptInput.placeholder = "Listening... (15s max)";
                        csTranscriptInput.value = ""; // Clear for new dictation
                        
                        // Set 15 second hard cutoff
                        csRecogTimeout = setTimeout(() => {
                            csSpeechRecog.stop();
                            csMicBtn.style.backgroundColor = '#f43f5e';
                            csMicBtn.style.transform = 'scale(1)';
                            csTranscriptInput.placeholder = "Type or say your idea...";
                        }, 15000);
                        
                    } catch(e) {
                        console.error(e);
                    }
                });
            }

            if (csGenerateBtn) {
                csGenerateBtn.addEventListener('click', async () => {
                    const prompt = csTranscriptInput.value.trim();
                    if(!prompt) {
                        alert("Please tell me what game to build first!");
                        return;
                    }

                    // Show visual clock Loading State
                    csLoadingOverlay.style.display = 'flex';
                    
                    try {
                        // Attempt to hit the local bridge server which proxies to Cloud Ollama
                        const response = await fetch('http://localhost:3008/api/generate-game', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ prompt: prompt })
                        });
                        
                        if(response.ok) {
                            const data = await response.json();
                            const blob = new Blob([data.html], {type: 'text/html'});
                            const blobUrl = URL.createObjectURL(blob);
                            
                            csLoadingOverlay.style.display = 'none';
                            csIdleScreen.style.display = 'none';
                            csIframe.src = blobUrl;
                            csIframe.style.display = 'block';
                            
                            csSavedGames.unshift({ id: Date.now(), name: prompt.substring(0, 20) + "...", url: blobUrl });
                            csRenderGallery();
                            csSpeakToChild("I built your game! Let's play it, Sterling!");
                        } else {
                            throw new Error("Backend error");
                        }
                    } catch(e) {
                        console.warn("Backend not reachable. Falling back to mock render.", e);
                        
                        // MOCK FALLBACK: Simulate a visually appealing render time for 5 seconds
                        setTimeout(() => {
                            csLoadingOverlay.style.display = 'none';
                            csIdleScreen.style.display = 'none';
                            
                            // Read the raw HTML of the game and inject it directly to bypass WP routing
                            const gameHTML = `<!DOCTYPE html>
<html>
<head>
    <title>Sterling's Pickaxe Adventure</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <script src="https://cdn.jsdelivr.net/npm/phaser@3.60.0/dist/phaser-arcade-physics.min.js"></script>
    <style>
        body { margin: 0; padding: 0; background: #87CEEB; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: 'Arial', sans-serif; overflow: hidden; touch-action: none; }
        #game-container { width: 100%; height: 100%; max-width: 600px; max-height: 800px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    </style>
</head>
<body>
    <div id="game-container"></div>
    <script>
        const config = {
            type: Phaser.AUTO,
            scale: {
                mode: Phaser.Scale.FIT,
                parent: 'game-container',
                autoCenter: Phaser.Scale.CENTER_BOTH,
                width: 400,
                height: 600
            },
            physics: {
                default: 'arcade',
                arcade: {
                    gravity: { y: 600 },
                    debug: false
                }
            },
            scene: { create: create, update: update }
        };

        const game = new Phaser.Game(config);

        let player;
        let platforms;
        let lettersGroup;
        let monstersGroup;
        let bouldersGroup;
        let score = 0;
        let lives = 3;
        let scoreText;
        let livesText;
        let grappleLine;
        let isGrappling = false;
        let grappleTarget = null;
        let highestY = 500;

        function create() {
            this.cameras.main.setBackgroundColor('#87CEEB');

            grappleLine = this.add.graphics({ lineStyle: { width: 4, color: 0x333333 } });
            grappleLine.setDepth(1);

            platforms = this.physics.add.staticGroup();
            lettersGroup = this.physics.add.group();
            monstersGroup = this.physics.add.group();
            bouldersGroup = this.physics.add.group();

            // Ground
            platforms.create(200, 590, 'ground').setSize(400, 40).setOffset(0,0);
            let gRect = this.add.rectangle(200, 590, 400, 40, 0x8B4513);
            platforms.add(gRect);

            // Generate initial platforms up to y = -2000
            for(let i=0; i<30; i++) {
                let py = 500 - (i * 120);
                let px = Phaser.Math.Between(50, 350);
                let plat = this.add.rectangle(px, py, Phaser.Math.Between(80, 150), 20, 0x32CD32).setStrokeStyle(2, 0x006400);
                platforms.add(plat);

                // Add Letter
                if (Phaser.Math.FloatBetween(0, 1) > 0.3) {
                    const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    let letterText = this.add.text(px, py - 40, alphabet[Phaser.Math.Between(0, 25)], { 
                        fontSize: '28px', fontStyle: 'bold', fill: '#FFF', backgroundColor: '#FF4500', padding: {x: 8, y: 5} 
                    }).setOrigin(0.5);
                    this.physics.add.existing(letterText);
                    letterText.body.setAllowGravity(false);
                    lettersGroup.add(letterText);
                }

                // Add Monster
                if (i > 2 && Phaser.Math.FloatBetween(0, 1) > 0.7) {
                    let mx = Phaser.Math.Between(50, 350);
                    let mBox = this.add.rectangle(mx, py - 80, 40, 40, 0x222222);
                    this.add.text(mx, py - 80, 'M', {fontSize: '24px', fill: '#ff0000', fontStyle: 'bold'}).setOrigin(0.5);
                    this.physics.add.existing(mBox);
                    mBox.body.setBounce(1).setCollideWorldBounds(true);
                    mBox.body.setVelocityX(Phaser.Math.Between(-100, 100));
                    monstersGroup.add(mBox);
                }
            }

            // Player (Stick figure approx)
            player = this.add.rectangle(200, 500, 24, 48, 0xffffff).setStrokeStyle(3, 0x000000);
            this.physics.add.existing(player);
            player.body.setBounce(0.1);
            player.setDepth(2);
            
            this.cameras.main.startFollow(player, true, 0, 0.1, 0, 150);

            // Boulders falling
            this.time.addEvent({
                delay: 2500,
                callback: () => {
                    let bx = Phaser.Math.Between(player.x - 200, player.x + 200);
                    let boulder = this.add.circle(bx, player.y - 400, 25, 0x666666).setStrokeStyle(2, 0x333333);
                    this.physics.add.existing(boulder);
                    boulder.body.setBounce(0.5).setCircle(25);
                    bouldersGroup.add(boulder);
                },
                loop: true
            });

            // Collisions
            this.physics.add.collider(player, platforms);
            this.physics.add.collider(monstersGroup, platforms);
            this.physics.add.collider(bouldersGroup, platforms);

            this.physics.add.overlap(player, lettersGroup, (p, l) => {
                l.destroy();
                score += 10;
                scoreText.setText('Score: ' + score);
            });

            this.physics.add.collider(player, monstersGroup, (p, m) => { hitHazard(this, m); });
            this.physics.add.collider(player, bouldersGroup, (p, b) => { hitHazard(this, b); });

            // UI
            scoreText = this.add.text(10, 10, 'Score: 0', { fontSize: '24px', fill: '#000', fontStyle: 'bold' }).setScrollFactor(0);
            livesText = this.add.text(280, 10, 'Lives: 3', { fontSize: '24px', fill: '#f00', fontStyle: 'bold' }).setScrollFactor(0);

            // Tap/Drag Grapple Mechanics
            this.input.on('pointerdown', function (pointer) {
                if (lives <= 0) return;
                const worldX = pointer.worldX;
                const worldY = pointer.worldY;
                
                // Grapple upwards or sideways
                if(worldY < player.y + 50) {
                    isGrappling = true;
                    grappleTarget = { x: worldX, y: worldY };
                    
                    this.physics.moveToObject(player, grappleTarget, 500);
                    player.body.setAllowGravity(false);
                }
            }, this);

            this.input.on('pointerup', function () {
                if(isGrappling) {
                    isGrappling = false;
                    player.body.setAllowGravity(true);
                }
            }, this);
        }

        function hitHazard(scene, hazard) {
            if(isGrappling && hazard.y < player.y) {
                // Pickaxe attack!
                hazard.destroy();
                score += 50;
                scoreText.setText('Score: ' + score);
                
                // Bounce player off enemy slightly
                player.body.setVelocityY(-200);
                return;
            }
            
            player.setFillStyle(0xff0000);
            lives -= 1;
            livesText.setText('Lives: ' + lives);
            
            player.body.setVelocityY(-300);
            player.body.setVelocityX(Phaser.Math.Between(-200, 200));
            isGrappling = false;
            player.body.setAllowGravity(true);
            
            if(lives <= 0) {
                scene.physics.pause();
                scene.add.text(200, player.y, 'GAME OVER', { fontSize: '48px', fill: '#f00', stroke: '#fff', strokeThickness: 6 }).setOrigin(0.5);
            }
            
            setTimeout(() => { if(lives > 0) player.setFillStyle(0xffffff); }, 500);
        }

        function update() {
            if (lives <= 0) return;

            grappleLine.clear();
            if(isGrappling && grappleTarget) {
                grappleLine.lineStyle(4, 0x333333, 1);
                grappleLine.beginPath();
                grappleLine.moveTo(player.x, player.y);
                grappleLine.lineTo(grappleTarget.x, grappleTarget.y);
                grappleLine.strokePath();

                let dist = Phaser.Math.Distance.Between(player.x, player.y, grappleTarget.x, grappleTarget.y);
                if(dist < 30) {
                    isGrappling = false;
                    player.body.setAllowGravity(true);
                    player.body.setVelocityY(-200); // little hop at the end of grapple
                }
            }
            
            bouldersGroup.getChildren().forEach(b => {
                if(b.y > player.y + 800) b.destroy();
            });

            // Prevent falling infinitely
            if(player.y > highestY + 800) {
                lives = 0;
                livesText.setText('Lives: 0');
                this.physics.pause();
                this.add.text(200, player.y, 'FELL OFF!', { fontSize: '48px', fill: '#f00', stroke: '#fff', strokeThickness: 6 }).setOrigin(0.5);
            }

            if(player.y < highestY) {
                highestY = player.y;
            }
        }
    </script>
</body>
</html>\`;
                            
                            csIframe.removeAttribute('src'); // clear any bad routing
                            csIframe.srcdoc = gameHTML;
                            csIframe.style.display = 'block';

        });
    </script>
</body>
</html>
