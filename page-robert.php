<?php
/**
 * Template Name: Robert First Grade Learning Page
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robert's Learning Lab | Writing, Dictation, and Math</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #08131f;
            --panel: rgba(16, 31, 48, 0.82);
            --panel-strong: #112238;
            --line: rgba(255, 255, 255, 0.12);
            --text: #f7fbff;
            --muted: #b7c7d8;
            --blue: #1fa2ff;
            --green: #2bd17e;
            --gold: #f6c453;
            --coral: #ff6b6b;
            --ink: #102033;
            --paper: #fffaf0;
        }
        * { box-sizing: border-box; }
        html { scroll-padding-top: 108px; }
        body {
            margin: 0;
            font-family: "Outfit", sans-serif;
            background:
                radial-gradient(circle at 12% 12%, rgba(31, 162, 255, 0.24), transparent 30%),
                radial-gradient(circle at 86% 18%, rgba(43, 209, 126, 0.18), transparent 26%),
                linear-gradient(135deg, #08131f 0%, #0d1a2b 50%, #101a30 100%);
            color: var(--text);
            min-height: 100vh;
        }
        h1, h2, h3 { font-family: "Plus Jakarta Sans", sans-serif; margin: 0; letter-spacing: 0; }
        p { margin: 0; color: var(--muted); line-height: 1.65; }
        button, input, textarea { font: inherit; }
        .nav {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1rem 5vw;
            background: rgba(8, 19, 31, 0.94);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(16px);
        }
        .brand { font-weight: 800; color: var(--text); }
        .nav a { color: var(--muted); text-decoration: none; font-weight: 700; margin-left: 1rem; }
        .nav a:hover { color: var(--text); }
        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(320px, 0.9fr);
            gap: 3rem;
            align-items: center;
            padding: 5rem 5vw 3rem;
            max-width: 1320px;
            margin: 0 auto;
        }
        .eyebrow { color: var(--gold); font-weight: 800; text-transform: uppercase; font-size: 0.84rem; letter-spacing: 0.08em; }
        h1 { font-size: clamp(2.6rem, 6vw, 5.8rem); line-height: 0.98; margin-top: 0.8rem; }
        .hero p { font-size: 1.15rem; max-width: 720px; margin-top: 1.25rem; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 0.9rem; margin-top: 2rem; }
        .btn {
            border: 0;
            border-radius: 999px;
            padding: 0.9rem 1.25rem;
            cursor: pointer;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
        }
        .btn.primary { background: linear-gradient(135deg, var(--blue), #4776ff); color: white; }
        .btn.secondary { background: rgba(255,255,255,0.08); color: var(--text); border: 1px solid var(--line); }
        .btn.success { background: var(--green); color: #062014; }
        .btn.warn { background: var(--gold); color: #241703; }
        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 18px 48px rgba(0,0,0,0.28);
        }
        .hero-card { padding: 1.5rem; }
        .daily-list { display: grid; gap: 0.8rem; margin-top: 1.1rem; }
        .daily-item { display: grid; grid-template-columns: 34px 1fr; gap: 0.75rem; align-items: start; }
        .daily-num {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: rgba(31,162,255,0.16);
            color: #9bd8ff;
            font-weight: 800;
        }
        section {
            max-width: 1320px;
            margin: 0 auto;
            padding: 3rem 5vw;
            scroll-margin-top: 108px;
        }
        .section-head { display: flex; justify-content: space-between; gap: 1rem; align-items: end; margin-bottom: 1.5rem; }
        .section-head h2 { font-size: clamp(1.7rem, 3vw, 2.7rem); }
        .grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 1rem; }
        .card { padding: 1.25rem; }
        .span-4 { grid-column: span 4; }
        .span-5 { grid-column: span 5; }
        .span-7 { grid-column: span 7; }
        .span-12 { grid-column: span 12; }
        .label { display: block; font-weight: 800; margin-bottom: 0.5rem; color: var(--text); }
        .field, textarea {
            width: 100%;
            border: 1px solid rgba(16, 32, 51, 0.18);
            border-radius: 8px;
            padding: 0.9rem 1rem;
            background: var(--paper);
            color: var(--ink);
            outline: none;
        }
        textarea { min-height: 150px; resize: vertical; line-height: 1.8; }
        .paper {
            background: var(--paper);
            color: var(--ink);
            border-radius: 8px;
            padding: 1rem;
            border: 1px solid rgba(16, 32, 51, 0.12);
        }
        .paper p, .paper li { color: #405368; }
        .writing-lines {
            min-height: 160px;
            background-image: linear-gradient(to bottom, transparent 31px, rgba(31, 162, 255, 0.35) 32px);
            background-size: 100% 32px;
            line-height: 32px;
            font-size: 1.25rem;
            padding: 0 0.5rem;
            outline: none;
        }
        .pill-row { display: flex; flex-wrap: wrap; gap: 0.55rem; margin-top: 1rem; }
        .pill {
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.07);
            color: var(--text);
            border-radius: 999px;
            padding: 0.55rem 0.8rem;
            cursor: pointer;
            font-weight: 700;
        }
        .math-board {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto 1fr;
            gap: 0.7rem;
            align-items: center;
            justify-content: center;
            color: var(--text);
            font-size: clamp(2rem, 6vw, 4.5rem);
            font-weight: 800;
            text-align: center;
            padding: 1.5rem;
            background: rgba(0,0,0,0.22);
            border-radius: 8px;
        }
        .math-options { display: flex; flex-wrap: wrap; gap: 0.8rem; margin-top: 1rem; }
        .math-options button { min-width: 82px; font-size: 1.4rem; }
        .status { min-height: 1.6rem; color: #9bd8ff; font-weight: 800; margin-top: 0.8rem; }
        canvas {
            width: 100%;
            max-width: 720px;
            height: 280px;
            background: #fffaf0;
            border-radius: 8px;
            display: block;
            touch-action: none;
            cursor: crosshair;
        }
        .dictation-output { min-height: 130px; }
        .word-bank { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.8rem; }
        .word-bank button { border-radius: 8px; border: 1px solid rgba(255,255,255,0.14); background: rgba(255,255,255,0.08); color: var(--text); padding: 0.5rem 0.7rem; cursor: pointer; }
        .small { font-size: 0.92rem; color: var(--muted); }
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; padding-top: 3rem; }
            .section-head { display: block; }
            .span-4, .span-5, .span-7 { grid-column: span 12; }
            .nav { align-items: start; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <nav class="nav">
        <div class="brand">Robert's Learning Lab</div>
        <div class="nav-links">
            <a href="#writing">Writing</a>
            <a href="#dictation">Dictation</a>
            <a href="#math">Math</a>
            <a href="#plan">Daily Plan</a>
        </div>
    </nav>

    <header class="hero">
        <div>
            <div class="eyebrow">First grade practice hub</div>
            <h1>Writing, clear speech, and confident math.</h1>
            <p>This page is built for Robert's current level: writing letters and names, building full sentences, practicing dictation, and moving from addition and subtraction into multiplication and division readiness.</p>
            <div class="hero-actions">
                <a class="btn primary" href="#writing">Start writing</a>
                <a class="btn secondary" href="#dictation">Practice talk-to-text</a>
                <a class="btn secondary" href="#math">Try math</a>
            </div>
        </div>
        <div class="panel hero-card">
            <h2>Today's quick path</h2>
            <p>Keep the session short, positive, and repeatable.</p>
            <div class="daily-list">
                <div class="daily-item"><div class="daily-num">1</div><p>Write his name, then one friend's name.</p></div>
                <div class="daily-item"><div class="daily-num">2</div><p>Build one sentence from the word bank.</p></div>
                <div class="daily-item"><div class="daily-num">3</div><p>Say the sentence out loud, then use dictation.</p></div>
                <div class="daily-item"><div class="daily-num">4</div><p>Complete five math problems and read the answers back.</p></div>
            </div>
        </div>
    </header>

    <main>
        <section id="writing">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Writing center</p>
                    <h2>Name, letter, and sentence practice</h2>
                </div>
                <p class="small">Designed for iPad, pencil, mouse, or keyboard.</p>
            </div>
            <div class="grid">
                <div class="panel card span-5">
                    <label class="label" for="writingPrompt">Choose a writing prompt</label>
                    <select id="writingPrompt" class="field">
                        <option value="Robert">Write your first name: Robert</option>
                        <option value="Robert Hale">Write your full name: Robert Hale</option>
                        <option value="My friend is kind.">Write a sentence: My friend is kind.</option>
                        <option value="I can solve hard math.">Write a sentence: I can solve hard math.</option>
                        <option value="Today I learned something new.">Write a sentence: Today I learned something new.</option>
                    </select>
                    <div class="pill-row">
                        <button class="pill" type="button" onclick="setPrompt('Dad')">Dad</button>
                        <button class="pill" type="button" onclick="setPrompt('Mom')">Mom</button>
                        <button class="pill" type="button" onclick="setPrompt('Sterling')">Sterling</button>
                        <button class="pill" type="button" onclick="setPrompt('My teacher helps me learn.')">Teacher sentence</button>
                    </div>
                    <div class="status" id="writingStatus">Current guide: Robert</div>
                    <canvas id="writingCanvas" width="900" height="360" aria-label="Writing practice canvas"></canvas>
                    <div class="hero-actions">
                        <button class="btn secondary" type="button" onclick="clearWriting()">Clear</button>
                        <button class="btn primary" type="button" onclick="saveWriting()">Mark complete</button>
                        <button class="btn warn" type="button" onclick="speakGuide()">Read guide</button>
                    </div>
                </div>
                <div class="panel card span-7">
                    <label class="label">Keyboard writing lines</label>
                    <div class="paper">
                        <div id="keyboardWriting" class="writing-lines" contenteditable="true" aria-label="Keyboard writing practice">Robert</div>
                    </div>
                    <div class="word-bank">
                        <button type="button" onclick="addWord('I')">I</button>
                        <button type="button" onclick="addWord('can')">can</button>
                        <button type="button" onclick="addWord('write')">write</button>
                        <button type="button" onclick="addWord('a')">a</button>
                        <button type="button" onclick="addWord('clear')">clear</button>
                        <button type="button" onclick="addWord('sentence')">sentence</button>
                        <button type="button" onclick="addWord('today')">today</button>
                        <button type="button" onclick="addWord('.')">.</button>
                    </div>
                    <div class="hero-actions">
                        <button class="btn primary" type="button" onclick="readKeyboardWriting()">Read my sentence</button>
                        <button class="btn secondary" type="button" onclick="newSentenceStarter()">New starter</button>
                    </div>
                    <div class="status" id="sentenceStatus">Sentence builder ready.</div>
                </div>
            </div>
        </section>

        <section id="dictation">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Dictation and speech</p>
                    <h2>Talk it out, then clean it up</h2>
                </div>
                <p class="small">Uses browser speech recognition when available.</p>
            </div>
            <div class="grid">
                <div class="panel card span-7">
                    <label class="label" for="dictationText">Dictation pad</label>
                    <textarea id="dictationText" class="dictation-output" placeholder="Press Start Dictation, say a sentence, then review the words here."></textarea>
                    <div class="hero-actions">
                        <button id="dictationButton" class="btn primary" type="button" onclick="toggleDictation()">Start dictation</button>
                        <button class="btn secondary" type="button" onclick="readDictation()">Read it back</button>
                        <button class="btn secondary" type="button" onclick="clearDictation()">Clear</button>
                    </div>
                    <div class="status" id="dictationStatus">Dictation is ready.</div>
                </div>
                <div class="panel card span-5">
                    <h3>Coaching prompts</h3>
                    <div class="daily-list">
                        <div class="daily-item"><div class="daily-num">A</div><p>Say the whole idea first, then write it.</p></div>
                        <div class="daily-item"><div class="daily-num">B</div><p>If a word is unclear, repeat calmly and try again.</p></div>
                        <div class="daily-item"><div class="daily-num">C</div><p>Ask: does the sentence have a capital letter, spaces, and punctuation?</p></div>
                    </div>
                    <div class="hero-actions">
                        <button class="btn warn" type="button" onclick="loadDictationPrompt()">Give me a sentence</button>
                    </div>
                </div>
            </div>
        </section>

        <section id="math">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Math ladder</p>
                    <h2>Addition, subtraction, multiplication, and division readiness</h2>
                </div>
                <p class="small">Use easier modes for warmup, harder modes for challenge.</p>
            </div>
            <div class="grid">
                <div class="panel card span-7">
                    <div class="pill-row" style="margin-top: 0;">
                        <button class="pill" type="button" onclick="setMathMode('add')">Addition</button>
                        <button class="pill" type="button" onclick="setMathMode('subtract')">Subtraction</button>
                        <button class="pill" type="button" onclick="setMathMode('multiply')">Multiplication</button>
                        <button class="pill" type="button" onclick="setMathMode('divide')">Division</button>
                    </div>
                    <div class="math-board" aria-live="polite">
                        <div id="leftNumber">4</div>
                        <div id="operator">+</div>
                        <div id="rightNumber">3</div>
                        <div>=</div>
                        <div>?</div>
                    </div>
                    <div id="mathOptions" class="math-options"></div>
                    <div class="status" id="mathStatus">Choose the answer.</div>
                </div>
                <div class="panel card span-5">
                    <h3>Math talk</h3>
                    <p>Robert should explain the problem out loud before answering. The goal is not just speed. The goal is understanding and confidence.</p>
                    <div class="hero-actions">
                        <button class="btn primary" type="button" onclick="readMathProblem()">Read problem</button>
                        <button class="btn secondary" type="button" onclick="newMathProblem()">New problem</button>
                    </div>
                    <div class="paper" style="margin-top: 1rem;">
                        <p><strong>Prompt:</strong> "Tell me how you know. Can you draw it, count it, or make groups?"</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="plan">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Guided routine</p>
                    <h2>Simple weekly structure</h2>
                </div>
            </div>
            <div class="grid">
                <div class="panel card span-4">
                    <h3>Monday and Tuesday</h3>
                    <p>Name writing, friend names, short sentences, addition and subtraction.</p>
                </div>
                <div class="panel card span-4">
                    <h3>Wednesday and Thursday</h3>
                    <p>Dictation, sentence cleanup, reading aloud, multiplication as equal groups.</p>
                </div>
                <div class="panel card span-4">
                    <h3>Friday</h3>
                    <p>Review completed work, pick one favorite sentence, and do a five-problem math check.</p>
                </div>
            </div>
        </section>
    </main>

    <script>
        const writingSelect = document.getElementById('writingPrompt');
        const writingCanvas = document.getElementById('writingCanvas');
        const writingCtx = writingCanvas.getContext('2d');
        let drawing = false;
        let mathMode = 'add';
        let currentMath = { left: 4, right: 3, answer: 7, operator: '+' };
        let recognition = null;
        let dictating = false;

        function speak(text) {
            if (!('speechSynthesis' in window) || !text) return;
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.rate = 0.88;
            utterance.pitch = 1.0;
            const voices = window.speechSynthesis.getVoices();
            const preferred = voices.find(v => v.lang === 'en-US' && /Mark|David|Google|United/i.test(v.name)) || voices.find(v => v.lang === 'en-US');
            if (preferred) utterance.voice = preferred;
            window.speechSynthesis.speak(utterance);
        }

        function drawWritingGuide() {
            const text = writingSelect.value;
            writingCtx.clearRect(0, 0, writingCanvas.width, writingCanvas.height);
            writingCtx.fillStyle = '#fffaf0';
            writingCtx.fillRect(0, 0, writingCanvas.width, writingCanvas.height);
            writingCtx.strokeStyle = 'rgba(31, 162, 255, 0.35)';
            writingCtx.lineWidth = 2;
            for (let y = 80; y < writingCanvas.height; y += 70) {
                writingCtx.beginPath();
                writingCtx.moveTo(32, y);
                writingCtx.lineTo(writingCanvas.width - 32, y);
                writingCtx.stroke();
            }
            writingCtx.save();
            writingCtx.font = text.length > 18 ? '700 46px Outfit' : '700 64px Outfit';
            writingCtx.textAlign = 'center';
            writingCtx.textBaseline = 'middle';
            writingCtx.setLineDash([12, 10]);
            writingCtx.lineWidth = 3;
            writingCtx.strokeStyle = 'rgba(16, 32, 51, 0.28)';
            writingCtx.strokeText(text, writingCanvas.width / 2, 175);
            writingCtx.setLineDash([]);
            writingCtx.fillStyle = 'rgba(16, 32, 51, 0.08)';
            writingCtx.fillText(text, writingCanvas.width / 2, 175);
            writingCtx.restore();
            document.getElementById('writingStatus').textContent = 'Current guide: ' + text;
        }

        function canvasPoint(event) {
            const rect = writingCanvas.getBoundingClientRect();
            const source = event.touches && event.touches[0] ? event.touches[0] : event;
            return {
                x: (source.clientX - rect.left) * (writingCanvas.width / rect.width),
                y: (source.clientY - rect.top) * (writingCanvas.height / rect.height)
            };
        }

        function startDraw(event) {
            drawing = true;
            const point = canvasPoint(event);
            writingCtx.beginPath();
            writingCtx.moveTo(point.x, point.y);
            event.preventDefault();
        }

        function moveDraw(event) {
            if (!drawing) return;
            const point = canvasPoint(event);
            writingCtx.lineTo(point.x, point.y);
            writingCtx.strokeStyle = '#1fa2ff';
            writingCtx.lineWidth = 13;
            writingCtx.lineCap = 'round';
            writingCtx.lineJoin = 'round';
            writingCtx.stroke();
            event.preventDefault();
        }

        function stopDraw() { drawing = false; }

        function clearWriting() {
            drawWritingGuide();
            document.getElementById('writingStatus').textContent = 'Cleared. Trace the guide again.';
        }

        function saveWriting() {
            document.getElementById('writingStatus').textContent = 'Marked complete for this practice session.';
            speak('Good work. Now read what you wrote.');
        }

        function setPrompt(text) {
            let found = false;
            Array.from(writingSelect.options).forEach(option => {
                if (option.value === text) {
                    writingSelect.value = text;
                    found = true;
                }
            });
            if (!found) {
                const option = document.createElement('option');
                option.value = text;
                option.textContent = text;
                writingSelect.appendChild(option);
                writingSelect.value = text;
            }
            document.getElementById('keyboardWriting').textContent = text;
            drawWritingGuide();
        }

        function speakGuide() { speak(writingSelect.value); }

        function addWord(word) {
            const target = document.getElementById('keyboardWriting');
            const spacer = word === '.' ? '' : ' ';
            target.textContent = (target.textContent.trim() + spacer + word).replace(/\s+\./g, '.').trim();
            document.getElementById('sentenceStatus').textContent = 'Added: ' + word;
        }

        function readKeyboardWriting() {
            const text = document.getElementById('keyboardWriting').textContent.trim();
            document.getElementById('sentenceStatus').textContent = text ? 'Reading sentence.' : 'Write a sentence first.';
            speak(text);
        }

        function newSentenceStarter() {
            const starters = ['I can', 'Today I', 'My friend', 'At school I', 'I learned'];
            document.getElementById('keyboardWriting').textContent = starters[Math.floor(Math.random() * starters.length)];
            document.getElementById('sentenceStatus').textContent = 'New starter loaded.';
        }

        function setupDictation() {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                document.getElementById('dictationStatus').textContent = 'Speech recognition is not available in this browser.';
                return;
            }
            recognition = new SpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;
            recognition.lang = 'en-US';
            recognition.onresult = event => {
                let text = '';
                for (let i = 0; i < event.results.length; i++) {
                    text += event.results[i][0].transcript;
                }
                document.getElementById('dictationText').value = text.trim();
            };
            recognition.onend = () => {
                dictating = false;
                document.getElementById('dictationButton').textContent = 'Start dictation';
                document.getElementById('dictationStatus').textContent = 'Dictation stopped. Review the sentence.';
            };
        }

        function toggleDictation() {
            if (!recognition) {
                document.getElementById('dictationStatus').textContent = 'Speech recognition is not available in this browser.';
                return;
            }
            if (!dictating) {
                dictating = true;
                recognition.start();
                document.getElementById('dictationButton').textContent = 'Stop dictation';
                document.getElementById('dictationStatus').textContent = 'Listening. Say one clear sentence.';
            } else {
                recognition.stop();
            }
        }

        function readDictation() { speak(document.getElementById('dictationText').value.trim()); }
        function clearDictation() {
            document.getElementById('dictationText').value = '';
            document.getElementById('dictationStatus').textContent = 'Cleared. Ready for a new sentence.';
        }
        function loadDictationPrompt() {
            const prompts = [
                'I can write a complete sentence.',
                'My favorite book has a funny part.',
                'I solved the math problem with groups.',
                'Today I helped my friend.'
            ];
            const prompt = prompts[Math.floor(Math.random() * prompts.length)];
            document.getElementById('dictationText').value = prompt;
            speak(prompt);
        }

        function setMathMode(mode) {
            mathMode = mode;
            newMathProblem();
        }

        function newMathProblem() {
            let left = 0;
            let right = 0;
            let operator = '+';
            let answer = 0;
            if (mathMode === 'add') {
                left = rand(4, 18); right = rand(2, 12); operator = '+'; answer = left + right;
            } else if (mathMode === 'subtract') {
                left = rand(8, 24); right = rand(2, Math.min(12, left - 1)); operator = '-'; answer = left - right;
            } else if (mathMode === 'multiply') {
                left = rand(2, 6); right = rand(2, 6); operator = 'x'; answer = left * right;
            } else {
                right = rand(2, 5); answer = rand(2, 6); left = right * answer; operator = '/';
            }
            currentMath = { left, right, operator, answer };
            document.getElementById('leftNumber').textContent = left;
            document.getElementById('operator').textContent = operator;
            document.getElementById('rightNumber').textContent = right;
            renderMathOptions(answer);
            document.getElementById('mathStatus').textContent = 'Choose the answer.';
        }

        function renderMathOptions(answer) {
            const options = new Set([answer]);
            while (options.size < 4) {
                const offset = rand(-5, 6);
                if (answer + offset > 0) options.add(answer + offset);
            }
            const container = document.getElementById('mathOptions');
            container.innerHTML = '';
            Array.from(options).sort(() => Math.random() - 0.5).forEach(option => {
                const button = document.createElement('button');
                button.className = 'btn secondary';
                button.type = 'button';
                button.textContent = option;
                button.onclick = () => checkMath(option, button);
                container.appendChild(button);
            });
        }

        function checkMath(value, button) {
            if (value === currentMath.answer) {
                button.className = 'btn success';
                document.getElementById('mathStatus').textContent = 'Correct. Explain how you solved it.';
                speak('Correct. Tell me how you solved it.');
            } else {
                button.style.opacity = '0.35';
                document.getElementById('mathStatus').textContent = 'Try again. Count it or draw it.';
                speak('Try again.');
            }
        }

        function readMathProblem() {
            const opWord = currentMath.operator === '+' ? 'plus' : currentMath.operator === '-' ? 'minus' : currentMath.operator === 'x' ? 'times' : 'divided by';
            speak(`${currentMath.left} ${opWord} ${currentMath.right}. What is the answer?`);
        }

        function rand(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }

        writingSelect.addEventListener('change', () => {
            document.getElementById('keyboardWriting').textContent = writingSelect.value;
            drawWritingGuide();
        });
        writingCanvas.addEventListener('mousedown', startDraw);
        writingCanvas.addEventListener('mousemove', moveDraw);
        writingCanvas.addEventListener('mouseup', stopDraw);
        writingCanvas.addEventListener('mouseleave', stopDraw);
        writingCanvas.addEventListener('touchstart', startDraw, { passive: false });
        writingCanvas.addEventListener('touchmove', moveDraw, { passive: false });
        writingCanvas.addEventListener('touchend', stopDraw);
        window.speechSynthesis?.addEventListener?.('voiceschanged', () => {});
        drawWritingGuide();
        setupDictation();
        newMathProblem();
    </script>
</body>
</html>
