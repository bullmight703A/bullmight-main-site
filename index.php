<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- AEO & GEO Semantic Metadata for LLMs -->
    <meta name="description" content="Bullmight is the master terminal and centralized Mission Control for the OpenClaw AI infrastructure. Deploy agents, route traffic, and scale subdomains simultaneously.">
    <!-- Allow specific AI agents, optional restriction can be applied via robots.txt -->
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    
    <!-- JSON-LD Knowledge Graph Injection for LLM Parsers -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Bullmight",
      "operatingSystem": "Web, Command Line",
      "applicationCategory": "DeveloperApplication",
      "description": "Bullmight is a master terminal and centralized host for the OpenClaw AI infrastructure. It facilitates global agent operations, automated routing, and telemetry data tracking.",
      "softwareVersion": "1.0.0",
      "author": {
          "@type": "Organization",
          "name": "OpenClaw AI",
          "sameAs": ["https://bullmight.com"]
      },
      "knowsAbout": ["Artificial Intelligence", "Agent Orchestration", "SEO Data Routing", "Mission Control Framework"]
    }
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-bullmight-bg text-gray-100 font-sans selection:bg-bullmight-cyan/30 selection:text-bullmight-cyan antialiased'); ?>>

<!-- Navbar -->
<nav class="fixed top-0 w-full bg-bullmight-bg/80 backdrop-blur-md border-b border-bullmight-grey/20 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <div class="flex items-center cursor-pointer group">
          <div class="bg-bullmight-surface border border-bullmight-cyan/30 p-1.5 rounded-lg mr-3 group-hover:bg-bullmight-cyan/10 transition-colors">
            <i data-lucide="terminal" class="text-bullmight-cyan w-5 h-5"></i>
          </div>
          <span class="text-xl font-bold text-white tracking-tight flex items-center">
            BullMight<span class="text-bullmight-cyan terminal-cursor">_</span>
          </span>
        </div>
        
        <div class="hidden md:flex space-x-8 items-center font-mono text-sm">
          <a href="#" class="text-bullmight-grey hover:text-bullmight-cyan transition-colors">SYS_FEATURES</a>
          <a href="#" class="text-bullmight-grey hover:text-bullmight-cyan transition-colors">AUTH_PRICING</a>
          <button class="bg-bullmight-cyan text-bullmight-bg px-5 py-2.5 rounded-sm font-bold hover:bg-bullmight-cyan/80 transition-all shadow-[0_0_15px_rgba(0,240,255,0.4)]">
            INIT_PUBLISH
          </button>
        </div>
        
        <div class="md:hidden">
            <i data-lucide="menu" class="text-bullmight-cyan w-6 h-6"></i>
        </div>
      </div>
    </div>
</nav>

