<?php
/**
 * Template Name: IRO Mission Control
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRO Console - Bullmight</title>
    <!-- Tailwind CSS (Native Injection, No Babel Required!) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              cyber: {
                dark: '#07090F',
                panel: '#11131C',
                subpanel: '#0B0D13',
                highlight: '#1C1F2E',
                border: '#2D3142',
                cyan: '#00F0FF',
                green: '#00FFA3',
                pink: '#FF007A',
                gray: '#8E8E93',
                orange: '#F59E0B'
              }
            }
          }
        }
      }
    </script>
    <style>
        body { margin: 0; background-color: #07090F; color: #E2E8F0; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #2D3142; border-radius: 20px; }
    </style>
</head>
<body class="min-h-screen font-mono tracking-tight selection:bg-cyber-cyan/30">

<div class="p-6">
    <!-- Header -->
    <header class="flex items-center justify-between border-b border-cyber-cyan/20 pb-4 mb-6">
    <div class="flex items-center space-x-3">
        <svg class="text-cyber-cyan w-6 h-6 animate-pulse" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
        <h1 class="text-2xl font-bold tracking-widest text-cyber-cyan">IRO_CONSOLE</h1>
    </div>
    <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-2 bg-[#052E20] text-cyber-green px-3 py-1 rounded-sm border border-cyber-green/30 text-xs">
        <span class="w-2 h-2 rounded-full bg-cyber-green animate-pulse"></span>
        <span>SYSTEM: SECURE</span>
        </div>
        <a href="/" class="text-xs text-cyber-gray hover:text-white transition-colors">EXIT TO MAIN</a>
    </div>
    </header>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Left Column: Agents & Telemetry -->
    <div class="lg:col-span-4 space-y-6">
        
        <!-- Agent Fleet Status -->
        <div class="bg-cyber-panel border border-cyber-border rounded-md p-5 flex flex-col shadow-lg">
        <h2 class="text-sm font-bold text-cyber-gray mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect></svg>
            AGENT FLEET STATUS
        </h2>
        <div class="space-y-4">
            <!-- IRO -->
            <div class="flex flex-col p-3 bg-cyber-subpanel rounded border border-cyber-border hover:border-cyber-cyan/30 transition-colors">
                <div class="flex justify-between items-center mb-1"><span class="font-bold">IRO</span><span class="text-xs text-cyber-green">ONLINE & LISTENING</span></div>
                <div class="text-xs text-cyber-gray mb-2">Managing UI & Conversational memory</div>
                <button class="flex justify-center items-center text-xs text-cyber-gray hover:text-cyber-cyan bg-cyber-highlight py-1.5 rounded border border-transparent w-full mt-1">RESTART</button>
            </div>
            <!-- MASTERCHEF -->
            <div class="flex flex-col p-3 bg-cyber-subpanel rounded border border-cyber-border hover:border-cyber-cyan/30 transition-colors">
                <div class="flex justify-between items-center mb-1"><span class="font-bold">MASTERCHEF</span><span class="text-xs text-cyber-cyan">GHL AUTOMATION</span></div>
                <div class="text-xs text-cyber-gray mb-2">Running workflow in GHL</div>
                <button class="flex justify-center items-center text-xs text-cyber-gray hover:text-cyber-cyan bg-cyber-highlight py-1.5 rounded border border-transparent w-full mt-1">RESTART</button>
            </div>
            <!-- VOLT -->
            <div class="flex flex-col p-3 bg-cyber-subpanel rounded border border-cyber-border">
                <div class="flex justify-between items-center mb-1"><span class="font-bold">VOLT</span><span class="text-xs text-cyber-orange">PROCESSING DATA</span></div>
                <div class="text-xs text-cyber-gray mb-2">Updating opportunities pipeline</div>
                <button class="flex justify-center items-center text-xs text-cyber-gray hover:text-cyber-cyan bg-cyber-highlight py-1.5 rounded w-full mt-1" disabled>STANDBY</button>
            </div>
            <!-- PICASSO -->
            <div class="flex flex-col p-3 bg-cyber-subpanel rounded border border-cyber-border">
                <div class="flex justify-between items-center mb-1"><span class="font-bold">PICASSO</span><span class="text-xs text-cyber-gray">STNDBY_MODE</span></div>
                <div class="text-xs text-cyber-gray mb-2">Awaiting image generation tasks</div>
                <button class="flex justify-center items-center text-xs text-cyber-gray hover:text-cyber-cyan bg-cyber-highlight py-1.5 rounded w-full mt-1" disabled>STANDBY</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Middle/Right Column: Conversation & Wimper/Kidazzle -->
    <div class="lg:col-span-8 flex flex-col space-y-6">
        
        <!-- Kidazzle & Wimper Opportunities Section -->
        <div class="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg">
        <h2 class="text-sm font-bold text-cyber-gray mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle></svg>
            OPPORTUNITY PIPELINES (GHL SYNC)
        </h2>
        <div class="grid grid-cols-2 gap-4">
            <!-- Kidazzle -->
            <div class="p-4 bg-cyber-subpanel rounded border border-cyber-pink/20">
            <h3 class="text-cyber-pink font-bold mb-2 flex items-center">Kidazzle B2C</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between border-b border-cyber-border pb-1">
                <span class="text-cyber-gray">New Leads Today</span>
                <span class="text-white font-bold">14</span>
                </div>
                <div class="flex justify-between pt-1">
                <span class="text-cyber-gray">Pipeline Value</span>
                <span class="text-cyber-green font-bold">$12,400</span>
                </div>
            </div>
            </div>
            
            <!-- WIMPER -->
            <div class="p-4 bg-cyber-subpanel rounded border border-cyber-cyan/20">
            <h3 class="text-cyber-cyan font-bold mb-2 flex items-center">WIMPER B2B</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between border-b border-cyber-border pb-1">
                <span class="text-cyber-gray">Outreach Sent</span>
                <span class="text-white font-bold">245</span>
                </div>
                <div class="flex justify-between pt-1">
                <span class="text-cyber-gray">Projected Value</span>
                <span class="text-cyber-green font-bold">$45,000</span>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Conversation Tab / Command Center -->
        <div class="bg-cyber-panel border border-cyber-border flex-grow rounded-md shadow-lg flex flex-col overflow-hidden min-h-[400px]">
        <!-- Tabs -->
        <div class="flex border-b border-cyber-border">
            <button class="flex-1 py-3 text-sm font-bold transition-colors text-cyber-cyan border-b-2 border-cyber-cyan bg-cyber-highlight">
            INTERACTIVE CONVERSATION
            </button>
            <button class="flex-1 py-3 text-sm font-bold transition-colors text-cyber-gray hover:text-[#E2E8F0] cursor-not-allowed" disabled>
            RAW TERMINAL LOGS
            </button>
        </div>

        <!-- Chat Area -->
        <div class="flex flex-col flex-grow p-4 bg-cyber-subpanel">
            <div class="flex-grow space-y-4 overflow-y-auto mb-4 custom-scrollbar pr-2 min-h-[250px] max-h-[350px]">
                
                <!-- Initial Message -->
                <div class="flex justify-start">
                    <div class="p-3 rounded-lg max-w-[80%] bg-cyber-cyan/10 border border-cyber-cyan/30">
                    <span class="text-xs font-bold block mb-1 text-cyber-cyan">IRO</span>
                    <p class="text-sm">Console physically rendered. Failsafe mode activated to bypass WP Engine strict Security Policies. Awaiting Node tunnel link.</p>
                    </div>
                </div>

            </div>
            
            <!-- Chat Input -->
            <div class="pt-3 border-t border-cyber-border space-y-3">
            <div class="flex space-x-2">
                <input type="text" placeholder="Talk to IRO... command execution, workflow modification, etc." class="flex-grow bg-cyber-panel border border-cyber-border rounded px-4 py-3 text-sm focus:outline-none focus:border-cyber-cyan/50" />
                <button class="bg-cyber-cyan text-cyber-subpanel font-bold px-6 rounded hover:bg-white transition-colors flex items-center" onclick="alert('Execute hooked up via OpenClaw bridge')">
                EXECUTE
                </button>
            </div>
            </div>
        </div>

        </div>

    </div>
    </div>
</div>

</body>
</html>
