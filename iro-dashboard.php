<?php
/**
 * Template Name: IRO Mission Control v3.0
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenClaw - Master Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      tailwind.config = {
        theme: {
            extend: {
                colors: {
                    cyber: {
                        dark: '#05070a',
                        panel: '#0e1116',
                        subpanel: '#151921',
                        border: '#1f2533',
                        highlight: '#1a1f2e',
                        cyan: '#00F0FF',
                        green: '#00FFA3',
                        orange: '#FF5C00',
                        purple: '#B026FF',
                        slate: '#8E9BB0'
                    }
                },
                fontFamily: {
                    mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'monospace']
                }
            }
        }
      }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700;800&display=swap');
        body { background: #05070a; color: #8E9BB0; font-family: 'JetBrains Mono', monospace; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #0e1116; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #1f2533; border-radius: 10px; }
        .glass-panel { background: rgba(14, 17, 22, 0.7); backdrop-filter: blur(12px); border: 1px solid #1f2533; }
        .message-bubble.bot { background: rgba(0, 240, 255, 0.05); border-left: 2px solid #00F0FF; border-radius: 0 8px 8px 0; }
        .message-bubble.user { background: rgba(255, 92, 0, 0.05); border-right: 2px solid #FF5C00; border-radius: 8px 0 0 8px; text-align: right; }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden selection:bg-cyber-cyan/30">

    <!-- Top Navigation Bar -->
    <header class="h-16 flex items-center justify-between px-6 border-b border-cyber-border bg-cyber-panel shrink-0 shadow-lg relative z-20">
        <div class="flex items-center gap-4">
            <i data-lucide="cpu" class="text-cyber-cyan animate-pulse"></i>
            <h1 class="text-xl font-extrabold tracking-widest text-white">BULLMIGHT <span class="text-cyber-cyan opacity-80">MASTER CONTROL</span></h1>
            <span class="bg-cyber-purple/10 text-cyber-purple text-[10px] px-2 py-0.5 rounded border border-cyber-purple/30 uppercase tracking-widest font-bold ml-2">v3.0 Secure</span>
        </div>
        <div class="flex items-center gap-6">
            <div id="system-status" class="flex items-center gap-2 bg-[#052E20] text-cyber-green px-3 py-1.5 rounded text-xs border border-cyber-green/30">
                <div class="w-2 h-2 rounded-full bg-cyber-green animate-pulse"></div>
                <span class="font-bold tracking-widest opacity-90">SYSTEM ONLINE</span>
            </div>
            <button class="text-cyber-slate hover:text-white transition-colors" onclick="alert('Feature requires GHL Auth Key integration.')">
                <i data-lucide="settings" class="w-5 h-5"></i>
            </button>
        </div>
    </header>

    <!-- Main Workspace -->
    <div class="flex-1 flex overflow-hidden">
        
        <!-- Left Sidebar: Fleet & Cron -->
        <div class="w-80 flex flex-col border-r border-cyber-border bg-cyber-panel shrink-0 z-10 overflow-y-auto custom-scrollbar">
            
            <!-- Agent Fleet -->
            <div class="p-5 border-b border-cyber-border">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-[10px] uppercase font-bold tracking-widest text-white/50 flex items-center gap-2">
                        <i data-lucide="network" class="w-3 h-3"></i> Agent Fleet
                    </h2>
                    <button class="text-[10px] bg-cyber-border hover:bg-white text-white hover:text-black px-2 py-1 rounded transition-colors font-bold uppercase tracking-widest" onclick="alert('Master Restart Triggered. Rebooting PM2 processes.')">Restart All</button>
                </div>
                
                <div class="space-y-3">
                    <!-- Agent: IRO -->
                    <div class="bg-cyber-subpanel border border-[#00F0FF]/20 rounded p-3 hover:border-[#00F0FF]/50 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-white text-sm flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-[#00F0FF]"></div> IRO</span>
                            <span class="text-[9px] text-[#00F0FF] uppercase tracking-widest border border-[#00F0FF]/30 px-1.5 rounded">Core</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-cyber-slate/70">Sys Admin & Comms</span>
                            <button class="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] text-cyber-slate hover:text-white"><i data-lucide="rotate-cw" class="w-3 h-3"></i></button>
                        </div>
                        <div class="border-t border-[#00F0FF]/10 pt-2 flex gap-1 mt-2">
                            <input type="text" class="flex-1 bg-cyber-dark text-[9px] px-2 py-1 rounded text-white border border-[#00F0FF]/20 focus:border-[#00F0FF] outline-none" placeholder="Telegram API / Instruct..." onkeydown="if(event.key==='Enter') window.open('https://web.telegram.org/a/#1234567', '_blank')" />
                            <button onclick="window.open('https://web.telegram.org/a/#1234567', '_blank')" class="bg-[#00F0FF]/20 text-[#00F0FF] px-2 rounded hover:bg-[#00F0FF] hover:text-black transition-colors" title="Launch Telegram App"><i data-lucide="send" class="w-3 h-3"></i></button>
                        </div>
                    </div>
                    
                    <!-- Agent: MASTERCHEF -->
                    <div class="bg-cyber-subpanel border border-[#FF5C00]/20 rounded p-3 hover:border-[#FF5C00]/50 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-white text-sm flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-[#FF5C00]"></div> Masterchef</span>
                            <span class="text-[9px] text-[#FF5C00] uppercase tracking-widest border border-[#FF5C00]/30 px-1.5 rounded">GHL/Web</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-cyber-slate/70">WIMPER Email Sequence</span>
                            <button class="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] text-cyber-slate hover:text-white"><i data-lucide="rotate-cw" class="w-3 h-3"></i></button>
                        </div>
                        <div class="border-t border-[#FF5C00]/10 pt-2 flex gap-1 mt-2">
                            <input type="text" class="flex-1 bg-cyber-dark text-[9px] px-2 py-1 rounded text-white border border-[#FF5C00]/20 focus:border-[#FF5C00] outline-none" placeholder="Telegram API / Instruct..." onkeydown="if(event.key==='Enter') window.open('https://web.telegram.org/a/#1234567', '_blank')" />
                            <button onclick="window.open('https://web.telegram.org/a/#1234567', '_blank')" class="bg-[#FF5C00]/20 text-[#FF5C00] px-2 rounded hover:bg-[#FF5C00] hover:text-black transition-colors" title="Launch Telegram App"><i data-lucide="send" class="w-3 h-3"></i></button>
                        </div>
                    </div>
                    
                    <!-- Agent: VOLT -->
                    <div class="bg-cyber-subpanel border border-[#B026FF]/20 rounded p-3 hover:border-[#B026FF]/50 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-white text-sm flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-[#B026FF]"></div> Volt</span>
                            <span class="text-[9px] text-[#B026FF] uppercase tracking-widest border border-[#B026FF]/30 px-1.5 rounded">Data</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-cyber-slate/70">Scraping & SEO Metric</span>
                            <button class="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] text-cyber-slate hover:text-white"><i data-lucide="rotate-cw" class="w-3 h-3"></i></button>
                        </div>
                        <div class="border-t border-[#B026FF]/10 pt-2 flex gap-1 mt-2">
                            <input type="text" class="flex-1 bg-cyber-dark text-[9px] px-2 py-1 rounded text-white border border-[#B026FF]/20 focus:border-[#B026FF] outline-none" placeholder="Telegram API / Instruct..." onkeydown="if(event.key==='Enter') window.open('https://web.telegram.org/a/#1234567', '_blank')" />
                            <button onclick="window.open('https://web.telegram.org/a/#1234567', '_blank')" class="bg-[#B026FF]/20 text-[#B026FF] px-2 rounded hover:bg-[#B026FF] hover:text-white transition-colors" title="Launch Telegram App"><i data-lucide="send" class="w-3 h-3"></i></button>
                        </div>
                    </div>

                    <!-- Agent: PICASSO -->
                    <div class="bg-cyber-subpanel border border-[#00FFA3]/20 rounded p-3 hover:border-[#00FFA3]/50 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-white text-sm flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-[#00FFA3]"></div> Picasso</span>
                            <span class="text-[9px] text-[#00FFA3] uppercase tracking-widest border border-[#00FFA3]/30 px-1.5 rounded">Media</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-cyber-slate/70">Awaiting HeyGen Task</span>
                            <button class="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] text-cyber-slate hover:text-white"><i data-lucide="rotate-cw" class="w-3 h-3"></i></button>
                        </div>
                        <div class="border-t border-[#00FFA3]/10 pt-2 flex gap-1 mt-2">
                            <input type="text" class="flex-1 bg-cyber-dark text-[9px] px-2 py-1 rounded text-white border border-[#00FFA3]/20 focus:border-[#00FFA3] outline-none" placeholder="Telegram API / Instruct..." onkeydown="if(event.key==='Enter') window.open('https://web.telegram.org/a/#1234567', '_blank')" />
                            <button onclick="window.open('https://web.telegram.org/a/#1234567', '_blank')" class="bg-[#00FFA3]/20 text-[#00FFA3] px-2 rounded hover:bg-[#00FFA3] hover:text-black transition-colors" title="Launch Telegram App"><i data-lucide="send" class="w-3 h-3"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cron Jobs & Queues -->
            <div class="p-5 flex-1 flex flex-col">
                <h2 class="text-[10px] uppercase font-bold tracking-widest text-white/50 mb-4 flex items-center gap-2">
                    <i data-lucide="server-cog" class="w-3 h-3"></i> Active Cron Queue
                </h2>
                <div class="space-y-4 flex-1 overflow-y-auto custom-scrollbar pr-2">
                    <!-- Cron Item -->
                    <div class="flex gap-3 items-start">
                        <div class="w-2 h-2 rounded-full bg-cyber-green mt-1.5 shrink-0 blink-slow"></div>
                        <div class="space-y-1">
                            <div class="text-xs text-white">Daily Performance Sync</div>
                            <div class="text-[10px] text-cyber-slate/60 font-mono">Runs every 12 hours. Next in 4h.</div>
                        </div>
                    </div>
                    <!-- Cron Item -->
                    <div class="flex gap-3 items-start">
                        <div class="w-2 h-2 rounded-full bg-cyber-orange mt-1.5 shrink-0"></div>
                        <div class="space-y-1">
                            <div class="text-xs text-white">AFC n8n Lesson Engine</div>
                            <div class="text-[10px] text-cyber-orange/80 font-mono">Action Required - Validating Classroom 4 Rules.</div>
                        </div>
                    </div>
                    <!-- Cron Item -->
                    <div class="flex gap-3 items-start">
                        <div class="w-2 h-2 rounded-full bg-cyber-cyan mt-1.5 shrink-0"></div>
                        <div class="space-y-1">
                            <div class="text-xs text-white">EasyGrow 5W Email Pipeline</div>
                            <div class="text-[10px] text-cyber-slate/60 font-mono">Awaiting Trigger. Blocked by Robert until Test 1 is reviewed.</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Center: Interactive Chat Interface -->
        <div class="flex-1 flex flex-col relative bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAzNHYtbDItMiAybC0yLTJ2LTEwTDMyIDE4bC0yIDJwLTEwdjEwTDMyIDMybDIgMnYtaHoiIGZpbGw9IiMxYTFmMmUiIGZpbGwtb3BhY2l0eT0iMC4xNSIvPjwvZz48L3N2Zz4=')]">
            
            <!-- Chat Header -->
            <div class="h-14 border-b border-cyber-border bg-cyber-panel/90 backdrop-blur shrink-0 flex items-center justify-between px-6 z-10 w-full">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-black px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest flex items-center gap-1">
                        <i data-lucide="radio-receiver" class="w-3 h-3"></i> TACTICAL COMMS
                    </span>
                    <span class="text-xs opacity-50">Secure channel directly to OpenClaw Engine node.</span>
                </div>
                <div class="flex items-center gap-2">
                    <button class="text-xs px-3 py-1.5 border border-cyber-border hover:bg-cyber-border hover:text-white rounded transition-colors flex items-center gap-2">
                        <i data-lucide="upload-cloud" class="w-3 h-3"></i> Add Skill File
                    </button>
                    <button class="text-xs px-3 py-1.5 bg-cyber-cyan text-black hover:bg-white font-bold rounded transition-colors" onclick="clearTerminal()">CLEAR LOG</button>
                </div>
            </div>

            <!-- Chat Window -->
            <div id="chat-window" class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-6">
                <!-- System Message -->
                <div class="flex justify-center">
                    <div class="bg-cyber-panel border border-cyber-border px-4 py-2 rounded text-[10px] text-cyber-slate/50">
                        MISSION CONTROL LINK V3.0 ACTIVATED [<?php echo date('Y-m-d H:i:s'); ?>]
                    </div>
                </div>

                <!-- Bot Message -->
                <div class="flex justify-start max-w-3xl">
                    <div class="flex-1 space-y-2">
                        <div class="text-[10px] font-bold text-cyber-cyan px-2 flex items-center gap-1">
                            <i data-lucide="cpu" class="w-3 h-3"></i> IRO / ANTIGRAVITY ENGINE
                        </div>
                        <div class="message-bubble bot p-4 shadow-lg text-sm text-white/90">
                            Systems re-initialized. The WIMPER Cloudflare `DNS Proxy` loop must be fixed via the Cloudflare Dashboard. 
                            <br><br>
                            I have built this interface to mirror your Telegram experience directly. The Cron monitor to the left is locked in. The Asset Feed to the right is monitoring Picasso. How do we proceed with the AFC Lesson Engine?
                        </div>
                    </div>
                </div>

                <!-- User Message -->
                <div class="flex justify-end ml-auto max-w-3xl">
                    <div class="flex-1 space-y-2">
                        <div class="text-[10px] font-bold text-cyber-orange px-2 text-right">ROBERT / CMD</div>
                        <div class="message-bubble user p-4 shadow-lg text-sm text-white">
                            approed
                        </div>
                    </div>
                </div>

                <!-- Chat Bottom Anchor -->
                <div id="chat-anchor"></div>
            </div>

            <!-- Input Area -->
            <div class="p-5 bg-cyber-panel border-t border-cyber-border shrink-0 z-10">
                <form id="consoleForm" class="flex items-end gap-3" onsubmit="handleChatSubmit(event)">
                    <div class="flex-1 bg-cyber-dark border border-cyber-border rounded-lg overflow-hidden focus-within:border-cyber-cyan/50 transition-colors">
                        <textarea id="consoleInput" rows="2" class="w-full bg-transparent p-3 text-sm text-white focus:outline-none resize-none custom-scrollbar" placeholder="Transmit instruction to OpenClaw Node..." required></textarea>
                    </div>
                    <button type="submit" class="h-[52px] px-6 bg-cyber-cyan text-black font-extrabold rounded-lg hover:bg-white transition-all shadow-[0_0_15px_rgba(0,240,255,0.2)] flex items-center gap-2">
                        TRANSMIT <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Sidebar: Assets & Opportunities -->
        <div class="w-80 flex flex-col border-l border-cyber-border bg-cyber-panel shrink-0 z-10 overflow-y-auto custom-scrollbar">
            
            <!-- CRM Opportunities -->
            <div class="p-5 border-b border-cyber-border">
                <h2 class="text-[10px] uppercase font-bold tracking-widest text-[#00FFA3] mb-4 flex items-center gap-2">
                    <i data-lucide="bar-chart-3" class="w-3 h-3"></i> Local SEO & GHL Pipeline (Live)
                </h2>
                <div class="space-y-4">
                    <div class="bg-cyber-subpanel border border-[#00FFA3]/20 rounded p-4 relative overflow-hidden group">
                        <!-- WIMPER BG Pattern -->
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9IiMwMEZGQTMiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] opacity-20"></div>
                        <div class="relative z-10">
                            <div class="text-[10px] uppercase tracking-widest text-[#00FFA3] mb-1 font-bold">Wimper Target Pool</div>
                            <div class="text-xl font-bold text-white mb-2">14,000 Linked</div>
                            <div class="w-full bg-cyber-dark h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[#00FFA3] h-full w-[0%]"></div>
                            </div>
                            <div class="text-[9px] text-[#00FFA3]/70 mt-2 font-mono uppercase">Status: Volting...</div>
                        </div>
                    </div>

                    <div class="bg-cyber-subpanel border border-[#00F0FF]/20 rounded p-4 relative overflow-hidden group hover:border-[#00F0FF]/50 transition-colors">
                        <!-- Kidazzle BG Pattern -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[#00F0FF]/5 to-transparent"></div>
                        <div class="relative z-10">
                            <div class="text-[10px] uppercase tracking-widest text-[#00F0FF] mb-1 font-bold">Kidazzle Opportunities</div>
                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    <div class="text-2xl font-bold text-white leading-none">12 +</div>
                                    <div class="text-[9px] text-cyber-slate mt-1">Pending Tours</div>
                                </div>
                                <div class="bg-[#00F0FF]/10 text-[#00F0FF] rounded-full px-2 py-1 flex items-center gap-1 text-[10px] font-bold">
                                    <i data-lucide="trending-up" class="w-3 h-3"></i> 24h
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <span class="bg-cyber-dark text-cyber-slate border border-cyber-border text-[9px] px-1.5 py-0.5 rounded">Midtown</span>
                                <span class="bg-cyber-dark text-cyber-slate border border-cyber-border text-[9px] px-1.5 py-0.5 rounded">Doral</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Picasso / G-Docs Asset Feed -->
            <div class="p-5 flex-1 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-[10px] uppercase font-bold tracking-widest text-cyber-purple flex items-center gap-2">
                        <i data-lucide="files" class="w-3 h-3"></i> Asset Stream
                    </h2>
                    <span class="bg-cyber-purple/10 text-cyber-purple px-1.5 py-0.5 rounded text-[9px] font-bold">LIVE</span>
                </div>
                
                <div class="space-y-3 flex-1 overflow-y-auto custom-scrollbar pr-2">
                    
                    <!-- Asset Card 1 -->
                    <a href="#" class="block bg-cyber-subpanel border border-cyber-border hover:border-cyber-purple/40 rounded p-3 transition-colors group">
                        <div class="flex gap-3 items-center">
                            <div class="w-8 h-8 rounded bg-[#4285F4]/20 text-[#4285F4] flex items-center justify-center shrink-0">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-xs font-bold text-white truncate group-hover:text-cyber-purple transition-colors">Terminator Manifest.pdf</div>
                                <div class="text-[10px] text-cyber-slate/60 mt-0.5">Generated by IRO Core • 2h ago</div>
                            </div>
                        </div>
                    </a>

                    <!-- Asset Card 2 -->
                    <a href="#" class="block bg-cyber-subpanel border border-cyber-border hover:border-cyber-purple/40 rounded p-3 transition-colors group">
                        <div class="flex gap-3 items-center">
                            <div class="w-8 h-8 rounded bg-cyber-purple/10 text-cyber-purple flex items-center justify-center shrink-0">
                                <i data-lucide="image" class="w-4 h-4"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-xs font-bold text-white truncate group-hover:text-cyber-purple transition-colors">Wimper_Avatar_Render.jpg</div>
                                <div class="text-[10px] text-cyber-slate/60 mt-0.5">Picasso Render Engine • 4h ago</div>
                            </div>
                        </div>
                    </a>

                    <!-- Add New -->
                    <button class="w-full border border-dashed border-cyber-border hover:border-cyber-slate text-cyber-slate rounded p-3 text-xs flex items-center justify-center gap-2 transition-colors">
                        <i data-lucide="plus" class="w-3 h-3"></i> Upload Reference Doc
                    </button>

                </div>
            </div>
            
        </div>
    </div>

    <!-- Modals & Scripts -->
    <script>
        lucide.createIcons();

        function handleChatSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('consoleInput');
            const val = input.value.trim();
            if(!val) return;

            const chatWindow = document.getElementById('chat-window');
            const anchor = document.getElementById('chat-anchor');

            // Render User Block
            const userBlock = document.createElement('div');
            userBlock.className = 'flex justify-end ml-auto max-w-3xl mb-6 fade-in';
            userBlock.innerHTML = `
                <div class="flex-1 space-y-2">
                    <div class="text-[10px] font-bold text-cyber-orange px-2 text-right">ROBERT / CMD</div>
                    <div class="message-bubble user p-4 shadow-lg text-sm text-white">
                        ${val.replace(/\n/g, '<br>')}
                    </div>
                </div>
            `;
            chatWindow.insertBefore(userBlock, anchor);

            // Execute local link logic (requires local backend to hit bridge files)
            fetch('http://localhost:3004/api/command', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: val, target: 'iro' })
            }).then(res => {
                setTimeout(() => simulateBotAcknowledge(), 600);
            }).catch(e => {
                setTimeout(() => simulateBotError(), 600);
            });

            input.value = '';
            scrollToBottom();
        }

        function simulateBotAcknowledge() {
            const chatWindow = document.getElementById('chat-window');
            const anchor = document.getElementById('chat-anchor');
            const botBlock = document.createElement('div');
            botBlock.className = 'flex justify-start max-w-3xl mb-6 fade-in';
            botBlock.innerHTML = `
                <div class="flex-1 space-y-2">
                    <div class="text-[10px] font-bold text-cyber-cyan px-2 flex items-center gap-1">
                        <i data-lucide="cpu" class="w-3 h-3"></i> LOCAL RELAY
                    </div>
                    <div class="message-bubble bot p-4 shadow-lg text-sm text-white/90">
                        <span class="text-xs font-mono opacity-50 block mb-2">[SYS_ACK]</span>
                        Transmission written securely to <b>to-iro.md</b> in the local bridge workspace. Awaiting processing cycle.
                    </div>
                </div>
            `;
            chatWindow.insertBefore(botBlock, anchor);
            lucide.createIcons();
            scrollToBottom();
        }

        function simulateBotError() {
            const chatWindow = document.getElementById('chat-window');
            const anchor = document.getElementById('chat-anchor');
            const botBlock = document.createElement('div');
            botBlock.className = 'flex justify-start max-w-3xl mb-6 fade-in';
            botBlock.innerHTML = `
                <div class="flex-1 space-y-2">
                    <div class="text-[10px] font-bold text-[#FF5C00] px-2 flex items-center gap-1">
                        <i data-lucide="alert-triangle" class="w-3 h-3"></i> ERROR
                    </div>
                    <div class="bg-[#FF5C00]/10 border-l-2 border-[#FF5C00] rounded-r p-4 shadow-lg text-sm text-white/90">
                        Cannot reach local node server at localhost:3004. Ensure PM2 bridge is active.
                    </div>
                </div>
            `;
            chatWindow.insertBefore(botBlock, anchor);
            lucide.createIcons();
            scrollToBottom();
        }

        function scrollToBottom() {
            const chat = document.getElementById('chat-window');
            chat.scrollTop = chat.scrollHeight;
        }

        function clearTerminal() {
            const chat = document.getElementById('chat-window');
            const anchor = document.getElementById('chat-anchor');
            chat.innerHTML = '';
            chat.appendChild(anchor);
        }

        // Submitting textarea on Enter (allow shift+enter for lines)
        document.getElementById('consoleInput').addEventListener('keydown', function(e) {
            if(e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleChatSubmit(e);
            }
        });
    </script>
</body>
</html>
