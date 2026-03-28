<?php
/**
 * Routing Template: IRO Dashboard Legacy
 */

// Load Telemetry Data
$telemetry = ['kidazzle' => [], 'wimper' => []];
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $telemetry_path = 'C:/Users/kidaz/.openclaw/workspace/bridge/telemetry.json';
    if (file_exists($telemetry_path)) {
        $telemetry_data = file_get_contents($telemetry_path);
        if ($telemetry_data) {
            $telemetry = json_decode($telemetry_data, true);
        }
    }
}
$kidazzle = $telemetry['kidazzle'] ?? [];
$wimper = $telemetry['wimper'] ?? [];

$kidazzle_leads = number_format($kidazzle['leadsToday'] ?? 14);
$kidazzle_appts = number_format($kidazzle['appointmentsBooked'] ?? 3);
$kidazzle_value = $kidazzle['pipelineValue'] ?? '$12,400';

$wimper_sent = number_format($wimper['outreachSent'] ?? 245);
$wimper_replies = number_format($wimper['warmReplies'] ?? 8);
$wimper_value = $wimper['projectedValue'] ?? '$45,000';

// Note: For Wimper B2B Outreach Sent we can show the large pool if we want
$wimper_sent_display = number_format($wimper['pool'] ?? 14000);
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
        /* Fix mobile lock */
        html, body { overflow-x: hidden; height: auto; min-height: 100vh; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #2D3142; border-radius: 20px; }
    </style>
</head>
<body>
    <div id="iro-root"></div>
    <script type="text/babel">
        const { useState } = React;

        // Raw SVG Components to avoid dependency issues on WP load
        const IconTerminal = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>;
        const IconCpu = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>;
        const IconRefresh = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>;
        const IconTarget = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>;
        const IconUsers = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>;
        const IconBarChart = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>;
        const IconFileText = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>;
        const IconLink = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>;
        const IconSend = ({className}) => <svg className={className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>;

        
class ErrorBoundary extends React.Component {
  constructor(props) { super(props); this.state = { hasError: false, error: null }; }
  static getDerivedStateFromError(error) { return { hasError: true, error }; }
  render() { if (this.state.hasError) return <div style={{color:'white', padding:'20px'}}>Fatal React Error: {this.state.error.message}</div>; return this.props.children; }
}
const IROConsole = () => {
          const [activeTab, setActiveTab] = useState('dashboard');
          const [chatInput, setChatInput] = useState('');
          const [docLink, setDocLink] = useState('');
          const [logs, setLogs] = useState([
            { time: '18:05:32', msg: 'System: Secure TCP connection established via Cloudflare Proxied Network.', type: 'info' },
            { time: '18:05:36', msg: 'OpenClaw: Retrieving Master Manifest state.', type: 'info' },
            { time: '18:06:15', msg: 'IRO: "Waiting for next command structure."', type: 'warning' }
          ]);
          const [chatHistory, setChatHistory] = useState([
            { sender: 'IRO', msg: 'Console initialized. Awaiting commands for agent assignment.' }
          ]);
          const [pendingErrors, setPendingErrors] = useState([]);
          const [deliverables, setDeliverables] = useState([]);
          const [kidazzleOpps, setKidazzleOpps] = useState([]);
          const [wimperOpps, setWimperOpps] = useState([]);
          const [telemetry, setTelemetry] = useState({ kidazzle: { leadsToday: 14, appointmentsBooked: 3, pipelineValue: "$12,400" }, wimper: { pool: 14000, warmReplies: 8, projectedValue: "$45,000" } });

          React.useEffect(() => {
              const fetchErrors = async () => {
                  try {
                      const res = await fetch('https://stuffed-year-anderson-backed.trycloudflare.com/api/errors').catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         setPendingErrors(Array.isArray(data) ? data : []);
                      }
                  } catch(e) {}
              };
              
              const fetchDeliverables = async () => {
                  try {
                      const res = await fetch('https://stuffed-year-anderson-backed.trycloudflare.com/api/deliverables').catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         setDeliverables(Array.isArray(data) ? data : []);
                      }
                  } catch(e) {}
              };
              
              const fetchTelemetry = async () => {
                  try {
                      const res = await fetch('https://stuffed-year-anderson-backed.trycloudflare.com/api/telemetry').catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         if(data && Object.keys(data).length > 0) {
                            setTelemetry(prev => ({...prev, ...data}));
                         }
                      }
                  } catch(e) {}
              };

              fetchErrors();
              fetchDeliverables();
              fetchTelemetry();
              const intv = setInterval(() => {
                  fetchErrors();
                  fetchDeliverables();
                  fetchTelemetry();
              }, 10000); // Polls every 10 seconds natively
              return () => clearInterval(intv);
          }, []);

          const handleSendChat = async () => {
            if(!chatInput.trim()) return;
            const msg = chatInput;
            setChatHistory(prev => [...prev, {sender: 'You', msg}]);
            setChatInput('');
            try {
               const res = await fetch('https://stuffed-year-anderson-backed.trycloudflare.com/api/chat', {
                   method: 'POST',
                   headers: { 'Content-Type': 'application/json' },
                   body: JSON.stringify({ message: msg })
               });
               const data = await res.json();
               setChatHistory(prev => [...prev, {sender: 'IRO', msg: data.reply || "Command executed."}]);
            } catch(e) {
               setChatHistory(prev => [...prev, {sender: 'SYSTEM', msg: "BRIDGE DISCONNECTED."}]);
            }
          };

          const handleApproveAsset = async (url) => {
              try {
                  const res = await fetch('https://stuffed-year-anderson-backed.trycloudflare.com/api/command', {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json' },
                      body: JSON.stringify({ target: 'GHL_SOCIAL', message: `APPROVE_IMAGE: ${url}` })
                  });
                  if(res.ok) alert("Asset Approved! Pushing to GHL Social Planner Drafts.");
              } catch(e) {
                  alert("Error dispatching approval.");
              }
          };

          const handleRestartAgent = (agent) => {
            setLogs(prev => [...prev, { time: new Date().toLocaleTimeString('en-US',{hour12:false}), msg: `System: Restarting ${agent}...`, type: 'warning' }]);
          };

          return (
            <div className="min-h-screen bg-cyber-dark text-[#E2E8F0] p-6 font-mono tracking-tight selection:bg-cyber-cyan/30">
              {/* Header */}
              <header className="flex items-center justify-between border-b border-cyber-cyan/20 pb-4 mb-6">
                <div className="flex items-center space-x-3">
                  <IconTerminal className="text-cyber-cyan w-6 h-6 animate-pulse" />
                  <h1 className="text-2xl font-bold tracking-widest text-cyber-cyan">IRO_CONSOLE</h1>
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
              
              {/* Main Grid: 3 Equal Columns */}
              <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                {/* Column 1: Agent Fleet & Cron Jobs */}
                <div className="flex flex-col space-y-6">
                  {/* Agent Fleet Status */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg flex-shrink-0">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <IconCpu className="w-4 h-4 mr-2" /> AGENT FLEET STATUS
                    </h2>
                    <div className="space-y-4">
                      {[
                        { name: 'IRO', status: 'ONLINE & LISTENING', color: 'text-cyber-green', actions: 'Managing UI & Conversational memory' },
                        { name: 'MASTERCHEF', status: 'GHL AUTOMATION', color: 'text-cyber-cyan', actions: 'Running workflow #14022 in GHL' },
                        { name: 'VOLT', status: 'PROCESSING DATA', color: 'text-cyber-orange', actions: 'Updating opportunities pipeline' },
                        { name: 'PICASSO', status: 'STNDBY_MODE', color: 'text-cyber-gray', actions: 'Awaiting image generation tasks' }
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
                            <IconRefresh className="w-3 h-3 mr-2" /> RESTART
                          </button>
                        </div>
                      ))}
                    </div>
                  </div>

                  {/* Cron Jobs & Error Pending Alerts */}
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 shadow-lg flex-grow flex flex-col min-h-[400px]">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center relative">
                      <IconCpu className="w-4 h-4 mr-2" /> ACTIVE CRON JOBS / SYSTEM ALERTS
                      {pendingErrors.length > 0 && (
                          <span className="absolute right-0 top-0 flex h-3 w-3">
                              <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                              <span className="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                          </span>
                      )}
                    </h2>
                    <div className="space-y-3 flex-grow overflow-y-auto max-h-[1000px] custom-scrollbar">
                      {pendingErrors.length === 0 ? (
                         <div className="text-xs text-cyber-green p-3 bg-cyber-subpanel border border-cyber-green/20 rounded">
                           NO PENDING ERRORS. SYSTEM NOMINAL.
                         </div>
                      ) : pendingErrors.map((err, idx) => (
                        <div key={idx} className="flex flex-col p-3 bg-cyber-subpanel rounded border border-cyber-pink/40 animate-pulse">
                          <div className="flex justify-between items-center mb-1">
                            <span className="font-bold text-xs text-red-500 block flex items-center">
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

                {/* Column 2: Dashboard Command Center */}
                <div className="flex flex-col h-full bg-cyber-panel border border-cyber-border rounded-md shadow-lg min-h-[850px]">
                    {/* Tabs */}
                    <div className="flex flex-wrap border-b border-cyber-border rounded-t-lg overflow-hidden shrink-0">
                      <button 
                        onClick={() => setActiveTab('dashboard')}
                        className={`flex-1 py-3 px-2 text-[11px] font-bold transition-colors ${activeTab === 'dashboard' ? 'text-cyber-cyan border-b-2 border-cyber-cyan bg-cyber-highlight' : 'text-cyber-gray hover:text-[#E2E8F0]'}`}
                      >
                        TACTICAL COMMS
                      </button>
                      <button onClick={() => setActiveTab('kidazzle')} className={`flex-1 py-3 px-2 text-[11px] font-bold transition-colors ${activeTab === 'kidazzle' ? 'text-cyber-pink border-b-2 border-cyber-pink bg-cyber-highlight' : 'text-cyber-gray hover:text-[#E2E8F0]'}`}>DA PIPELINE</button>
                      <button onClick={() => setActiveTab('wimper')} className={`flex-1 py-3 px-2 text-[11px] font-bold transition-colors ${activeTab === 'wimper' ? 'text-cyber-cyan border-b-2 border-cyber-cyan bg-cyber-highlight' : 'text-cyber-gray hover:text-[#E2E8F0]'}`}>WIMPER PIPELINE</button>
                      <button onClick={() => setActiveTab('logs')} className={`flex-1 py-3 px-2 text-[11px] font-bold transition-colors ${activeTab === 'logs' ? 'text-cyber-cyan border-b-2 border-cyber-cyan bg-cyber-highlight' : 'text-cyber-gray hover:text-[#E2E8F0]'}`}>
                        RAW LOGS
                      </button>
                    </div>

                    {/* Chat Area */}
                    {activeTab === 'dashboard' && (
                      <div className="flex flex-col flex-grow p-4 bg-cyber-subpanel rounded-b-lg">
                        <div className="flex-grow space-y-4 overflow-y-auto mb-4 custom-scrollbar pr-2 min-h-[350px]">
                          {chatHistory.map((chat, idx) => (
                            <div key={idx} className={`flex ${chat.sender === 'You' ? 'justify-end' : 'justify-start'}`}>
                              <div className={`p-3 rounded-lg max-w-[90%] ${chat.sender === 'You' ? 'bg-cyber-highlight border border-cyber-border' : 'bg-cyber-cyan/10 border border-cyber-cyan/30'}`}>
                                <span className="text-xs font-bold block mb-1" style={{ color: chat.sender === 'You' ? '#8E8E93' : '#00F0FF' }}>{chat.sender}</span>
                                <p className="text-sm shadow-sm">{chat.msg}</p>
                              </div>
                            </div>
                          ))}
                        </div>
                        
                        {/* Doc Upload & Chat Input */}
                        <div className="pt-3 border-t border-cyber-border space-y-3 shrink-0">
                          <div className="flex space-x-2">
                            <div className="flex-grow bg-cyber-panel border border-cyber-border rounded flex items-center px-3 focus-within:border-cyber-cyan/50">
                              <IconFileText className="w-4 h-4 text-cyber-gray mr-2" />
                              <input 
                                type="text" 
                                value={docLink}
                                onChange={(e) => setDocLink(e.target.value)}
                                placeholder="Paste Google Docs URL..." 
                                className="bg-transparent border-none outline-none w-full text-sm py-2 text-[#E2E8F0] placeholder-cyber-gray"
                              />
                            </div>
                            <button onClick={() => setDocLink('')} className="bg-cyber-highlight border border-cyber-border hover:border-cyber-cyan px-3 rounded text-xs font-bold flex items-center transition-colors">
                              <IconLink className="w-3 h-3 mr-1" /> LINK
                            </button>
                          </div>
                          
                          <div className="flex space-x-2">
                            <input 
                              type="text" 
                              value={chatInput}
                              onChange={(e) => setChatInput(e.target.value)}
                              onKeyDown={(e) => e.key === 'Enter' && handleSendChat()}
                              placeholder="Command IRO..." 
                              className="flex-grow bg-cyber-panel border border-cyber-border rounded px-4 py-3 text-sm focus:outline-none focus:border-cyber-cyan/50"
                            />
                            <button 
                              onClick={handleSendChat}
                              className="bg-cyber-cyan text-cyber-subpanel font-bold px-4 rounded hover:bg-white transition-colors flex items-center text-sm"
                            >
                              <IconSend className="w-4 h-4 mr-1" /> SEND
                            </button>
                          </div>
                        </div>
                      </div>
                    )}
                    
                    {/* Kidazzle Opps */}
                    {activeTab === 'kidazzle' && (
                      <div className="p-4 bg-cyber-subpanel flex-grow overflow-y-auto max-h-[850px] custom-scrollbar rounded-b-lg">
                         <h3 className="text-cyber-pink font-bold mb-4">DA Pipeline ({kidazzleOpps.length} Live)</h3>
                         <div className="space-y-2">
                            {kidazzleOpps.map((opp, i) => (
                               <div key={i} className="p-3 border border-cyber-pink/30 bg-cyber-highlight rounded flex justify-between hover:border-cyber-pink transition-colors cursor-pointer">
                                  <div>
                                    <div className="font-bold text-[#E2E8F0] text-sm">{opp.name || opp.contactName || "Unknown"}</div>
                                    <div className="text-xs text-cyber-gray mt-1">Value: <span className="text-cyber-pink">{opp.monetaryValue ? '$'+opp.monetaryValue : '$0'}</span> | <span className="text-white">{opp.status || 'open'}</span></div>
                                  </div>
                                  <div className="text-[10px] text-cyber-gray flex items-center whitespace-nowrap">{new Date(opp.updatedAt || opp.createdAt).toLocaleDateString()}</div>
                               </div>
                            ))}
                            {kidazzleOpps.length === 0 && <div className="text-cyber-gray text-xs">No opportunities mapped/loading...</div>}
                         </div>
                      </div>
                    )}
                    
                    {/* Wimper Opps */}
                    {activeTab === 'wimper' && (
                      <div className="p-4 bg-cyber-subpanel flex-grow overflow-y-auto max-h-[850px] custom-scrollbar rounded-b-lg">
                         <h3 className="text-cyber-cyan font-bold mb-4">Wimper Pipeline ({wimperOpps.length} Live)</h3>
                         <div className="space-y-2">
                            {wimperOpps.map((opp, i) => (
                               <div key={i} className="p-3 border border-cyber-cyan/30 bg-cyber-highlight rounded flex justify-between hover:border-cyber-cyan transition-colors cursor-pointer">
                                  <div>
                                    <div className="font-bold text-[#E2E8F0] text-sm">{opp.name || opp.contactName || "Unknown"}</div>
                                    <div className="text-xs text-cyber-gray mt-1">Value: <span className="text-cyber-cyan">{opp.monetaryValue ? '$'+opp.monetaryValue : '$0'}</span> | <span className="text-white">{opp.status || 'open'}</span></div>
                                  </div>
                                  <div className="text-[10px] text-cyber-gray flex items-center whitespace-nowrap">{new Date(opp.updatedAt || opp.createdAt).toLocaleDateString()}</div>
                               </div>
                            ))}
                            {wimperOpps.length === 0 && <div className="text-cyber-gray text-xs">No opportunities mapped/loading...</div>}
                         </div>
                      </div>
                    )}

                    {/* Logs Area */}
                    {activeTab === 'logs' && (
                      <div className="p-4 bg-cyber-subpanel flex-grow text-sm space-y-2 overflow-y-auto max-h-[850px] custom-scrollbar rounded-b-lg">
                        {logs.map((log, i) => (
                          <div key={i} className="flex space-x-3">
                            <span className="text-cyber-gray">[{log.time}]</span>
                            <span className={log.type === 'warning' ? 'text-cyber-orange' : 'text-cyber-cyan'}>
                              {log.msg}
                            </span>
                          </div>
                        ))}
                        <div className="animate-pulse text-cyber-gray mt-2">&gt; Waiting for input...</div>
                      </div>
                    )}
                </div>

                {/* Column 3: Assets Created */}
                <div className="flex flex-col space-y-6 flex-grow min-h-[850px]">
                  <div className="bg-cyber-panel border border-cyber-border rounded-md p-5 flex flex-col shadow-lg flex-grow">
                    <h2 className="text-sm font-bold text-cyber-gray mb-4 flex items-center">
                      <IconFileText className="w-4 h-4 mr-2" /> ASSETS CREATED & PENDING REVIEW
                    </h2>
                    <div className="flex flex-col space-y-4 max-h-[800px] overflow-y-auto custom-scrollbar pr-2 flex-grow">
                      {deliverables.length === 0 ? (
                         <div className="text-xs text-cyber-gray">No assets generated yet.</div>
                      ) : deliverables.map((file, idx) => (
                        <a key={idx} href={file.url} download target="_blank" className="flex flex-col items-center bg-cyber-subpanel rounded border border-cyber-border hover:border-cyber-cyan/50 transition-colors group overflow-hidden shrink-0">
                           {file.type === 'pdf' ? (
                               <div className="w-full h-32 shrink-0 bg-red-900/30 text-red-500 rounded-t flex items-center justify-center font-bold text-3xl group-hover:bg-red-900/50">PDF</div>
                           ) : file.type === 'md' ? (
                               <div className="w-full h-32 shrink-0 bg-blue-900/30 text-blue-500 rounded-t flex items-center justify-center font-bold text-3xl group-hover:bg-blue-900/50">MARKDOWN</div>
                           ) : (
                               <div className="w-full h-48 shrink-0 border-b border-cyber-border relative overflow-hidden">
                                  <img src={file.url} alt={file.name} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                               </div>
                           )}
                           <div className="p-4 w-full flex flex-col justify-between bg-cyber-highlight">
                               <div>
                                   <div className="text-sm font-bold text-[#E2E8F0] truncate group-hover:text-cyber-cyan transition-colors" title={file.name}>{file.name}</div>
                                   <div className="text-[10px] text-cyber-gray uppercase mt-1">Click to Download</div>
                               </div>
                               {(file.type === 'png' || file.type === 'jpg' || file.type === 'jpeg') && (
                                   <button 
                                      onClick={(e) => { e.preventDefault(); handleApproveAsset(file.url); }}
                                      className="mt-3 bg-cyber-pink hover:bg-red-500 text-white font-bold text-xs px-3 py-2.5 rounded shadow-lg transition-colors border border-red-500/50 w-full uppercase"
                                   >
                                      SEND TO GHL PLANNER
                                   </button>
                               )}
                           </div>
                        </a>
                      ))}
                    </div>
                  </div>
                </div>
              </div>

            </div>
          );
        };

        const root = ReactDOM.createRoot(document.getElementById('iro-root'));
        root.render(<ErrorBoundary><IROConsole /></ErrorBoundary>);
    </script>
</body>
</html>