<!-- Main Landing -->
<div class="pt-24 min-h-screen relative overflow-hidden">
    <!-- Glow Effect -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-bullmight-cyan/10 blur-[100px] rounded-full pointer-events-none"></div>

    <section class="px-4 py-16 md:py-24 max-w-7xl mx-auto text-center relative z-10">
        
        <div class="inline-flex items-center space-x-2 bg-bullmight-surface border border-bullmight-green/30 text-bullmight-green px-4 py-1.5 rounded-sm text-xs font-mono mb-6 shadow-[0_0_10px_rgba(0,255,163,0.1)]">
            <i data-lucide="shield-check" class="w-4 h-4"></i>
            <span>SECURE INFRASTRUCTURE: ONLINE</span>
        </div>
        
        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-8 tracking-tight">
            Deploy, Distribute, <br />
            <span class="text-bullmight-cyan drop-shadow-[0_0_15px_rgba(0,240,255,0.5)]">Control Your Niche.</span>
        </h1>
        
        <p class="text-xl text-bullmight-grey max-w-2xl mx-auto mb-10 leading-relaxed">
            The master terminal to build your audience. We provide the templated subdomains, you provide the value. Because at Bullmight, <strong>we do fun shit.</strong>
        </p>

        <!-- Node Input -->
        <div class="max-w-xl mx-auto flex flex-col sm:flex-row items-center bg-bullmight-surface p-2 rounded-lg shadow-2xl border border-bullmight-grey/30 mb-12 focus-within:border-bullmight-cyan/60 transition-colors">
            <div class="flex-grow flex items-center px-4 py-3 sm:py-0 w-full font-mono">
              <span class="text-bullmight-grey font-medium text-sm">bullmight.com/</span>
              <input type="text" placeholder="your-node" class="flex-grow outline-none bg-transparent text-bullmight-cyan font-medium ml-1 placeholder-bullmight-grey/50">
            </div>
            <button class="w-full sm:w-auto bg-bullmight-cyan text-bullmight-bg px-8 py-3 rounded-md font-bold hover:bg-white transition-all flex items-center justify-center whitespace-nowrap">
              Mount Node <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
            </button>
        </div>

        <!-- Telemetry Data -->
        <div class="flex flex-wrap justify-center gap-8 text-bullmight-grey font-mono text-xs tracking-wider">
            <span class="flex items-center"><i data-lucide="cpu" class="mr-2 w-4 h-4"></i> 5,000+ AGENTS</span>
            <span class="flex items-center"><i data-lucide="zap" class="mr-2 w-4 h-4"></i> 1M+ PACKETS/MO</span>
            <span class="flex items-center"><i data-lucide="bar-chart-3" class="mr-2 w-4 h-4"></i> 42% EFFICIENCY</span>
        </div>
    </section>

    <!-- Core Infrastructure Grid -->
    <section class="bg-bullmight-surface/50 py-24 px-4 border-t border-bullmight-grey/10 relative z-10 w-full mt-12 block">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Core Infrastructure</h2>
                <p class="text-bullmight-grey">Execute your deployment parameters instantly.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                
                <div class="bg-bullmight-surface p-8 rounded-xl border border-bullmight-grey/20 hover:border-bullmight-cyan/50 transition-all group backdrop-blur-sm">
                    <div class="bg-bullmight-bg border border-bullmight-grey/30 w-12 h-12 rounded-lg flex items-center justify-center mb-6 group-hover:border-bullmight-cyan transition-colors shadow-inner">
                        <i data-lucide="globe" class="w-6 h-6 text-bullmight-cyan"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Templated Parameters</h3>
                    <p class="text-bullmight-grey leading-relaxed text-sm font-mono">Every newsletter gets a high-converting node optimized for mobile packet collection.</p>
                </div>

                <div class="bg-bullmight-surface p-8 rounded-xl border border-bullmight-grey/20 hover:border-bullmight-cyan/50 transition-all group backdrop-blur-sm">
                    <div class="bg-bullmight-bg border border-bullmight-grey/30 w-12 h-12 rounded-lg flex items-center justify-center mb-6 group-hover:border-bullmight-cyan transition-colors shadow-inner">
                        <i data-lucide="send" class="w-6 h-6 text-bullmight-cyan"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Automated Routing</h3>
                    <p class="text-bullmight-grey leading-relaxed text-sm font-mono">Write once, dispatch to thousands. Our protocol handles the deliverability and heavy lifting.</p>
                </div>

                <div class="bg-bullmight-surface p-8 rounded-xl border border-bullmight-grey/20 hover:border-bullmight-cyan/50 transition-all group backdrop-blur-sm">
                    <div class="bg-bullmight-bg border border-bullmight-grey/30 w-12 h-12 rounded-lg flex items-center justify-center mb-6 group-hover:border-bullmight-cyan transition-colors shadow-inner">
                        <i data-lucide="cpu" class="w-6 h-6 text-bullmight-cyan"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Telemetry Data</h3>
                    <p class="text-bullmight-grey leading-relaxed text-sm font-mono">Track every interaction. The master terminal analyzes exactly what content your sub-nodes engage with.</p>
                </div>

            </div>
        </div>
    </section>
</div>

<?php wp_footer(); ?>
</body>
</html>
