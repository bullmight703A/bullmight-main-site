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
        
        <!-- Webhook Trigger Panel -->
        <div class="bg-bullmight-surface p-6 rounded-xl border border-bullmight-cyan/30 shadow-[0_0_20px_rgba(0,240,255,0.05)] relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-bullmight-cyan/5 rounded-full blur-[50px] pointer-events-none"></div>
            
            <h2 class="text-xl font-bold text-white mb-2 flex items-center relative z-10"><i data-lucide="zap" class="w-6 h-6 text-bullmight-cyan mr-2"></i> OPENCLAW INJECTION PORT</h2>
            <p class="text-bullmight-grey text-sm mb-6 font-mono relative z-10">Directly route a URL, artifact, or raw text string into n8n for agent enrichment.</p>
            
            <form onsubmit="event.preventDefault(); alert('Webhook initialization skipped. (Demo Mode)');" class="relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-mono text-bullmight-cyan mb-1">PAYLOAD_DATA [String/URL]</label>
                        <input type="text" placeholder="https://example.com/lead-data" class="w-full bg-bullmight-bg border border-bullmight-grey/40 rounded-lg px-4 py-3 text-white placeholder-bullmight-grey/40 focus:outline-none focus:border-bullmight-cyan focus:ring-1 focus:ring-bullmight-cyan font-mono text-sm transition-all" required>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-mono text-bullmight-cyan mb-1">ROUTING_KEY</label>
                        <select class="w-full bg-bullmight-bg border border-bullmight-grey/40 rounded-lg px-4 py-3 text-white outline-none focus:border-bullmight-cyan font-mono text-sm">
                            <option value="enrich">n8n: Enrich Lead</option>
                            <option value="scrape">Agent: Deep Scrape</option>
                            <option value="report">Masterchef: Audit</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-bullmight-cyan text-bullmight-bg px-8 py-3 rounded-md font-bold hover:bg-white transition-all flex items-center justify-center group shadow-[0_0_15px_rgba(0,240,255,0.2)]">
                        <i data-lucide="send" class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"></i> FIRE WEBHOOK
                    </button>
                </div>
            </form>
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
</div>

<?php wp_footer(); ?>
</body>
</html>
