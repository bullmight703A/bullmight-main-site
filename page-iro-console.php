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
        const API_BASE = 'https://api.bullmight.com';
        
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
        const Terminal = (p) => <IconBase {...p}><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></IconBase>;

        const App = () => {
          const [activeTab, setActiveTab] = useState('CHAT');
          const [inputValue, setInputValue] = useState('');
          const [activeIframe, setActiveIframe] = useState(null);
          const [isNightProtocolModalOpen, setIsNightProtocolModalOpen] = useState(false);
          const [brainContext, setBrainContext] = useState(() => {
              try { return localStorage.getItem('iro_brain_context') || ''; } catch(e) { return ''; }
          });
          const handleBrainChange = (e) => {
              setBrainContext(e.target.value);
              try { localStorage.setItem('iro_brain_context', e.target.value); } catch(e) {}
          };
          
          const [systemHealth, setSystemHealth] = useState({ cpu: 0, ram: 0, diskC: 0, diskD: 0, network: 0 });

          const [localNotes, setLocalNotes] = useState(() => {
              try { return localStorage.getItem('iro_notes_save') || ''; } catch(e) { return ''; }
          });
          const handleNotesChange = (e) => {
              setLocalNotes(e.target.value);
              try { localStorage.setItem('iro_notes_save', e.target.value); } catch(e) {}
          };

          const [chatMessages, setChatMessages] = useState(() => {
              try {
                  const saved = localStorage.getItem('iro_chat_thread');
                  if(saved) return JSON.parse(saved);
              } catch(e) {}
              return [
                { role: 'system', text: 'Secure connection re-established via Cloudflare.' },
                { role: 'user', text: '@IRO, check the GHL pipeline for the new tech leads.' },
                { role: 'agent', text: 'Accessing GoHighLevel API... 14 new opportunities found.', name: 'IRO' },
              ];
          });

          const [agents, setAgents] = useState([
            { id: 'iro', name: 'IRO', status: 'ONLINE & LISTENING', color: 'text-cyan-400', isRestarting: false },
            { id: 'masterchef', name: 'MASTERCHEF', status: 'AWAITING TASK', color: 'text-yellow-400', isRestarting: false },
            { id: 'volt', name: 'VOLT:', status: 'STNDBY_MODE', color: 'text-slate-500', isRestarting: false },
            { id: 'picasso', name: 'PICASSO:', status: 'STNDBY_MODE', color: 'text-slate-500', isRestarting: false }
          ]);

          const localFalconLocations = [
            { id: 1, name: 'Hampton', gmb: 'https://business.google.com/dashboard/l/111', mile1: '1.2', mile5: '3.4', mile10: '5.6', trend: '+12%', url: 'https://localfalcon.com/scans?q=Hampton+Kidazzle' },
            { id: 2, name: 'College Pk', gmb: 'https://business.google.com/dashboard/l/222', mile1: '1.5', mile5: '4.2', mile10: '7.1', trend: '+8%', url: 'https://localfalcon.com/scans?q=College+Park+Kidazzle' },
            { id: 3, name: 'West End', gmb: 'https://business.google.com/dashboard/l/333', mile1: '2.0', mile5: '3.8', mile10: '6.4', trend: '+15%', url: 'https://localfalcon.com/scans?q=West+End+Kidazzle' },
            { id: 4, name: 'Midtown', gmb: 'https://business.google.com/dashboard/l/444', mile1: '1.0', mile5: '2.5', mile10: '5.2', trend: '+5%', url: 'https://localfalcon.com/scans?q=Midtown+Kidazzle' },
            { id: 5, name: 'Memphis', gmb: 'https://business.google.com/dashboard/l/555', mile1: '1.8', mile5: '3.0', mile10: '4.5', trend: '+22%', url: 'https://localfalcon.com/scans?q=Memphis+Kidazzle' },
            { id: 6, name: 'Miami', gmb: 'https://business.google.com/dashboard/l/666', mile1: '4.1', mile5: '6.2', mile10: '9.0', trend: '+4%', url: 'https://localfalcon.com/scans?q=Miami+Kidazzle' },
            { id: 7, name: 'Wimper ATL', gmb: 'https://business.google.com/dashboard/l/777', mile1: '1.1', mile5: '2.8', mile10: '3.5', trend: '+18%', url: 'https://localfalcon.com/scans?q=Atlanta+Wimper' },
            { id: 8, name: 'Wimper CLT', gmb: 'https://business.google.com/dashboard/l/888', mile1: '1.0', mile5: '1.5', mile10: '2.0', trend: '+30%', url: 'https://localfalcon.com/scans?q=Charlotte+Wimper' },
            { id: 9, name: 'Wimper DFW', gmb: 'https://business.google.com/dashboard/l/999', mile1: '2.0', mile5: '3.5', mile10: '4.8', trend: '+11%', url: 'https://localfalcon.com/scans?q=Dallas+Wimper' },
            { id: 10, name: 'Wimper FICA', gmb: 'https://business.google.com/dashboard/l/000', mile1: '1.0', mile5: '2.0', mile10: '3.2', trend: '+45%', url: 'https://localfalcon.com/scans?q=FICA+Wimper' },
          ];

          const [activeLessonPlanLoc, setActiveLessonPlanLoc] = useState('MAIN MASTER OUTBOX');
          const [telemetryData, setTelemetryData] = useState({ seo: { matrix: [] }, kidazzle: { lessonPlans: [] } });
          const [videoPrompt, setVideoPrompt] = useState('');
          const [imagePrompt, setImagePrompt] = useState('');
          const [isGeneratingVideo, setIsGeneratingVideo] = useState(false);
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
            
            // Generate clean history array immediately to safely pass down
            const currentHistory = [...chatMessages, { role: 'user', text: txt }];
            setChatMessages(currentHistory);
            try { localStorage.setItem('iro_chat_thread', JSON.stringify(currentHistory)); } catch(e) {}
            
            setInputValue('');
            
            // Temporary indicator
            setChatMessages(prev => [...prev, { role: 'system', text: 'Executing query on internal vectors...', temp: true }]);

            try {
                const res = await fetch(`${TUNNELS.CHAT}/api/chat`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ message: txt, history: currentHistory })
                });
                const data = await res.json();
                
                // Add reply, filter out temp
                setChatMessages(prev => {
                    const newArr = prev.filter(m => !m.temp);
                    const finalArr = [...newArr, { role: 'agent', name: 'IRO', text: data.reply || '[Network Error]', thought: data.thought || null }];
                    try { localStorage.setItem('iro_chat_thread', JSON.stringify(finalArr)); } catch(e) {}
                    return finalArr;
                });
            } catch(err) {
                setChatMessages(prev => {
                    const newArr = prev.filter(m => !m.temp);
                    const finalArr = [...newArr, { role: 'system', text: '[System error connecting to deep brain]' }];
                    try { localStorage.setItem('iro_chat_thread', JSON.stringify(finalArr)); } catch(e) {}
                    return finalArr;
                });
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
                    <h2 className="text-[10px] font-bold text-cyan-500 uppercase tracking-widest mb-4 flex-none"><span className="text-yellow-500">Night Protocol</span> Execution</h2>
                    <div className="space-y-2 overflow-y-auto pr-1 flex-1 scrollbar-hide">
                      {[
                        { name: 'Day 1: Keyword Map', status: 'verified', type: 'doc' },
                        { name: 'Day 2: Comp Grid', status: 'verified', type: 'doc' },
                        { name: 'Day 3: Base Index', status: 'verified', type: 'doc' },
                        { name: 'Day 4: Rank Vault', status: 'verified', type: 'doc' },
                        { name: 'Day 5: Deep Links', status: 'pending', type: 'db' }
                      ].map((f, i) => (
                        <div key={i} onClick={() => setIsNightProtocolModalOpen(true)} className="flex items-center gap-3 p-2 bg-slate-950/20 border border-slate-800/40 rounded cursor-pointer hover:border-cyan-500/50 hover:bg-slate-800 transition-colors group">
                          {f.type === 'doc' ? <FileText size={12} className={f.status === 'verified' ? "text-cyan-600 group-hover:text-cyan-400" : "text-amber-500 group-hover:text-amber-400"} /> : <Database size={12} className="text-emerald-500 group-hover:text-emerald-400" />}
                          <span className="text-[10px] font-mono text-slate-400 group-hover:text-slate-200 flex-grow truncate">{f.name}</span>
                          <div className={`w-2 h-2 rounded-full ${f.status === 'verified' ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse shadow-[0_0_8px_orange]'}`}></div>
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
                      {['CHAT', 'BRAIN', 'SEO', 'KIDAZZLE', 'WIMPER', 'VIDEO', 'IMAGES', 'NOTES'].map(tab => (
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

                      {/* TABS REPLACED */}

                      {/* BRAIN TAB */}
                      {activeTab === 'BRAIN' && (
                        <div className="p-4 h-full flex flex-col min-h-0 bg-slate-950/20">
                            <p className="text-[10px] text-emerald-500 uppercase font-bold tracking-widest mb-3 flex items-center justify-between">
                               <span><Terminal size={12} className="inline mr-2"/> IRO Long-Term Memory / Guidelines</span>
                               <span className="text-[8px] bg-emerald-900/30 text-emerald-500 px-2 py-0.5 rounded">Persistent Storage</span>
                            </p>
                            <label className="text-[9px] text-slate-500 mb-2 uppercase font-bold tracking-tighter">Enter global rules, target facts, or directives for IRO's cognitive loop below:</label>
                            <textarea 
                                value={brainContext}
                                onChange={handleBrainChange}
                                placeholder="Example: Always ensure FICA Strategy targets are prioritized."
                                className="w-full flex-1 bg-black/40 border border-slate-800 rounded p-4 text-xs font-mono text-emerald-400 focus:outline-none focus:border-emerald-500 transition-colors resize-none placeholder-emerald-900/50"
                            />
                            <div className="mt-3 flex justify-end">
                                <button className="px-4 py-2 bg-emerald-900/30 text-emerald-400 text-[10px] uppercase tracking-widest font-bold border border-emerald-800/50 rounded hover:bg-emerald-900/50 hover:border-emerald-500 transition-all shadow-[0_0_10px_rgba(16,185,129,0.1)]">Inject to Memory</button>
                            </div>
                        </div>
                      )}

                      {/* SEO PROTOCOL TAB */}
                      {activeTab === 'SEO' && (
                        <div className="p-4 h-full overflow-y-auto space-y-4 scrollbar-hide flex flex-col">
                           <div className="bg-slate-900/40 border border-slate-800 rounded p-4 shrink-0">
                               <p className="text-[10px] text-cyan-500 uppercase font-bold tracking-widest mb-4 flex items-center justify-between">
                                  <span><Eye size={12} className="inline mr-2"/> Antigravity Research: Kidazzle Location SEO Rankings</span>
                                  <span className="text-[8px] bg-cyan-900/30 text-cyan-400 px-2 py-0.5 rounded">DataForSEO & Local Falcon Grid</span>
                               </p>
                               <div className="w-full bg-slate-950/50 rounded border border-slate-800/40 overflow-hidden">
                                   <table className="w-full text-left text-[10px]">
                                      <thead className="bg-slate-900/80 text-slate-500 uppercase">
                                          <tr>
                                              <th className="p-2 font-bold pl-4">Location</th>
                                              <th className="p-2 font-bold">Top Keyword Ranked</th>
                                              <th className="p-2 font-bold text-center">1 Mile Avg</th>
                                              <th className="p-2 font-bold text-center">5 Mile Avg</th>
                                              <th className="p-2 font-bold text-center">15 Mile Avg</th>
                                              <th className="p-2 font-bold text-center">MoM Trend</th>
                                          </tr>
                                      </thead>
                                      <tbody className="text-slate-300 divide-y divide-slate-800/50 font-mono">
                                          {[
                                            { loc: 'Hampton', kw: 'Childcare Near Me', mile1: '1.2', mile5: '3.4', mile15: '8.5', trend: '▲' },
                                            { loc: 'College Park', kw: 'Daycare College Park', mile1: '1.5', mile5: '4.2', mile15: '12.0', trend: '▲' },
                                            { loc: 'West End', kw: 'Afterschool Program', mile1: '2.0', mile5: '3.8', mile15: '7.4', trend: '▬' },
                                            { loc: 'Midtown', kw: 'Best Daycare Midtown', mile1: '1.0', mile5: '2.5', mile15: '9.2', trend: '▲' },
                                            { loc: 'Memphis', kw: 'Infant Childcare TN', mile1: '1.8', mile5: '3.0', mile15: '6.5', trend: '▲' },
                                            { loc: 'Miami', kw: 'Miami Childcare Center', mile1: '4.1', mile5: '6.2', mile15: '14.0', trend: '▲' },
                                            { loc: 'Wimper ATL HQ', kw: 'Childcare Section 125', mile1: '1.1', mile5: '2.8', mile15: '3.5', trend: '▲' },
                                            { loc: 'Wimper CLT', kw: 'B2B Childcare Benefits', mile1: '1.0', mile5: '1.5', mile15: '3.0', trend: '▲' },
                                            { loc: 'Wimper DFW', kw: 'FICA Tax Strategy', mile1: '2.0', mile5: '3.5', mile15: '5.0', trend: '▲' },
                                            { loc: 'Wimper FICA', kw: 'Section 125 Administration', mile1: '1.0', mile5: '2.0', mile15: '4.5', trend: '▲' },
                                          ].map((row, i) => (
                                              <tr key={i} className="hover:bg-slate-800/30">
                                                  <td className="p-2 pl-4 text-cyan-400 font-bold ">{row.loc}</td>
                                                  <td className="p-2 text-slate-400">{row.kw}</td>
                                                  <td className="p-2 text-center font-bold text-green-400">{row.mile1}</td>
                                                  <td className="p-2 text-center text-green-400">{row.mile5}</td>
                                                  <td className="p-2 text-center text-yellow-500">{row.mile15}</td>
                                                  <td className={`p-2 text-center ${row.trend === '▼' ? 'text-red-500' : row.trend === '▬' ? 'text-slate-500' : 'text-green-500'}`}>{row.trend}</td>
                                              </tr>
                                          ))}
                                      </tbody>
                                   </table>
                               </div>
                           </div>
                           
                           <div className="bg-slate-900/40 border border-slate-800 rounded p-4 shrink-0 mt-4">
                               <p className="text-[10px] text-purple-500 uppercase font-bold tracking-widest mb-4 flex items-center gap-2">
                                  <FileText size={12} className="inline"/> Antigravity Deep Research Findings
                               </p>
                               <div className="p-4 bg-slate-950/50 rounded border border-slate-800/40 font-mono text-xs text-slate-400 leading-relaxed space-y-3">
                                   <p><strong className="text-purple-400">Insight 1:</strong> The local market query density for 'Childcare Near Me' in Hampton peaks between 6:30 AM and 8:00 AM on weekdays.</p>
                                   <p><strong className="text-purple-400">Insight 2:</strong> Competitor GBP saturation is high beyond the 5-mile radius, requiring targeted combo-pages to capture edge-case long-tail searches.</p>
                                   <p><strong className="text-purple-400">Insight 3:</strong> Wimper's "Section 125 Tax Strategy" is experiencing explosive national volume (+34% MoM), accelerating the need for high-converting video landers.</p>
                               </div>
                           </div>
                        </div>
                      )}

                      {/* KIDAZZLE TAB */}
                      {activeTab === 'KIDAZZLE' && (
                        <div className="p-4 h-full overflow-y-auto space-y-4 scrollbar-hide">
                          <div className="mb-2 flex justify-between items-center bg-slate-950 p-2 border border-slate-800 rounded">
                              <h3 className="text-[10px] text-slate-500 uppercase tracking-widest flex items-center gap-2 font-bold"><Users size={12}/> Hampton Location Pipeline</h3>
                              <div className="flex gap-4 items-center">
                                  <span className="text-[8px] bg-cyan-900/40 text-cyan-500 px-2 rounded border border-cyan-800/40 hidden sm:inline-block">GHL Live Tracking</span>
                                  <a href="https://app.bullmight.com/v2/location/ZR2UvxPL2wlZNSvHjmJD/opportunities/list" target="_blank" className="text-[9px] text-cyan-500 hover:text-white uppercase flex items-center gap-1 font-bold transition-colors"><ExternalLink size={10}/> Launch Portal</a>
                              </div>
                          </div>
                          
                          <div className="grid grid-cols-2 lg:grid-cols-4 gap-3">
                              {[
                                { group: '1. New Intakes', value: 412, color: 'text-red-500', bg: 'bg-red-950/20', border: 'border-red-900/40' },
                                { group: '2. Tours Sched', value: 87, color: 'text-blue-500', bg: 'bg-blue-950/20', border: 'border-blue-900/40' },
                                { group: '3. Tours Comp', value: 34, color: 'text-purple-500', bg: 'bg-purple-950/20', border: 'border-purple-900/40' },
                                { group: '4. Enrolled', value: 12, color: 'text-green-500', bg: 'bg-green-950/20', border: 'border-green-900/40' }
                              ].map((metric, i) => (
                                <div key={i} className={`${metric.bg} border ${metric.border} p-4 rounded flex flex-col items-center justify-center text-center shadow-lg transition-transform hover:scale-[1.02]`}>
                                   <p className="text-[9px] text-slate-400 uppercase font-bold mb-2 tracking-widest whitespace-nowrap">{metric.group}</p>
                                   <p className={`text-3xl font-black ${metric.color} drop-shadow-md`}>{metric.value}</p>
                                </div>
                              ))}
                          </div>

                           <div className="bg-slate-900/40 border border-slate-800/60 shadow-lg rounded overflow-hidden mt-4 flex flex-col">
                             <div className="bg-slate-950 p-3 border-b border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                               <h3 className="text-[10px] text-slate-400 uppercase tracking-widest flex items-center gap-2 font-bold"><FileText size={12}/> Lesson Plan Assembly Engine</h3>
                               <span className="text-[8px] bg-yellow-900/40 text-yellow-500 px-2 rounded border border-yellow-800/40">OpenClaw Node Sync</span>
                             </div>

                             <div className="flex bg-slate-950/40 border-b border-slate-800 p-2 gap-2 overflow-x-auto scrollbar-hide shrink-0">
                                {['MAIN MASTER OUTBOX', 'Hampton', 'College Pk', 'West End', 'Midtown', 'Memphis', 'Miami'].map(loc => (
                                   <button 
                                      key={loc}
                                      onClick={() => setActiveLessonPlanLoc(loc)}
                                      className={`px-3 py-1.5 text-[9px] uppercase tracking-widest font-bold whitespace-nowrap rounded transition-all ${activeLessonPlanLoc === loc ? 'bg-cyan-900/60 text-cyan-400 border border-cyan-700/50' : 'bg-slate-900/50 text-slate-500 border border-slate-800 hover:text-slate-300 hover:border-slate-600'}`}
                                   >
                                      {loc}
                                   </button>
                                ))}
                             </div>

                             <div className="w-full h-[500px] relative bg-slate-950 group">
                               {activeLessonPlanLoc !== 'MAIN MASTER OUTBOX' && (
                                  <div className="absolute inset-0 bg-slate-950/90 z-10 flex flex-col items-center justify-center pointer-events-none fade-in duration-300">
                                      <Zap size={24} className="text-yellow-500 mb-2 animate-pulse" />
                                      <span className="text-[10px] text-yellow-500 font-bold uppercase tracking-widest bg-yellow-950/40 border border-yellow-900/40 px-3 py-1 rounded">Targeting: {activeLessonPlanLoc}</span>
                                      <p className="text-[9px] text-slate-500 max-w-xs text-center mt-2 font-mono">Awaiting precise Sub-Folder UUID from OpenClaw Node for {activeLessonPlanLoc}. Currently targeting global bucket.</p>
                                  </div>
                               )}
                               <iframe 
                                   src="https://drive.google.com/embeddedfolderview?id=1D4RRpu_xPZ5U-95065LA5lOxTRp9kauY&usp=sharing#list" 
                                   className={`w-full h-full border-0 absolute inset-0 ${activeLessonPlanLoc !== 'MAIN MASTER OUTBOX' ? 'opacity-20 blur-[1px]' : 'opacity-100'}`}
                                   title="Lesson Plans Folder"
                               />
                             </div>
                           </div>
                        </div>
                      )}

                      {/* WIMPER TAB */}
                      {activeTab === 'WIMPER' && (
                        <div className="p-4 h-full overflow-y-auto space-y-4 scrollbar-hide">
                          
                          <div className="mb-2 flex justify-between items-center bg-slate-950 p-2 border border-slate-800 rounded">
                              <h3 className="text-[10px] text-slate-500 uppercase tracking-widest flex items-center gap-2 font-bold"><Users size={12}/> Wimper Webinar Pipeline</h3>
                              <div className="flex gap-4 items-center">
                                  <span className="text-[8px] bg-cyan-900/40 text-cyan-500 px-2 rounded border border-cyan-800/40 hidden sm:inline-block">GHL Live Tracking</span>
                                  <a href="https://app.bullmight.com/v2/location/0RWYeXXWw8hhpga54CD/opportunities/list" target="_blank" className="text-[9px] text-cyan-500 hover:text-white uppercase flex items-center gap-1 font-bold transition-colors"><ExternalLink size={10}/> Launch Portal</a>
                              </div>
                          </div>
                          
                          <div className="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                              {[
                                { group: 'New Sign Up', value: 3, color: 'text-slate-300', bg: 'bg-slate-950/20', border: 'border-slate-800' },
                                { group: 'Called a.t. Sign Up', value: 4, color: 'text-cyan-500', bg: 'bg-cyan-950/20', border: 'border-cyan-900/40' },
                                { group: 'Attended', value: 1, color: 'text-blue-500', bg: 'bg-blue-950/20', border: 'border-blue-900/40' },
                                { group: 'Called a.t. Attend', value: 12, color: 'text-purple-500', bg: 'bg-purple-950/20', border: 'border-purple-900/40' },
                                { group: 'Did Not Attend', value: 17, color: 'text-red-500', bg: 'bg-red-950/20', border: 'border-red-900/40' },
                                { group: 'Booked Call', value: 1, color: 'text-green-500', bg: 'bg-green-950/20', border: 'border-green-900/40' },
                                { group: 'No show', value: 0, color: 'text-orange-500', bg: 'bg-orange-950/20', border: 'border-orange-900/40' },
                                { group: 'Follow Up', value: 3, color: 'text-yellow-500', bg: 'bg-yellow-950/20', border: 'border-yellow-900/40' }
                              ].map((metric, i) => (
                                <div key={i} className={`${metric.bg} border ${metric.border} p-4 rounded flex flex-col items-center justify-center text-center shadow-lg transition-transform hover:scale-[1.02]`}>
                                   <p className="text-[9px] text-slate-400 uppercase font-bold mb-2 tracking-widest whitespace-nowrap overflow-hidden text-ellipsis w-full">{metric.group}</p>
                                   <p className={`text-3xl font-black ${metric.color} drop-shadow-md`}>{metric.value}</p>
                                </div>
                              ))}
                          </div>
                          
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
                      {/* VIDEO AND IMAGES TABS */}
                      {activeTab === 'VIDEO' && (
                        <div className="p-4 h-full overflow-y-auto flex flex-col gap-4 font-mono scrollbar-hide">
                           <div className="bg-slate-900/40 border border-slate-800 rounded p-4 flex flex-col shrink-0 gap-4">
                               <div className="flex items-center gap-4">
                                   <div className="w-12 h-12 rounded bg-cyan-950/50 border border-cyan-800 flex items-center justify-center shrink-0 shadow-[0_0_15px_rgba(34,211,238,0.2)]">
                                       <Video size={24} className="text-cyan-400" />
                                   </div>
                                   <div>
                                       <h2 className="text-sm uppercase tracking-widest font-black text-slate-200">OpenClaw Omni-Video Engine</h2>
                                       <p className="text-[9px] text-cyan-500 uppercase tracking-widest mt-1 font-bold">Claude Bot • HeyGen CLI • C-Dance</p>
                                   </div>
                               </div>
                               <div className="flex flex-col sm:flex-row gap-2 mt-2">
                                 <input 
                                     type="text" 
                                     value={videoPrompt}
                                     onChange={(e) => setVideoPrompt(e.target.value)}
                                     placeholder="Enter YouTube URL for Deep Research OR HeyGen Prompt..."
                                     className="flex-1 bg-slate-950/80 border border-slate-800 rounded p-2.5 text-[10px] text-slate-300 focus:outline-none focus:border-cyan-800 font-mono tracking-widest"
                                 />
                                 <button 
                                     onClick={() => { setIsGeneratingVideo(true); setVideoPrompt(''); }}
                                     className="px-5 py-2.5 bg-cyan-950/50 border border-cyan-700 hover:bg-cyan-900 transition-colors text-[10px] text-cyan-400 uppercase tracking-widest font-black rounded w-full sm:w-auto shadow-[0_0_10px_rgba(34,211,238,0.1)] flex items-center justify-center gap-2">
                                     <Zap size={12} /> {isGeneratingVideo ? 'Processing...' : 'Execute Master Production'}
                                 </button>
                               </div>
                           </div>

                           <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 shrink-0">
                               {/* Stage 1: Long Form Generation */}
                               <div className="bg-slate-900/40 border-t-2 border-t-purple-500 border-x border-b border-slate-800/60 rounded p-4 relative overflow-hidden group">
                                   <div className="absolute -top-10 -right-10 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl flex-none pointer-events-none" />
                                   <p className="text-[10px] text-purple-400 uppercase font-black tracking-widest mb-3 flex items-center justify-between">1. Long-Form Core <TrendingUp size={12} /></p>
                                   <div className="space-y-3 mt-4">
                                      <div className="bg-slate-950/50 rounded border border-slate-800 p-2 text-[9px] text-slate-400 uppercase tracking-tighter hover:border-purple-500/40 transition-colors flex items-center gap-2"><span className="text-purple-500">↳</span> Deep Research Prompts</div>
                                      <div className="bg-slate-950/50 rounded border border-slate-800 p-2 text-[9px] text-slate-400 uppercase tracking-tighter hover:border-purple-500/40 transition-colors flex items-center gap-2"><span className="text-purple-500">↳</span> Script & Outline Generation</div>
                                      <div className="bg-slate-950/50 rounded border border-slate-800 p-2 text-[9px] text-slate-400 uppercase tracking-tighter hover:border-purple-500/40 transition-colors flex items-center gap-2"><span className="text-purple-500">↳</span> HeyGen & C-Dance Rendering</div>
                                   </div>
                               </div>

                               {/* Stage 2: Fragmentation */}
                               <div className="bg-slate-900/40 border-t-2 border-t-amber-500 border-x border-b border-slate-800/60 rounded p-4 relative overflow-hidden group">
                                   <div className="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl flex-none pointer-events-none" />
                                   <p className="text-[10px] text-amber-500 uppercase font-black tracking-widest mb-3 flex items-center justify-between">2. Hook Fragmentation <Layers size={12} /></p>
                                   <div className="space-y-3 mt-4">
                                      <div className="bg-slate-950/50 rounded border border-slate-800 p-2 flex justify-between items-center text-[9px] text-slate-400 uppercase tracking-tighter hover:border-amber-500/40 transition-colors"><span>Extract 30s Shorts</span><span className="text-amber-500 font-bold">12 Active</span></div>
                                      <div className="bg-slate-950/50 rounded border border-slate-800 p-2 flex justify-between items-center text-[9px] text-slate-400 uppercase tracking-tighter hover:border-amber-500/40 transition-colors"><span>Extract 60s Reels</span><span className="text-amber-500 font-bold">8 Active</span></div>
                                      <div className="bg-slate-950/50 rounded border border-slate-800 p-2 flex justify-between items-center text-[9px] text-slate-400 uppercase tracking-tighter hover:border-amber-500/40 transition-colors"><span>Generate YT Titles</span><span className="text-amber-500 font-bold px-1.5 py-0.5 bg-amber-950/30 rounded border border-amber-900/50">Ready</span></div>
                                   </div>
                               </div>

                               {/* Stage 3: Social & GHL Metrics */}
                               <div className="bg-slate-900/40 border-t-2 border-t-green-500 border-x border-b border-slate-800/60 rounded p-4 relative overflow-hidden group">
                                   <div className="absolute -top-10 -right-10 w-32 h-32 bg-green-500/10 rounded-full blur-2xl flex-none pointer-events-none" />
                                   <p className="text-[10px] text-green-500 uppercase font-black tracking-widest mb-3 flex items-center justify-between">3. GHL Social Engagement <Send size={12} /></p>
                                   <div className="space-y-3 mt-4">
                                      <div className="bg-slate-950/50 rounded border border-slate-800 p-2 text-[9px] text-slate-400 uppercase tracking-tighter flex items-center justify-between hover:border-green-500/40 transition-colors">
                                          <span>Facebook CTR</span>
                                          <span className="text-green-400 font-bold flex items-center gap-1"><TrendingUp size={10} /> +137%</span>
                                      </div>
                                      <div className="bg-slate-950/50 rounded border border-slate-800 p-2 text-[9px] text-slate-400 uppercase tracking-tighter flex items-center justify-between hover:border-green-500/40 transition-colors">
                                          <span>LinkedIn Plays</span>
                                          <span className="text-slate-300 font-bold">Syncing...</span>
                                      </div>
                                      <div className="bg-green-950/30 rounded border border-green-800/60 p-2 text-[9px] text-green-400 font-bold uppercase tracking-widest text-center shadow-[0_0_10px_rgba(34,197,94,0.1)] hover:bg-green-900/40 transition-colors cursor-pointer flex items-center justify-center gap-2"><Send size={10} /> Sync GHL Matrix Data</div>
                                   </div>
                               </div>
                           </div>

                           <div className="bg-slate-900/20 border border-slate-800/40 rounded p-4 flex-1 flex flex-col min-h-0">
                               <p className="text-[10px] text-slate-400 uppercase font-bold tracking-widest mb-3 flex items-center justify-between">
                                  <span className="flex items-center gap-2"><Terminal size={12} /> Live Post-Production Stream</span>
                                  <span className="text-[8px] bg-slate-950 text-slate-500 px-2 rounded border border-slate-800 py-0.5 shadow-sm hidden sm:inline-block">GHL Listening Webhook Active</span>
                               </p>
                               <div className="bg-black/50 border border-slate-800/50 rounded flex-1 p-3 font-mono text-[9px] text-slate-500 space-y-2 overflow-y-auto overflow-x-hidden w-full">
                                   <p className="border-l-2 border-cyan-800 pl-2 text-cyan-500/90">[SYS] Claude Bot master control mapped to OpenClaw core.</p>
                                   <p className="border-l-2 border-purple-800 pl-2 text-purple-400">[SYS] AirLLM Stream Init: 70B Model Inference Online.</p>
                                   <p className="border-l-2 border-cyan-800 pl-2">[SYS] Obsidian daily briefing workflow pre-loaded.</p>
                                   <p className="border-l-2 border-cyan-800 pl-2">[SYS] HeyGen CLI and C-Dance environment authenticated seamlessly.</p>
                                   <p className="border-l-2 border-emerald-800 pl-2 text-emerald-500/90 font-bold">[NET] GHL Media API initialized for automated social uploads.</p>
                                   <p className="border-l-2 border-amber-800 pl-2 text-amber-500 animate-pulse mt-4">[IDLE] Waiting for deep UI prompt payload to ignite pipeline...</p>
                               </div>
                           </div>
                        </div>
                      )}
                      
                      {activeTab === 'IMAGES' && (
                        <div className="p-4 h-full overflow-y-auto flex flex-col gap-4 font-mono scrollbar-hide">
                           <div className="bg-slate-900/40 border border-slate-800 rounded p-4 flex flex-col sm:flex-row justify-between items-center sm:items-start shrink-0 gap-4">
                               <div className="flex items-center gap-4">
                                   <div className="w-12 h-12 rounded bg-fuchsia-950/50 border border-fuchsia-800 flex items-center justify-center shrink-0 shadow-[0_0_15px_rgba(217,70,239,0.2)]">
                                       <Crosshair size={24} className="text-fuchsia-400" />
                                   </div>
                                   <div>
                                       <h2 className="text-sm uppercase tracking-widest font-black text-slate-200">Picasso Multi-Modal Matrix</h2>
                                       <p className="text-[9px] text-fuchsia-500 uppercase tracking-widest mt-1 font-bold">Flux Core • Midjourney V6 • GHL Auto-Push</p>
                                   </div>
                               </div>
                           </div>

                           <div className="bg-slate-900/20 border border-slate-800/40 rounded p-4 flex-1 flex flex-col min-h-0">
                               <div className="flex flex-col gap-3 h-full">
                                   <p className="text-[10px] text-slate-400 uppercase font-bold tracking-widest flex items-center justify-between">
                                      <span className="flex items-center gap-2"><Terminal size={12} /> Master Graphic Prompt</span>
                                      <span className="text-[8px] bg-slate-950 text-slate-500 px-2 rounded border border-slate-800 py-0.5">Google Drive Sandbox Linked</span>
                                   </p>

                                   <textarea 
                                       className="w-full h-32 bg-slate-950/80 border border-slate-800 rounded p-3 text-[11px] text-slate-300 focus:outline-none focus:border-fuchsia-800 scrollbar-hide font-mono tracking-widest resize-none"
                                       placeholder="Enter graphic prompt here... (e.g. 'Stylized illustration of a diner scene, Wimper business owners discussing Section 125 tax loopholes')"
                                       value={imagePrompt}
                                       onChange={(e) => setImagePrompt(e.target.value)}
                                   />
                                   
                                   <div className="flex justify-between items-center mt-2">
                                       <p className="text-[9px] text-slate-500 animate-pulse">[IDLE] Picasso node awaiting input payload...</p>
                                       <button 
                                           onClick={() => setImagePrompt('')}
                                           className="px-6 py-2.5 bg-fuchsia-950/50 border border-fuchsia-700 hover:bg-fuchsia-900 transition-colors text-[10px] text-fuchsia-400 uppercase tracking-widest font-black rounded shadow-[0_0_10px_rgba(217,70,239,0.1)] flex items-center justify-center gap-2"
                                       >
                                           <Zap size={12} /> Render Graphix
                                       </button>
                                   </div>
                               </div>
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
                      <div className="flex flex-col gap-3 overflow-y-auto pr-1 flex-1 scrollbar-hide">
                        {localFalconLocations.map(loc => (
                         <div key={loc.id} className="bg-slate-950/40 border border-slate-800 rounded flex flex-col transition-all group overflow-hidden">
                           <div className="bg-slate-900 border-b border-slate-800 p-2 flex justify-between items-center">
                              <span className="text-[10px] font-bold uppercase text-slate-300 truncate tracking-widest">{loc.name}</span>
                              <div className="flex gap-2 shrink-0">
                                 <a href={loc.gmb} target="_blank" title="Google My Business" className="text-slate-500 hover:text-blue-400 transition-colors bg-slate-950 p-1 rounded border border-slate-700 hover:border-blue-500/50"><ExternalLink size={10} /></a>
                                 <button onClick={() => setActiveIframe(loc)} title="Local Falcon Map" className="text-slate-500 hover:text-cyan-400 transition-colors bg-slate-950 p-1 rounded border border-slate-700 hover:border-cyan-500/50"><Crosshair size={10} /></button>
                              </div>
                           </div>
                           <div className="flex divide-x divide-slate-800 bg-slate-900/40">
                              <div className="p-2 flex-1 text-center"><p className="text-[8px] text-slate-500 uppercase font-bold tracking-tighter mb-1">1 Mile</p><p className="text-[11px] font-black text-cyan-400">{loc.mile1}</p></div>
                              <div className="p-2 flex-1 text-center"><p className="text-[8px] text-slate-500 uppercase font-bold tracking-tighter mb-1">5 Mile</p><p className="text-[11px] font-black text-indigo-400">{loc.mile5}</p></div>
                              <div className="p-2 flex-1 text-center"><p className="text-[8px] text-slate-500 uppercase font-bold tracking-tighter mb-1">10 Mile</p><p className="text-[11px] font-black text-yellow-500">{loc.mile10}</p></div>
                           </div>
                           <div className="bg-slate-950 p-2 flex justify-between items-center border-t border-slate-800">
                               <span className="text-[8px] text-slate-500 uppercase font-bold flex items-center gap-1.5"><TrendingUp size={10} className="text-slate-600"/> 15-Day Tracker</span>
                               <span className="text-[9px] font-bold text-green-500 px-1.5 py-0.5 bg-green-950/30 rounded border border-green-900/50">{loc.trend}</span>
                           </div>
                         </div>
                       ))}
                     </div>
                  </section>
                </div>
              </div>
              
              <footer className="mt-4 p-3 md:p-2 border border-slate-800 bg-slate-900/20 rounded flex flex-col md:flex-row justify-between items-center text-[8px] text-slate-600 uppercase tracking-[0.2em] gap-2 flex-none">
                <div className="flex gap-6"><span>Instance: IRO_Node_X1</span><span>AirLLM Linked</span></div>
                <div className="flex gap-4 items-center tracking-tighter">
                  <span className="flex items-center gap-2 font-bold text-yellow-500 animate-[pulse_2s_ease-in-out_infinite] bg-yellow-950/40 px-3 py-1 rounded border border-yellow-900/50">
                     <span className="w-1.5 h-1.5 rounded-full bg-yellow-400 shadow-[0_0_5px_yellow]"></span> OpenClaw Compute Active (Thinking... Check back in 10-15m)
                  </span>
                  <span className="text-cyan-600 font-bold border-l border-slate-800 pl-4 uppercase">Ver 2.5.5_Media_Core</span>
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

              {/* NIGHT PROTOCOL MODAL */}
              {isNightProtocolModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 lg:p-12 animate-in fade-in duration-200">
                  <div className="bg-slate-900 border border-slate-700 rounded-lg shadow-[0_0_40px_rgba(0,0,0,0.5)] w-full h-full max-w-7xl flex flex-col overflow-hidden relative">
                     <div className="p-4 border-b border-slate-800 flex items-center justify-between bg-slate-950/50">
                         <p className="text-xs text-yellow-500 uppercase font-bold tracking-widest flex items-center gap-2">
                            <Zap size={14} /> Night Protocol Execution Log <span className="text-[9px] text-slate-500 ml-2 border border-slate-800 px-2 py-0.5 rounded">Live Viewer</span>
                         </p>
                         <button onClick={() => setIsNightProtocolModalOpen(false)} className="text-slate-500 hover:text-white transition-colors bg-slate-800 hover:bg-slate-700 p-1.5 rounded-full">
                            <Crosshair size={14} className="rotate-45" />
                         </button>
                     </div>
                     <div className="flex-1 bg-slate-950 relative w-full h-full overflow-y-auto p-4 lg:p-6 flex flex-col gap-6 scrollbar-hide">
                        <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            {[
                               { label: 'Total Clicks', val: '12.4K', color: 'text-cyan-400', border: 'border-cyan-900/40' },
                               { label: 'Total Impressions', val: '148.2K', color: 'text-purple-400', border: 'border-purple-900/40' },
                               { label: 'Average CTR', val: '8.4%', color: 'text-emerald-400', border: 'border-emerald-900/40' },
                               { label: 'Average Position', val: '14.2', color: 'text-yellow-400', border: 'border-yellow-900/40' }
                            ].map((stat, i) => (
                               <div key={i} className={`bg-slate-900 border ${stat.border} rounded p-4 flex flex-col justify-center items-center shadow-lg transition-transform hover:-translate-y-1`}>
                                  <p className="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2 text-center">{stat.label}</p>
                                  <p className={`text-2xl sm:text-3xl font-black ${stat.color} drop-shadow-md`}>{stat.val}</p>
                               </div>
                            ))}
                        </div>
                        
                        <div className="bg-slate-900 border border-slate-800 rounded flex-1 overflow-hidden flex flex-col shadow-lg">
                           <div className="border-b border-slate-800 p-4 bg-slate-950 flex justify-between items-center">
                               <h4 className="text-[10px] text-slate-400 uppercase tracking-widest font-bold flex items-center gap-2"><Search size={14} className="text-cyan-600" /> Top Search Queries (Night Protocol Filtered)</h4>
                               <span className="text-[8px] bg-slate-800 text-slate-400 px-2 rounded border border-slate-700">Last 28 Days</span>
                           </div>
                           <div className="overflow-x-auto">
                               <table className="w-full text-left text-[10px] flex-1">
                                  <thead className="bg-slate-800/50 text-slate-500 uppercase">
                                      <tr>
                                          <th className="p-4 font-bold pl-6">Query</th>
                                          <th className="p-4 font-bold text-center">Clicks</th>
                                          <th className="p-4 font-bold text-center">Impressions</th>
                                          <th className="p-4 font-bold text-center">Position</th>
                                      </tr>
                                  </thead>
                                  <tbody className="text-slate-300 divide-y divide-slate-800/50 font-mono">
                                      {[
                                        { q: 'Section 125 Tax Free Childcare', c: '1,204', i: '14,020', p: '2.1' },
                                        { q: 'Wimper Strategy FICA Savings', c: '840', i: '10,100', p: '1.4' },
                                        { q: 'Hampton child care near me', c: '650', i: '8,400', p: '3.8' },
                                        { q: 'Best daycare college park ga', c: '420', i: '5,200', p: '4.2' },
                                        { q: 'How to pay for daycare tax free', c: '310', i: '12,500', p: '10.5' },
                                        { q: 'Childcare tax credit 2026', c: '280', i: '15,600', p: '12.8' },
                                        { q: 'Top rated pre k memphis tn', c: '195', i: '3,200', p: '5.0' },
                                        { q: 'Kidazzle early learning center', c: '1,500', i: '4,100', p: '1.1' },
                                      ].map((row, i) => (
                                          <tr key={i} className="hover:bg-slate-800/30 transition-colors">
                                              <td className="p-4 pl-6 text-cyan-400 font-bold">{row.q}</td>
                                              <td className="p-4 text-center text-slate-200">{row.c}</td>
                                              <td className="p-4 text-center text-slate-400">{row.i}</td>
                                              <td className="p-4 text-center font-bold text-yellow-500">{row.p}</td>
                                          </tr>
                                      ))}
                                  </tbody>
                               </table>
                           </div>
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
