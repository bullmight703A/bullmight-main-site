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
    <title>IRO Control Center</title>
    <!-- Modern Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'sans-serif'],
              mono: ['JetBrains Mono', 'monospace'],
            }
          }
        }
      }
    </script>
    <!-- React & ReactDOM -->
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <!-- Babel -->
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
        body { 
            margin: 0; 
            background-color: #0a0f14; 
            color: #E6EDF3; 
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>
    <div id="root"></div>

    <script type="text/babel">
        const { useState, useEffect, useRef } = React;
        const API_BASE = 'https://brisbane-constant-share-taken.trycloudflare.com';
        
        // Hardcore Dedicated Tunnels (Replace API_BASE with HTTPS Cloudflare tunnel URLs when bound to ports)
        const TUNNELS = {
            CHAT: API_BASE,        // Architecture Target: http://localhost:3012
            SEO: API_BASE,         // Architecture Target: http://localhost:3013
            KIDAZZLE: API_BASE,    // Architecture Target: http://localhost:3014
            WIMPER: API_BASE,      // Architecture Target: http://localhost:3015
            PICASSO: API_BASE,     // Architecture Target: http://localhost:3016
            GLOBAL: API_BASE,
            SYSTEM: API_BASE       // Architecture Target: http://localhost:3006
        };

        // Custom Light SVG Icons based on Lucide
        const IconBase = ({children, className="", size=18}) => (
          <svg xmlns="http://www.w3.org/2000/svg" width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}>{children}</svg>
        );
        const RefreshCw = (p) => <IconBase {...p}><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></IconBase>;
        const FileText = (p) => <IconBase {...p}><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></IconBase>;
        const Github = (p) => <IconBase {...p}><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></IconBase>;
        const Send = (p) => <IconBase {...p}><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></IconBase>;
        const ExternalLink = (p) => <IconBase {...p}><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></IconBase>;
        const Download = (p) => <IconBase {...p}><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></IconBase>;
        const Eye = (p) => <IconBase {...p}><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></IconBase>;
        const Paperclip = (p) => <IconBase {...p}><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></IconBase>;
        const Mic = (p) => <IconBase {...p}><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" x2="12" y1="19" y2="22"></line></IconBase>;
        const TrendingUp = (p) => <IconBase {...p}><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></IconBase>;
        const Users = (p) => <IconBase {...p}><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></IconBase>;
        const Clock = (p) => <IconBase {...p}><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></IconBase>;
        const AlertCircle = (p) => <IconBase {...p}><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></IconBase>;
        const Phone = (p) => <IconBase {...p}><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></IconBase>;
        const Mail = (p) => <IconBase {...p}><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></IconBase>;
        const Tag = (p) => <IconBase {...p}><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></IconBase>;
        const Video = (p) => <IconBase {...p}><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></IconBase>;
        const Database = (p) => <IconBase {...p}><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></IconBase>;
        const Layers = (p) => <IconBase {...p}><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 12 12 17 22 12"></polyline><polyline points="2 17 12 22 22 17"></polyline></IconBase>;
        const Zap = (p) => <IconBase {...p}><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></IconBase>;
        const Search = (p) => <IconBase {...p}><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></IconBase>;
        const FileBarChart = (p) => <IconBase {...p}><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"></path><path d="M14 3v5h5M10 18v-4M14 18v-8M6 18v-6"></path></IconBase>;
        const ShieldCheck = (p) => <IconBase {...p}><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></IconBase>;
        const Crosshair = (p) => <IconBase {...p}><circle cx="12" cy="12" r="10"></circle><line x1="22" y1="12" x2="18" y2="12"></line><line x1="6" y1="12" x2="2" y2="12"></line><line x1="12" y1="6" x2="12" y2="2"></line><line x1="12" y1="22" x2="12" y2="18"></line></IconBase>;
        const X = (p) => <IconBase {...p}><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></IconBase>;

        const App = () => {
          const [activeTab, setActiveTab] = useState('CHAT');
          const [inputValue, setInputValue] = useState('');
          const [activeIframe, setActiveIframe] = useState(null);
          
          const [systemHealth, setSystemHealth] = useState({ cpu: 0, ram: 0, diskC: 0, diskD: 0, network: 0 });

          const [localNotes, setLocalNotes] = useState(() => {
              try { return localStorage.getItem('iro_notes_save') || ''; } catch(e) { return ''; }
          });
          const handleNotesChange = (e) => {
              setLocalNotes(e.target.value);
              try { localStorage.setItem('iro_notes_save', e.target.value); } catch(e) {}
          };

          const [chatMessages, setChatMessages] = useState([
            { role: 'system', text: 'Secure connection re-established via Cloudflare.' },
            { role: 'user', text: '@IRO, check the GHL pipeline for the new tech leads.' },
            { role: 'agent', text: 'Accessing GoHighLevel API... 14 new opportunities found.', name: 'IRO' },
          ]);

          const [agents, setAgents] = useState([
            { id: 'iro', name: 'IRO', status: 'ONLINE & LISTENING', color: 'text-cyan-400', isRestarting: false },
            { id: 'masterchef', name: 'MASTERCHEF', status: 'AWAITING TASK', color: 'text-yellow-400', isRestarting: false },
            { id: 'volt', name: 'VOLT:', status: 'STNDBY_MODE', color: 'text-slate-500', isRestarting: false },
            { id: 'picasso', name: 'PICASSO:', status: 'STNDBY_MODE', color: 'text-slate-500', isRestarting: false }
          ]);

          const localFalconLocations = [
            { id: 1, name: 'Hampton', url: 'https://localfalcon.com/scans?q=Hampton+Kidazzle' },
            { id: 2, name: 'College Pk', url: 'https://localfalcon.com/scans?q=College+Park+Kidazzle' },
            { id: 3, name: 'West End', url: 'https://localfalcon.com/scans?q=West+End+Kidazzle' },
            { id: 4, name: 'Midtown', url: 'https://localfalcon.com/scans?q=Midtown+Kidazzle' },
            { id: 5, name: 'Decatur', url: 'https://localfalcon.com/scans?q=Decatur+Kidazzle' },
            { id: 6, name: 'Buckhead', url: 'https://localfalcon.com/scans?q=Buckhead+Kidazzle' },
            { id: 7, name: 'Roswell', url: 'https://localfalcon.com/scans?q=Roswell+Kidazzle' },
            { id: 8, name: 'Sandy Spr', url: 'https://localfalcon.com/scans?q=Sandy+Springs+Kidazzle' },
          ];

          const [telemetryData, setTelemetryData] = useState({ seo: { matrix: [] }, kidazzle: { lessonPlans: [] } });
          const [n8nErrors, setN8nErrors] = useState([]);
          const messagesEndRef = useRef(null);

          useEffect(() => {
              messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
          }, [chatMessages]);

          useEffect(() => {
              const fetchHealth = async () => {
                  try {
                      const res = await fetch(`${TUNNELS.SYSTEM}/api/system-health`);
                      const data = await res.json();
                      if(!data.error) setSystemHealth(data);
                  } catch(e) {}
              };
              
              const fetchTelemetry = async () => {
                  try {
                      // Kidazzle array
                      const resK = await fetch(`${TUNNELS.SYSTEM}/api/kidazzle-matrix`);
                      const dataK = await resK.json();
                      
                      // SEO array
                      const resS = await fetch(`${TUNNELS.SYSTEM}/api/seo-matrix`);
                      const dataS = await resS.json();
                      
                      setTelemetryData(prev => ({
                          ...prev, 
                          kidazzle: { ...prev.kidazzle, lessonPlans: dataK },
                          seo: { ...prev.seo, matrix: dataS }
                      }));
                  } catch(e) {}
              };
              
              fetchHealth();
              fetchTelemetry();
              const interval = setInterval(() => { fetchHealth(); fetchTelemetry(); }, 5000);
              return () => clearInterval(interval);
          }, []);

          const [brainLogs, setBrainLogs] = useState({ memory: 'Loading core traits...', thoughts: 'Connecting to neural net...' });
          useEffect(() => {
              const fetchBrain = async () => {
                  try {
                      const res = await fetch(`${TUNNELS.SYSTEM}/api/brain-logs`);
                      const data = await res.json();
                      if(!data.error) setBrainLogs(data);
                  } catch(e) {}
              };
              if (activeTab === 'BRAIN') {
                  fetchBrain();
                  const i2 = setInterval(fetchBrain, 5000);
                  return () => clearInterval(i2);
              }
          }, [activeTab]);

          const restartAgent = async (id) => {
            const agName = agents.find(a => a.id === id).name;
            setAgents(prev => prev.map(a => a.id === id ? { ...a, isRestarting: true, status: 'REBOOTING...' } : a));
            try {
                await fetch(`${API_BASE}/api/restart-agent`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ agent: agName })
                });
            } catch(e) {}
            setTimeout(() => {
              setAgents(prev => prev.map(a => a.id === id ? { ...a, isRestarting: false, status: 'ONLINE & READY' } : a));
            }, 2000);
          };

          const handleSendMessage = async (e) => {
            e.preventDefault();
            if (!inputValue.trim()) return;
            const txt = inputValue;
            setChatMessages(prev => [...prev, { role: 'user', text: txt }]);
            setInputValue('');
            
            // Temporary indicator
            setChatMessages(prev => [...prev, { role: 'system', text: 'Executing query on internal vectors...', temp: true }]);

            try {
                const res = await fetch(`${TUNNELS.CHAT}/api/chat`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ message: txt })
                });
                const data = await res.json();
                
                // Add reply, filter out temp
                setChatMessages(prev => {
                    const newArr = prev.filter(m => !m.temp);
                    return [...newArr, { role: 'agent', name: 'IRO', text: data.reply || '[Network Error]', thought: data.thought || null }];
                });
            } catch(err) {
                setChatMessages(prev => prev.filter(m => !m.temp));
                setChatMessages(prev => [...prev, { role: 'system', text: '[System error connecting to deep brain]' }]);
            }
          };

          const recoveredLeads = [
            { name: 'Sarah Connor', phone: '+1 (555) 012-3456', email: 's.connor@cyberdyne.io', tags: ['Hot Lead', 'Enterprise'], status: 'Follow-up' },
            { name: 'Rick Deckard', phone: '+1 (555) 987-6543', email: 'deckard@blade.run', tags: ['Tech', 'Inquiry'], status: 'Nurture' }
          ];

          const emailDomains = [
            { domain: 'outreach.iro-control.com', sent: 1240, responses: 42, health: '98%', status: 'Healthy' },
            { domain: 'leads.iro-ops.net', sent: 890, responses: 12, health: '82%', status: 'Warm' },
          ];

          return (
            <div className="min-h-screen bg-[#0a0f14] text-slate-300 font-mono p-2 md:p-4 selection:bg-cyan-500/30 flex flex-col lg:max-h-screen lg:overflow-hidden">
              {/* HEADER */}
              <header className="flex flex-col md:flex-row justify-between items-center border-b border-cyan-900/30 pb-4 mb-4 gap-4 flex-none">
                <div className="flex items-center gap-3 w-full md:w-auto">
                  <div className="w-3 h-3 rounded-full border border-cyan-400 animate-pulse shadow-[0_0_8px_cyan]" />
                  <h1 className="text-lg md:text-xl font-bold tracking-[0.2em] md:tracking-[0.3em] text-cyan-400 uppercase truncate">IRO Control Center</h1>
                </div>
                <div className="flex items-center justify-between md:justify-end gap-4 md:gap-6 text-[10px] tracking-widest w-full md:w-auto">
                  <div className="flex items-center gap-2 px-3 py-1 rounded bg-cyan-950/20 border border-cyan-400/20 text-cyan-400 font-bold uppercase whitespace-nowrap">
                    System: Secure
                  </div>
                  <button className="text-slate-500 hover:text-white transition-colors uppercase font-bold">Exit_Cmd</button>
                </div>
              </header>

              <div className="grid grid-cols-12 gap-4 md:gap-6 flex-1 min-h-0">
                
                {/* LEFT COLUMN: AGENTS & DOCUMENTS */}
                <div className="col-span-12 lg:col-span-3 flex flex-col gap-4 order-2 lg:order-1 lg:h-full lg:min-h-0 lg:overflow-hidden">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 flex-none">
                    <div className="flex justify-between items-center mb-4">
                      <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Agent Fleet</h2>
                      <button className="text-[9px] bg-cyan-600/20 border border-cyan-500/40 text-cyan-400 px-2 py-1 rounded hover:bg-cyan-500 hover:text-black transition-all font-bold uppercase">Restart All</button>
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

                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 flex-none">
                    <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Activity Monitor</h2>
                    <div className="space-y-3">
                      {n8nErrors && n8nErrors.length > 0 ? (
                        n8nErrors.slice(0, 3).map((err, idx) => (
                           <div key={idx} className="p-2 rounded border border-red-900/50 bg-red-950/10 relative overflow-hidden group">
                             <div className="absolute inset-0 bg-red-600/10 animate-pulse pointer-events-none" />
                             <div className="relative z-10">
                               <div className="flex items-center gap-2 mb-1">
                                 <AlertCircle size={10} className="text-red-500 animate-bounce" />
                                 <span className="text-[11px] text-red-200 uppercase font-bold">N8N WorkFlow Err: {err.workflowId}</span>
                               </div>
                               <p className="text-[9px] text-red-400/80 uppercase font-bold tracking-tighter truncate">{err.message}</p>
                             </div>
                           </div>
                        ))
                      ) : (
                        <div className="p-2 rounded border border-slate-800 bg-slate-950/40">
                          <div className="flex items-center gap-2 mb-1">
                            <div className="w-2 h-2 rounded-full bg-green-500 animate-pulse" />
                            <span className="text-[11px] font-bold uppercase text-white">SYSTEM CLEAR</span>
                          </div>
                          <p className="text-[9px] text-slate-500">All local and upstream pipelines are reporting healthy status telemetry.</p>
                        </div>
                      )}
                    </div>
                  </section>

                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 flex-1 overflow-hidden flex flex-col min-h-0">
                    <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4 flex-none">Bridge Active Files</h2>
                    <div className="space-y-2 overflow-y-auto pr-1 flex-1 scrollbar-hide">
                      {[
                        { name: 'Architecture_Mapping.png', type: 'IMG', url: '/deliverables/Architecture_Mapping.png' },
                        { name: 'telemetry.json', type: 'JSON', url: '/deliverables/telemetry.json' },
                        { name: 'real_health.json', type: 'JSON', url: '/deliverables/real_health.json' },
                        { name: 'n8n_errors.json', type: 'JSON', url: '/deliverables/n8n_errors.json' }
                      ].map((doc, i) => (
                        <div key={i} className="flex items-center justify-between p-2 bg-slate-950/20 border border-slate-800/40 rounded hover:border-cyan-900 transition-colors group">
                          <div className="flex items-center gap-2 overflow-hidden flex-1">
                            <FileText size={12} className={doc.error ? "text-red-500" : "text-cyan-600"} />
                            <span className="text-[10px] truncate text-slate-400 group-hover:text-slate-200">{doc.name}</span>
                          </div>
                          <div className="flex gap-2">
                            <a href={`${API_BASE}${doc.url}`} target="_blank" className="text-slate-600 hover:text-cyan-400" title="View Document"><Eye size={10}/></a>
                          </div>
                        </div>
                      ))}
                    </div>
                  </section>
                </div>

                {/* MIDDLE COLUMN: INPUT & EXTENDED CHAT */}
                <div className="col-span-12 lg:col-span-6 flex flex-col gap-4 order-1 lg:order-2 min-h-[60vh] lg:h-full lg:min-h-0 lg:overflow-hidden">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-3 flex-none">
                    <div className="flex flex-col sm:flex-row items-center gap-3">
                      <label className="text-[9px] font-bold text-slate-500 uppercase whitespace-nowrap self-start sm:self-center">GitHub Repo:</label>
                      <div className="relative flex-1 w-full">
                        <Github size={12} className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-600" />
                        <input type="text" placeholder="Paste URL..." className="w-full bg-slate-950/60 border border-slate-800 rounded py-1.5 pl-9 text-[11px] focus:outline-none focus:border-cyan-500 text-slate-100" />
                      </div>
                      <button className="w-full sm:w-auto bg-cyan-600 hover:bg-cyan-500 text-black font-bold py-1.5 px-4 rounded text-[10px] uppercase transition-all shadow-[0_0_10px_rgba(34,211,238,0.2)] active:scale-95">Sync</button>
                    </div>
                  </section>

                  {/* Dynamic Middle Area Box */}
                  <section className="flex-1 flex flex-col bg-slate-900/10 border border-slate-800/60 rounded overflow-hidden min-h-0">
                    <div className="flex flex-none border-b border-slate-800 bg-slate-950/20 overflow-x-auto scrollbar-hide">
                      {['CHAT', 'BRAIN', 'SEO', 'KIDAZZLE', 'WIMPER', 'NOTES'].map(tab => (
                        <button key={tab} onClick={() => setActiveTab(tab)} className={`flex-1 sm:flex-none px-4 sm:px-8 py-3 text-[10px] font-bold tracking-widest transition-all whitespace-nowrap ${activeTab === tab ? 'text-cyan-400 bg-slate-950 border-b-2 border-cyan-400' : 'text-slate-500 hover:text-slate-300'}`}>
                          {tab}
                        </button>
                      ))}
                    </div>

                    <div className="flex-1 relative bg-slate-950/10 overflow-hidden min-h-0">
                      
                      {/* CHAT TAB */}
                      {activeTab === 'CHAT' && (
                        <div className="h-full flex flex-col p-4">
                          <div className="flex-1 overflow-y-auto space-y-4 mb-4 scrollbar-hide pr-2">
                            {chatMessages.map((msg, i) => (
                              <div key={i} className="text-[11px] animate-in fade-in slide-in-from-bottom-1 duration-300">
                                {msg.role === 'system' ? (
                                  <span className="text-slate-600 italic">[{new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}] {msg.text}</span>
                                ) : (
                                  <div className={`p-2 rounded flex flex-col ${msg.role === 'user' ? 'bg-slate-800/30' : 'bg-cyan-950/10 border-l border-cyan-800/40'}`}>
                                    <div>
                                      <span className={msg.role === 'user' ? "text-cyan-600 font-bold" : "text-cyan-400 font-bold"}>
                                        {msg.role === 'user' ? 'User:' : `${msg.name} //`}
                                      </span>
                                      <span className="text-slate-300 ml-2 leading-relaxed whitespace-pre-wrap">{msg.text}</span>
                                    </div>
                                      {/* Thought block removed - Native to BRAIN tab only */}
                                  </div>
                                )}
                              </div>
                            ))}
                            <div ref={messagesEndRef} />
                          </div>
                          <form onSubmit={handleSendMessage} className="flex gap-2 bg-slate-950/40 p-1 rounded border border-slate-800 flex-none items-center">
                            <button type="button" className="text-slate-500 p-2 hover:text-cyan-400 transition-all focus:outline-none"><Paperclip size={14} /></button>
                            <input value={inputValue} onChange={(e) => setInputValue(e.target.value)} placeholder="Wait for prompt or type query..." className="flex-1 bg-transparent p-2 text-xs focus:outline-none font-bold text-white placeholder-slate-600" />
                            <button type="button" className="text-slate-500 p-2 hover:text-cyan-400 transition-all focus:outline-none" title="British Auto-Talking (Standby)"><Mic size={14} /></button>
                            <button type="submit" className="text-cyan-500 p-2 hover:bg-cyan-500 hover:text-black rounded transition-all"><Send size={14} /></button>
                          </form>
                        </div>
                      )}

                      {/* BRAIN LOGS TAB */}
                      {activeTab === 'BRAIN' && (
                        <div className="p-4 h-full overflow-y-auto space-y-4 scrollbar-hide flex flex-col">
                           {/* Growth Dashboard Row */}
                           <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 shrink-0">
                               <div className="bg-slate-900/40 p-3 rounded border border-slate-800 text-center">
                                   <p className="text-[9px] text-slate-500 uppercase tracking-widest font-bold mb-1">Topics Indexed</p>
                                   <p className="text-xl text-cyan-400 font-mono">{brainLogs.growth?.topics_indexed || 0}</p>
                               </div>
                               <div className="bg-slate-900/40 p-3 rounded border border-slate-800 text-center">
                                   <p className="text-[9px] text-slate-500 uppercase tracking-widest font-bold mb-1">Synaptic Thoughts</p>
                                   <p className="text-xl text-yellow-500 font-mono">{brainLogs.growth?.synapses || 0}</p>
                               </div>
                               <div className="bg-slate-900/40 p-3 rounded border border-slate-800 text-center">
                                   <p className="text-[9px] text-slate-500 uppercase tracking-widest font-bold mb-1">Volatile Core Memory</p>
                                   <p className="text-xl text-green-400 font-mono">{brainLogs.growth?.core_memory_kb || 0} KB</p>
                               </div>
                           </div>

                           {/* Recalled Neural Clusters */}
                           <div className="bg-slate-900/40 border border-slate-800 p-3 rounded shrink-0">
                               <p className="text-[10px] text-green-500 uppercase font-bold tracking-widest mb-2 flex items-center gap-2"><Eye size={14}/> Recent Memory Injections</p>
                               <div className="flex flex-wrap gap-2">
                                  {(brainLogs.growth?.recent_topics || []).map((t, idx) => (
                                     <span key={idx} className="bg-slate-800/80 border border-slate-700 text-slate-300 text-[10px] px-2 py-1 rounded shadow-inner uppercase tracking-wider">{t}</span>
                                  ))}
                               </div>
                           </div>

                           <div className="flex-1 flex flex-col md:flex-row gap-4 min-h-0">
                             <div className="bg-slate-900/40 border border-slate-800 p-3 rounded flex-1 flex flex-col min-h-[30vh]">
                                 <p className="text-[10px] text-yellow-500 uppercase font-bold tracking-widest mb-2 flex items-center gap-2"><Zap size={14}/> Core OpenClaw Memory (The Brain)</p>
                                 <div className="bg-slate-950/50 p-2 rounded text-[10px] text-slate-400 border border-slate-800/40 font-mono whitespace-pre-wrap flex-1 overflow-y-auto custom-scrollbar">
                                     {brainLogs.memory}
                                 </div>
                             </div>
                             <div className="bg-slate-900/40 border border-slate-800 p-3 rounded flex-1 flex flex-col min-h-[30vh]">
                                 <p className="text-[10px] text-cyan-500 uppercase font-bold tracking-widest mb-2 flex items-center gap-2"><Zap size={14}/> Live Neural Stream (Inner Monologue)</p>
                                 <div className="bg-slate-950/50 p-2 border-l-2 border-cyan-800 rounded text-[10px] text-slate-300 font-mono whitespace-pre-wrap flex-1 overflow-y-auto shadow-inner custom-scrollbar">
                                     {brainLogs.thoughts || 'Waiting for thought intercept...'}
                                 </div>
                             </div>
                           </div>
                        </div>
                      )}

                      {/* SEO PROTOCOL TAB */}
                      {activeTab === 'SEO' && (
                        <div className="p-4 h-full overflow-y-auto space-y-6 scrollbar-hide flex flex-col">
                           <div className="bg-slate-900/40 border border-slate-800 rounded p-4 shrink-0">
                               <p className="text-[10px] text-cyan-500 uppercase font-bold tracking-widest mb-4 flex items-center justify-between">
                                  <span><Eye size={12} className="inline mr-2"/> Top Industry Keywords Radius</span>
                                  <span className="text-[8px] bg-cyan-900/30 text-cyan-400 px-2 py-0.5 rounded">Local Falcon Grid</span>
                               </p>
                               <div className="w-full bg-slate-950/50 rounded border border-slate-800/40 overflow-hidden">
                                   <table className="w-full text-left text-[10px]">
                                      <thead className="bg-slate-900/80 text-slate-500 uppercase">
                                          <tr>
                                              <th className="p-2 font-bold pl-4">Target Keyword</th>
                                              <th className="p-2 font-bold text-center">1 Mile Avg</th>
                                              <th className="p-2 font-bold text-center">5 Mile Avg</th>
                                              <th className="p-2 font-bold text-center">10 Mile Avg</th>
                                          </tr>
                                      </thead>
                                      <tbody className="text-slate-300 divide-y divide-slate-800/50 font-mono">
                                          {Array.isArray(telemetryData?.seo?.matrix) && telemetryData.seo.matrix.length > 0 ? telemetryData.seo.matrix.map((row, i) => (
                                              <tr key={i} className="hover:bg-slate-800/30">
                                                  <td className="p-2 pl-4">{row.keyword}</td>
                                                  <td className="p-2 text-center font-bold text-green-400">{row.m1}</td>
                                                  <td className="p-2 text-center text-green-400">{row.m5}</td>
                                                  <td className="p-2 text-center text-yellow-500">{row.m10}</td>
                                              </tr>
                                          )) : (
                                              <tr><td colSpan="4" className="p-4 text-center text-xs text-slate-500 animate-pulse">AWAITING LIVE METRICS FROM IRO BRIDGE...</td></tr> 
                                          )}
                                      </tbody>
                                   </table>
                               </div>
                           </div>

                           <div className="bg-slate-900/40 border border-slate-800 rounded p-4 flex-1 flex flex-col min-h-0">
                               <p className="text-[10px] text-yellow-500 uppercase font-bold tracking-widest mb-4 flex items-center justify-between">
                                  <span><Zap size={12} className="inline mr-2"/> Night Protocol Tracker</span>
                                  <span className="text-[8px] bg-yellow-900/30 text-yellow-500 px-2 py-0.5 rounded">Pages Created & Indexed</span>
                               </p>
                               <div className="bg-slate-950/50 p-3 rounded border border-slate-800/40 flex-1 overflow-y-auto space-y-3 font-mono text-[10px]">
                                   <div className="flex justify-between items-center border-b border-slate-800/60 pb-2">
                                       <span className="text-slate-300 truncate">/daycare-roswell-toddlers (Kidazzle)</span>
                                       <span className="text-green-500 whitespace-nowrap bg-green-900/20 px-2 rounded">✓ INDEXED</span>
                                   </div>
                                   <div className="flex justify-between items-center border-b border-slate-800/60 pb-2">
                                       <span className="text-slate-300 truncate">/childcare-hampton-infants (Kidazzle)</span>
                                       <span className="text-green-500 whitespace-nowrap bg-green-900/20 px-2 rounded">✓ INDEXED</span>
                                   </div>
                                   <div className="flex justify-between items-center border-b border-slate-800/60 pb-2">
                                       <span className="text-slate-300 truncate">/wimper-employer-tax-advantage (Wimper)</span>
                                       <span className="text-yellow-500 whitespace-nowrap bg-yellow-900/20 px-2 rounded">CRAWLED_WAITING</span>
                                   </div>
                                   <div className="flex justify-between items-center border-b border-slate-800/60 pb-2">
                                       <span className="text-slate-300 truncate">/section-125-calculators (Wimper)</span>
                                       <span className="text-cyan-500 whitespace-nowrap bg-cyan-900/20 px-2 rounded">DISPATCHED</span>
                                   </div>
                               </div>
                           </div>
                        </div>
                      )}

                      {/* KIDAZZLE TAB */}
                      {activeTab === 'KIDAZZLE' && (
                        <div className="p-4 h-full overflow-y-auto space-y-4 scrollbar-hide">
                          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div className="bg-slate-900/40 border border-slate-800 p-3 rounded">
                              <p className="text-[9px] text-slate-500 uppercase font-bold mb-1">GHL Pipeline Opportunities</p>
                              <p className="text-xl font-bold text-cyan-400">Active Syncing...</p>
                              <div className="mt-2 h-1 w-full bg-slate-800 rounded-full overflow-hidden">
                                <div className="h-full bg-cyan-500 w-[100%] animate-pulse" />
                              </div>
                            </div>
                            <div className="bg-slate-900/40 border border-slate-800 p-3 rounded flex flex-col justify-center">
                              <a href="https://app.bullmight.com/v2/location/ZR2UvxPL2wlZNSvHjmJD/opportunities/list" target="_blank" className="w-full py-2 bg-cyan-600/10 border border-cyan-600/40 text-cyan-500 rounded text-[10px] hover:bg-cyan-500 hover:text-black transition-all font-bold uppercase flex items-center justify-center gap-2">
                                 <ExternalLink size={12} /> Launch GHL Portal
                              </a>
                            </div>
                          </div>

                          <div className="bg-slate-900/40 border border-slate-800 rounded overflow-hidden mt-4">
                            <div className="bg-slate-950 p-3 border-b border-slate-800 flex justify-between items-center">
                              <h3 className="text-[10px] text-slate-500 uppercase tracking-widest flex items-center gap-2 font-bold"><Users size={12}/> Opportunity Pipeline Status</h3>
                              <span className="text-[8px] bg-cyan-900/40 text-cyan-500 px-2 rounded border border-cyan-800/40">GHL Live Tracking</span>
                            </div>
                            <div className="p-2 space-y-2">
                              {[
                                { group: 'Intake Leads (New)', value: 177 },
                                { group: 'Tours Scheduled & Completed', value: 23 },
                                { group: 'Confirmed Enrollments (Won)', value: 0 }
                              ].map((metric, i) => (
                                <div key={i} className="p-3 bg-slate-950/40 border border-slate-800/40 rounded flex flex-col sm:flex-row gap-4 group hover:border-cyan-900 transition-all justify-between items-center">
                                  <div className="flex-1 w-full flex justify-between items-center">
                                     <span className="text-xs font-bold text-slate-200 uppercase">{metric.group}</span>
                                     <span className="font-bold text-cyan-400 text-lg">{metric.value}</span>
                                  </div>
                                </div>
                              ))}
                            </div>
                          </div>

                           <div className="bg-slate-900/40 border border-slate-800/60 shadow-lg rounded overflow-hidden mt-4">
                            <div className="bg-slate-950 p-3 border-b border-slate-800 flex justify-between items-center">
                              <h3 className="text-[10px] text-slate-400 uppercase tracking-widest flex items-center gap-2 font-bold"><FileText size={12}/> Lesson Plan Assembly Engine</h3>
                              <span className="text-[8px] bg-yellow-900/40 text-yellow-500 px-2 rounded border border-yellow-800/40">Weekly PDF Pipeline</span>
                            </div>
                            <div className="p-4 grid grid-cols-2 md:grid-cols-4 gap-3 bg-slate-900/20">
                               {Array.isArray(telemetryData?.kidazzle?.lessonPlans) && telemetryData.kidazzle.lessonPlans.length > 0 ? telemetryData.kidazzle.lessonPlans.map((loc, i) => (
                                  <div key={i} className={`p-3 rounded border text-center flex flex-col items-center justify-center transition-all bg-opacity-30 backdrop-blur-sm shadow-inner ${loc.code === 'CRAWLED' ? 'bg-cyan-900/40 border-cyan-700/60' : loc.code === 'ERROR' ? 'bg-red-900/40 border-red-700/60' : 'bg-yellow-900/40 border-yellow-700/60'}`}>
                                      <span className="text-[10px] uppercase font-bold text-slate-100">{loc.name}</span>
                                      <span className={`text-[8px] mt-1.5 uppercase font-bold tracking-widest px-2 py-0.5 rounded bg-black/40 ${loc.code === 'CRAWLED' ? 'text-cyan-400 border border-cyan-900/50' : loc.code === 'ERROR' ? 'text-red-400 border border-red-900/50' : 'text-yellow-400 border border-yellow-900/50'}`}>{loc.status}</span>
                                  </div>
                               )) : (
                                  <div className="text-center text-[10px] text-slate-400 col-span-4 p-8 font-mono animate-pulse bg-slate-900/30 border border-slate-800 rounded">
                                      <Zap size={14} className="mx-auto mb-2 opacity-50" />
                                      AWAITING LIVE METRICS FROM IRO BRIDGE...
                                  </div>
                               )}
                            </div>
                          </div>
                        </div>
                      )}

                      {/* WIMPER TAB */}
                      {activeTab === 'WIMPER' && (
                        <div className="p-4 h-full overflow-y-auto space-y-4 scrollbar-hide">
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
                                <Mail size={14} /> Global Email Status
                              </div>
                              <div className="space-y-4">
                                <div>
                                  <div className="flex justify-between mb-1 uppercase font-bold text-[9px]"><span>Total Dispatched</span><span>14,000+</span></div>
                                  <div className="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                                    <div className="h-full bg-cyan-500 w-[100%]" />
                                  </div>
                                </div>
                                <div className="grid grid-cols-2 gap-2 text-center text-xs">
                                  <div className="p-2 bg-slate-950/50 border border-slate-800/50 rounded">
                                     <p className="text-[8px] uppercase tracking-wider text-slate-500">Open Rate</p>
                                     <p className="font-bold text-white mt-1">Pending Sync</p>
                                  </div>
                                  <div className="p-2 bg-slate-950/50 border border-slate-800/50 rounded">
                                     <p className="text-[8px] uppercase tracking-wider text-slate-500">Response Rate</p>
                                     <p className="font-bold text-cyan-400 mt-1">Pending Sync</p>
                                  </div>
                                </div>
                                <div className="p-2 border border-green-900/40 bg-green-950/20 rounded">
                                  <p className="text-[8px] uppercase tracking-wider text-green-500 font-bold">Deliverability Health</p>
                                  <p className="font-bold text-green-300 text-xs mt-1">99.8% - No Spam Bounding</p>
                                </div>
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
                        </div>
                      )}
                      
                      {/* NOTES TAB */}
                      {activeTab === 'NOTES' && (
                        <div className="p-4 h-full flex flex-col">
                          <div className="bg-slate-900/40 p-3 border border-slate-800 flex flex-col flex-1 rounded overflow-hidden">
                             <div className="flex justify-between items-center mb-3">
                               <h3 className="text-[10px] text-cyan-500 uppercase tracking-widest flex items-center gap-2 font-bold"><FileText size={12}/> Local Scratchpad</h3>
                               <span className="text-[8px] text-slate-500 uppercase">Auto-Saves to Browser</span>
                             </div>
                             <textarea 
                               className="w-full flex-grow bg-slate-950/50 border border-slate-800/60 rounded p-4 text-slate-300 text-[11px] focus:outline-none focus:border-cyan-800 scrollbar-hide font-mono leading-loose tracking-wide resize-none" 
                               placeholder="Jot down pipeline shifts, active hook thoughts, or Wimper tech ops here..."
                               value={localNotes}
                               onChange={handleNotesChange}
                             />
                          </div>
                        </div>
                      )}
                    </div>
                  </section>
                </div>

                {/* RIGHT COLUMN: SYSTEM HEALTH (CIRCLES) & SEO MATRIX */}
                <div className="col-span-12 lg:col-span-3 flex flex-col gap-4 order-3 lg:h-full lg:min-h-0 lg:overflow-hidden">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 flex-none">
                    <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-6 font-bold">Health Dashboard</h2>
                    <div className="grid grid-cols-2 gap-y-10 gap-x-4 pb-4">
                      {[
                        { label: 'CPU', val: systemHealth.cpu, color: 'stroke-cyan-500' },
                        { label: 'RAM', val: systemHealth.ram, color: 'stroke-green-500' },
                        { label: 'DISK', val: systemHealth.diskC, val2: systemHealth.diskD, color: 'stroke-yellow-500', color2: 'stroke-red-500' },
                        { label: 'NET', val: systemHealth.network, color: 'stroke-purple-500' }
                      ].map(gauge => (
                        <div key={gauge.label} className="flex flex-col items-center gap-2">
                          <div className="relative w-16 h-16 xl:w-20 xl:h-20">
                            <svg className="w-full h-full transform -rotate-90">
                              <circle cx="50%" cy="50%" r="36%" fill="none" stroke="currentColor" strokeWidth="3" className="text-slate-900" />
                              <circle cx="50%" cy="50%" r="36%" fill="none" stroke="currentColor" strokeWidth="4" className={gauge.color} strokeDasharray={226.2} strokeDashoffset={226.2 - ((gauge.val || 0) / 100) * 226.2} strokeLinecap="round" />
                              {gauge.val2 !== undefined && (
                                <>
                                  <circle cx="50%" cy="50%" r="24%" fill="none" stroke="currentColor" strokeWidth="3" className="text-slate-900" />
                                  <circle cx="50%" cy="50%" r="24%" fill="none" stroke="currentColor" strokeWidth="3" className={gauge.color2} strokeDasharray={150.8} strokeDashoffset={150.8 - ((gauge.val2 || 0) / 100) * 150.8} strokeLinecap="round" />
                                </>
                              )}
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

                   {/* SEO LOCATION MATRIX REPLACING QUICK TOOLS */}
                   <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 flex-1 flex flex-col overflow-hidden">
                      <div className="flex justify-between items-center mb-4">
                        <h2 className="text-[10px] font-bold text-slate-500 uppercase tracking-widest font-bold">Google Pack Matrix</h2>
                        <Search size={10} className="text-cyan-600" />
                      </div>
                      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-2 overflow-y-auto pr-1 flex-1 scrollbar-hide">
                        {localFalconLocations.map(loc => (
                         <button key={loc.id} onClick={() => setActiveIframe(loc)} className="flex items-center justify-between p-2 text-[9px] font-bold uppercase bg-slate-950/40 border border-slate-800 rounded hover:border-cyan-500 hover:text-cyan-400 hover:bg-cyan-900/20 tracking-tighter text-slate-400 transition-all group">
                           <span className="truncate">{loc.name}</span>
                           <Crosshair size={10} className="opacity-0 group-hover:opacity-100 transition-opacity" />
                         </button>
                       ))}
                     </div>
                  </section>
                </div>
              </div>
              
              <footer className="mt-4 p-3 md:p-2 border border-slate-800 bg-slate-900/20 rounded flex flex-col md:flex-row justify-between items-center text-[8px] text-slate-600 uppercase tracking-[0.2em] gap-2 flex-none">
                <div className="flex gap-6"><span>Instance: IRO_Node_X1</span><span>Uptime: 01:42:04</span></div>
                <div className="flex gap-4 items-center font-bold tracking-tighter">
                  <span className="flex items-center gap-1.5"><span className="w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_5px_green]"></span> All Nodes OK</span>
                  <span className="text-cyan-600 font-bold border-l border-slate-800 pl-4 uppercase">Ver 2.5.4_Mobile_Refined</span>
                </div>
              </footer>

              {/* IFrame Modal Overlay */}
              {activeIframe && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-[#0a0f14]/95 p-4 sm:p-6 backdrop-blur-sm animate-in fade-in duration-300">
                  <div className="bg-slate-900/90 border border-cyan-900/50 w-full max-w-6xl h-full max-h-[90vh] flex flex-col rounded-lg shadow-[0_0_50px_rgba(34,211,238,0.15)] relative overflow-hidden">
                    
                    <div className="flex justify-between items-center border-b border-slate-800 p-4 bg-slate-950">
                      <h3 className="text-cyan-500 font-bold flex items-center uppercase tracking-widest text-xs">
                        <Crosshair size={14} className="mr-3" /> SEO VECTOR STREAM: <span className="text-white ml-2">{activeIframe.name}</span>
                      </h3>
                      <button onClick={() => setActiveIframe(null)} className="text-slate-500 hover:text-red-400 font-bold px-3 py-1.5 bg-slate-900 rounded border border-slate-800 hover:border-red-500/50 hover:bg-red-950/30 uppercase tracking-widest text-[9px] flex items-center transition-all">
                          <X size={10} className="mr-1.5" /> CLOSE STREAM
                      </button>
                    </div>
                    
                    <div className="flex-grow p-4 bg-black/40 flex flex-col relative w-full h-full">
                       <div className="flex-grow rounded border border-slate-800 relative bg-[#0a0f14] overflow-hidden group">
                         <div className="absolute inset-0 flex flex-col items-center justify-center opacity-40 z-0">
                            <Search size={40} className="text-cyan-600 animate-pulse mb-4" />
                            <p className="text-slate-400 text-xs font-mono text-center px-4">Initializing Secure Map Frame for <strong className="text-white">{activeIframe.name}</strong>...<br/><span className="text-[10px] text-slate-600 mt-2 block">Local Falcon architecture may prevent embedded loading (X-Frame-Options).<br/>Use the external portal launch link below if frame refuses to connect.</span></p>
                          <a href={activeIframe.url} target="_blank" className="mt-6 px-4 py-2 border border-slate-700 rounded text-xs hover:bg-slate-800 transition-colors uppercase font-bold text-slate-300">Launch Local Falcon</a></div>
                         <iframe src={activeIframe.url} className="w-full h-full border-0 absolute inset-0 z-10 bg-transparent" sandbox="allow-same-origin allow-scripts allow-popups allow-forms" />
                       </div>
                       <div className="mt-4 flex justify-end">
                         <a href={activeIframe.url} target="_blank" rel="noreferrer" className="flex items-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 hover:border-cyan-500 text-[10px] text-cyan-600 hover:text-cyan-400 uppercase tracking-widest font-mono rounded transition-colors group">
                             Launch Dedicated Portal <ExternalLink size={10} className="group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
                         </a>
                       </div>
                    </div>
                  </div>
                </div>
              )}

            </div>
          );
        };

        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<App />);
    </script>
</body>
</html>
