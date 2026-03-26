<?php
/**
 * Template Name: Dick & Jane Console
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dick & Jane Console</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <!-- Use unpkg lucide to render standard icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { margin: 0; background-color: #1c1f26; font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif; }
    </style>
</head>
<body>
    <div id="root"></div>
    <script type="text/babel">
        const { useState, useEffect, useRef } = React;

        // Create standard react components for each lucide icon using the lucide API
        const IconWrapper = ({ name, size = 24, className = '', fill = 'none' }) => {
            const iconRef = useRef(null);
            
            useEffect(() => {
                if (iconRef.current && window.lucide) {
                    // Try to clear it first if React re-renders
                    iconRef.current.innerHTML = '';
                    // Convert CamelCase to lucide name like bell-ring
                    const iconName = name.replace(/([a-z0-9])([A-Z])/g, '$1-$2').toLowerCase();
                    const iconData = window.lucide.icons[iconName];
                    
                    if (iconData) {
                        const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                        svg.setAttribute('width', size);
                        svg.setAttribute('height', size);
                        svg.setAttribute('viewBox', '0 0 24 24');
                        svg.setAttribute('fill', fill);
                        svg.setAttribute('stroke', fill === 'currentColor' ? 'none' : 'currentColor');
                        svg.setAttribute('stroke-width', '2');
                        svg.setAttribute('stroke-linecap', 'round');
                        svg.setAttribute('stroke-linejoin', 'round');
                        svg.setAttribute('class', className);
                        
                        iconData[2].forEach(([tag, attrs]) => {
                            const el = document.createElementNS('http://www.w3.org/2000/svg', tag);
                            Object.entries(attrs).forEach(([k, v]) => el.setAttribute(k, v));
                            svg.appendChild(el);
                        });
                        iconRef.current.appendChild(svg);
                    }
                }
            }, [name, size, className, fill]);
            
            return <i ref={iconRef} style={{ display: 'inline-block' }}></i>;
        };

        const Beer = (props) => <IconWrapper name="Beer" {...props} />;
        const Users = (props) => <IconWrapper name="Users" {...props} />;
        const DollarSign = (props) => <IconWrapper name="DollarSign" {...props} />;
        const AlertTriangle = (props) => <IconWrapper name="AlertTriangle" {...props} />;
        const Zap = (props) => <IconWrapper name="Zap" {...props} />;
        const ShieldCheck = (props) => <IconWrapper name="ShieldCheck" {...props} />;
        const TrendingUp = (props) => <IconWrapper name="TrendingUp" {...props} />;
        const MessageSquare = (props) => <IconWrapper name="MessageSquare" {...props} />;
        const Terminal = (props) => <IconWrapper name="Terminal" {...props} />;
        const Clock = (props) => <IconWrapper name="Clock" {...props} />;
        const ChevronRight = (props) => <IconWrapper name="ChevronRight" {...props} />;
        const Wifi = (props) => <IconWrapper name="Wifi" {...props} />;
        const Activity = (props) => <IconWrapper name="Activity" {...props} />;
        const MapPin = (props) => <IconWrapper name="MapPin" {...props} />;
        const Heart = (props) => <IconWrapper name="Heart" {...props} />;

        

const App = () => {
  const [currentTime, setCurrentTime] = useState(new Date());
  const [messages, setMessages] = useState([
    { id: 1, sender: 'SYSTEM', text: 'Ice machine at Baby Jane\'s reporting high-temp cycle. Monitor for drainage issues.', type: 'alert' },
    { id: 2, sender: 'AI COMMAND', text: 'Robert, Fort Greene is seeing a surge in "The Jane" orders. Recommend chilling another batch of cucumber-infused gin. Over.', type: 'ai' },
    { id: 3, sender: 'COMMUNITY', text: 'New 5-star review: "Best neighborhood vibes in Brooklyn. The Dick is perfectly balanced."', type: 'social' }
  ]);

  useEffect(() => {
    const timer = setInterval(() => setCurrentTime(new Date()), 1000);
    return () => clearInterval(timer);
  }, []);

  const locations = [
    { name: "Dick & Jane's", area: "Fort Greene", status: 'Core', color: 'text-cyan-400', border: 'border-cyan-500/30' },
    { name: "Baby Jane's", area: "Bed-Stuy", status: 'Active', color: 'text-amber-400', border: 'border-amber-500/30' },
    { name: "Expansion Node", area: "TBD", status: 'Offline', color: 'text-slate-500', border: 'border-slate-700' }
  ];

  return (
    // Updated root background to "Titan" (Deep Metallic Grey-Blue)
    <div className="min-h-screen bg-[#1c1f26] text-[#cbd5e1] font-mono selection:bg-cyan-500/30 overflow-hidden flex flex-col p-4 gap-4">
      {/* HEADER SECTION */}
      <header className="flex items-center justify-between border-b border-white/10 pb-4">
        <div className="flex items-center gap-4">
          <div className="p-2 bg-amber-500/10 rounded border border-amber-500/50 shadow-[0_0_10px_rgba(245,158,11,0.1)]">
            <Heart className="w-6 h-6 text-amber-500" fill="currentColor" />
          </div>
          <div>
            <h1 className="text-xl font-bold tracking-tighter text-white flex items-center gap-2">
              DICK & JANE'S <span className="text-white/20 mx-1">/</span> <span className="text-amber-500 underline decoration-cyan-500/50 underline-offset-4">BABY JANE'S</span>
              <span className="text-[10px] px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded-full border border-cyan-500/40 ml-2 uppercase tracking-widest font-black">Command Center</span>
            </h1>
          </div>
        </div>
        <div className="flex items-center gap-6">
          <div className="flex items-center gap-2 px-3 py-1 bg-green-500/10 border border-green-500/30 rounded text-green-400 text-[10px] font-bold">
            <div className="w-2 h-2 bg-green-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(34,197,94,0.6)]" />
            BROOKLYN_NODES_ONLINE
          </div>
          <div className="text-slate-500 text-xs font-bold bg-black/20 px-3 py-1 rounded border border-white/5">
            {currentTime.toLocaleTimeString([], { hour12: false })} [2026-03-26]
          </div>
        </div>
      </header>

      <div className="flex-1 grid grid-cols-12 gap-4 overflow-hidden">
        
        {/* LEFT RAIL: VENUE FLEET */}
        <aside className="col-span-2 flex flex-col gap-4">
          <div className="text-[10px] text-slate-500 uppercase tracking-[0.2em] font-black flex justify-between px-1">
            Locations <span className="text-amber-500 underline cursor-pointer hover:text-amber-400">Refresh</span>
          </div>
          {locations.map((loc) => (
            <div key={loc.name} className={`p-3 bg-[#252a33] border ${loc.border} rounded relative group cursor-pointer hover:bg-[#2d333d] hover:translate-x-1 transition-all duration-200 shadow-lg`}>
              <div className="flex justify-between items-start mb-1">
                <span className={`text-sm font-black ${loc.color}`}>{loc.name}</span>
                <span className="text-[8px] bg-black/40 px-1.5 py-0.5 rounded uppercase font-bold tracking-tighter text-slate-400">{loc.status}</span>
              </div>
              <div className="flex items-center gap-1 text-[9px] text-slate-400 uppercase tracking-tighter font-bold">
                <MapPin size={8} /> {loc.area}
              </div>
              <div className="absolute right-2 bottom-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <ChevronRight className="w-4 h-4 text-slate-500" />
              </div>
            </div>
          ))}

          <div className="mt-auto space-y-4">
            <div className="text-[10px] text-slate-500 uppercase tracking-[0.2em] font-black px-1">Community Pulse</div>
            <div className="p-3 border border-white/10 bg-[#252a33] rounded shadow-inner">
              <div className="flex items-center gap-2 text-xs text-amber-400 font-black uppercase tracking-tighter">
                <Heart size={12} fill="currentColor" />
                Vibe Level: Peak
              </div>
              <div className="text-[10px] text-slate-400 mt-1 italic font-medium leading-relaxed">"Best neighbor vibes in Fort Greene"</div>
            </div>
          </div>
        </aside>

        {/* CENTER: MISSION COMMS */}
        <main className="col-span-7 flex flex-col gap-4 overflow-hidden">
          <div className="bg-[#252a33] border border-white/10 p-2 flex items-center gap-4 rounded shadow-md">
            <div className="bg-white text-black text-[10px] font-black px-2 py-1 rounded flex items-center gap-2 uppercase tracking-tighter">
              <Terminal size={12} /> FLOOR COMMS
            </div>
            <input 
              type="text" 
              placeholder="Query venue status or issue floor command..."
              className="bg-transparent text-sm flex-1 outline-none text-amber-100 placeholder:text-slate-600 font-medium"
            />
            <button className="bg-amber-500 text-black text-[10px] font-black px-4 py-1.5 rounded hover:bg-amber-400 transition-colors">TRANSMIT</button>
          </div>

          <div className="flex-1 bg-black/30 border border-white/10 rounded p-6 overflow-y-auto space-y-6 relative shadow-inner">
             <div className="sticky top-0 left-0 right-0 flex justify-center -mt-2 mb-6 pointer-events-none">
                <span className="text-[10px] bg-[#252a33] px-3 py-1 rounded-full border border-white/10 text-slate-500 uppercase tracking-[0.3em] font-black shadow-xl">
                  Active Operational Feed
                </span>
             </div>

             {messages.map(msg => (
                <div key={msg.id} className="space-y-2">
                   <div className="flex justify-between items-center w-full">
                      <div className="text-[10px] font-black flex items-center gap-2">
                         <span className={msg.type === 'alert' ? 'text-orange-500' : msg.type === 'social' ? 'text-pink-400' : 'text-cyan-400'}>
                            ◈ {msg.sender}
                         </span>
                         <span className="text-slate-600 font-bold uppercase tracking-widest">/ NODE_SEC</span>
                      </div>
                      <div className="text-[9px] text-slate-700 font-black tracking-widest">18:46:54</div>
                   </div>
                   <div className={`p-4 rounded-sm border shadow-sm ${
                     msg.type === 'alert' ? 'bg-orange-500/5 border-orange-500/20' : 
                     msg.type === 'social' ? 'bg-pink-500/5 border-pink-500/20' : 
                     'bg-cyan-500/5 border-cyan-500/20'
                   }`}>
                      <p className="text-sm leading-relaxed text-slate-300 font-medium">
                         {msg.text}
                      </p>
                   </div>
                </div>
             ))}

             <div className="flex flex-col items-end space-y-2">
                <div className="text-[10px] font-black text-amber-500 uppercase tracking-[0.1em] underline decoration-cyan-500 underline-offset-4 decoration-2">Robert / CMD</div>
                <div className="bg-amber-500/5 border border-amber-500/20 p-3 rounded-sm min-w-[140px] text-right shadow-sm">
                   <span className="text-sm italic text-amber-200 font-medium">Checking Baby Jane's inventory...</span>
                </div>
             </div>
          </div>

          <div className="bg-[#252a33] border border-white/10 p-2 rounded flex gap-2 shadow-2xl">
            <input 
              type="text" 
              className="bg-black/40 border border-white/5 flex-1 rounded px-4 text-sm text-amber-400 outline-none placeholder:text-slate-700 font-bold" 
              placeholder="Query: 'Baby Jane' sales today..."
            />
            <button className="bg-amber-500 text-black px-4 py-2 rounded flex items-center gap-2 font-black text-xs uppercase tracking-tighter shadow-[0_0_20px_rgba(245,158,11,0.2)] hover:scale-105 transition-transform">
              Transmit <Zap size={14} fill="currentColor" />
            </button>
          </div>
        </main>

        {/* RIGHT RAIL: ANALYTICS & ASSETS */}
        <aside className="col-span-3 flex flex-col gap-4 overflow-y-auto">
          
          <div className="bg-[#252a33] border border-white/10 rounded p-4 border-l-4 border-l-amber-500 shadow-md">
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-[10px] font-black tracking-[0.1em] uppercase text-slate-500 flex items-center gap-2">
                <DollarSign size={12} className="text-amber-400" /> Revenue Flow
              </h3>
              <span className="text-sm font-black text-amber-400">$8,245.00</span>
            </div>
            <div className="space-y-3">
              <div className="flex justify-between items-center">
                <div className="text-[11px] text-slate-300 font-black uppercase tracking-tighter">Dick & Jane's</div>
                <div className="text-right">
                   <div className="text-xs text-green-400 font-black font-mono">+$1,200.50</div>
                </div>
              </div>
              <div className="flex justify-between items-center">
                <div className="text-[11px] text-slate-300 font-black uppercase tracking-tighter">Baby Jane's</div>
                <div className="text-right">
                   <div className="text-xs text-slate-400 font-black font-mono">+$845.00</div>
                </div>
              </div>
            </div>
          </div>

          <div className="bg-[#252a33] border border-white/10 rounded p-4 border-l-4 border-l-cyan-500 shadow-md">
            <h3 className="text-[10px] font-black tracking-[0.1em] uppercase text-slate-500 flex items-center gap-2 mb-4">
              <Beer size={12} className="text-cyan-400" /> Key Sales Items
            </h3>
            <div className="space-y-4">
              {[
                { name: "The Jane (Gin)", level: 18, total: "142 Sold" },
                { name: "The Dick (Bourbon)", level: 42, total: "98 Sold" },
                { name: "Draft Beer", level: 65, total: "210 Sold" },
              ].map((item, i) => (
                <div key={i}>
                  <div className="flex justify-between text-[10px] mb-1">
                    <span className="text-slate-300 font-black uppercase tracking-tighter">{item.name}</span>
                    <span className="text-slate-500 italic font-black font-mono">{item.total}</span>
                  </div>
                  <div className="w-full h-1.5 bg-black/40 rounded-full overflow-hidden border border-white/5">
                    <div 
                      className={`h-full shadow-[0_0_10px_rgba(34,211,238,0.2)] ${item.level < 20 ? 'bg-orange-500 animate-pulse' : 'bg-cyan-500'}`} 
                      style={{ width: `${item.level}%` }} 
                    />
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="bg-[#252a33] border border-white/10 rounded p-4 shadow-md">
            <h3 className="text-[10px] font-black tracking-[0.1em] uppercase text-slate-500 flex items-center gap-2 mb-4">
              <ShieldCheck size={12} className="text-purple-400" /> Floor Ops
            </h3>
            <div className="space-y-2">
              <div className="flex items-center gap-3 p-3 bg-black/20 rounded border border-white/5 hover:border-white/10 transition-colors">
                <Users size={14} className="text-slate-400" />
                <div className="flex-1">
                  <div className="text-[9px] text-slate-500 uppercase tracking-widest font-black">Live Attendance</div>
                  <div className="text-sm font-black font-mono text-white">92 <span className="text-slate-600 px-1">/</span> 10</div>
                </div>
                <Activity size={14} className="text-green-500 animate-pulse" />
              </div>
              <div className="flex items-center gap-3 p-3 bg-black/20 rounded border border-white/5">
                <Clock size={14} className="text-slate-400" />
                <div className="flex-1">
                  <div className="text-[9px] text-slate-500 uppercase tracking-widest font-black">Peak Projection</div>
                  <div className="text-sm font-black font-mono text-white underline decoration-cyan-500 underline-offset-2">22:00</div>
                </div>
                <TrendingUp size={14} className="text-cyan-500" />
              </div>
            </div>
          </div>

          <div className="mt-auto border-t border-amber-500/20 pt-4">
            <div className="p-4 bg-amber-500/5 border border-amber-500/20 rounded-lg shadow-xl backdrop-blur-sm">
              <div className="text-[8px] font-black text-amber-500 mb-2 tracking-[0.2em] uppercase">Managerial Authorization Required</div>
              <div className="text-[11px] text-slate-300 mb-3 leading-relaxed font-bold">
                Baby Jane's (Bed-Stuy) requests permission to swap Draft Line #2 for Seasonal Stout.
              </div>
              <div className="flex gap-2">
                <button className="flex-1 bg-green-500 text-black text-[10px] py-2 rounded font-black uppercase tracking-tighter hover:bg-green-400 transition-all shadow-lg">GRANT ACCESS</button>
                <button className="flex-1 bg-red-500/20 border border-red-500/40 text-red-500 text-[10px] py-2 rounded font-black uppercase tracking-tighter hover:bg-red-500/30 transition-all">DENY</button>
              </div>
            </div>
          </div>

        </aside>
      </div>
    </div>
  );
};




        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<App />);
    </script>
</body>
</html>
