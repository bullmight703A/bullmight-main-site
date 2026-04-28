<?php
/**
 * Template Name: Sterling Game Hub
 */
get_header(); 

// This ensures any existing content on the page is displayed BEFORE the game hub
while ( have_posts() ) :
    the_post();
    ?>
    <div class="sterling-existing-content" style="max-w: 1200px; margin: 0 auto; padding: 2rem;">
        <?php the_content(); ?>
    </div>
    <?php
endwhile;
?>

<div class="min-h-screen bg-yellow-50 font-sans p-6" style="background-color: #fefce8; padding: 2rem; font-family: sans-serif;">
    <div style="max-w: 1200px; margin: 0 auto; display: flex; gap: 2rem; flex-wrap: wrap;">
        
        <!-- LEFT COLUMN: Creation Station -->
        <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 1.5rem;">
            <h1 style="font-size: 2.5rem; font-weight: 900; color: #2563eb; margin: 0;">
                Sterling's Creation Station 🚀
            </h1>
            
            <!-- The Game Player -->
            <div style="flex: 1; min-height: 500px; background: white; border-radius: 1.5rem; border: 8px solid #4ade80; overflow: hidden; position: relative; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                <div id="loading-overlay" style="display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.9); flex-direction: column; align-items: center; justify-content: center; z-index: 50;">
                    <h2 style="font-size: 2rem; font-weight: 900; color: #f97316;">Building your game...</h2>
                </div>

                <iframe id="game-iframe" style="display: none; width: 100%; height: 100%; border: none;"></iframe>
                
                <div id="idle-screen" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; background: #eff6ff;">
                    <span style="font-size: 4rem;">🎙️</span>
                    <h2 style="font-size: 2rem; font-weight: bold; color: #1e40af; text-align: center; padding: 1rem;">Tap the mic and tell me what to build!</h2>
                </div>
            </div>

            <!-- Dictation Controls -->
            <div style="background: white; border-radius: 1.5rem; padding: 1.5rem; border: 4px solid #bfdbfe; display: flex; align-items: center; gap: 1.5rem;">
                <button id="mic-btn" style="padding: 2rem; border-radius: 50%; background: #f97316; border: none; cursor: pointer; transition: transform 0.2s; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                    <svg style="width: 2.5rem; height: 2.5rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                    </svg>
                </button>
                <div id="transcript-display" style="flex: 1; background: #f1f5f9; border-radius: 1rem; padding: 1.5rem; font-size: 1.25rem; color: #334155; font-weight: bold;">
                    Waiting for your idea...
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Game Gallery -->
        <div style="width: 320px; display: flex; flex-direction: column; gap: 1rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold; color: #1e293b; background: white; padding: 1rem; border-radius: 1rem; border: 2px solid #f1f5f9; margin: 0;">
                My Games 🎮
            </h2>
            <div id="game-gallery" style="display: flex; flex-direction: column; gap: 1rem; overflow-y: auto; max-height: 700px;">
                <p id="no-games-msg" style="color: #64748b; text-align: center; font-weight: 500; margin-top: 2rem;">No games yet. Build one!</p>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let savedGames = [];
    let isRecording = false;
    
    const micBtn = document.getElementById('mic-btn');
    const transcriptDisplay = document.getElementById('transcript-display');
    const loadingOverlay = document.getElementById('loading-overlay');
    const iframe = document.getElementById('game-iframe');
    const idleScreen = document.getElementById('idle-screen');
    const gameGallery = document.getElementById('game-gallery');
    const noGamesMsg = document.getElementById('no-games-msg');

    function speakToChild(text) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(text);
            const voices = window.speechSynthesis.getVoices();
            // Try to find a good American English voice
            const americanVoice = voices.find(v => v.lang === 'en-US' && v.name.includes('Google')) || 
                                  voices.find(v => v.lang === 'en-US') || 
                                  voices[0];
            utterance.voice = americanVoice;
            utterance.rate = 0.9;
            utterance.pitch = 1.1;
            window.speechSynthesis.speak(utterance);
        }
    }

    function renderGallery() {
        if (savedGames.length > 0) noGamesMsg.style.display = 'none';
        
        // Clear current list (except the 'no games' msg)
        Array.from(gameGallery.children).forEach(child => {
            if (child.id !== 'no-games-msg') child.remove();
        });

        savedGames.forEach(game => {
            const card = document.createElement('div');
            card.style.cssText = 'background: white; padding: 1rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-bottom: 4px solid #60a5fa; cursor: pointer; transition: background 0.2s;';
            card.innerHTML = `
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">👾</div>
                <h3 style="font-weight: bold; font-size: 1.125rem; color: #1e293b; margin: 0;">${game.name}</h3>
                <p style="font-size: 0.875rem; color: #64748b; margin: 0.25rem 0 0 0;">Play again!</p>
            `;
            
            card.addEventListener('click', () => {
                iframe.src = game.url;
                iframe.style.display = 'block';
                idleScreen.style.display = 'none';
            });
            
            // Push to top (gallery renders from array which already prepended it)
            gameGallery.appendChild(card);
        });
    }

    micBtn.addEventListener('click', () => {
        isRecording = !isRecording;
        
        if(isRecording) {
            micBtn.style.backgroundColor = '#ef4444'; // Red
            transcriptDisplay.innerText = "Listening...";
            
            // MOCK: Simulate dictation and generation
            setTimeout(() => {
                transcriptDisplay.innerText = "Make a game where a dog jumps on letters.";
                isRecording = false;
                micBtn.style.backgroundColor = '#f97316'; // Back to orange
                
                loadingOverlay.style.display = 'flex';
                
                // MOCK: Simulate rendering time
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                    idleScreen.style.display = 'none';
                    
                    const mockGameUrl = 'about:blank'; // Replace with real generated URL
                    iframe.src = mockGameUrl;
                    iframe.style.display = 'block';
                    
                    // Add to gallery (push to top)
                    savedGames.unshift({
                        id: Date.now(),
                        name: "Dog Letter Jump",
                        url: mockGameUrl
                    });
                    
                    renderGallery();
                    speakToChild("I built your dog game! Let's play it, Sterling!");
                    
                }, 3000);
            }, 2000);
        }
    });
});
</script>

<?php get_footer(); ?>
