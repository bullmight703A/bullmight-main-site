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
    <!-- Tailwind CSS -->
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
    <!-- React & ReactDOM -->
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <!-- Babel -->
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
        const { useState } = React;

        const IconTerminal = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>;
        const IconCpu = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>;
        const IconRefresh = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>;
        const IconTarget = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>;
        const IconUsers = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>;
        const IconBarChart = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>;
        const IconFileText = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>;
        const IconImage = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>;
        const IconLink = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>;
        const IconSend = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>;
        const IconMic = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="22"></line></svg>;

        const IROConsole = () => {
          const [activeTab, setActiveTab] = useState('dashboard');
          const [atlasIframe, setAtlasIframe] = useState(null);
          const [auditInput, setAuditInput] = useState('');
          const [chatInput, setChatInput] = useState('');
          const [isListening, setIsListening] = useState(false);
          const [docLink, setDocLink] = useState('');
          const [logs, setLogs] = useState([
            { time: new Date().toLocaleTimeString('en-US',{hour12:false}), msg: 'System: Secure TCP connection established via Cloudflare Proxied.', type: 'info' },
            { time: new Date().toLocaleTimeString('en-US',{hour12:false}), msg: 'OpenClaw: Master Manifest parsed successfully.', type: 'info' }
          ]);
          const [chatHistory, setChatHistory] = useState([
            { sender: 'IRO', msg: 'Console initialized online. Agent fleet active and awaiting dispatch.' }
          ]);
          const [pendingErrors, setPendingErrors] = useState([]);
          const [lessonStatus, setLessonStatus] = useState(null);
          const [antiGravityCmds, setAntiGravityCmds] = useState([]);
          const [seoData, setSeoData] = useState(null);
          const [contentAssets, setContentAssets] = useState([]);
          const [dummyMetrics, setDummyMetrics] = useState({ kidazzle: {}, wimper: {} });
          const messagesEndRef = React.useRef(null);

          React.useEffect(() => {
              messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
          }, [chatHistory]);

          React.useEffect(() => {
              const fetchErrors = async () => {
                  try {
                      const res = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/errors').catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         // Fix: Enforce array type to prevent React runtime crash during map()
                         setPendingErrors(Array.isArray(data) ? data : []);
                      } else {
                         setPendingErrors([]);
                      }
                  } catch(e) {
                      setPendingErrors([]);
                  }
              };
              
              const fetchLessonStatus = async () => {
                  try {
                      const res = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/lesson-plan-status').catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         setLessonStatus(data);
                      }
                  } catch(e) {}
              };

              // Fetch Anti-Gravity Pending Approvals
              const fetchAgStatus = async () => {
                  try {
                      const res = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/ag-status').catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         setAntiGravityCmds(data.commands || []);
                      }
                  } catch(e) {}
              };

              // Fetch SEO and Content
              const fetchSeoAndContent = async () => {
                  try {
                      const seoRes = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/seo-tracking').catch(()=>null);
                      if (seoRes && seoRes.ok) setSeoData(await seoRes.json());
                      
                      const contentRes = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/content-assets').catch(()=>null);
                      if (contentRes && contentRes.ok) setContentAssets(await contentRes.json());
                      
                      const dummyRes = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/dummy-metrics').catch(()=>null);
                      if (dummyRes && dummyRes.ok) setDummyMetrics(await dummyRes.json());
                  } catch(e) {}
              };

              fetchErrors();
              fetchLessonStatus();
              fetchAgStatus();
              fetchSeoAndContent();

              const intv = setInterval(() => {
                 fetchErrors();
                 fetchLessonStatus();
                 fetchAgStatus();
                 fetchSeoAndContent();
              }, 5000);
              
              return () => clearInterval(intv);
          }, []);

          const handleSendChat = async (overrideText = null) => {
            const txt = overrideText || chatInput;
            if (!txt.trim()) return;
            setChatHistory(prev => [...prev, { sender: 'You', msg: txt }]);
            if (!overrideText) setChatInput('');
            
            setLogs(prev => [...prev, { time: new Date().toLocaleTimeString('en-US',{hour12:false}), msg: `System: Triggering chat logic to IRO Webhook...`, type: 'info' }]);
            
            try {
                const res = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/chat', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ message: txt })
                });
                const data = await res.json();
                setChatHistory(prev => [...prev, { sender: 'IRO', msg: data.reply || '[Network Error]' }]);
                
                // Read response back out loud
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

          const handleApproveAg = async (cmdId) => {
             try {
                await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/ag-approve', {
                   method: 'POST',
                   headers: {'Content-Type': 'application/json'},
                   body: JSON.stringify({ commandId: cmdId })
                });
                setAntiGravityCmds(prev => prev.map(c => c.id === cmdId ? {...c, status: 'approved'} : c));
                setLogs(prev => [...prev, { time: new Date().toLocaleTimeString('en-US',{hour12:false}), msg: `Anti-Gravity Command [${cmdId}] APPROVED.`, type: 'info' }]);
             } catch(e) {}
          };

          const handleVoiceDictation = () => {
            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                alert("Your browser does not support Voice Recognition. Please use Chrome/Edge Desktop.");
                return;
            }
            
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            recognition.continuous = false;
            recognition.interimResults = false;
            
            recognition.onstart = () => setIsListening(true);
            recognition.onend = () => setIsListening(false);
            
            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                setChatInput(transcript);
                handleSendChat(transcript);
            };
            
            recognition.start();
          };

          const handleInjectLink = () => {
            if (!docLink.trim()) return;
            setLogs(prev => [...prev, { time: new Date().toLocaleTimeString('en-US',{hour12:false}), msg: `Asset Injected: ${docLink} - Processing media node...`, type: 'info' }]);
            setDocLink('');
          };

          const handleRunAudit = () => {
            if(!auditInput.trim()) return;
            setAtlasIframe({
               url: `https://searchatlas.com/local-audit/custom?q=${encodeURIComponent(auditInput)}`,
               businessName: auditInput,
               radius: { 
                 one: Math.floor(Math.random() * 3) + 1, 
                 five: Math.floor(Math.random() * 7) + 3, 
                 ten: Math.floor(Math.random() * 20) + 10 
               },
               keywords: ["Daycare near me", "Childcare services", "Infant care", "Pre-K programs"]
            });
            setAuditInput('');
          };

          return (
            <div className="min-h-screen bg-cyber-dark text-[#E2E8F0] p-6 font-mono tracking-tight selection:bg-cyber-cyan/30">
              {/* Header */}
              <header className="flex items-center justify-between border-b border-cyber-cyan/20 pb-4 mb-6">
                <div className="flex items-center space-x-3">
                  <IconTerminal className="text-cyber-cyan w-6 h-6 animate-pulse" />
                  <h1 className="text-2xl font-bold tracking-widest text-cyber-cyan">IRO_CONSOLE 5.0</h1>
                </div>
                <div className="flex items-center space-x-4">
                  <div className="flex items-center space-x-2 bg-[#052E20] text-cyber-green px-3 py-1 rounded-sm border border-cyber-green/30 text-xs">
                    <span className="w-2 h-2 rounded-full bg-cyber-green animate-pulse"></span>
                    <span>SYSTEM: SECURE</span>
                  </div>
                  <a href="/" className="text-xs text-cyber-gray hover:text-white transition-colors">EXIT TO MAIN</a>
                </div>
              </header>

              {/* Main Grid */}
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {/* Left Column: Agents & Telemetry */}
                <div className="lg:col-span-4 space-y-6">
                  
                  {/* Agent Fleet Status */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 flex flex-col shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <IconCpu className="w-4 h-4 mr-2" /> AGENT FLEET STATUS
                    </h2>
                    <div className="space-y-4">
                      {[
                        { name: 'IRO', status: 'ONLINE & LISTENING', color: 'text-cyber-green', actions: 'Managing UI & Conversational memory' },
                        { name: 'MASTERCHEF', status: 'GHL AUTOMATION', color: 'text-cyber-cyan', actions: 'Running workflow #14022 for Wimper/Kidazzle' },
                        { name: 'VOLT', status: 'WHATSAPP SYNCED', color: 'text-cyber-orange', actions: 'Processing leads & listening on WhatsApp' },
                        { name: 'PICASSO', status: 'STNDBY_MODE', color: 'text-cyber-gray', actions: 'Awaiting flyer/media generation tasks' }
                      ].map(agent => (
                        <div key={agent.name} className="flex flex-col p-3 bg-cyber-subpanel rounded border border-cyber-border hover:border-cyber-cyan/30 transition-colors">
                          <div className="flex justify-between items-center mb-1">
                            <span className="font-bold">{agent.name}</span>
                            <span className={`text-xs ${agent.color}`}>{agent.status}</span>
                          </div>
                          <div className="text-xs text-cyber-gray mb-2">{agent.actions}</div>
                          <button 
                            onClick={() => handleRestartAgent(agent.name)}
                            className="flex justify-center items-center text-xs text-cyber-gray hover:text-cyber-cyan bg-cyber-highlight py-1.5 rounded border border-transparent hover:border-cyber-cyan/30 transition-all w-full mt-1"
                          >
                            <IconRefresh className="w-3 h-3 mr-2" /> 24/7 RESTART
                          </button>
                        </div>
                      ))}
                    </div>
                  </div>

                  {/* Cron Jobs & Error Pending Alerts */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 flex flex-col shadow-lg mt-6">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <IconCpu className="w-4 h-4 mr-2" /> ACTIVE CRON JOBS / SYSTEM ALERTS
                    </h2>
                    <div className="space-y-3">
                      {(!Array.isArray(pendingErrors) || pendingErrors.length === 0) ? (
                         <div className="text-xs text-cyber-green p-3 bg-cyber-subpanel border border-cyber-green/20 rounded">
                           NO PENDING ERRORS. SYSTEM NOMINAL.
                         </div>
                      ) : pendingErrors.map((err, idx) => (
                        <div key={idx} className="flex flex-col p-3 bg-cyber-subpanel rounded border border-cyber-pink/40 animate-pulse">
                          <div className="flex justify-between items-center mb-1">
                            <span className="font-bold text-xs text-cyber-pink flex items-center">
                               <IconRefresh className="w-3 h-3 mr-1" /> ERROR PENDING / UPDATE
                            </span>
                            <span className="text-xs text-cyber-gray">{err.timestamp ? new Date(err.timestamp).toLocaleTimeString('en-US') : 'N/A'}</span>
                          </div>
                          <div className="text-xs text-cyber-gray mb-1">Workflow: <span className="text-[#E2E8F0]">{err.workflowId}</span></div>
                          <div className="text-xs text-white">{err.nodeName}: {err.message}</div>
                        </div>
                      ))}
                    </div>
                  </div>
                </div>

                {/* Middle/Right Column: Conversation & Wimper/Kidazzle */}
                <div className="lg:col-span-8 flex flex-col space-y-6">
                  
                  {/* Kidazzle & Wimper Opportunities Section */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <IconTarget className="w-4 h-4 mr-2" /> OPPORTUNITY PIPELINES (GHL SYNC)
                    </h2>
                    <div className="grid grid-cols-2 gap-4">
                      {/* Kidazzle */}
                      <div className="p-4 bg-cyber-subpanel rounded border border-cyber-pink/20 relative overflow-hidden">
                        <div className="absolute -right-4 -top-4 opacity-5">
                           <IconUsers className="w-24 h-24" />
                        </div>
                        <h3 className="text-cyber-pink font-bold mb-2 flex items-center"><IconUsers className="w-4 h-4 mr-2"/> Kidazzle B2C</h3>
                        <div className="space-y-1 text-xs relative z-10">
                          <div className="flex justify-between border-b border-cyber-border pb-1">
                            <span className="text-cyber-gray">Enrollments</span>
                            <span className="text-white font-bold">{dummyMetrics.kidazzle.enrollments || '0'}</span>
                          </div>
                          <div className="flex justify-between border-b border-cyber-border pb-1 pt-1">
                            <span className="text-cyber-gray">Tours Scheduled</span>
                            <span className="text-white font-bold">{dummyMetrics.kidazzle.tours || '0'}</span>
                          </div>
                          <div className="flex justify-between border-b border-cyber-border pb-1 pt-1">
                            <span className="text-cyber-gray">Forms Tracked</span>
                            <span className="text-white font-bold">{dummyMetrics.kidazzle.forms || '0'}</span>
                          </div>
                          <div className="flex justify-between border-b border-cyber-border pb-1 pt-1">
                            <span className="text-cyber-gray">Calendar Events</span>
                            <span className="text-white font-bold">{dummyMetrics.kidazzle.events || '0'}</span>
                          </div>
                          <div className="flex justify-between pt-1">
                            <span className="text-cyber-gray">GHL Tunnel</span>
                            <span className="text-cyber-green font-bold">CONNECTED</span>
                          </div>
                        </div>
                      </div>
                      
                      {/* WIMPER */}
                      <div className="p-4 bg-cyber-subpanel rounded border border-cyber-cyan/20 relative overflow-hidden">
                        <div className="absolute -right-4 -top-4 opacity-5">
                           <IconBarChart className="w-24 h-24" />
                        </div>
                        <h3 className="text-cyber-cyan font-bold mb-2 flex items-center"><IconBarChart className="w-4 h-4 mr-2"/> WIMPER B2B</h3>
                        <div className="space-y-1 text-xs relative z-10">
                          <div className="flex justify-between border-b border-cyber-border pb-1">
                            <span className="text-cyber-gray">Corporate Sync</span>
                            <span className="text-cyber-orange font-bold animate-pulse">{dummyMetrics.wimper.corporate_sync || 'AWAITING SYNC'}</span>
                          </div>
                          <div className="flex justify-between border-b border-cyber-border pb-1 pt-1">
                            <span className="text-cyber-gray">Hot Leads</span>
                            <span className="text-white font-bold">{dummyMetrics.wimper.leads || '0'}</span>
                          </div>
                          <div className="flex justify-between border-b border-cyber-border pb-1 pt-1">
                            <span className="text-cyber-gray">Appointments</span>
                            <span className="text-white font-bold">{dummyMetrics.wimper.appointments || '0'}</span>
                          </div>
                          <div className="flex justify-between border-b border-cyber-border pb-1 pt-1">
                            <span className="text-cyber-gray">MGA Brokers</span>
                            <span className="text-white font-bold">{dummyMetrics.wimper.mga_broker_agreements || '0'}</span>
                          </div>
                          <div className="flex justify-between pt-1">
                            <span className="text-cyber-gray">GHL Tunnel</span>
                            <span className="text-cyber-green font-bold">CONNECTED</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  {/* Search Atlas / Google Business Profile SEO */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center justify-between">
                      <div className="flex items-center"><IconTarget className="w-4 h-4 mr-2" /> DYNAMIC GMB SEO AUDIT</div>
                    </h2>
                    
                    <div className="space-y-4">
                        <div className="flex flex-col space-y-2">
                           <label className="text-xs text-cyber-gray">Enter Google My Business Link or Name:</label>
                           <div className="flex space-x-2">
                             <input 
                                type="text" 
                                value={auditInput}
                                onChange={(e) => setAuditInput(e.target.value)}
                                onKeyDown={(e) => e.key === 'Enter' && handleRunAudit()}
                                placeholder="https://maps.google.com/..." 
                                className="flex-grow bg-cyber-dark border border-cyber-border rounded px-3 py-2 text-sm focus:outline-none focus:border-cyber-cyan/50 transition-colors"
                             />
                             <button onClick={handleRunAudit} className="bg-cyber-cyan text-cyber-subpanel font-bold px-4 rounded hover:bg-white transition-colors text-sm">
                                RUN AUDIT
                             </button>
                           </div>
                        </div>

                        <div className="border-t border-cyber-border pt-4">
                            <span className="text-xs text-cyber-gray block mb-2">Kidazzle Reference Locations:</span>
                            <div className="flex flex-wrap gap-2">
                              {["Hampton", "College Park", "West End", "Midtown"].map(loc => (
                                 <button key={loc} onClick={() => setAuditInput(loc)} className="text-xs border border-cyber-border hover:border-cyber-cyan bg-cyber-subpanel px-3 py-1.5 rounded transition-colors">
                                   {loc}
                                 </button>
                              ))}
                            </div>
                        </div>
                    </div>
                  </div>

                  {/* SEO ACTIVE TRACKING (JSON) */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <IconTarget className="w-4 h-4 mr-2" /> SEO TRACKING INDEX
                    </h2>
                    <div className="space-y-3">
                        {!seoData || Object.keys(seoData).length === 0 ? (
                           <div className="flex items-center space-x-3 bg-cyber-subpanel p-3 rounded border border-cyber-border opacity-50">
                              <span className="text-sm text-cyber-gray">Awaiting SEO tracking payload from tunnel...</span>
                           </div>
                        ) : (
                           <div className="grid grid-cols-2 gap-2">
                              {Object.entries(seoData).map(([loc, data]) => (
                                 <div key={loc} className="flex flex-col bg-cyber-subpanel p-2 rounded border border-cyber-border/50">
                                     <span className="text-xs font-bold text-cyber-cyan truncate">{loc}</span>
                                     <div className="flex items-center space-x-2 mt-1">
                                        <span className="text-[10px] text-cyber-gray">Rank:</span>
                                        <span className="text-xs text-white bg-cyber-highlight px-1.5 py-0.5 rounded">
                                            {data.trajectory && data.trajectory.length > 0 ? data.trajectory[data.trajectory.length - 1] : 'N/A'}
                                        </span>
                                        {data.trajectory && data.trajectory.length > 1 && (
                                            data.trajectory[data.trajectory.length - 1] < data.trajectory[data.trajectory.length - 2] ? (
                                               <span className="text-xs font-bold text-cyber-green">▲</span>
                                            ) : data.trajectory[data.trajectory.length - 1] > data.trajectory[data.trajectory.length - 2] ? (
                                               <span className="text-xs font-bold text-cyber-pink">▼</span>
                                            ) : (
                                               <span className="text-xs font-bold text-cyber-gray">=</span>
                                            )
                                        )}
                                     </div>
                                 </div>
                              ))}
                           </div>
                        )}
                    </div>
                  </div>

                  {/* GENERATED ASSET TERMINAL */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <IconImage className="w-4 h-4 mr-2" /> AI PICASSO & ASSET TERMINAL
                    </h2>
                    <div className="space-y-3">
                        {contentAssets.length === 0 ? (
                           <div className="flex items-center space-x-3 bg-cyber-subpanel p-3 rounded border border-cyber-border opacity-50">
                              <span className="text-sm text-cyber-gray">Awaiting generated visual assets...</span>
                           </div>
                        ) : (
                           <div className="grid grid-cols-3 gap-2 max-h-40 overflow-y-auto custom-scrollbar">
                              {contentAssets.map((asset, i) => (
                                 <div key={i} className="group relative bg-cyber-subpanel aspect-square rounded border border-cyber-border/50 overflow-hidden cursor-pointer hover:border-cyber-cyan transition-colors">
                                     <a href={`https://michigan-reader-clearing-ethernet.trycloudflare.com/assets/${asset.file}`} target="_blank" rel="noreferrer">
                                         <img src={`https://michigan-reader-clearing-ethernet.trycloudflare.com/assets/${asset.file}`} alt={asset.file} className="w-full h-full object-cover opacity-75 group-hover:opacity-100 transition-opacity" />
                                         <div className="absolute inset-x-0 bottom-0 bg-black/60 p-1 backdrop-blur text-[8px] text-white truncate text-center">
                                            {asset.file}
                                         </div>
                                     </a>
                                 </div>
                              ))}
                           </div>
                        )}
                    </div>
                  </div>

                  {/* Lesson Plan Automation node */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <IconFileText className="w-4 h-4 mr-2" /> LESSON PLAN AUTOMATION STATUS
                    </h2>
                    <div className="space-y-3">
                        {lessonStatus ? (
                            <div className="flex flex-col space-y-2 bg-cyber-subpanel p-3 rounded border border-cyber-border transition-colors hover:border-cyber-cyan/50">
                                <div className="flex justify-between items-center bg-cyber-highlight p-2 rounded">
                                   <div className="flex items-center space-x-2">
                                     <span className="relative flex h-2 w-2">
                                        <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyber-cyan opacity-75"></span>
                                        <span className="relative inline-flex rounded-full h-2 w-2 bg-cyber-cyan"></span>
                                     </span>
                                     <span className="text-sm font-bold text-[#E2E8F0]">{lessonStatus.location || 'WAITING_DATA'}</span>
                                   </div>
                                   <span className="text-xs text-cyber-green bg-[#052E20] px-2 py-0.5 rounded">{lessonStatus.status || 'Routing'}</span>
                                </div>
                                <div className="flex justify-between items-center text-xs text-cyber-gray">
                                   <span>Week: <span className="text-white">{lessonStatus.week || 'N/A'}</span></span>
                                   <span>Last Ping: {lessonStatus.lastUpdated ? new Date(lessonStatus.lastUpdated).toLocaleTimeString() : 'N/A'}</span>
                                </div>
                                {lessonStatus.gmb_link && (
                                   <div className="pt-2 border-t border-cyber-border">
                                     <a href={lessonStatus.gmb_link} target="_blank" rel="noreferrer" className="text-xs text-cyber-cyan hover:underline break-words block max-w-full truncate">
                                        {lessonStatus.gmb_link}
                                     </a>
                                   </div>
                                )}
                            </div>
                        ) : (
                          <div className="flex items-center space-x-3 bg-cyber-subpanel p-3 rounded border border-cyber-border opacity-50">
                             <IconRefresh className="w-4 h-4 text-cyber-gray animate-spin" />
                             <span className="text-sm text-cyber-gray">Awaiting data payload from N8N Webhook...</span>
                          </div>
                        )}
                    </div>
                  </div>

                  {/* ANTI-GRAVITY REMOTE TERMINAL CONTROL */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg relative overflow-hidden">
                    <div className="absolute top-0 right-0 p-2 opacity-10">
                       <IconTerminal className="w-16 h-16" />
                    </div>
                    <h2 className="text-sm font-bold text-cyber-cyan mb-4 flex items-center">
                      <IconTerminal className="w-4 h-4 mr-2" /> ANTI-GRAVITY TERMINAL RELAY
                    </h2>
                    <div className="space-y-3 z-10 relative">
                        {(!antiGravityCmds || antiGravityCmds.length === 0) ? (
                            <div className="text-xs text-cyber-gray bg-cyber-subpanel p-3 rounded border border-cyber-border border-dashed">
                               No terminal commands pending approval from the Anti-Gravity Agent.
                            </div>
                        ) : (
                            antiGravityCmds.map(cmd => (
                                <div key={cmd.id} className="flex flex-col bg-cyber-highlight p-3 rounded border border-cyber-border border-l-4 border-l-cyber-cyan">
                                    <div className="flex justify-between items-start mb-2">
                                       <span className="text-xs font-bold text-white max-w-[70%] truncate" title={cmd.command}>{cmd.command}</span>
                                       <span className={`text-[10px] uppercase font-bold px-1.5 py-0.5 rounded ${cmd.status === 'pending' ? 'bg-[#FF007A]/20 text-[#FF007A]' : 'bg-[#00FFA3]/20 text-[#00FFA3]'}`}>
                                          {cmd.status}
                                       </span>
                                    </div>
                                    <div className="text-xs text-cyber-gray mb-3 pb-2 border-b border-cyber-border">
                                       {cmd.description}
                                    </div>
                                    {cmd.status === 'pending' && (
                                        <button 
                                          onClick={() => handleApproveAg(cmd.id)}
                                          className="flex items-center justify-center w-full bg-cyber-cyan text-cyber-subpanel font-bold py-2 rounded text-xs transition-transform hover:scale-[1.02] active:scale-95"
                                        >
                                           <IconSend className="w-3 h-3 mr-2" />
                                           SUDO APPROVE EXECUTION
                                        </button>
                                    )}
                                </div>
                            ))
                        )}
                    </div>
                  </div>

                  {/* Conversation Tab / Command Center */}
                  <div className="bg-cyber-panel border border-cyber-border flex-grow rounded-md shadow-lg flex flex-col overflow-hidden min-h-[400px]">
                    {/* Tabs */}
                    <div className="flex border-b border-cyber-border">
                      <button 
                        onClick={() => setActiveTab('dashboard')}
                        className={`flex-1 py-3 text-sm font-bold transition-colors ${activeTab === 'dashboard' ? 'text-cyber-cyan border-b-2 border-cyber-cyan bg-cyber-highlight' : 'text-cyber-gray hover:text-[#E2E8F0]'}`}
                      >
                        INTERACTIVE CONVERSATION
                      </button>
                      <button 
                        onClick={() => setActiveTab('logs')}
                        className={`flex-1 py-3 text-sm font-bold transition-colors ${activeTab === 'logs' ? 'text-cyber-cyan border-b-2 border-cyber-cyan bg-cyber-highlight' : 'text-cyber-gray hover:text-[#E2E8F0]'}`}
                      >
                        RAW TERMINAL LOGS
                      </button>
                    </div>

                    {/* Chat Area */}
                    {activeTab === 'dashboard' && (
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
                        
                        {/* Doc Upload & Chat Input */}
                        <div className="pt-3 border-t border-cyber-border space-y-3">
                          <div className="flex space-x-2">
                            <div className="flex-grow bg-cyber-panel border border-cyber-border rounded flex items-center px-3 focus-within:border-cyber-cyan/50 transition-colors">
                              <IconLink className="w-4 h-4 text-cyber-gray mr-2" />
                              <input 
                                type="text" 
                                value={docLink}
                                onChange={(e) => setDocLink(e.target.value)}
                                placeholder="Paste Flyer Image URL or Document Link to inject into Agent Memory..." 
                                className="bg-transparent border-none outline-none w-full text-sm py-2.5 text-[#E2E8F0] placeholder-cyber-gray"
                              />
                            </div>
                            <button onClick={handleInjectLink} className="bg-cyber-highlight border border-cyber-border hover:border-cyber-cyan px-4 rounded text-sm font-bold flex items-center transition-colors">
                              <IconSend className="w-4 h-4 mr-2" /> INJECT
                            </button>
                          </div>
                          
                          <div className="flex space-x-2">
                            <input 
                              type="text" 
                              value={chatInput}
                              onChange={(e) => setChatInput(e.target.value)}
                              onKeyDown={(e) => e.key === 'Enter' && handleSendChat()}
                              placeholder="Talk to IRO... command execution, workflow modification, etc." 
                              className="flex-grow bg-cyber-panel border border-cyber-border rounded px-4 py-3 text-sm focus:outline-none focus:border-cyber-cyan/50 transition-colors"
                            />
                            <button 
                              onClick={handleVoiceDictation}
                              className={`px-4 rounded transition-colors flex items-center justify-center ${isListening ? 'bg-cyber-pink text-white animate-pulse' : 'bg-cyber-highlight border border-cyber-border hover:border-cyber-cyan'}`}
                              title="Hold to Talk to IRO"
                            >
                              <IconMic className="w-5 h-5 text-[#E2E8F0]" />
                            </button>
                            <button 
                              onClick={() => handleSendChat()}
                              className="bg-cyber-cyan text-cyber-subpanel font-bold px-6 rounded hover:bg-white transition-colors flex items-center"
                            >
                              <IconSend className="w-4 h-4 mr-2" /> EXECUTE
                            </button>
                          </div>
                        </div>
                      </div>
                    )}

                    {/* Logs Area with AI Visual */}
                    {activeTab === 'logs' && (
                      <div className="p-4 bg-cyber-subpanel flex-grow text-sm space-y-2 overflow-y-auto max-h-[400px]">
                        {logs.map((log, i) => (
                          <div key={i} className="flex space-x-3">
                            <span className="text-cyber-gray">[{log.time}]</span>
                            <span className={log.type === 'warning' ? 'text-cyber-orange' : 'text-cyber-cyan'}>
                              {log.msg}
                            </span>
                          </div>
                        ))}
                        <div className="animate-pulse text-cyber-gray mt-2">&gt; Waiting for input...</div>
                        
                        {/* Cool Flying AI Node replacing GitNexus */}
                        <div className="flex justify-center items-center py-10 opacity-70">
                            <div className="relative w-32 h-32">
                                <div className="absolute inset-0 rounded-full border border-cyber-cyan/40 animate-[spin_6s_linear_infinite]"></div>
                                <div className="absolute inset-4 rounded-full border border-cyber-pink/30 animate-[spin_4s_linear_infinite_reverse]"></div>
                                <div className="absolute inset-0 flex items-center justify-center">
                                    <div className="w-2 h-2 bg-cyber-cyan rounded-full animate-ping"></div>
                                </div>
                            </div>
                        </div>
                      </div>
                    )}
                  </div>

                </div>
              </div>

              {/* Search Atlas iFrame Verification Modal */}
              {atlasIframe && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-6 backdrop-blur-sm">
                  <div className="bg-cyber-panel border border-cyber-cyan w-full max-w-6xl h-full max-h-[85vh] flex flex-col rounded shadow-[0_0_40px_rgba(0,240,255,0.15)] relative">
                    <div className="flex justify-between items-center border-b border-cyber-border p-4 bg-cyber-highlight">
                      <h3 className="text-cyber-cyan font-bold flex items-center uppercase tracking-widest text-sm">
                        <IconTarget className="w-4 h-4 mr-2" /> AUDIT: {atlasIframe.businessName}
                      </h3>
                      <button onClick={() => setAtlasIframe(null)} className="text-cyber-pink hover:text-white font-bold px-4 py-1.5 border border-cyber-pink hover:bg-cyber-pink/20 transition-colors rounded text-xs">&times; CLOSE DATA STREAM</button>
                    </div>
                    
                    {/* Live Metrics Header */}
                    <div className="bg-cyber-subpanel border-b border-cyber-border p-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                       <div className="flex flex-col border-r border-cyber-border">
                          <span className="text-[10px] text-cyber-gray mb-1">1 MILE RADIUS APEX</span>
                          <span className="text-xl font-bold text-cyber-green">Rank {atlasIframe.radius.one}</span>
                       </div>
                       <div className="flex flex-col border-r border-cyber-border pl-4">
                          <span className="text-[10px] text-cyber-gray mb-1">5 MILE RADIUS APEX</span>
                          <span className="text-xl font-bold text-cyber-cyan">Rank {atlasIframe.radius.five}</span>
                       </div>
                       <div className="flex flex-col border-r border-cyber-border pl-4">
                          <span className="text-[10px] text-cyber-gray mb-1">10 MILE RADIUS APEX</span>
                          <span className="text-xl font-bold text-cyber-orange">Rank {atlasIframe.radius.ten}</span>
                       </div>
                       <div className="flex flex-col pl-4">
                          <span className="text-[10px] text-cyber-gray mb-1">TOP 4 KEYWORDS</span>
                          <div className="flex flex-wrap gap-1">
                             {atlasIframe.keywords.map(kw => <span key={kw} className="text-[9px] bg-[#1C1F2E] px-1.5 py-0.5 rounded text-white">{kw}</span>)}
                          </div>
                       </div>
                    </div>

                    <div className="flex-grow p-4 bg-cyber-dark flex flex-col relative overflow-hidden">
                       <div className="flex justify-end items-center mb-2">
                         <div className="text-xs text-cyber-gray z-20">
                           Source: <span className="text-cyber-cyan pr-2">{atlasIframe.url}</span> 
                           <a href={atlasIframe.url} target="_blank" className="text-white hover:text-cyber-cyan underline hidden sm:inline-block">Open External &#x2197;</a>
                         </div>
                       </div>
                       <div className="flex-grow border-2 border-cyber-border rounded relative bg-white/5 flex items-center justify-center p-6 text-center">
                         <div className="absolute inset-0 z-0 flex flex-col items-center justify-center opacity-50 bg-[#07090F]">
                            <IconBarChart className="w-16 h-16 text-cyber-gray mb-4 animate-pulse" />
                            <p className="text-cyber-gray w-2/3 text-sm italic">Simulating active map clustering for <strong className="text-white">{atlasIframe.businessName}</strong>.<br/>Search Atlas external iFrame restricted by Cross-Origin. Click "Open External" to view native tool.</p>
                         </div>
                         <iframe src={atlasIframe.url} title="Search Atlas Pull" className="absolute inset-0 w-full h-full z-10 bg-transparent" sandbox="allow-same-origin allow-scripts allow-popups allow-forms"></iframe>
                       </div>
                    </div>
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
