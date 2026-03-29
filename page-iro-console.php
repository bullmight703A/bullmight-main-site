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
    <title>IRO Console V5 - Bullmight</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              cyber: {
                dark: '#0a0f14',
              }
            }
          }
        }
      }
    </script>
    <style>
      body { margin: 0; background-color: #0a0f14; }
      .scrollbar-hide::-webkit-scrollbar { display: none; }
      .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <!-- React & ReactDOM -->
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <!-- Babel -->
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>
<body>
    <div id="iro-root"></div>
    <script type="text/babel">
        const { useState, useEffect } = React;

        // --- LUCIDE SVG ICONS ---
        const Icon = ({d, size=24, className=""}) => <svg className={className} width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" dangerouslySetInnerHTML={{__html: d}}></svg>;
        const RefreshCw = p => <Icon {...p} d='<polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>'/>;
        const FileText = p => <Icon {...p} d='<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>'/>;
        const Github = p => <Icon {...p} d='<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/>'/>;
        const Send = p => <Icon {...p} d='<line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>'/>;
        const ExternalLink = p => <Icon {...p} d='<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>'/>;
        const Download = p => <Icon {...p} d='<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>'/>;
        const Eye = p => <Icon {...p} d='<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'/>;
        const TrendingUp = p => <Icon {...p} d='<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>'/>;
        const Users = p => <Icon {...p} d='<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'/>;
        const Clock = p => <Icon {...p} d='<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'/>;
        const AlertCircle = p => <Icon {...p} d='<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'/>;
        const Phone = p => <Icon {...p} d='<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>'/>;
        const Mail = p => <Icon {...p} d='<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22 6 12 13 2 6"/>'/>;
        const Tag = p => <Icon {...p} d='<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>'/>;
        const Video = p => <Icon {...p} d='<polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>'/>;
        const Database = p => <Icon {...p} d='<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>'/>;
        const Layers = p => <Icon {...p} d='<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>'/>;
        const Zap = p => <Icon {...p} d='<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>'/>;
        const Search = p => <Icon {...p} d='<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>'/>;
        const FileBarChart = p => <Icon {...p} d='<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="M8 18v-3"/><path d="M16 18v-8"/>'/>;
        const ShieldCheck = p => <Icon {...p} d='<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>'/>;

        const App = () => {
          const [activeTab, setActiveTab] = useState('CHAT');
          const [inputValue, setInputValue] = useState('');
          const [githubUrl, setGithubUrl] = useState('');
          
          const [chatMessages, setChatMessages] = useState([
            { role: 'system', text: 'Secure connection re-established via Cloudflare.' },
            { role: 'user', text: '@IRO, check the GHL pipeline for the new tech leads.' },
            { role: 'agent', text: 'IRO: Accessing GoHighLevel API... 14 new opportunities found.', name: 'IRO' },
          ]);

          const [agents, setAgents] = useState([
            { id: 'iro', name: 'IRO', status: 'ONLINE & LISTENING', color: 'text-cyan-400', isRestarting: false },
            { id: 'masterchef', name: 'MASTERCHEF', status: 'AWAITING TASK', color: 'text-yellow-400', isRestarting: false },
            { id: 'volt', name: 'VOLT', status: 'STNDBY_MODE', color: 'text-slate-500', isRestarting: false },
            { id: 'picasso', name: 'PICASSO', status: 'STNDBY_MODE', color: 'text-slate-500', isRestarting: false }
          ]);

          const [pendingErrors, setPendingErrors] = useState([]);
          
          // System Health state
          const [systemHealth, setSystemHealth] = useState({ cpu: 78, ram: 42, disk: 91, net: 12 });

          // API Integrations (merged from original logic)
          useEffect(() => {
              const fetchErrors = async () => {
                  try {
                      const res = await fetch('http://74.92.194.249:3004/api/errors').catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         setPendingErrors(Array.isArray(data) ? data : []);
                      } else { setPendingErrors([]); }
                  } catch(e) { setPendingErrors([]); }
              };
              
              const pingAgents = async () => {
                  try {
                      await fetch('http://74.92.194.249:3004/api/ping', { 
                          method: 'POST', body: JSON.stringify({ action: 'keep-alive' })
                      }).catch(e => null);
                  } catch(e) {}
              };

              // Simulated systemic fluctuation
              const updateHealth = () => {
                  setSystemHealth(prev => ({
                     cpu: Math.max(10, Math.min(99, prev.cpu + (Math.random() * 10 - 5))),
                     ram: Math.max(20, Math.min(99, prev.ram + (Math.random() * 4 - 2))),
                     disk: prev.disk,
                     net: Math.max(5, Math.min(100, prev.net + (Math.random() * 20 - 10)))
                  }));
              };

              fetchErrors(); pingAgents();
              const intv = setInterval(fetchErrors, 10000);
              const keepAliveIntv = setInterval(pingAgents, 300000); 
              const healthIntv = setInterval(updateHealth, 5000);
              
              return () => { clearInterval(intv); clearInterval(keepAliveIntv); clearInterval(healthIntv); };
          }, []);

          const restartAgent = (id) => {
            setAgents(prev => prev.map(a => a.id === id ? { ...a, isRestarting: true, status: 'REBOOTING...' } : a));
            setTimeout(() => {
              setAgents(prev => prev.map(a => a.id === id ? { ...a, isRestarting: false, status: 'ONLINE & READY' } : a));
            }, 2000);
          };

          const handleRestartAll = () => {
            setAgents(prev => prev.map(a => ({ ...a, isRestarting: true, status: 'REBOOTING...' })));
            setTimeout(() => {
              setAgents(prev => prev.map(a => ({ ...a, isRestarting: false, status: 'ONLINE & READY' })));
            }, 2000);
          };

          const handleSendMessage = (e) => {
            e.preventDefault();
            if (!inputValue.trim()) return;
            setChatMessages([...chatMessages, { role: 'user', text: inputValue }]);
            setInputValue('');
            // Simulate Ollama
            setTimeout(() => {
              setChatMessages(prev => [...prev, { role: 'agent', text: 'Executing query securely through local Ollama cloud vector...', name: 'OLLAMA CORE' }]);
            }, 1500);
          };

          const handleSyncGithub = () => {
             if (!githubUrl) return;
             setChatMessages(prev => [...prev, { role: 'system', text: `Sync requested for repository: ${githubUrl}` }]);
             setGithubUrl('');
             setTimeout(() => {
               setChatMessages(prev => [...prev, { role: 'agent', text: 'Repo mapped successfully. Awaiting instructions on code analysis.', name: 'IRO' }]);
               setActiveTab('CHAT');
             }, 1000);
          };

          const recoveredLeads = [
            { name: 'Sarah Connor', phone: '+1 (555) 012-3456', email: 's.connor@cyberdyne.io', tags: ['Hot Lead', 'Enterprise'], status: 'Follow-up' },
            { name: 'Rick Deckard', phone: '+1 (555) 987-6543', email: 'deckard@blade.run', tags: ['Tech', 'Inquiry'], status: 'Nurture' },
            { name: 'Ellen Ripley', phone: '+1 (555) 246-8102', email: 'ripley@weyland.corp', tags: ['Urgent', 'Recovery'], status: 'Call Back' }
          ];

          const emailDomains = [
            { domain: 'outreach.iro-control.com', sent: 1240, responses: 42, health: '98%', status: 'Healthy' },
            { domain: 'leads.iro-ops.net', sent: 890, responses: 12, health: '82%', status: 'Warm' },
          ];

          return (
            <div className="min-h-screen bg-[#0a0f14] text-slate-300 font-mono p-2 md:p-4 selection:bg-cyan-500/30 flex flex-col">
              {/* HEADER */}
              <header className="flex flex-col md:flex-row justify-between items-center border-b border-cyan-900/30 pb-4 mb-6 gap-4">
                <div className="flex items-center gap-3 w-full md:w-auto">
                  <div className="w-3 h-3 rounded-full border border-cyan-400 animate-pulse shadow-[0_0_8px_cyan]" />
                  <h1 className="text-lg md:text-xl font-bold tracking-[0.2em] md:tracking-[0.3em] text-cyan-400 uppercase truncate">IRO Control Center v5.1</h1>
                </div>
                <div className="flex items-center justify-between md:justify-end gap-4 md:gap-6 text-[10px] tracking-widest w-full md:w-auto">
                  <div className="flex items-center gap-2 px-3 py-1 rounded bg-cyan-950/20 border border-cyan-400/20 text-cyan-400 font-bold uppercase whitespace-nowrap">
                    System: Secure & Redundant
                  </div>
                  <button className="text-slate-500 hover:text-white transition-colors">Exit_Cmd</button>
                </div>
              </header>

              <div className="grid grid-cols-12 gap-4 md:gap-6 flex-1">
                
                {/* LEFT COLUMN: AGENTS & DOCUMENTS */}
                <div className="col-span-12 lg:col-span-3 flex flex-col gap-4 md:gap-6 order-2 lg:order-1">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 h-full flex flex-col">
                    <div className="flex justify-between items-center mb-4">
                      <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Agent Fleet</h2>
                      <button onClick={handleRestartAll} className="text-[9px] bg-cyan-600/20 border border-cyan-500/40 text-cyan-400 px-2 py-1 rounded hover:bg-cyan-500 hover:text-black transition-all font-bold uppercase">Restart All</button>
                    </div>
                    <div className="space-y-2">
                      {agents.map(agent => (
                        <div key={agent.id} className="flex justify-between items-center py-2 px-3 bg-slate-950/40 border border-slate-800/40 rounded">
                          <span className="text-xs font-bold tracking-wider">{agent.name}</span>
                          <div className="flex items-center gap-3">
                            <button onClick={() => restartAgent(agent.id)} className={`p-1 text-slate-500 hover:text-cyan-400 transition-colors ${agent.isRestarting ? 'animate-spin text-cyan-400' : ''}`}><RefreshCw size={12} /></button>
                            <span className={`text-[9px] font-bold ${agent.color} uppercase tracking-tighter`}>{agent.status}</span>
                          </div>
                        </div>
                      ))}
                    </div>
                  </section>

                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 min-h-[150px]">
                    <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Activity Monitor</h2>
                    <div className="space-y-3">
                      <div className="p-2 rounded border border-slate-800 bg-slate-950/40">
                        <div className="flex items-center gap-2 mb-1">
                          <div className="w-2 h-2 rounded-full bg-cyan-400" />
                          <span className="text-[11px] font-bold uppercase">IRO: GHL Sync / Lesson Plans</span>
                        </div>
                        <p className="text-[9px] text-slate-500">Processing nodes. Last sync: College Park</p>
                      </div>
                      
                      {pendingErrors.length > 0 ? (
                         pendingErrors.map((err, idx) => (
                           <div key={idx} className="p-2 rounded border border-red-900/50 bg-red-950/10 relative overflow-hidden group">
                             <div className="absolute inset-0 bg-red-600/10 animate-pulse pointer-events-none" />
                             <div className="relative z-10">
                               <div className="flex items-center gap-2 mb-1">
                                 <AlertCircle size={10} className="text-red-500 animate-bounce" />
                                 <span className="text-[11px] text-red-200 uppercase font-bold">{err.nodeName || 'Alert'} Warning</span>
                               </div>
                               <p className="text-[9px] text-red-400/80 uppercase font-bold tracking-tighter">Bottleneck: {err.message || 'Error occurred'}</p>
                             </div>
                           </div>
                         ))
                      ) : (
                         <div className="p-2 rounded border border-slate-800 bg-slate-950/40">
                           <p className="text-[9px] text-slate-500 uppercase font-bold tracking-widest text-center mt-1">No Active Loops</p>
                         </div>
                      )}
                    </div>
                  </section>

                  {/* DOCUMENT VAULT IMPORTED INTO UI */}
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 flex-1 overflow-hidden flex flex-col min-h-[250px]">
                    <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4 font-bold">Docs & Exports (Vault)</h2>
                    <div className="space-y-2 overflow-y-auto pr-1">
                      {[
                        { name: 'KIDazzle_Enrollment_Flyer.png', url: '/wp-content/uploads/KIDazzle_Flyer.png', type: 'IMG', error: false },
                        { name: 'WIMPER_Audit_Review_Q3.pdf', url: '/wp-content/uploads/Wimper_Audit.pdf', type: 'PDF', error: false },
                        { name: 'GHL_Pipeline_Export.csv', url: '#', type: 'CSV', error: false },
                        { name: 'Volt_Error_Log_01.txt', url: '#', type: 'TXT', error: true }
                      ].map((doc, i) => (
                        <div key={i} className="flex items-center justify-between p-2 bg-slate-950/20 border border-slate-800/40 rounded hover:border-cyan-900 transition-colors group">
                          <div className="flex items-center gap-2 overflow-hidden flex-1">
                            <FileText size={12} className={doc.error ? "text-red-500" : "text-cyan-600"} />
                            <span className="text-[10px] truncate w-full text-slate-400 group-hover:text-cyan-400 transition-colors cursor-pointer">{doc.name}</span>
                          </div>
                          <div className="flex gap-2">
                            <a href={doc.url} download className="text-slate-600 hover:text-cyan-400"><Download size={12}/></a>
                          </div>
                        </div>
                      ))}
                    </div>
                  </section>
                </div>

                {/* MIDDLE COLUMN: INPUT & EXTENDED CHAT */}
                <div className="col-span-12 lg:col-span-6 flex flex-col gap-4 order-1 lg:order-2">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-3">
                    <div className="flex flex-col sm:flex-row items-center gap-3">
                      <label className="text-[9px] font-bold text-slate-500 uppercase whitespace-nowrap self-start sm:self-center">GitHub Repo:</label>
                      <div className="relative flex-1 w-full">
                        <Github size={12} className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-600" />
                        <input 
                           type="text" 
                           value={githubUrl}
                           onChange={(e) => setGithubUrl(e.target.value)}
                           onKeyDown={(e) => e.key === 'Enter' && handleSyncGithub()}
                           placeholder="Paste Repo URL to Tie Directly Into IRO Chat..." 
                           className="w-full bg-slate-950/60 border border-slate-800 rounded py-1.5 pl-9 text-[11px] focus:outline-none focus:border-cyan-500 text-slate-100 placeholder:text-slate-600" 
                        />
                      </div>
                      <button onClick={handleSyncGithub} className="w-full sm:w-auto bg-cyan-600 hover:bg-cyan-500 text-black font-bold py-1.5 px-4 rounded text-[10px] uppercase transition-all shadow-lg active:scale-95">Sync Agent</button>
                    </div>
                  </section>

                  <section className="flex-1 flex flex-col bg-slate-900/10 border border-slate-800/60 rounded overflow-hidden min-h-[450px]">
                    <div className="flex border-b border-slate-800 bg-slate-950/20">
                      {['CHAT', 'KIDAZZLE', 'WIMPER'].map(tab => (
                        <button key={tab} onClick={() => setActiveTab(tab)} className={`flex-1 sm:flex-none px-4 sm:px-8 py-3 text-[10px] font-bold tracking-widest transition-all ${activeTab === tab ? 'text-cyan-400 bg-slate-950 border-b-2 border-cyan-400' : 'text-slate-500 hover:text-slate-300'}`}>
                          {tab}
                        </button>
                      ))}
                    </div>

                    <div className="flex-1 relative bg-slate-950/10 overflow-hidden">
                      {activeTab === 'CHAT' && (
                        <div className="h-full flex flex-col p-4">
                          <div className="flex-1 overflow-y-auto space-y-4 mb-4 scrollbar-hide">
                            {chatMessages.map((msg, i) => (
                              <div key={i} className="text-[11px] duration-300">
                                {msg.role === 'system' ? (
                                  <span className="text-slate-600 italic">[{new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}] {msg.text}</span>
                                ) : (
                                  <div className={`p-2 rounded ${msg.role === 'user' ? 'text-right' : 'bg-cyan-950/10 border-l border-cyan-800/40 text-left'}`}>
                                    <span className={msg.role === 'user' ? "text-slate-500 font-bold block mb-1" : "text-cyan-400 font-bold block mb-1"}>
                                      {msg.role === 'user' ? 'You:' : `${msg.name} //`}
                                    </span>
                                    <span className="text-slate-300 leading-relaxed font-medium tracking-wide">{msg.text}</span>
                                  </div>
                                )}
                              </div>
                            ))}
                          </div>
                          <form onSubmit={handleSendMessage} className="flex gap-2 bg-slate-950/40 p-1 rounded border border-slate-800 focus-within:border-cyan-500/50 transition-colors">
                            <input value={inputValue} onChange={(e) => setInputValue(e.target.value)} placeholder="Send mission instructions to Cloud Ollama LLM..." className="flex-1 bg-transparent p-2 text-xs focus:outline-none font-bold placeholder:text-slate-600" />
                            <button type="submit" className="text-cyan-500 p-2 hover:bg-cyan-500 hover:text-black rounded transition-all"><Send size={14} /></button>
                          </form>
                        </div>
                      )}

                      {activeTab === 'KIDAZZLE' && (
                        <div className="p-4 h-full overflow-y-auto space-y-4 custom-scrollbar">
                          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div className="bg-slate-900/40 border border-slate-800 p-3 rounded">
                              <p className="text-[9px] text-slate-500 uppercase font-bold mb-1">Total Pipeline Value</p>
                              <p className="text-xl font-bold text-cyan-400">$1.82M</p>
                              <div className="mt-2 h-1 w-full bg-slate-800 rounded-full overflow-hidden">
                                <div className="h-full bg-cyan-500 w-[72%]" />
                              </div>
                            </div>
                            <div className="bg-slate-900/40 border border-slate-800 p-3 rounded flex flex-col justify-center">
                              <button className="w-full py-2 bg-yellow-600/10 border border-yellow-600/40 text-yellow-500 rounded text-[10px] hover:bg-yellow-500 hover:text-black transition-all font-bold uppercase flex items-center justify-center gap-2">
                                 <Clock size={12} /> Kidazzle EOD Export
                              </button>
                            </div>
                          </div>

                          <div className="bg-slate-900/40 border border-slate-800 rounded overflow-hidden">
                            <div className="bg-slate-950 p-2 border-b border-slate-800">
                              <h3 className="text-[10px] text-slate-500 uppercase tracking-widest flex items-center gap-2 font-bold"><Users size={12}/> Recovery Operations (GHL)</h3>
                            </div>
                            <div className="p-2 space-y-2">
                              {recoveredLeads.map((lead, i) => (
                                <div key={i} className="p-3 bg-slate-950/40 border border-slate-800/40 rounded flex flex-col sm:flex-row gap-4 group hover:border-cyan-900 transition-all justify-between items-start sm:items-center">
                                  <div className="flex-1">
                                    <p className="text-xs font-bold text-slate-100 uppercase">{lead.name}</p>
                                    <div className="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-1">
                                      <span className="text-[10px] text-slate-500 flex items-center gap-1 font-bold"><Phone size={10}/> {lead.phone}</span>
                                      <span className="text-[10px] text-slate-500 flex items-center gap-1 font-bold"><Mail size={10}/> {lead.email}</span>
                                    </div>
                                    <div className="flex flex-wrap gap-1 mt-2">
                                      {lead.tags.map(tag => (
                                        <span key={tag} className="text-[8px] bg-slate-900 text-cyan-600 border border-cyan-900/30 px-1.5 py-0.5 rounded uppercase font-bold">{tag}</span>
                                      ))}
                                    </div>
                                  </div>
                                  <button className="self-end sm:self-center p-3 bg-green-950/20 text-green-500 rounded-full hover:bg-green-500 hover:text-black transition-all shadow-[0_0_10px_rgba(34,197,94,0.1)]">
                                    <Phone size={16} />
                                  </button>
                                </div>
                              ))}
                            </div>
                          </div>
                        </div>
                      )}

                      {activeTab === 'WIMPER' && (
                        <div className="p-4 h-full overflow-y-auto space-y-4 custom-scrollbar">
                          {/* Wimper Specific EOD Report */}
                          <div className="bg-slate-900/40 border border-slate-800 p-4 rounded flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div className="flex items-center gap-3">
                              <FileBarChart size={24} className="text-cyan-500" />
                              <div>
                                <h3 className="text-xs font-bold text-slate-200 uppercase">Wimper Tech EOD Summary</h3>
                                <p className="text-[9px] text-slate-500 uppercase">Status: Awaiting Final Validation</p>
                              </div>
                            </div>
                            <button className="w-full sm:w-auto text-[9px] bg-cyan-600/10 border border-cyan-600/40 text-cyan-400 px-4 py-2 rounded hover:bg-cyan-500 hover:text-black transition-all font-bold uppercase flex items-center justify-center gap-2">
                               <Clock size={12} /> Generate Tech EOD
                            </button>
                          </div>

                          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div className="bg-slate-900/40 border border-slate-800 p-3 rounded">
                              <div className="flex items-center gap-2 mb-3 text-cyan-400 font-bold uppercase text-[10px]">
                                <Mail size={14} /> Cold Email Delivery
                              </div>
                              <div className="space-y-2">
                                {emailDomains.map(d => (
                                  <div key={d.domain} className="p-2 bg-slate-950/40 border border-slate-800/60 rounded">
                                    <div className="flex justify-between text-[10px] mb-1">
                                      <span className="text-slate-100 font-bold">{d.domain}</span>
                                      <span className={d.status === 'Healthy' ? 'text-green-500' : 'text-yellow-500'}>{d.status}</span>
                                    </div>
                                    <div className="flex justify-between text-[9px] text-slate-500 uppercase font-bold">
                                      <span>Sent: {d.sent}</span>
                                      <span>Resp: {d.responses} ({Math.round((d.responses/d.sent)*100)}%)</span>
                                    </div>
                                  </div>
                                ))}
                              </div>
                            </div>

                            <div className="bg-slate-900/40 border border-slate-800 p-3 rounded">
                              <div className="flex items-center gap-2 mb-3 text-yellow-500 font-bold uppercase text-[10px]">
                                <Search size={14} /> Scraper Intelligence
                              </div>
                              <div className="space-y-3">
                                <div>
                                  <div className="flex justify-between mb-1 uppercase font-bold text-[9px]"><span>Active Progress</span><span>72%</span></div>
                                  <div className="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                                    <div className="h-full bg-yellow-500 w-[72%] shadow-[0_0_8px_orange]" />
                                  </div>
                                </div>
                                <div className="bg-slate-950/60 p-2 rounded text-[9px] text-slate-500 border-l-2 border-yellow-600">
                                   [INF] Extraction: LinkedIn-Lead-Pool-B
                                   <br />[RES] 4,201 records indexed
                                </div>
                              </div>
                            </div>
                          </div>

                          <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            {[
                              { icon: <Layers size={14}/>, label: 'n8n Hooks', val: 'Active', color: 'text-green-500' },
                              { icon: <Database size={14}/>, label: 'Vector DB', val: 'Optimized', color: 'text-cyan-500' },
                              { icon: <Zap size={14}/>, label: 'Latency', val: '14ms', color: 'text-yellow-500' },
                              { icon: <ShieldCheck size={14}/>, label: 'Proxy Wall', val: 'Secure', color: 'text-green-400' }
                            ].map((s, idx) => (
                              <div key={idx} className="bg-slate-900/40 border border-slate-800 p-2 rounded text-center">
                                <div className="text-slate-500 mb-1 flex justify-center">{s.icon}</div>
                                <p className="text-[8px] text-slate-500 uppercase font-bold truncate">{s.label}</p>
                                <p className={`text-[10px] font-bold uppercase ${s.color}`}>{s.val}</p>
                              </div>
                            ))}
                          </div>
                        </div>
                      )}
                    </div>
                  </section>
                </div>

                {/* RIGHT COLUMN: SYSTEM HEALTH (CIRCLES) & QUICK TOOLS */}
                <div className="col-span-12 lg:col-span-3 flex flex-col gap-4 order-3">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 h-full flex flex-col justify-center">
                    <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-6 font-bold flex items-center"><ActivityMonitorIcon /> Live Health Dashboard</h2>
                    <div className="grid grid-cols-2 gap-y-10 gap-x-4 pb-4">
                      {[
                        { label: 'CPU', val: Math.round(systemHealth.cpu), color: 'stroke-cyan-500' },
                        { label: 'RAM', val: Math.round(systemHealth.ram), color: 'stroke-green-500' },
                        { label: 'DISK', val: Math.round(systemHealth.disk), color: 'stroke-red-500' },
                        { label: 'NET', val: Math.round(systemHealth.net), color: 'stroke-cyan-400' }
                      ].map(gauge => (
                        <div key={gauge.label} className="flex flex-col items-center gap-2">
                          <div className="relative w-20 h-20 transition-all duration-1000">
                            <svg className="w-full h-full transform -rotate-90">
                              <circle cx="40" cy="40" r="36" fill="none" stroke="currentColor" strokeWidth="3" className="text-slate-900" />
                              <circle cx="40" cy="40" r="36" fill="none" stroke="currentColor" strokeWidth="4" className={gauge.color} strokeDasharray={226.2} strokeDashoffset={226.2 - (gauge.val / 100) * 226.2} strokeLinecap="round" style={{ transition: 'stroke-dashoffset 1s ease-out' }} />
                            </svg>
                            <div className="absolute inset-0 flex flex-col items-center justify-center">
                              <span className="text-[11px] font-bold text-slate-100">{gauge.val}%</span>
                              <span className="text-[8px] text-slate-600 font-bold uppercase tracking-tighter">{gauge.label}</span>
                            </div>
                          </div>
                        </div>
                      ))}
                    </div>
                  </section>

                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 flex-1">
                     <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 font-bold">Quick Tools</h2>
                     <div className="flex flex-col gap-2">
                       <button className="flex items-center gap-3 p-3 w-full text-[10px] bg-slate-950/40 border border-slate-800 rounded hover:border-cyan-500 transition-colors group">
                         <RefreshCw size={14} className="text-cyan-500 group-hover:rotate-180 transition-transform duration-500" />
                         <span className="font-bold uppercase tracking-tighter">Flush Agent Memory</span>
                       </button>
                       <button className="flex items-center gap-3 p-3 w-full text-[10px] bg-slate-950/40 border border-slate-800 rounded hover:border-cyan-500 transition-colors group">
                         <Video size={14} className="text-cyan-500" />
                         <span className="font-bold uppercase tracking-tighter">Mobilize Asset Gen</span>
                       </button>
                       <button className="flex items-center gap-3 p-3 w-full text-[10px] bg-slate-950/40 border border-slate-800 rounded hover:border-cyan-500 transition-colors group">
                         <ExternalLink size={14} className="text-cyan-500" />
                         <span className="font-bold uppercase tracking-tighter">External GHL Portal</span>
                       </button>
                     </div>
                  </section>
                </div>
              </div>
              
              <footer className="mt-6 p-3 md:p-2 border border-slate-800 bg-slate-900/20 rounded flex flex-col md:flex-row justify-between items-center text-[8px] text-slate-600 uppercase tracking-[0.2em] gap-2">
                <div className="flex gap-6"><span>Instance: IRO_Node_X1_bullmight_master</span><span>Uptime: Active Sync</span></div>
                <div className="flex gap-4 items-center font-bold tracking-tighter">
                  <span className="flex items-center gap-1.5"><span className="w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_5px_green] animate-pulse"></span> All Nodes OK</span>
                  <span className="text-cyan-600 font-bold border-l border-slate-800 pl-4 uppercase">Ver 5.1.0_Final</span>
                </div>
              </footer>
            </div>
          );
        };

        const ActivityMonitorIcon = () => <svg className="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>

        const root = ReactDOM.createRoot(document.getElementById('iro-root'));
        root.render(<App />);
    </script>
</body>
</html>
