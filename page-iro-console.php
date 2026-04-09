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
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
        body { margin: 0; background-color: #07090F; color: #E2E8F0; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #2D3142; border-radius: 20px; }
    </style>
</head>
<body>
    <div id="iro-root"></div>
    <script type="text/babel">
        const { useState, useEffect, useRef } = React;

        const icons = {
            Terminal: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>,
            Cpu: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>,
            Refresh: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>,
            Target: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>,
            Users: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>,
            BarChart: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>,
            FileText: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>,
            Image: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>,
            Link: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>,
            Send: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>,
            Mic: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="22"></line></svg>,
            Github: ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
        };

        const IROConsole = () => {
          const [activeTab, setActiveTab] = useState('chat');
          const [githubUrl, setGithubUrl] = useState('');
          const [chatInput, setChatInput] = useState('');
          const [docLink, setDocLink] = useState('');
          const [isListening, setIsListening] = useState(false);
          const [chatHistory, setChatHistory] = useState([
            { sender: 'IRO', msg: 'Console initialized online. Agent fleet active and awaiting dispatch.' }
          ]);
          const [lessonStatus, setLessonStatus] = useState(null);
          const [pendingErrors, setPendingErrors] = useState([]);
          const [antiGravityCmds, setAntiGravityCmds] = useState([]);
          const [seoData, setSeoData] = useState(null);
          const [atlasIframe, setAtlasIframe] = useState(null);
          const [auditInput, setAuditInput] = useState('');
          const messagesEndRef = useRef(null);

          useEffect(() => {
              messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
          }, [chatHistory]);

          useEffect(() => {
              const fetchData = async () => {
                  try {
                      // Fetch Telemetry from N8N webhook
                      const res = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/lesson-plan-status').catch(() => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         setLessonStatus(data);
                      }
                      
                      const errRes = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/errors').catch(() => null);
                      if (errRes && errRes.ok) {
                          const data = await errRes.json();
                          setPendingErrors(Array.isArray(data) ? data : []);
                      }

                      const agRes = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/ag-status').catch(() => null);
                      if (agRes && agRes.ok) {
                          const data = await agRes.json();
                          setAntiGravityCmds(data.commands || []);
                      }
                  } catch(e) {}
              };

              fetchData();
              const intv = setInterval(fetchData, 5000);
              return () => clearInterval(intv);
          }, []);

          const handleSendChat = async () => {
             const txt = chatInput;
             if (!txt.trim()) return;
             setChatHistory(prev => [...prev, { sender: 'You', msg: txt }]);
             setChatInput('');
             
             try {
                const res = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/chat', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ message: txt })
                });
                const data = await res.json();
                setChatHistory(prev => [...prev, { sender: 'IRO', msg: data.reply || '[Network Error]' }]);
                
                if ('speechSynthesis' in window) {
                   const utterance = new SpeechSynthesisUtterance(data.reply);
                   utterance.pitch = 0.9;
                   utterance.rate = 1.05;
                   window.speechSynthesis.speak(utterance);
                }
             } catch (e) {
                setChatHistory(prev => [...prev, { sender: 'IRO', msg: '[System offline or Cloudflare tunnel broken]' }]);
             }
          };

          const handleRunAudit = () => {
             if(!auditInput.trim()) return;
             setAtlasIframe(`https://searchatlas.com/local-audit/custom?q=${encodeURIComponent(auditInput)}`);
             setAuditInput('');
          };

          return (
            <div className="min-h-screen bg-cyber-dark text-[#E2E8F0] p-6 font-mono tracking-tight selection:bg-cyber-cyan/30">
              
              {/* Header */}
              <header className="flex items-center justify-between border-b border-cyber-cyan/20 pb-4 mb-6">
                <div className="flex items-center space-x-3">
                  <icons.Terminal className="text-cyber-cyan w-6 h-6 animate-pulse" />
                  <h1 className="text-2xl font-bold tracking-widest text-cyber-cyan">IRO_CONSOLE 5.7</h1>
                </div>
                
                {/* Embedded GitHub Repo Linker */}
                <div className="flex-grow max-w-xl mx-8 hidden lg:flex space-x-2">
                    <div className="flex-grow bg-cyber-panel border border-cyber-border rounded flex items-center px-3">
                      <icons.Github className="w-4 h-4 text-cyber-gray mr-2" />
                      <input 
                        type="text" 
                        value={githubUrl}
                        onChange={(e) => setGithubUrl(e.target.value)}
                        placeholder="Paste Repo URL to Tie Directly Into IRO Chat..." 
                        className="bg-transparent border-none outline-none w-full text-sm py-2 text-[#E2E8F0] placeholder-cyber-gray"
                      />
                    </div>
                    <button className="bg-cyber-cyan text-cyber-subpanel font-bold px-4 rounded hover:bg-white text-xs">SYNC AGENT</button>
                </div>

                <div className="flex items-center space-x-2 bg-[#052E20] text-cyber-green px-3 py-1 rounded-sm border border-cyber-green/30 text-xs">
                  <span className="w-2 h-2 rounded-full bg-cyber-green animate-pulse"></span>
                  <span>SYSTEM SECURE</span>
                </div>
              </header>

              <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {/* Left Column (Agents & Errors) */}
                <div className="lg:col-span-3 space-y-6">
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 flex flex-col shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <icons.Cpu className="w-4 h-4 mr-2" /> AGENTS
                    </h2>
                    <div className="space-y-4">
                      {[
                        { name: 'IRO', status: 'ONLINE & LISTENING', color: 'text-cyber-green' },
                        { name: 'MASTERCHEF', status: 'AWAITING TASK', color: 'text-cyber-orange' },
                        { name: 'VOLT', status: 'WHATSAPP SYNCED', color: 'text-cyber-gray' },
                        { name: 'PICASSO', status: 'STNDBY_MODE', color: 'text-cyber-gray' }
                      ].map(agent => (
                        <div key={agent.name} className="flex justify-between items-center p-3 bg-cyber-subpanel rounded border border-cyber-border hover:border-cyber-cyan/30 transition-colors cursor-pointer">
                          <span className="font-bold text-sm">{agent.name}</span>
                          <span className={`text-[10px] ${agent.color} flex items-center`}><icons.Refresh className="w-3 h-3 mr-1"/> {agent.status}</span>
                        </div>
                      ))}
                    </div>
                  </div>

                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 flex flex-col shadow-lg mt-6">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <icons.FileText className="w-4 h-4 mr-2" /> DOCS & EXPORTS (VAULT)
                    </h2>
                    <div className="space-y-2">
                       <div className="flex justify-between items-center p-2 bg-cyber-subpanel border border-cyber-border rounded">
                          <span className="text-xs text-cyber-cyan flex items-center"><icons.Link className="w-3 h-3 mr-1"/> Kidazzle_Brand_Guide.pdf</span>
                          <button className="text-[10px] bg-cyber-highlight px-2 py-1 rounded hover:text-white">DL</button>
                       </div>
                    </div>
                  </div>
                </div>

                {/* Center Column (Chat & Dashboards) */}
                <div className="lg:col-span-6 flex flex-col space-y-6">
                  
                  {/* Chat Top Nav Tabs */}
                  <div className="flex space-x-1 border-b border-cyber-border">
                      <button onClick={() => setActiveTab('chat')} className={`px-4 py-2 text-xs font-bold ${activeTab === 'chat' ? 'text-cyber-cyan border-b-2 border-cyber-cyan' : 'text-cyber-gray'}`}>INTERACTIVE CONVERSATION</button>
                      <button onClick={() => setActiveTab('kidazzle')} className={`px-4 py-2 text-xs font-bold ${activeTab === 'kidazzle' ? 'text-cyber-cyan border-b-2 border-cyber-cyan' : 'text-cyber-gray'}`}>KIDAZZLE DA PIPELINE</button>
                      <button onClick={() => setActiveTab('wimper')} className={`px-4 py-2 text-xs font-bold ${activeTab === 'wimper' ? 'text-cyber-cyan border-b-2 border-cyber-cyan' : 'text-cyber-gray'}`}>WIMPER B2B</button>
                      <button onClick={() => setActiveTab('notes')} className={`px-4 py-2 text-xs font-bold ${activeTab === 'notes' ? 'text-cyber-cyan border-b-2 border-cyber-cyan' : 'text-cyber-gray'}`}>NOTES & GITHUB</button>
                  </div>

                  <div className="bg-cyber-panel border border-cyber-border flex-grow rounded-md shadow-lg flex flex-col min-h-[400px]">
                      
                      {/* CHAT TAB */}
                      {activeTab === 'chat' && (
                        <div className="flex flex-col flex-grow p-4 bg-cyber-subpanel">
                          <div className="flex-1 min-h-0 overflow-y-auto space-y-4 mb-4 custom-scrollbar pr-2">
                            {chatHistory.map((chat, idx) => (
                              <div key={idx} className={`flex ${chat.sender === 'You' ? 'justify-end' : 'justify-start'}`}>
                                <div className={`p-3 rounded-lg max-w-[80%] ${chat.sender === 'You' ? 'bg-cyber-highlight border border-cyber-border' : 'bg-cyber-cyan/10 border border-cyber-cyan/30'}`}>
                                  <span className="text-xs font-bold block mb-1" style={{ color: chat.sender === 'You' ? '#8E8E93' : '#00F0FF' }}>{chat.sender}</span>
                                  <p className="text-sm break-words">{chat.msg}</p>
                                </div>
                              </div>
                            ))}
                            <div ref={messagesEndRef} />
                          </div>
                          <div className="pt-3 border-t border-cyber-border space-y-3">
                            <div className="flex space-x-2">
                                <button className="bg-cyber-highlight border border-cyber-border px-3 rounded text-cyber-gray hover:text-white"><icons.FileText className="w-4 h-4" /></button>
                                <input 
                                  type="text" 
                                  value={chatInput}
                                  onChange={(e) => setChatInput(e.target.value)}
                                  onKeyDown={(e) => e.key === 'Enter' && handleSendChat()}
                                  placeholder="Talk to IRO..." 
                                  className="flex-grow bg-cyber-panel border border-cyber-border rounded px-4 py-3 text-sm focus:outline-none focus:border-cyber-cyan/50"
                                />
                                <button className="bg-cyber-pink px-4 py-2 rounded text-white flex items-center justify-center"><icons.Mic className="w-4 h-4" /></button>
                                <button onClick={handleSendChat} className="bg-cyber-cyan text-cyber-subpanel font-bold px-6 rounded hover:bg-white text-sm">EXECUTE</button>
                            </div>
                          </div>
                        </div>
                      )}

                      {/* KIDAZZLE DA TAB */}
                      {activeTab === 'kidazzle' && (
                        <div className="p-4 bg-cyber-subpanel flex-grow space-y-4">
                           <h3 className="text-sm font-bold text-cyber-cyan mb-4">DA TAG PIPELINE & N8N AUTOMATION</h3>
                           <div className="grid grid-cols-4 gap-2">
                               {['Hampton', 'West End', 'College Park', 'Summit', 'Memphis', 'Miami', 'AFC', 'CP Infant'].map(loc => (
                                 <div key={loc} className="p-3 bg-cyber-highlight border border-cyber-border rounded text-center">
                                    <span className="text-xs text-white block truncate">{loc}</span>
                                    <span className="text-[10px] text-cyber-gray mt-1 block">Awaiting DA Tag</span>
                                 </div>
                               ))}
                           </div>
                           
                           {/* Lesson Plan Automation Feed updated! */}
                           <div className="mt-8 border-t border-cyber-border pt-4">
                              <h3 className="text-sm font-bold text-cyber-gray mb-3 flex items-center"><icons.FileText className="w-4 h-4 mr-2" /> PROCESSED LESSON PLANS (N8N FEED)</h3>
                              {lessonStatus ? (
                                  <div className="flex justify-between items-center bg-[#052E20] border border-cyber-green p-3 rounded">
                                     <span className="text-sm font-bold text-white">{lessonStatus.location || 'Routing...'}</span>
                                     <span className="text-xs text-cyber-green">{lessonStatus.status || 'Active'} - Week: {lessonStatus.week || 'N/A'}</span>
                                  </div>
                              ) : (
                                  <div className="text-xs text-cyber-pink bg-cyber-pink/10 border border-cyber-pink p-3 rounded">
                                     AWAITING PAYLOAD FROM N8N WEBHOOK
                                  </div>
                              )}
                           </div>
                        </div>
                      )}

                      {/* WIMPER B2B TAB */}
                      {activeTab === 'wimper' && (
                        <div className="p-4 bg-cyber-subpanel flex-grow space-y-4">
                           <h3 className="text-sm font-bold text-cyber-cyan mb-4">WIMPER PIPELINE</h3>
                           <div className="p-4 border border-cyber-border rounded bg-cyber-highlight">
                              <span className="text-xs text-cyber-gray block mb-1">Cold Email Campaign</span>
                              <span className="text-lg font-bold text-white">Active</span>
                           </div>
                        </div>
                      )}

                      {/* NOTES TAB */}
                      {activeTab === 'notes' && (
                        <div className="p-4 bg-cyber-subpanel flex-grow space-y-4">
                           <h3 className="text-sm font-bold text-cyber-cyan mb-4">SYSTEM NOTES & REPOSITORIES</h3>
                           <div className="text-xs text-cyber-gray">Ready to document next sprint updates...</div>
                        </div>
                      )}
                  </div>
                </div>

                {/* Right Column (CPU, Dynamic Search Atlas) */}
                <div className="lg:col-span-3 space-y-6">
                  
                  {/* CPU/RAM Block */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 flex flex-col shadow-lg items-center justify-center">
                     <span className="text-xs font-bold text-cyber-gray mb-4 self-start">SYSTEM VITALS</span>
                     <div className="w-32 h-32 rounded-full border-4 border-cyber-cyan/20 flex flex-col items-center justify-center relative">
                        <div className="absolute inset-0 border-4 border-cyber-cyan rounded-full" style={{clipPath: 'polygon(0 0, 100% 0, 100% 15%, 0 15%)'}}></div>
                        <span className="text-2xl font-bold text-white">14%</span>
                        <span className="text-[10px] text-cyber-gray">CPU CORE</span>
                     </div>
                     <div className="w-full flex justify-between mt-6 text-xs border-t border-cyber-border pt-4">
                        <span className="text-cyber-green flex items-center"><span className="w-2 h-2 rounded-full bg-cyber-green mr-2"></span>OS C: (INTERNAL)</span>
                        <span className="text-cyber-cyan flex items-center"><span className="w-2 h-2 rounded-full bg-cyber-cyan mr-2"></span>DATA D: (PASSPORT)</span>
                     </div>
                  </div>

                  {/* Dynamic GMB Audit */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 flex flex-col shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4">SEO COMMAND CENTER</h2>
                    <div className="flex flex-col space-y-3">
                      <input 
                         type="text" 
                         value={auditInput}
                         onChange={(e) => setAuditInput(e.target.value)}
                         placeholder="Paste GMB URL or Name..." 
                         className="bg-cyber-subpanel border border-cyber-border rounded px-3 py-2 text-xs text-white outline-none"
                      />
                      <button onClick={handleRunAudit} className="bg-cyber-cyan text-cyber-subpanel font-bold py-2 rounded text-xs">AUDIT GBP</button>
                    </div>

                    <div className="mt-4 border-t border-cyber-border pt-4">
                        <span className="text-[10px] text-cyber-gray block mb-2">GBP RANK (5 MILE)</span>
                        <div className="grid grid-cols-2 gap-2">
                           {['Hampton', 'West End', 'Coll. PK', 'Summit', 'ATL Federal', 'Memphis', 'Miami', 'Corporate'].map(loc => (
                             <div key={loc} className="p-2 bg-cyber-subpanel border border-cyber-border rounded">
                                <span className="text-[10px] text-[#E2E8F0] block truncate">{loc}</span>
                                <span className={loc === 'Corporate' ? "text-[8px] text-cyber-orange" : "text-[8px] text-cyber-green"}>
                                   {loc === 'Corporate' ? 'AWAITING' : 'LIVE: ONLINE'}
                                </span>
                             </div>
                           ))}
                        </div>
                    </div>
                  </div>

                  {/* Anti-Gravity Terminal Relay */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-cyan mb-3 flex items-center">
                      <icons.Terminal className="w-4 h-4 mr-2" /> ANTI-GRAVITY BRIDGE
                    </h2>
                    <div className="text-xs text-cyber-gray p-3 border border-cyber-border border-dashed rounded bg-cyber-subpanel">
                       Awaiting your explicit approval to execute commands.
                    </div>
                  </div>

                </div>
              </div>
              
              {/* iFrame Logic */}
              {atlasIframe && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm">
                   <div className="bg-cyber-panel border border-cyber-cyan w-full max-w-5xl h-[80vh] flex flex-col p-4 relative">
                      <button onClick={() => setAtlasIframe(null)} className="absolute top-4 right-4 text-cyber-pink font-bold border border-cyber-pink px-3 py-1 rounded text-xs">&times; CLOSE</button>
                      <iframe src={atlasIframe} className="w-full h-full border-none"></iframe>
                   </div>
                </div>
              )}

            </div>
          );
        };

        const root = ReactDOM.createRoot(document.getElementById('iro-root'));
        root.render(<IROConsole />);
    </script>
</body>
</html>
