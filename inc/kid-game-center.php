<?php
$kid_game_profile = isset($bullmight_game_profile) ? strtolower((string) $bullmight_game_profile) : 'sterling';
$kid_game_is_robert = $kid_game_profile === 'robert';
$kid_game_name = $kid_game_is_robert ? 'Robert' : 'Sterling';
$kid_game_title = $kid_game_is_robert ? "Robert's Game Lab" : "Sterling's Game Lab";
$kid_game_focus = $kid_game_is_robert
    ? 'writing, dictation, sentence building, and math strategy'
    : 'speech confidence, sound practice, early reading, and calm repetition';
$kid_game_examples = $kid_game_is_robert
    ? 'Make a car chase math game with addition under 30, sentence words to collect, and one writing challenge.'
    : 'Make an Angry Birds style slingshot game where I knock down S words and then read a short sentence.';
$kid_game_seed = $kid_game_is_robert
    ? array(
        array(
            'title' => 'Sentence Builder Quest',
            'type' => 'writing',
            'engine' => 'chase',
            'prompt' => 'Build a car chase game where Robert collects words and writes a complete sentence at the finish.',
            'goal' => 'Write one clear sentence with capital letter, spacing, and punctuation.',
            'challenge' => 'Collect the words in order, then read the sentence back.',
        ),
        array(
            'title' => 'Math Bridge Builder',
            'type' => 'math',
            'engine' => 'slingshot',
            'prompt' => 'Create an Angry Birds style math game with addition, subtraction, and an explain-your-answer moment.',
            'goal' => 'Solve five problems and explain one strategy out loud.',
            'challenge' => 'Choose answers to place bridge blocks across the river.',
        ),
    )
    : array(
        array(
            'title' => 'Rocket Sound Run',
            'type' => 'speech',
            'engine' => 'chase',
            'prompt' => 'Build a car chase game where Sterling practices smooth starter sounds before catching stars.',
            'goal' => 'Practice five target words with calm, steady speech.',
            'challenge' => 'Say each word, tap launch, and guide the rocket to stars.',
        ),
        array(
            'title' => 'Picture Word Match',
            'type' => 'reading',
            'engine' => 'slingshot',
            'prompt' => 'Create an Angry Birds style matching game with short words, pictures, and gentle read-back.',
            'goal' => 'Match six early words and read each one back.',
            'challenge' => 'Tap the matching card pairs before the timer ends.',
        ),
    );
