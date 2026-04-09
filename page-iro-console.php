<?php
/**
 * Template Name: IRO Mission Control Hybrid
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
        const { useState, useEffect, useRef } = React;

        const IconTerminal = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>;
        const IconCpu = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>;
        const IconRefresh = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>;
        const IconTarget = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>;
        const IconUsers = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>;
        const IconBarChart = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>;
        const IconFileText = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>;
        const IconImage = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>;
        const IconSend = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>;
        const IconMic = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="22"></line></svg>;

        const IROConsole = () => {
          const [chatInput, setChatInput] = useState('');
          const [chatHistory, setChatHistory] = useState([{ sender: 'IRO', msg: 'Hybrid Layout Initialized. Telemetry Sync Active.' }]);
          const [lessonStatus, setLessonStatus] = useState(null);
          const [dummyMetrics, setDummyMetrics] = useState({ kidazzle: {}, wimper: {} });
          const messagesEndRef = useRef(null);

          useEffect(() => {
              messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
          }, [chatHistory]);

          useEffect(() => {
              const fetchLessonStatus = async () => {
                  try {
                      // Attempting to hit the CF tunnel for telemetry
                      const res = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/lesson-plan-status').catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         setLessonStatus(data);
                      }
                  } catch(e) {}
              };

              const fetchSeoAndContent = async () => {
                  try {
                      const dummyRes = await fetch('https://michigan-reader-clearing-ethernet.trycloudflare.com/api/dummy-metrics').catch(()=>null);
                      if (dummyRes && dummyRes.ok) setDummyMetrics(await dummyRes.json());
                  } catch(e) {}
              };

              fetchLessonStatus();
              fetchSeoAndContent();

              const intv = setInterval(() => {
                 fetchLessonStatus();
                 fetchSeoAndContent();
              }, 5000);
              return () => clearInterval(intv);
          }, []);

          const handleSendChat = async () => {
            if (!chatInput.trim()) return;
            setChatHistory(prev => [...prev, { sender: 'You', msg: chatInput }]);
            setChatInput('');
          };

          return (
            <div className="min-h-screen bg-cyber-dark text-[#E2E8F0] p-4 font-mono tracking-tight">
              {/* Header */}
              <header className="flex items-center justify-between border-b border-cyber-cyan/20 pb-4 mb-4">
                <div className="flex items-center space-x-3">
                  <IconTerminal className="text-cyber-cyan w-6 h-6 animate-pulse" />
                  <h1 className="text-2xl font-bold tracking-widest text-cyber-cyan">IRO_CONSOLE (HYBRID 3-COLUMN)</h1>
                </div>
                <div className="flex items-center bg-[#052E20] text-cyber-green px-3 py-1 rounded-sm border border-cyber-green/30 text-xs">
                  <span className="w-2 h-2 rounded-full bg-cyber-green animate-pulse mr-2"></span>
                  SYSTEM SECURE
                </div>
              </header>

              {/* PERFECT 3-COLUMN LAYOUT */}
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {/* COLUMN 1: KIDAZZLE & AGENTS (Small Left) */}
                <div className="lg:col-span-3 space-y-4">
                   <div className="p-4 bg-cyber-subpanel rounded border border-cyber-pink/20">
                      <h3 className="text-cyber-pink font-bold mb-3 flex items-center"><IconUsers className="w-4 h-4 mr-2"/> Kidazzle B2C</h3>
                      <div className="space-y-2 text-xs">
                        <div className="flex justify-between border-b border-cyber-border pb-1">
                          <span className="text-cyber-gray">Enrollments</span>
                          <span className="text-white font-bold">{dummyMetrics.kidazzle.enrollments || '0'}</span>
                        </div>
                        <div className="flex justify-between border-b border-cyber-border pb-1">
                          <span className="text-cyber-gray">Tours Scheduled</span>
                          <span className="text-white font-bold">{dummyMetrics.kidazzle.tours || '0'}</span>
                        </div>
                      </div>
                   </div>

                   <div className="bg-cyber-panel border border-cyber-border rounded-md p-4">
                    <h2 className="text-xs font-bold text-cyber-gray mb-3"><IconCpu className="inline w-3 h-3 mr-1" /> FLEET STATUS</h2>
                    <div className="space-y-2">
                        {['IRO', 'MASTERCHEF', 'VOLT'].map(a => (
                          <div key={a} className="p-2 bg-cyber-subpanel rounded border border-cyber-border flex justify-between">
                            <span className="text-xs font-bold">{a}</span>
                            <span className="text-[10px] text-cyber-green">ONLINE</span>
                          </div>
                        ))}
                    </div>
                  </div>
                </div>

                {/* COLUMN 2: CONVERSATION & TERMINAL (Large Center) */}
                <div className="lg:col-span-6 flex flex-col space-y-4">
                  <div className="bg-cyber-panel border border-cyber-border flex-grow rounded-md flex flex-col overflow-hidden min-h-[500px]">
                    <div className="p-3 border-b border-cyber-border bg-cyber-highlight font-bold text-cyber-cyan text-sm">
                      INTERACTIVE TERMINAL
                    </div>
                    
                    <div className="flex flex-col flex-grow p-4 bg-cyber-subpanel">
                      <div className="flex-1 min-h-0 overflow-y-auto space-y-4 mb-4">
                        {chatHistory.map((chat, idx) => (
                          <div key={idx} className={`flex ${chat.sender === 'You' ? 'justify-end' : 'justify-start'}`}>
                            <div className={`p-3 rounded-lg max-w-[80%] ${chat.sender === 'You' ? 'bg-cyber-highlight border border-cyber-border' : 'bg-cyber-cyan/10 border border-cyber-cyan/30'}`}>
                              <span className="text-xs font-bold block mb-1" style={{ color: chat.sender === 'You' ? '#8E8E93' : '#00F0FF' }}>{chat.sender}</span>
                              <p className="text-sm">{chat.msg}</p>
                            </div>
                          </div>
                        ))}
                        <div ref={messagesEndRef} />
                      </div>
                      
                      <div className="flex space-x-2 border-t border-cyber-border pt-3">
                        <input 
                          type="text" 
                          value={chatInput}
                          onChange={(e) => setChatInput(e.target.value)}
                          onKeyDown={(e) => e.key === 'Enter' && handleSendChat()}
                          placeholder="Command execution..." 
                          className="flex-grow bg-cyber-panel border border-cyber-border rounded px-4 py-2 text-sm focus:outline-none focus:border-cyber-cyan/50"
                        />
                        <button className="bg-cyber-highlight border border-cyber-border px-3 rounded"><IconMic className="w-4 h-4" /></button>
                        <button onClick={handleSendChat} className="bg-cyber-cyan text-cyber-subpanel px-4 rounded font-bold">EXECUTE</button>
                      </div>
                    </div>
                  </div>
                </div>

                {/* COLUMN 3: TELEMETRY & WIMPER (Small Right) */}
                <div className="lg:col-span-3 space-y-4">
                   <div className="p-4 bg-cyber-subpanel rounded border border-cyber-cyan/20">
                      <h3 className="text-cyber-cyan font-bold mb-3 flex items-center"><IconBarChart className="w-4 h-4 mr-2"/> WIMPER B2B</h3>
                      <div className="space-y-2 text-xs">
                        <div className="flex justify-between border-b border-cyber-border pb-1">
                          <span className="text-cyber-gray">Corporate Sync</span>
                          <span className="text-cyber-orange font-bold animate-pulse">SYNCING</span>
                        </div>
                        <div className="flex justify-between border-b border-cyber-border pb-1">
                          <span className="text-cyber-gray">MGA Brokers</span>
                          <span className="text-white font-bold">{dummyMetrics.wimper.mga_broker_agreements || '0'}</span>
                        </div>
                      </div>
                   </div>

                   <div className="bg-cyber-panel border border-cyber-border rounded-md p-4 mt-4">
                    <h2 className="text-xs font-bold text-cyber-gray mb-3 flex items-center">
                      <IconFileText className="w-3 h-3 mr-1" /> N8N TELEMETRY FEED
                    </h2>
                    
                    {lessonStatus ? (
                        <div className="p-2 border border-cyber-cyan/50 rounded bg-cyber-cyan/10">
                           <div className="flex justify-between items-center mb-1">
                              <span className="font-bold text-sm text-white">{lessonStatus.location || 'AWAITING'}</span>
                              <span className="text-[10px] text-cyber-green bg-[#052E20] px-1 rounded">{lessonStatus.status || 'Routing'}</span>
                           </div>
                           <span className="text-xs text-cyber-gray">Week: {lessonStatus.week || 'N/A'}</span>
                        </div>
                    ) : (
                        <div className="text-xs text-cyber-pink bg-cyber-subpanel border border-cyber-pink/20 p-2 rounded">
                           Offline or awaiting payload...
                        </div>
                    )}
                   </div>
                </div>

              </div>
            </div>
          );
        };

        const root = ReactDOM.createRoot(document.getElementById('iro-root'));
        root.render(<IROConsole />);
    </script>
</body>
</html>
