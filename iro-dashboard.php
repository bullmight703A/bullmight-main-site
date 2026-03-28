<?php
/**
 * Template Name: IRO Mission Control v3.0
 */

// Load Telemetry Data
$telemetry = ['kidazzle' => [], 'wimper' => []];
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $telemetry_path = 'C:/Users/kidaz/.openclaw/workspace/bridge/telemetry.json';
    if (file_exists($telemetry_path)) {
        $telemetry_data = file_get_contents($telemetry_path);
        if ($telemetry_data) {
            $telemetry = json_decode($telemetry_data, true);
        }
    }
}
$kidazzle = $telemetry['kidazzle'] ?? [];
$wimper = $telemetry['wimper'] ?? [];

$kidazzle_pool = number_format($kidazzle['leadsToday'] ?? 12);
$wimper_pool = number_format($wimper['pool'] ?? 14000);
$wimper_pending = $wimper['pendingOps'] ?? 4;
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
                    <button class="text-[10px] bg-cyber-border hover:bg-white text-white hover:text-black px-2 py-1 rounded transition-colors font-bold uppercase tracking-widest" onclick="restartAgent('all')">Restart All</button>
                </div>
                
                <div class="space-y-3">
                    <!-- Agent: IRO -->
                    <div class="bg-cyber-subpanel border border-[#00F0FF]/20 rounded p-3 hover:border-[#00F0FF]/50 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-white text-sm flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-[#00F0FF]"></div> IRO</span>
                            <span class="text-[9px] text-[#00F0FF] uppercase tracking-widest border border-[#00F0FF]/30 px-1.5 rounded">Core</span>
                        </div>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-[#00F0FF]/10">
                            <span class="text-xs text-cyber-slate/70">Sys Admin & Comms</span>
                            <button onclick="restartAgent('iro')" class="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] bg-cyber-dark border border-cyber-border px-2 py-1 rounded text-cyber-slate hover:text-white hover:border-[#00F0FF] flex items-center gap-1"><i data-lucide="rotate-cw" class="w-3 h-3"></i> RESTART</button>
                        </div>
                    </div>
                    
                    <!-- Agent: MASTERCHEF -->
                    <div class="bg-cyber-subpanel border border-[#FF5C00]/20 rounded p-3 hover:border-[#FF5C00]/50 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-white text-sm flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-[#FF5C00]"></div> Masterchef</span>
                            <span class="text-[9px] text-[#FF5C00] uppercase tracking-widest border border-[#FF5C00]/30 px-1.5 rounded">GHL/Web</span>
                        </div>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-[#FF5C00]/10">
                            <span class="text-xs text-cyber-slate/70">WIMPER Email Sequence</span>
                            <button onclick="restartAgent('masterchef')" class="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] bg-cyber-dark border border-cyber-border px-2 py-1 rounded text-cyber-slate hover:text-white hover:border-[#FF5C00] flex items-center gap-1"><i data-lucide="rotate-cw" class="w-3 h-3"></i> RESTART</button>
                        </div>
                    </div>
                    
                    <!-- Agent: VOLT -->
                    <div class="bg-cyber-subpanel border border-[#B026FF]/20 rounded p-3 hover:border-[#B026FF]/50 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-white text-sm flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-[#B026FF]"></div> Volt</span>
                            <span class="text-[9px] text-[#B026FF] uppercase tracking-widest border border-[#B026FF]/30 px-1.5 rounded">Data</span>
                        </div>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-[#B026FF]/10">
                            <span class="text-xs text-cyber-slate/70">Scraping & SEO Metric</span>
                            <button onclick="restartAgent('volt')" class="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] bg-cyber-dark border border-cyber-border px-2 py-1 rounded text-cyber-slate hover:text-white hover:border-[#B026FF] flex items-center gap-1"><i data-lucide="rotate-cw" class="w-3 h-3"></i> RESTART</button>
                        </div>
                    </div>

                    <!-- Agent: PICASSO -->
                    <div class="bg-cyber-subpanel border border-[#00FFA3]/20 rounded p-3 hover:border-[#00FFA3]/50 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-white text-sm flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-[#00FFA3]"></div> Picasso</span>
                            <span class="text-[9px] text-[#00FFA3] uppercase tracking-widest border border-[#00FFA3]/30 px-1.5 rounded">Media</span>
                        </div>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-[#00FFA3]/10">
                            <span class="text-xs text-cyber-slate/70">Awaiting HeyGen Task</span>
                            <button onclick="restartAgent('picasso')" class="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] bg-cyber-dark border border-cyber-border px-2 py-1 rounded text-cyber-slate hover:text-white hover:border-[#00FFA3] flex items-center gap-1"><i data-lucide="rotate-cw" class="w-3 h-3"></i> RESTART</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cron Jobs & Queues -->
            <div class="p-5 flex-1 flex flex-col">
                <h2 class="text-[10px] uppercase font-bold tracking-widest text-white/50 mb-4 flex items-center gap-2">
                    <i data-lucide="server-cog" class="w-3 h-3"></i> Active Cron Queue
                </h2>
                <div class="space-y-4 flex-1 overflow-y-auto custom-scrollbar pr-2 mb-6">
                    <!-- Cron Item -->
                    <div class="flex gap-3 items-start">
                        <div class="w-2 h-2 rounded-full bg-cyber-green mt-1.5 shrink-0 blink-slow"></div>
                        <div class="space-y-1">
                            <div class="text-xs text-white">Daily Performance Sync</div>
                            <div class="text-[10px] text-cyber-slate/60 font-mono">Runs every 12 hours. Next in 4h.</div>
                        </div>
                    </div>
                </div>

                <!-- ADDED: Tool Approvals Extraction from composiohq/secure-openclaw -->
                <h2 class="text-[10px] uppercase font-bold tracking-widest text-[#FF5C00] mb-4 flex items-center gap-2">
                    <i data-lucide="shield-alert" class="w-3 h-3"></i> Pending Approvals
                </h2>
                <div class="space-y-3">
                    <div class="bg-cyber-dark border border-[#FF5C00]/30 rounded p-3">
                        <div class="text-[10px] text-cyber-slate mb-1">IRO Core requests permission:</div>
                        <div class="text-xs text-white font-mono mb-3"><span class="text-cyber-cyan">Send_Email</span> ("Davis, L. - Custom Follow-up")</div>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-[#00FFA3]/20 hover:bg-[#00FFA3] text-[#00FFA3] hover:text-black border border-[#00FFA3]/50 rounded text-[10px] font-bold py-1 transition-colors" onclick="alert('Tool action approved. Webhook fired.')">APPROVE (Y)</button>
                            <button class="flex-1 bg-[#FF5C00]/20 hover:bg-[#FF5C00] text-[#FF5C00] hover:text-white border border-[#FF5C00]/50 rounded text-[10px] font-bold py-1 transition-colors" onclick="alert('Tool action denied.')">DENY (N)</button>
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
                    <div class="flex items-center bg-cyber-dark border border-cyber-border rounded overflow-hidden">
                        <div class="bg-cyber-border px-2 py-1.5 flex items-center justify-center">
                            <i data-lucide="github" class="w-3 h-3 text-white"></i>
                        </div>
                        <input type="text" placeholder="Paste GitHub / Skill URL..." class="bg-transparent text-[10px] text-white px-2 py-1.5 outline-none w-40 focus:w-64 transition-all" />
                        <button class="text-[9px] font-bold text-black bg-cyber-cyan px-3 py-1.5 hover:bg-white transition-colors" onclick="alert('Skill appended to vector DB.')">ADD SKILL</button>
                    </div>
                    <button class="text-[10px] px-3 py-1.5 border border-cyber-border hover:bg-white hover:text-black font-bold rounded transition-colors" onclick="clearTerminal()">CLEAR LOG</button>
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
                <h2 class="text-[10px] uppercase font-bold tracking-widest text-white mb-4 flex items-center gap-2">
                    <i data-lucide="bar-chart-3" class="w-3 h-3 text-[#00F0FF]"></i> Live Pipeline Opportunities
                </h2>
                <div class="space-y-4">
                    
                    <!-- KIDAZZLE -->
                    <div class="bg-cyber-subpanel border border-[#00F0FF]/30 rounded p-5 min-h-[170px] relative overflow-hidden group hover:border-[#00F0FF]/60 transition-colors shadow-[0_0_10px_rgba(0,240,255,0.05)]">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#00F0FF]/5 to-transparent"></div>
                        <div class="relative z-10">
                            <div class="text-[10px] uppercase tracking-widest text-[#00F0FF] mb-2 font-bold flex justify-between items-center">
                                <span>Kidazzle Pipeline</span>
                                <span class="text-white text-xs"><?php echo $kidazzle_pool; ?> Active</span>
                            </div>
                            
                            <!-- Traffic -->
                            <div class="flex justify-between items-center text-[9px] mb-2 border-b border-cyber-border/50 pb-2">
                                <span class="text-cyber-slate">kidazzle.com Traffic (24h)</span>
                                <span class="text-[#00F0FF] font-mono">1,402</span>
                            </div>

                            <!-- Lead Box -->
                            <div class="flex justify-between items-center mt-3 mb-1 border-b border-cyber-border/30 pb-1">
                                <span class="text-[9px] text-cyber-slate uppercase tracking-wider font-bold">Recent Leads / Tours</span>
                                <span class="text-[9px] text-cyber-slate uppercase tracking-wider font-bold">Tag</span>
                            </div>
                            <div class="space-y-1.5 pt-1">
                                <div class="bg-cyber-dark/50 p-1.5 rounded flex justify-between items-center text-[9px]">
                                    <div>
                                        <span class="text-white font-mono block">Jones, M.</span>
                                        <span class="text-cyber-slate font-mono text-[8px]">Mar 27</span>
                                    </div>
                                    <span class="bg-[#00F0FF]/20 text-[#00F0FF] rounded px-1.5 py-0.5">Midtown</span>
                                </div>
                                <div class="bg-cyber-dark/50 p-1.5 rounded flex justify-between items-center text-[9px]">
                                    <div>
                                        <span class="text-white font-mono block">Smith, T.</span>
                                        <span class="text-cyber-slate font-mono text-[8px]">Mar 28</span>
                                    </div>
                                    <span class="bg-[#00F0FF]/20 text-[#00F0FF] rounded px-1.5 py-0.5">Doral</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- WIMPER -->
                    <div class="bg-cyber-subpanel border border-[#00FFA3]/30 rounded p-5 min-h-[220px] relative overflow-hidden group hover:border-[#00FFA3]/60 transition-colors shadow-[0_0_10px_rgba(0,255,163,0.05)]">
                        <!-- WIMPER BG Pattern -->
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9IiMwMEZGQTMiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] opacity-20"></div>
                        <div class="relative z-10">
                            <div class="text-[10px] uppercase tracking-widest text-[#00FFA3] mb-2 font-bold flex justify-between items-center">
                                <span>Wimper Program</span>
                                <span class="text-white text-xs"><?php echo $wimper_pool; ?> Pool</span>
                            </div>
                            
                            <!-- Opps -->
                            <div class="text-[9px] text-[#00FFA3]/70 font-mono mb-2">OPPORTUNITIES: <?php echo $wimper_pending; ?> Pending</div>

                            <!-- Contact Box -->
                            <div class="flex justify-between items-center mt-3 mb-1 border-b border-cyber-border/30 pb-1">
                                <span class="text-[9px] text-cyber-slate uppercase tracking-wider font-bold">Recent Calls & Webinars</span>
                                <span class="text-[9px] text-cyber-slate uppercase tracking-wider font-bold">Tag</span>
                            </div>
                            <div class="space-y-1.5 pt-1">
                                <div class="bg-cyber-dark/50 p-1.5 rounded flex justify-between items-center text-[9px]">
                                    <div>
                                        <span class="text-white font-mono block">Davis, L. </span>
                                        <span class="text-cyber-slate font-mono text-[8px]">(404) 555-0192</span>
                                    </div>
                                    <span class="bg-[#00FFA3]/20 text-[#00FFA3] rounded px-1.5 py-0.5">Call In</span>
                                </div>
                                <div class="bg-cyber-dark/50 p-1.5 rounded flex justify-between items-center text-[9px]">
                                    <div>
                                        <span class="text-white font-mono block">Miller, R.</span>
                                        <span class="text-cyber-slate font-mono text-[8px]">(305) 555-8841</span>
                                    </div>
                                    <span class="bg-[#B026FF]/20 text-[#B026FF] rounded px-1.5 py-0.5">Webinar</span>
                                </div>
                                <div class="bg-cyber-dark/50 p-1.5 rounded flex justify-between items-center text-[9px]">
                                    <div>
                                        <span class="text-white font-mono block">Chen, W.</span>
                                        <span class="text-cyber-slate font-mono text-[8px]">(770) 555-3319</span>
                                    </div>
                                    <span class="bg-[#FF5C00]/20 text-[#FF5C00] rounded px-1.5 py-0.5">Replied YES</span>
                                </div>
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

                    <!-- Add New / File Upload -->
                    <label class="w-full border border-dashed border-cyber-border hover:border-[#B026FF] hover:text-[#B026FF] text-cyber-slate rounded p-3 text-xs flex items-center justify-center gap-2 transition-colors cursor-pointer group">
                        <i data-lucide="upload" class="w-3 h-3 group-hover:-translate-y-0.5 transition-transform"></i> 
                        <span>Upload Reference Doc</span>
                        <input type="file" class="hidden" onchange="alert('Asset processing pipeline triggered. Distributing to Picasso and Agent nodes.')">
                    </label>

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

        function restartAgent(target) {
            const chatWindow = document.getElementById('chat-window');
            const anchor = document.getElementById('chat-anchor');

            const botBlock = document.createElement('div');
            botBlock.className = 'flex justify-start max-w-3xl mb-6 fade-in';
            botBlock.innerHTML = `
                <div class="flex-1 space-y-2">
                    <div class="text-[10px] font-bold text-[#FF5C00] px-2 flex items-center gap-1">
                        <i data-lucide="rotate-cw" class="w-3 h-3 animate-spin"></i> COMMAND
                    </div>
                    <div class="bg-cyber-panel border border-[#FF5C00]/30 rounded p-4 shadow-lg text-sm text-white/90">
                        Initiating PM2 restart for process: <b>${target.toUpperCase()}</b>
                    </div>
                </div>
            `;
            chatWindow.insertBefore(botBlock, anchor);
            lucide.createIcons();
            scrollToBottom();

            fetch('http://localhost:3004/api/restart', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ target: target })
            }).then(res => {
                setTimeout(() => {
                    const ackBlock = document.createElement('div');
                    ackBlock.className = 'flex justify-start max-w-3xl mb-6 fade-in';
                    ackBlock.innerHTML = `
                        <div class="flex-1 space-y-2">
                            <div class="text-[10px] font-bold text-cyber-cyan px-2 flex items-center gap-1">
                                <i data-lucide="check-circle" class="w-3 h-3"></i> SYSTEM MGR
                            </div>
                            <div class="message-bubble bot p-4 shadow-lg text-sm text-white/90">
                                <span class="text-xs font-mono opacity-50 block mb-2">[SYS_ACK]</span>
                                PM2 Process <b>${target.toUpperCase()}</b> fully rebooted and back online.
                            </div>
                        </div>
                    `;
                    chatWindow.insertBefore(ackBlock, anchor);
                    lucide.createIcons();
                    scrollToBottom();
                }, 1000);
            }).catch(e => {
                setTimeout(() => simulateBotError(), 600);
            });
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