?>
<section id="game-center" class="bm-game-center" data-profile="<?php echo htmlspecialchars($kid_game_profile, ENT_QUOTES, 'UTF-8'); ?>">
    <style>
        .bm-game-center {
            max-width: 1320px;
            margin: 0 auto 2rem;
            padding: 3rem 5vw;
            scroll-margin-top: 118px;
        }
        .bm-game-shell {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(300px, 0.65fr);
            gap: 1rem;
            align-items: stretch;
        }
        .bm-game-panel {
            background: rgba(12, 24, 39, 0.86);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            box-shadow: 0 18px 48px rgba(0,0,0,0.28);
            padding: 1.25rem;
        }
        .bm-game-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .bm-game-heading h2 { margin: 0; font-size: clamp(1.7rem, 3vw, 2.6rem); letter-spacing: 0; }
        .bm-game-heading p, .bm-game-muted { color: rgba(226, 236, 247, 0.78); line-height: 1.55; }
        .bm-game-tabs { display: flex; flex-wrap: wrap; gap: 0.5rem; margin: 1rem 0; }
        .bm-game-tab,
        .bm-game-action {
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 999px;
            min-height: 44px;
            padding: 0.7rem 1rem;
            color: #f8fafc;
            background: rgba(255,255,255,0.08);
            cursor: pointer;
            font: inherit;
            font-weight: 800;
        }
        .bm-game-tab[aria-selected="true"],
        .bm-game-action.primary {
            border-color: transparent;
            background: linear-gradient(135deg, #1fa2ff, #4776ff);
            color: #fff;
        }
        .bm-game-action.success { background: #2bd17e; color: #062014; border-color: transparent; }
        .bm-game-action.warn { background: #f6c453; color: #241703; border-color: transparent; }
        .bm-game-grid { display: grid; grid-template-columns: minmax(0, 0.95fr) minmax(280px, 1.05fr); gap: 1rem; }
        .bm-game-field {
            width: 100%;
            border: 1px solid rgba(16, 32, 51, 0.18);
            border-radius: 8px;
            padding: 0.9rem 1rem;
            background: #fffaf0;
            color: #102033;
            outline: none;
            min-height: 150px;
            resize: vertical;
            line-height: 1.65;
            font: inherit;
        }
        .bm-game-control-row { display: flex; flex-wrap: wrap; gap: 0.65rem; margin-top: 0.8rem; }
        .bm-game-status { min-height: 1.5rem; color: #9bd8ff; font-weight: 800; margin-top: 0.7rem; }
        .bm-game-conversation {
            display: grid;
            gap: 0.55rem;
            margin-top: 0.9rem;
            max-height: 180px;
            overflow: auto;
        }
        .bm-game-bubble {
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            padding: 0.7rem 0.8rem;
            background: rgba(255,255,255,0.06);
            color: rgba(248,250,252,0.94);
            line-height: 1.45;
            font-size: 0.95rem;
        }
        .bm-game-bubble.child { background: rgba(31,162,255,0.14); }
        .bm-game-stage {
            background: #07111e;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            overflow: hidden;
            min-height: 390px;
            display: grid;
            grid-template-rows: auto 1fr auto;
        }
        .bm-game-stage-header,
        .bm-game-stage-footer {
            padding: 0.9rem 1rem;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
            background: rgba(255,255,255,0.05);
        }
        .bm-game-stage-header h3 { margin: 0; font-size: 1.1rem; }
        .bm-game-playfield {
            position: relative;
            min-height: 260px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(31,162,255,0.18), transparent 52%),
                radial-gradient(circle at 20% 25%, rgba(246,196,83,0.22), transparent 18%),
                #0b1727;
        }
        .bm-game-canvas {
            width: 100%;
            height: 100%;
            min-height: 320px;
            display: block;
            background: transparent;
            touch-action: none;
        }
        .bm-game-avatar {
            position: absolute;
            left: 22px;
            bottom: 24px;
            width: 54px;
            height: 54px;
            border-radius: 999px;
            background: linear-gradient(135deg, #2bd17e, #1fa2ff);
            box-shadow: 0 10px 24px rgba(0,0,0,0.35);
            display: grid;
            place-items: center;
            color: #062014;
            font-weight: 900;
            transition: transform 0.28s ease;
        }
        .bm-game-target {
            position: absolute;
            border: 1px solid rgba(255,255,255,0.18);
            background: rgba(255,250,240,0.94);
            color: #102033;
            border-radius: 8px;
            padding: 0.75rem 0.9rem;
            font-weight: 900;
            box-shadow: 0 10px 24px rgba(0,0,0,0.22);
            cursor: pointer;
            min-width: 86px;
            text-align: center;
        }
        .bm-game-target.done { opacity: 0.22; pointer-events: none; transform: scale(0.96); }
        .bm-game-log-list { display: grid; gap: 0.75rem; max-height: 590px; overflow: auto; padding-right: 0.25rem; }
        .bm-game-log-card {
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.06);
            border-radius: 8px;
            padding: 0.9rem;
        }
        .bm-game-log-card h3 { margin: 0 0 0.35rem; font-size: 1rem; }
        .bm-game-log-card p { margin: 0; color: rgba(226,236,247,0.78); font-size: 0.94rem; line-height: 1.45; }
        .bm-game-empty {
            border: 1px dashed rgba(255,255,255,0.18);
            color: rgba(226,236,247,0.75);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
        @media (max-width: 980px) {
            .bm-game-shell,
            .bm-game-grid { grid-template-columns: 1fr; }
            .bm-game-heading { display: block; }
        }
    </style>

    <div class="bm-game-heading">
        <div>
            <p class="eyebrow">Game Center</p>
            <h2><?php echo htmlspecialchars($kid_game_title, ENT_QUOTES, 'UTF-8'); ?></h2>
        </div>
        <p class="bm-game-muted">Talk or type a game idea. The page turns it into a playable mini-game, saves it to the log, and lets <?php echo htmlspecialchars($kid_game_name, ENT_QUOTES, 'UTF-8'); ?> improve it later.</p>
    </div>

    <div class="bm-game-shell">
        <div class="bm-game-panel">
            <div class="bm-game-tabs" role="tablist" aria-label="Game Center controls">
                <button class="bm-game-tab" type="button" data-bm-tab="create" aria-selected="true">Create</button>
                <button class="bm-game-tab" type="button" data-bm-tab="improve" aria-selected="false">Improve</button>
                <button class="bm-game-tab" type="button" data-bm-tab="proof" aria-selected="false">Proof</button>
            </div>

            <div class="bm-game-grid">
                <div>
                    <label class="label" for="bmGamePrompt-<?php echo htmlspecialchars($kid_game_profile, ENT_QUOTES, 'UTF-8'); ?>">Talk to the tablet first</label>
                    <textarea id="bmGamePrompt-<?php echo htmlspecialchars($kid_game_profile, ENT_QUOTES, 'UTF-8'); ?>" class="bm-game-field" data-bm-prompt placeholder="<?php echo htmlspecialchars($kid_game_examples, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($kid_game_examples, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <div class="bm-game-control-row">
                        <button class="bm-game-action primary" type="button" data-bm-listen>Start talking</button>
                        <button class="bm-game-action success" type="button" data-bm-generate>Make my game</button>
                        <button class="bm-game-action warn" type="button" data-bm-improve>Improve selected</button>
                    </div>
                    <div class="bm-game-conversation" data-bm-conversation></div>
                    <div class="bm-game-status" data-bm-status>Ready. Focus: <?php echo htmlspecialchars($kid_game_focus, ENT_QUOTES, 'UTF-8'); ?>.</div>
                </div>

                <div class="bm-game-stage" aria-live="polite">
                    <div class="bm-game-stage-header">
                        <h3 data-bm-active-title>Game preview</h3>
                        <strong data-bm-score>0 / 0</strong>
                    </div>
                    <div class="bm-game-playfield" data-bm-playfield>
                        <div class="bm-game-avatar"><?php echo htmlspecialchars(substr($kid_game_name, 0, 1), ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div class="bm-game-stage-footer">
                        <span data-bm-goal>Generate or select a game.</span>
                        <button class="bm-game-action primary" type="button" data-bm-replay>Replay</button>
                    </div>
                </div>
            </div>
        </div>

        <aside class="bm-game-panel">
            <h2 style="margin: 0 0 0.45rem;">Game Log</h2>
            <p class="bm-game-muted">Saved games stay on this device for the preview. Each card can be replayed or selected for improvement.</p>
            <div class="bm-game-log-list" data-bm-log></div>
        </aside>
    </div>

    <script type="application/json" data-bm-seed><?php echo json_encode($kid_game_seed); ?></script>
    <script>
    (function() {
        const root = document.currentScript.closest('.bm-game-center');
        if (!root || root.dataset.ready === 'true') return;
        root.dataset.ready = 'true';

        const profile = root.dataset.profile || 'sterling';
        const storageKey = 'bullmight-game-center-' + profile;
        const seed = JSON.parse(root.querySelector('[data-bm-seed]').textContent || '[]');
        const prompt = root.querySelector('[data-bm-prompt]');
        const status = root.querySelector('[data-bm-status]');
        const playfield = root.querySelector('[data-bm-playfield]');
        const scoreEl = root.querySelector('[data-bm-score]');
        const titleEl = root.querySelector('[data-bm-active-title]');
        const goalEl = root.querySelector('[data-bm-goal]');
        const logEl = root.querySelector('[data-bm-log]');
        const conversationEl = root.querySelector('[data-bm-conversation]');
        const avatar = root.querySelector('.bm-game-avatar');
        let games = loadGames();
        let activeGame = games[0] || null;
        let score = 0;
        let conversationTurns = [];
        let recognition = null;
        let listening = false;

        function loadGames() {
            try {
                const saved = JSON.parse(localStorage.getItem(storageKey) || '[]');
                return saved.length ? saved : seed.map(toSavedGame);
            } catch (error) {
                return seed.map(toSavedGame);
            }
        }

        function saveGames() {
            localStorage.setItem(storageKey, JSON.stringify(games.slice(0, 24)));
        }

        function toSavedGame(input) {
            const type = input.type || inferType(input.prompt || '');
            const engine = input.engine || inferEngine(input.prompt || '', type);
            return {
                id: input.id || String(Date.now()) + '-' + Math.random().toString(16).slice(2),
                title: input.title || titleFromPrompt(input.prompt || ''),
                type,
                engine,
                prompt: input.prompt || '',
                goal: input.goal || goalForType(type),
                challenge: input.challenge || challengeForType(type),
                targets: targetsForType(type, input.prompt || ''),
                createdAt: input.createdAt || new Date().toISOString(),
                revisions: input.revisions || 0
            };
        }

        function inferType(text) {
            const value = text.toLowerCase();
            if (value.includes('math') || value.includes('add') || value.includes('subtract') || value.includes('multiply')) return 'math';
            if (value.includes('sentence') || value.includes('write') || value.includes('dictation')) return 'writing';
            if (value.includes('read') || value.includes('word') || value.includes('match')) return 'reading';
            return 'speech';
        }

        function inferEngine(text, type) {
            const value = text.toLowerCase();
            if (value.includes('angry') || value.includes('bird') || value.includes('slingshot') || value.includes('break')) return 'slingshot';
            if (value.includes('car') || value.includes('chase') || value.includes('drive') || value.includes('race')) return 'chase';
            if (type === 'writing' || type === 'reading') return 'slingshot';
            return 'chase';
        }

        function titleFromPrompt(text) {
            const type = inferType(text);
            const names = {
                math: 'Math Builder Game',
                writing: 'Sentence Quest',
                reading: 'Word Match Game',
                speech: 'Speech Launch Game'
            };
            return names[type] || 'Custom Learning Game';
        }

        function goalForType(type) {
            return {
                math: 'Solve the problems and explain one answer.',
                writing: 'Build or write one complete sentence.',
                reading: 'Read and match the target words.',
                speech: 'Practice each word calmly before moving on.'
            }[type] || 'Finish the learning challenge.';
        }

        function challengeForType(type) {
            return {
                math: 'Tap the correct answers to build the path.',
                writing: 'Collect words in order and read the sentence.',
                reading: 'Match the words before the board clears.',
                speech: 'Say each target, then tap it to launch.'
            }[type] || 'Tap each target to complete the game.';
        }

        function targetsForType(type, text) {
            const words = text.match(/[a-zA-Z]{3,}/g) || [];
            if (type === 'math') return ['8 + 7 = 15', '12 - 5 = 7', '3 x 4 = 12', '18 / 3 = 6'];
            if (type === 'writing') return (words.length ? words : ['I', 'can', 'write', 'clearly']).slice(0, 6);
            if (type === 'reading') return (words.length ? words : ['cat', 'moon', 'book', 'star', 'jump', 'kind']).slice(0, 6);
            return (words.length ? words : ['smooth', 'start', 'rocket', 'ready', 'steady']).slice(0, 6);
        }

        function transcriptText() {
            return conversationTurns.map(turn => turn.text).join(' ').trim();
        }

        function gameSourceText() {
            return (transcriptText() || prompt.value || '').trim();
        }

        function addConversation(role, text) {
            if (!text.trim()) return;
            conversationTurns.push({ role, text: text.trim(), at: new Date().toISOString() });
            renderConversation();
        }

        function renderConversation() {
            conversationEl.innerHTML = '';
            if (!conversationTurns.length) {
                const empty = document.createElement('div');
                empty.className = 'bm-game-bubble';
                empty.textContent = 'Press Start talking and describe the game. Example: I want a car chase game where I collect letters to spell rocket.';
                conversationEl.appendChild(empty);
                return;
            }
            conversationTurns.slice(-6).forEach(turn => {
                const bubble = document.createElement('div');
                bubble.className = 'bm-game-bubble ' + (turn.role === 'child' ? 'child' : '');
                bubble.textContent = (turn.role === 'child' ? 'Child: ' : 'Tablet: ') + turn.text;
                conversationEl.appendChild(bubble);
            });
        }

        function generateGame(isRevision) {
            const text = gameSourceText();
            if (!text) {
                status.textContent = 'Have them talk to the tablet or type a game idea first.';
                return;
            }
            if (isRevision && activeGame) {
                activeGame.prompt += ' Improvement: ' + text;
                activeGame.type = inferType(activeGame.prompt);
                activeGame.engine = inferEngine(activeGame.prompt, activeGame.type);
                activeGame.goal = goalForType(activeGame.type);
                activeGame.challenge = challengeForType(activeGame.type);
                activeGame.targets = targetsForType(activeGame.type, activeGame.prompt);
                activeGame.revisions += 1;
                status.textContent = 'Improved: ' + activeGame.title;
                addConversation('tablet', 'I updated the game with what you just told me.');
            } else {
                activeGame = toSavedGame({ prompt: text });
                games.unshift(activeGame);
                status.textContent = 'Created: ' + activeGame.title;
                addConversation('tablet', 'I made your game from your words. Tap the targets to play it.');
            }
            prompt.value = text;
            saveGames();
            renderLog();
            renderGame(activeGame);
        }

        function renderGame(game) {
            activeGame = game;
            score = 0;
            titleEl.textContent = game.title;
            goalEl.textContent = game.goal;
            scoreEl.textContent = '0 / ' + game.targets.length;
            playfield.innerHTML = '';
            status.textContent = 'Playing: ' + game.challenge;
            if (game.engine === 'slingshot') {
                renderSlingshotGame(game);
            } else {
                renderChaseGame(game);
            }
        }

        function makeCanvas() {
            const canvas = document.createElement('canvas');
            canvas.className = 'bm-game-canvas';
            const rect = playfield.getBoundingClientRect();
            canvas.width = Math.max(620, Math.floor(rect.width || 620));
            canvas.height = Math.max(320, Math.floor(rect.height || 320));
            playfield.appendChild(canvas);
            return canvas;
        }

        function finishGame(game) {
            status.textContent = 'Complete. Proof saved for ' + game.title + '.';
            game.lastPlayedAt = new Date().toISOString();
            game.lastScore = score + '/' + game.targets.length;
            saveGames();
            renderLog();
        }

        function renderChaseGame(game) {
            const canvas = makeCanvas();
            const ctx = canvas.getContext('2d');
            const car = { x: 48, y: canvas.height - 82, w: 72, h: 38 };
            const targets = game.targets.map((label, index) => ({
                label,
                x: 190 + (index % 3) * 145,
                y: 52 + Math.floor(index / 3) * 86,
                w: Math.max(88, label.length * 8),
                h: 42,
                done: false
            }));

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#0b1727';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = 'rgba(31,162,255,0.18)';
                for (let i = 0; i < 7; i++) ctx.fillRect(i * 120 - 20, canvas.height - 34, 66, 6);
                ctx.fillStyle = '#1fa2ff';
                ctx.fillRect(car.x, car.y, car.w, car.h);
                ctx.fillStyle = '#2bd17e';
                ctx.fillRect(car.x + 42, car.y - 18, 24, 18);
                ctx.fillStyle = '#07111e';
                ctx.beginPath(); ctx.arc(car.x + 16, car.y + 40, 8, 0, Math.PI * 2); ctx.fill();
                ctx.beginPath(); ctx.arc(car.x + 56, car.y + 40, 8, 0, Math.PI * 2); ctx.fill();
                targets.forEach(target => {
                    if (target.done) return;
                    ctx.fillStyle = '#fffaf0';
                    roundRect(ctx, target.x, target.y, target.w, target.h, 8);
                    ctx.fillStyle = '#102033';
                    ctx.font = '800 16px Outfit, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(target.label, target.x + target.w / 2, target.y + 27);
                });
            }

            function moveToTarget(target) {
                if (target.done) return;
                target.done = true;
                car.x = Math.max(18, target.x - 38);
                car.y = Math.min(canvas.height - 82, target.y + 48);
                score += 1;
                scoreEl.textContent = score + ' / ' + game.targets.length;
                speak(target.label);
                draw();
                if (score >= game.targets.length) finishGame(game);
            }

            canvas.addEventListener('click', event => {
                const point = canvasPoint(canvas, event);
                const hit = targets.find(target => !target.done && point.x >= target.x && point.x <= target.x + target.w && point.y >= target.y && point.y <= target.y + target.h);
                if (hit) moveToTarget(hit);
            });
            draw();
        }

        function renderSlingshotGame(game) {
            const canvas = makeCanvas();
            const ctx = canvas.getContext('2d');
            const origin = { x: 62, y: canvas.height - 72 };
            const blocks = game.targets.map((label, index) => ({
                label,
                x: canvas.width - 260 + (index % 2) * 118,
                y: 58 + Math.floor(index / 2) * 62,
                w: 104,
                h: 44,
                done: false
            }));
            let aim = { x: origin.x + 130, y: origin.y - 82 };

            function draw(ball) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#0b1727';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.strokeStyle = '#f6c453';
                ctx.lineWidth = 5;
                ctx.beginPath(); ctx.moveTo(origin.x - 16, origin.y); ctx.lineTo(origin.x, origin.y - 42); ctx.lineTo(origin.x + 16, origin.y); ctx.stroke();
                ctx.strokeStyle = 'rgba(246,196,83,0.7)';
                ctx.lineWidth = 2;
                ctx.beginPath(); ctx.moveTo(origin.x, origin.y - 34); ctx.lineTo(aim.x, aim.y); ctx.stroke();
                blocks.forEach(block => {
                    if (block.done) return;
                    ctx.fillStyle = '#fffaf0';
                    roundRect(ctx, block.x, block.y, block.w, block.h, 8);
                    ctx.fillStyle = '#102033';
                    ctx.font = '800 15px Outfit, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(block.label, block.x + block.w / 2, block.y + 28);
                });
                ctx.fillStyle = '#2bd17e';
                ctx.beginPath();
                ctx.arc((ball && ball.x) || aim.x, (ball && ball.y) || aim.y, 13, 0, Math.PI * 2);
                ctx.fill();
            }

            function launchAt(block) {
                if (block.done) return;
                let t = 0;
                const start = { ...aim };
                const timer = setInterval(() => {
                    t += 0.08;
                    const x = start.x + (block.x + block.w / 2 - start.x) * t;
                    const y = start.y + (block.y + block.h / 2 - start.y) * t - Math.sin(t * Math.PI) * 48;
                    draw({ x, y });
                    if (t >= 1) {
                        clearInterval(timer);
                        block.done = true;
                        score += 1;
                        scoreEl.textContent = score + ' / ' + game.targets.length;
                        speak(block.label);
                        draw();
                        if (score >= game.targets.length) finishGame(game);
                    }
                }, 24);
            }

            canvas.addEventListener('mousemove', event => { aim = canvasPoint(canvas, event); draw(); });
            canvas.addEventListener('touchmove', event => { event.preventDefault(); aim = canvasPoint(canvas, event.touches[0]); draw(); }, { passive: false });
            canvas.addEventListener('click', event => {
                const point = canvasPoint(canvas, event);
                const hit = blocks.find(block => !block.done && point.x >= block.x && point.x <= block.x + block.w && point.y >= block.y && point.y <= block.y + block.h);
                launchAt(hit || blocks.find(block => !block.done));
            });
            draw();
        }

        function canvasPoint(canvas, event) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: (event.clientX - rect.left) * (canvas.width / rect.width),
                y: (event.clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function roundRect(ctx, x, y, w, h, r) {
            ctx.beginPath();
            ctx.moveTo(x + r, y);
            ctx.arcTo(x + w, y, x + w, y + h, r);
            ctx.arcTo(x + w, y + h, x, y + h, r);
            ctx.arcTo(x, y + h, x, y, r);
            ctx.arcTo(x, y, x + w, y, r);
            ctx.closePath();
            ctx.fill();
        }

        function renderLog() {
            logEl.innerHTML = '';
            if (!games.length) {
                const empty = document.createElement('div');
                empty.className = 'bm-game-empty';
                empty.textContent = 'No saved games yet.';
                logEl.appendChild(empty);
                return;
            }
            games.forEach(game => {
                const card = document.createElement('article');
                card.className = 'bm-game-log-card';
                card.innerHTML = '<h3>' + escapeHtml(game.title) + '</h3>' +
                    '<p>' + escapeHtml(game.goal) + '</p>' +
                    '<p class="bm-game-muted">Type: ' + escapeHtml(game.type) + ' | Engine: ' + escapeHtml(game.engine || 'chase') + ' | Revisions: ' + game.revisions + (game.lastScore ? ' | Last: ' + escapeHtml(game.lastScore) : '') + '</p>';
                const row = document.createElement('div');
                row.className = 'bm-game-control-row';
                const play = document.createElement('button');
                play.className = 'bm-game-action primary';
                play.type = 'button';
                play.textContent = 'Play';
                play.addEventListener('click', () => renderGame(game));
                const improve = document.createElement('button');
                improve.className = 'bm-game-action';
                improve.type = 'button';
                improve.textContent = 'Improve';
                improve.addEventListener('click', () => {
                    activeGame = game;
                    prompt.value = 'Improve this game by adding ';
                    status.textContent = 'Selected for improvement: ' + game.title;
                    renderGame(game);
                });
                row.appendChild(play);
                row.appendChild(improve);
                card.appendChild(row);
                logEl.appendChild(card);
            });
        }

        function listen() {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                status.textContent = 'Speech recognition is not available in this browser. Typing still works.';
                return;
            }
            if (listening && recognition) {
                recognition.stop();
                return;
            }
            recognition = new SpeechRecognition();
            let voiceHadError = false;
            recognition.lang = 'en-US';
            recognition.interimResults = true;
            recognition.continuous = true;
            recognition.onstart = () => {
                listening = true;
                root.querySelector('[data-bm-listen]').textContent = 'Stop and build';
                status.textContent = 'Listening. Tell the tablet what kind of game to make.';
            };
            recognition.onresult = event => {
                let finalText = '';
                let interimText = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    if (event.results[i].isFinal) finalText += event.results[i][0].transcript + ' ';
                    else interimText += event.results[i][0].transcript + ' ';
                }
                if (finalText.trim()) addConversation('child', finalText.trim());
                const combined = (transcriptText() + ' ' + interimText).trim();
                prompt.value = combined || prompt.value;
            };
            recognition.onerror = event => {
                voiceHadError = true;
                status.textContent = 'Voice capture was blocked or unavailable: ' + event.error + '. Use localhost/HTTPS or type the prompt.';
            };
            recognition.onend = () => {
                listening = false;
                root.querySelector('[data-bm-listen]').textContent = 'Start talking';
                if (!voiceHadError && gameSourceText()) {
                    status.textContent = 'Voice idea captured. Building the game.';
                    generateGame(false);
                } else if (!voiceHadError) {
                    status.textContent = 'Listening stopped. No game idea captured.';
                }
            };
            recognition.start();
        }

        function speak(text) {
            if (!window.speechSynthesis || !text) return;
            window.speechSynthesis.cancel();
            window.speechSynthesis.speak(new SpeechSynthesisUtterance(text));
        }

        function escapeHtml(value) {
            return String(value).replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
        }

        root.querySelector('[data-bm-listen]').addEventListener('click', listen);
        root.querySelector('[data-bm-generate]').addEventListener('click', () => generateGame(false));
        root.querySelector('[data-bm-improve]').addEventListener('click', () => generateGame(true));
        root.querySelector('[data-bm-replay]').addEventListener('click', () => activeGame && renderGame(activeGame));
        root.querySelectorAll('[data-bm-tab]').forEach(tab => {
            tab.addEventListener('click', () => {
                root.querySelectorAll('[data-bm-tab]').forEach(item => item.setAttribute('aria-selected', 'false'));
                tab.setAttribute('aria-selected', 'true');
                const mode = tab.dataset.bmTab;
                if (mode === 'create') prompt.value = <?php echo json_encode($kid_game_examples); ?>;
                if (mode === 'improve') prompt.value = activeGame ? 'Improve this game by adding ' : 'Select a game from the log, then say what to improve.';
                if (mode === 'proof') status.textContent = activeGame && activeGame.lastScore ? 'Proof: ' + activeGame.title + ' last score ' + activeGame.lastScore + '.' : 'Play a game to create proof.';
            });
        });

        renderConversation();
        renderLog();
        if (activeGame) renderGame(activeGame);
    })();
    </script>
</section>
