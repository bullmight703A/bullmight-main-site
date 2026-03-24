<?php
/**
 * Template Name: IRO Mission Control
 * Subdomain Router: iro.bullmight.com
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IRO Mission Control | Bullmight</title>
    <!-- AEO & GEO Semantic Metadata for IRO -->
    <meta name="description" content="Dedicated Agent Terminal for IRO. Handles task queues, n8n webhook automations, and global OpenClaw network readouts.">
    <meta name="robots" content="noindex, nofollow"> <!-- Keep agent terminal private initially -->
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-bullmight-bg text-gray-100 font-sans selection:bg-bullmight-green/30 selection:text-bullmight-green antialiased'); ?>>

<!-- Top Nav -->
<nav class="fixed top-0 w-full bg-bullmight-surface/90 backdrop-blur-md border-b border-bullmight-green/30 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-3">
          <div class="bg-bullmight-bg border border-bullmight-green p-1.5 rounded-lg shadow-[0_0_10px_rgba(0,255,163,0.3)]">
            <i data-lucide="cpu" class="text-bullmight-green w-5 h-5"></i>
          </div>
          <span class="text-xl font-bold text-white tracking-widest font-mono">
            IRO<span class="text-bullmight-green animate-pulse">_CONSOLE</span>
          </span>
        </div>
        
        <div class="hidden md:flex items-center space-x-6">
            <div class="flex items-center text-xs font-mono text-bullmight-green bg-bullmight-green/10 px-3 py-1 rounded-full border border-bullmight-green/30">
                <span class="w-2 h-2 rounded-full bg-bullmight-green animate-pulse mr-2"></span>
                SYSTEM: SECURE
            </div>
            <a href="https://bullmight.com" class="text-bullmight-grey hover:text-white transition-colors text-sm font-mono"><i data-lucide="log-out" class="w-4 h-4 inline mr-1"></i> EXIT TO MAIN</a>
        </div>
      </div>
    </div>
</nav>

<!-- Main Terminal Grid -->
<div class="pt-24 min-h-screen px-4 py-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Column 1: Network Status & Task Queue -->
    <div class="col-span-1 flex flex-col gap-6">
        
        <!-- OpenClaw Agent Fleet Status -->
        <div class="bg-bullmight-surface p-6 rounded-xl border border-bullmight-grey/20 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10"><i data-lucide="network" class="w-24 h-24"></i></div>
            <h2 class="text-lg font-bold text-white mb-4 flex items-center"><i data-lucide="activity" class="w-5 h-5 text-bullmight-cyan mr-2"></i> AGENT FLEET STATUS</h2>
            
            <div class="space-y-4 font-mono text-sm relative z-10">
                <div class="flex justify-between items-center bg-bullmight-bg p-3 rounded-lg border border-bullmight-green/30">
                    <span class="text-white">IRO</span>
                    <span class="text-bullmight-green font-bold">ONLINE & LISTENING</span>
                </div>
                <div class="flex justify-between items-center bg-bullmight-bg p-3 rounded-lg border border-bullmight-grey/20">
                    <span class="text-bullmight-grey">MASTERCHEF</span>
                    <span class="text-bullmight-amber font-bold animate-pulse">AWAITING TASK</span>
                </div>
                <div class="flex justify-between items-center bg-bullmight-bg p-3 rounded-lg border border-bullmight-grey/20">
                    <span class="text-bullmight-grey">VOLT</span>
                    <span class="text-bullmight-grey font-bold">STNDBY_MODE</span>
                </div>
                <div class="flex justify-between items-center bg-bullmight-bg p-3 rounded-lg border border-bullmight-grey/20">
                    <span class="text-bullmight-grey">PICASSO</span>
                    <span class="text-bullmight-grey font-bold">STNDBY_MODE</span>
                </div>
            </div>
        </div>

        <!-- Current Task Queue -->
        <div class="bg-bullmight-surface p-6 rounded-xl border border-bullmight-grey/20 flex-grow">
            <h2 class="text-lg font-bold text-white mb-4 flex items-center"><i data-lucide="list-todo" class="w-5 h-5 text-bullmight-cyan mr-2"></i> ACTIVE INSTRUCTIONS</h2>
            <div class="bg-bullmight-bg border border-bullmight-grey/20 rounded-lg p-4 h-full min-h-[150px]">
                <p class="text-bullmight-grey font-mono text-sm"><span class="text-bullmight-cyan">></span> Waiting for manual override or webhook trigger...</p>
                <div class="mt-4 border-l-2 border-bullmight-green pl-3">
                    <p class="text-white font-mono text-xs">TASK_ID: 0x99A2</p>
                    <p class="text-bullmight-grey font-mono text-xs">ACTION: Initialize Mission Control GUI</p>
                    <p class="text-bullmight-green font-mono text-xs mt-1">STATUS: COMPLETED</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Column 2 & 3: Automation Webhook & Live Logs -->
    <div class="col-span-1 lg:col-span-2 flex flex-col gap-6">
        
        <!-- Conversational Agent Terminal (Antigravity Style) -->
        <div class="bg-bullmight-surface flex flex-col rounded-xl border border-bullmight-cyan/30 shadow-[0_0_20px_rgba(0,240,255,0.05)] relative overflow-hidden h-[500px]">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-bullmight-cyan/5 rounded-full blur-[50px] pointer-events-none"></div>
            
            <!-- Chat Header -->
            <div class="px-6 py-4 border-b border-bullmight-grey/20 relative z-10 flex justify-between items-center bg-bullmight-surface/80 backdrop-blur-sm">
                <div>
                    <h2 class="text-lg font-bold text-white flex items-center"><i data-lucide="message-square" class="w-5 h-5 text-bullmight-cyan mr-2"></i> AGENT COMMUNICATIONS</h2>
                    <p class="text-bullmight-grey text-xs font-mono">Direct secure line to your OpenClaw Fleet.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <select class="bg-bullmight-bg border border-bullmight-cyan/40 text-bullmight-cyan px-4 py-2 rounded font-mono text-xs focus:outline-none focus:border-bullmight-cyan shadow-inner">
                        <option value="iro" selected>Target: IRO (Local)</option>
                        <option value="masterchef">Target: Masterchef</option>
                        <option value="volt">Target: Volt</option>
                        <option value="picasso">Target: Picasso</option>
                    </select>
                    
                    <button type="button" class="bg-red-900/40 border border-red-500/50 text-red-400 hover:bg-red-600 hover:text-white px-4 py-2 rounded text-xs font-bold font-mono transition-colors shadow-[0_0_10px_rgba(255,0,0,0.1)] flex items-center" onclick="alert('Sending PM2 restart sequence & flushing active bridge queue...');">
                        <i data-lucide="refresh-cw" class="w-3 h-3 mr-1"></i> RESTART AGENT
                    </button>
                </div>
            </div>
            
            <!-- Chat History Area -->
            <div class="flex-grow p-6 overflow-y-auto space-y-6 relative z-10 wimper-scroll bg-bullmight-bg/30">
                <!-- User Message -->
                <div class="flex justify-end">
                    <div class="bg-bullmight-cyan text-bullmight-bg px-5 py-3 rounded-2xl rounded-tr-sm max-w-[80%]">
                        <p class="text-sm font-medium">IRO, analyze the new Kidazzle SEO architecture and confirm the JSON-LD schemas parsed correctly.</p>
                        <span class="text-[10px] text-bullmight-bg/60 mt-1 block text-right font-mono">18:02 PM</span>
                    </div>
                </div>
                
                <!-- Agent Message (IRO) -->
                <div class="flex justify-start">
                    <div class="bg-bullmight-bg border border-bullmight-grey/30 text-white px-5 py-3 rounded-2xl rounded-tl-sm max-w-[80%] shadow-md">
                        <div class="flex items-center mb-2">
                            <i data-lucide="cpu" class="w-4 h-4 text-bullmight-green mr-2"></i>
                            <span class="text-xs font-bold text-bullmight-green font-mono">AGENT_IRO</span>
                        </div>
                        <p class="text-sm text-bullmight-grey leading-relaxed">I have analyzed the current Kidazzle SEO architecture. The JSON-LD schema (Answer Engine Optimization) is correctly injecting the <code>@type: DeveloperApplication</code> metadata natively. The OpenClaw pipeline is completely unobstructed.</p>
                        <span class="text-[10px] text-bullmight-grey/50 mt-2 block font-mono">18:03 PM</span>
                    </div>
                </div>
            </div>

            <!-- Chat Input Area -->
            <div class="p-4 border-t border-bullmight-grey/20 bg-bullmight-surface relative z-10">
                <form onsubmit="event.preventDefault(); alert('Chat engine initializing. Waiting for WebSocket connection to openclaw bridge!');" class="relative flex items-center">
                    <button type="button" class="absolute left-4 text-bullmight-grey hover:text-white transition-colors" onclick="alert('Upload Dialog: Ready to accept artifacts.');">
                        <i data-lucide="paperclip" class="w-5 h-5"></i>
                    </button>
                    <input type="text" placeholder="Upload artifact or send an instruction to an agent..." class="w-full bg-bullmight-bg border border-bullmight-grey/40 rounded-full pl-12 pr-12 py-3 text-white placeholder-bullmight-grey/40 focus:outline-none focus:border-bullmight-cyan focus:ring-1 focus:ring-bullmight-cyan transition-all text-sm shadow-inner" required>
                    <button type="submit" class="absolute right-2 bg-bullmight-cyan text-bullmight-bg p-2 rounded-full hover:bg-white transition-all shadow-[0_0_10px_rgba(0,240,255,0.3)]">
                        <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Live Terminal Log -->
        <div class="bg-bullmight-bg p-1 rounded-xl border border-bullmight-grey/20 flex-grow relative shadow-inner">
            <div class="bg-bullmight-surface border-b border-bullmight-grey/20 px-4 py-2 flex items-center rounded-t-lg">
                <i data-lucide="terminal-square" class="w-4 h-4 text-bullmight-grey mr-2"></i> <span class="text-xs font-mono text-bullmight-grey uppercase">RAW_TERMINAL_LOG</span>
            </div>
            <div class="p-6 font-mono text-xs sm:text-sm space-y-2 h-[300px] overflow-y-auto wimper-scroll">
                <p class="text-bullmight-grey">[18:05:32] System: Secure TCP connection established via Cloudflare Proxied Network.</p>
                <p class="text-bullmight-grey">[18:05:34] Auth: Validating API tokens...</p>
                <p class="text-bullmight-green">[18:05:34] Auth: OK. Access Granted.</p>
                <p class="text-bullmight-grey">[18:05:36] OpenClaw: Retrieving Master Manifest state.</p>
                <p class="text-bullmight-grey">[18:05:40] IRO: <span class="text-white">"Building specific layout for iro.bullmight.com subdomain."</span></p>
                <p class="text-bullmight-amber">[18:06:15] Warning: UI heavily stylized. Prepare for absolute dominance over niche.</p>
                <p class="text-bullmight-cyan flex items-center mt-4">
                    <span>> Waiting for input</span><span class="inline-block w-2 h-4 bg-bullmight-cyan ml-1 terminal-cursor"></span>
                </p>
            </div>
        </div>

    </div>

    <!-- Full Width: GitNexus Zero-Server Knowledge Graph -->
    <div class="col-span-1 lg:col-span-3 mt-2 flex flex-col">
        <div class="bg-bullmight-surface p-6 rounded-xl border border-bullmight-green/30 shadow-[0_0_20px_rgba(0,255,163,0.05)] relative overflow-hidden group flex-grow">
            <div class="absolute right-0 top-0 opacity-10 pointer-events-none"><i data-lucide="git-merge" class="w-48 h-48 -mr-10 -mt-10"></i></div>
            
            <h2 class="text-xl font-bold text-white mb-2 flex items-center relative z-10"><i data-lucide="network" class="w-6 h-6 text-bullmight-cyan mr-2"></i> GITNEXUS / CORE ARCHITECTURE GRAPH</h2>
            <p class="text-bullmight-grey text-sm mb-6 font-mono relative z-10">Zero-Server Code Intelligence Engine activated. Mapping OpenClaw repositories to ensure synchronized agent logic.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative z-10">
                <!-- Visual Graph Placeholder -->
                <div class="col-span-3 bg-bullmight-bg border border-bullmight-grey/20 rounded-lg p-4 h-56 flex flex-col items-center justify-center cursor-pointer hover:border-bullmight-cyan transition-colors">
                    <div class="text-center font-mono animate-pulse">
                        <i data-lucide="boxes" class="w-10 h-10 mx-auto mb-3 text-bullmight-cyan"></i>
                        <p class="text-bullmight-cyan text-sm font-bold">AWAITING REPOSITORY PACKET</p>
                        <p class="text-xs text-bullmight-grey mt-2">Drag & Drop GitHub URL or .ZIP to generate Graph RAG</p>
                    </div>
                </div>
                
                <!-- Status Sidebar -->
                <div class="col-span-1 space-y-4 font-mono text-xs flex flex-col justify-between">
                    <div class="bg-bullmight-bg border border-bullmight-green/30 p-4 rounded-md shadow-inner flex-grow">
                        <span class="block text-bullmight-green mb-2 text-[10px] tracking-widest">INDEX DIRECTORY</span>
                        <span class="block text-white mb-1"><i data-lucide="folder" class="w-3 h-3 inline mr-1"></i> .gitnexus/</span>
                        <span class="block text-bullmight-grey"><i data-lucide="file-json" class="w-3 h-3 inline mr-1"></i> registry.json</span>
                    </div>
                    <div class="bg-bullmight-bg border border-bullmight-cyan/30 p-4 rounded-md shadow-inner flex-grow">
                        <span class="block text-bullmight-cyan mb-2 text-[10px] tracking-widest">OBSERVED AGENTS</span>
                        <span class="block text-white">IRO (Local)</span>
                        <span class="block text-white">Volt</span>
                        <span class="block text-white">Masterchef</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php wp_footer(); ?>
</body>
</html>
