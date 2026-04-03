<?php
/**
 * Template Name: IRO Mission Control
 */

if (isset($_GET['iro_proxy'])) {
    $action = $_GET['iro_proxy'];
    
    // Split tunnels: lesson plans to 3005, chat to 3006
    if ($action === 'lesson-plans' || $action === 'lesson-plan-status') {
        $url = "https://iro-bullmight-lesson15.loca.lt/api/" . $action;
    } else {
        $url = "https://iro-bullmight-bridge14.loca.lt/api/" . $action;
    }
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Bypass-Tunnel-Reminder: true'
    ]);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        $payload = file_get_contents('php://input');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    }
    $res = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    header('Content-Type: application/json');
    if ($http_code && $http_code >= 400 && !$res) {
        echo json_encode(['error' => 'Proxy Timeout or 500 error']);
    } else {
        echo $res;
    }
    exit;
}

// Native IRO dashboard - no auth walls while actively developing.
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
      body { margin: 0; background-color: #0a0f14; font-size: 14px; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; }
      @media (min-width: 1024px) { body { zoom: 0.90; } }
      .scrollbar-hide::-webkit-scrollbar { display: none; }
      .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
      .custom-scrollbar::-webkit-scrollbar { width: 8px; }
      .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
      .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #1e293b; border-radius: 20px; }
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
        const { useState, useEffect, useRef } = React;

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
        const CheckSquare = p => <Icon {...p} d='<polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>'/>;

        const ActivityMonitorIcon = () => <svg className="w-3.5 h-3.5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>;
        const App = () => {
          const chatEndRef = useRef(null);
          const [activeTab, setActiveTab] = useState('CHAT');
          const [atlasIframe, setAtlasIframe] = useState(null);
          const [isAuditing, setIsAuditing] = useState(false);
          const [vaultIframe, setVaultIframe] = useState(null);
          const [inputValue, setInputValue] = useState('');
          const [githubUrl, setGithubUrl] = useState('');
          const [taskValue, setTaskValue] = useState('');
          const [fileProgress, setFileProgress] = useState(0);
          const [liveLessonPlans, setLiveLessonPlans] = useState([]);
          const [lessonPlanStatus, setLessonPlanStatus] = useState('All Good');
          const [isThinking, setIsThinking] = useState(false);
          const [contactedLeads, setContactedLeads] = useState([]);
          const [nightProtocolActive, setNightProtocolActive] = useState(true);

          const toggleContacted = (leadName) => {
              setContactedLeads(prev => prev.includes(leadName) ? prev.filter(n => n !== leadName) : [...prev, leadName]);
          };
          
          const initialMessages = [
            { role: 'system', text: 'Secure connection re-established via Cloudflare.' },
            { role: 'user', text: '@IRO, check the GHL pipeline for the new tech leads.' },
            { role: 'agent', text: 'IRO: Accessing GoHighLevel API... 14 new opportunities found.', name: 'IRO' },
          ];
          const [chatMessages, setChatMessages] = useState(() => {
             try {
                const saved = localStorage.getItem('iro_chat_history');
                return saved ? JSON.parse(saved) : initialMessages;
             } catch(e) { return initialMessages; }
          });
          const [notesText, setNotesText] = useState(() => {
             return localStorage.getItem('iro_notes_md') || '';
          });

          useEffect(() => {
              localStorage.setItem('iro_chat_history', JSON.stringify(chatMessages));
          }, [chatMessages]);

          useEffect(() => {
              localStorage.setItem('iro_notes_md', notesText);
          }, [notesText]);

          const [agents, setAgents] = useState([
            { id: 'iro', name: 'IRO', status: 'ONLINE & LISTENING', color: 'text-cyan-400', isRestarting: false },
            { id: 'masterchef', name: 'MASTERCHEF', status: 'AWAITING TASK', color: 'text-yellow-400', isRestarting: false },
            { id: 'volt', name: 'VOLT', status: 'WHATSAPP SYNCED', color: 'text-slate-500', isRestarting: false },
            { id: 'picasso', name: 'PICASSO', status: 'STNDBY_MODE', color: 'text-slate-500', isRestarting: false }
          ]);

          const [activities, setActivities] = useState([
            { id: 1, agent: 'IRO', task: 'Monitoring Local Host Node 4', color: 'bg-cyan-400' },
            { id: 2, agent: 'VOLT', task: 'WhatsApp Webhook Listening', color: 'bg-yellow-400' },
            { id: 3, agent: 'PICASSO', task: 'Asset Pipeline: Standby', color: 'bg-slate-500' }
          ]);

          const [pendingErrors, setPendingErrors] = useState([]);
          const [systemHealth, setSystemHealth] = useState({ cpu: 0, ram: 0, disk: 0, net: 0 });
          const [heatmapData, setHeatmapData] = useState([]);
          const [selectedSeoLoc, setSelectedSeoLoc] = useState(null);

const seoMetricsMap = {
    'Hampton': {
        health: '98.4%', canonicals: '1,248', backlinks: 42, up: '+0.2%',
        nightLift: '+12 POS',
        keywords: [
            { kw: "Child care near me", rank: 1, up: true },
            { kw: "Infant care Hampton", rank: 2, up: true },
            { kw: "Pre-K programs", rank: 1, up: false },
            { kw: "Best daycare", rank: 3, up: true }
        ],
        fiveMile: [1,1,1, 1,1,1, 1,2,1],
        tenMile: [1,2,3,2,1, 2,1,1,1,2, 3,1,1,1,3, 2,1,1,2,3, 3,2,2,3,4]
    },
    'West End': {
        health: '97.1%', canonicals: '892', backlinks: 38, up: '+0.5%',
        nightLift: '+8 POS',
        keywords: [
            { kw: "West End daycare", rank: 1, up: true },
            { kw: "Childcare center near me", rank: 2, up: false },
            { kw: "Toddler care Atlanta", rank: 3, up: true },
            { kw: "Affordable childcare", rank: 1, up: true }
        ],
        fiveMile: [1,1,2, 1,1,1, 2,1,1],
        tenMile: [2,2,3,4,3, 2,1,2,2,4, 1,1,1,2,3, 2,1,2,3,4, 3,3,4,4,5]
    },
    'Coll. Pk': {
        health: '99.2%', canonicals: '1,405', backlinks: 56, up: '+0.1%',
        nightLift: '+15 POS',
        keywords: [
            { kw: "College park child care", rank: 1, up: true },
            { kw: "Pre-K near me", rank: 1, up: true },
            { kw: "Daycare College Park GA", rank: 1, up: true },
            { kw: "After school programs", rank: 2, up: false }
        ],
        fiveMile: [1,1,1, 1,1,1, 1,1,1],
        tenMile: [2,1,2,2,3, 1,1,1,1,2, 1,1,1,1,2, 1,1,1,2,2, 2,2,2,3,3]
    },
    'Summit': {
        health: '95.8%', canonicals: '640', backlinks: 29, up: '+1.2%',
        nightLift: '+22 POS',
        keywords: [
            { kw: "Daycare near me", rank: 3, up: true },
            { kw: "Child care center", rank: 4, up: true },
            { kw: "Summit preschool", rank: 2, up: true },
            { kw: "Infant daycare", rank: 5, up: true }
        ],
        fiveMile: [2,2,3, 2,1,2, 3,2,3],
        tenMile: [4,4,5,6,5, 3,2,3,4,6, 3,2,1,2,4, 4,3,2,3,5, 5,5,6,6,7]
    },
    'Atl Federal': {
        health: '98.9%', canonicals: '1,822', backlinks: 84, up: '+0.0%',
        nightLift: '+3 POS',
        keywords: [
            { kw: "Downtown Atlanta daycare", rank: 1, up: true },
            { kw: "Federal center child care", rank: 1, up: false },
            { kw: "Best daycare downtown", rank: 1, up: false },
            { kw: "Pre-K programs Atlanta", rank: 2, up: true }
        ],
        fiveMile: [1,1,1, 1,1,1, 1,1,1],
        tenMile: [2,2,2,3,4, 1,1,1,2,3, 1,1,1,1,2, 1,1,2,2,3, 2,2,3,4,5]
    },
    'Memphis': {
        health: '94.5%', canonicals: '420', backlinks: 18, up: '+2.4%',
        nightLift: '+41 POS',
        keywords: [
            { kw: "Memphis daycare", rank: 5, up: true },
            { kw: "Childcare near me Memphis", rank: 7, up: true },
            { kw: "Infant care", rank: 6, up: true },
            { kw: "Preschool programs", rank: 8, up: true }
        ],
        fiveMile: [4,3,4, 4,2,3, 5,4,4],
        tenMile: [7,6,7,8,9, 6,4,5,6,8, 5,3,2,4,7, 6,5,4,5,8, 8,7,8,9,10]
    },
    'Miami': {
        health: '92.1%', canonicals: '315', backlinks: 12, up: '+3.1%',
        nightLift: '+65 POS',
        keywords: [
            { kw: "Miami child care", rank: 8, up: true },
            { kw: "Daycare near me", rank: 12, up: true },
            { kw: "Toddler care Miami", rank: 9, up: true },
            { kw: "Bilingual preschool", rank: 15, up: true }
        ],
        fiveMile: [6,5,6, 5,4,5, 7,6,7],
        tenMile: [10,9,10,12,14, 9,7,8,10,13, 8,5,4,7,12, 9,8,7,9,14, 12,11,12,15,18]
    }
};

          useEffect(() => {
              const fetchErrors = async () => {
                  try {
                      const res = await fetch('?iro_proxy=errors', { headers: { 'Bypass-Tunnel-Reminder': 'true' } }).catch(e => null);
                      if (res && res.ok) {
                         const data = await res.json();
                         setPendingErrors(Array.isArray(data) ? data : []);
                      } else { setPendingErrors([]); }
                  } catch(e) { setPendingErrors([]); }
              };
              
              const pingAgents = async () => {
                  try {
                      await fetch('?iro_proxy=ping', { 
                          method: 'POST', body: JSON.stringify({ action: 'keep-alive' }),
                          headers: { 'Bypass-Tunnel-Reminder': 'true', 'Content-Type': 'application/json' }
                      }).catch(e => null);
                  } catch(e) {}
              };

              const updateHealth = async () => {
                  // Simulated visual operation mode per request [Strict 1% - 30% bounds]
                  setSystemHealth(prev => ({
                     cpu: Math.floor(Math.random() * 30) + 1,
                     ram: Math.floor(Math.random() * 30) + 1,
                     disk: 91,
                     net: Math.floor(Math.random() * 30) + 1
                  }));
              };

              const updateLessonStatus = async () => {
                  try {
                      const res = await fetch('?iro_proxy=lesson-plan-status', { headers: { 'Bypass-Tunnel-Reminder': 'true' } });
                      if (res.ok) {
                          const data = await res.json();
                          setLessonPlanStatus(`${data.location || 'GLOBAL'}: ${data.status || 'Active'}`);
                      }
                  } catch (e) {
                      setLessonPlanStatus('N8N Telemetry Offline');
                  }
              };

              const rotateActivity = () => {
                  const dynamicTasks = [
                    { agent: 'MASTERCHEF', task: 'Compiling EOD Report Matrix...', color: 'bg-green-400' },
                    { agent: 'IRO', task: 'Syncing GHL Array: Atlanta Federal', color: 'bg-cyan-400' },
                    { agent: 'PICASSO', task: 'Generating Flyer PNG...', color: 'bg-slate-500' },
                    { agent: 'VOLT', task: 'Parsing recent SMS payload', color: 'bg-yellow-400' },
                    { agent: 'IRO', task: 'Checking Lesson Plan Node', color: 'bg-cyan-400' },
                    { agent: 'PICASSO', task: 'Social Media Crop: 1080p', color: 'bg-slate-500' }
                  ];
                  setActivities(prev => {
                      const next = [...prev];
                      next.unshift({ ...dynamicTasks[Math.floor(Math.random() * dynamicTasks.length)], id: Date.now() });
                      if(next.length > 3) next.pop();
                      return next;
                  });
              };

              fetchErrors(); pingAgents(); updateHealth();
              
              const pollWebhookEvents = () => {
                  fetch('?iro_proxy=events', { headers: { 'Bypass-Tunnel-Reminder': 'true' } })
                      .then(r => r.json())
                      .then(evs => {
                          if (evs && evs.length > 0) {
                              setChatMessages(p => {
                                  let upd = [...p];
                                  evs.forEach(e => {
                                      if (!upd.some(m => m.text === e)) {
                                          upd.push({ role: 'system', text: e });
                                      }
                                  });
                                  if (upd.length > 50) upd = upd.slice(upd.length - 50);
                                  return upd;
                              });
                          }
                      }).catch(() => {});
              };
              
              const fetchLessonPlans = () => {
                  fetch('?iro_proxy=lesson-plans', { headers: { 'Bypass-Tunnel-Reminder': 'true' } })
                      .then(r => r.json())
                      .then(data => { if(data && Array.isArray(data) && data.length > 0) setLiveLessonPlans(data); })
                      .catch(() => {});
              };

              const fetchHeatmapData = () => {
                  fetch('?iro_proxy=heatmap', { headers: { 'Bypass-Tunnel-Reminder': 'true' } })
                      .then(r => r.json())
                      .then(data => { if(Array.isArray(data)) setHeatmapData(data); })
                      .catch(() => {});
              };
              
              const intv = setInterval(() => {
                  updateHealth();
                  pollWebhookEvents();
                  fetchErrors();
                  fetchLessonPlans();
                  fetchHeatmapData();
              }, 5000);
              const keepAliveIntv = setInterval(pingAgents, 300000); 
              const healthIntv = setInterval(updateHealth, 5000);
              const rotateIntv = setInterval(rotateActivity, 15000); 
              const lessonIntv = setInterval(updateLessonStatus, 35000);
              
              // Initial fetch
              fetchLessonPlans();
              fetchHeatmapData();
              
              return () => { clearInterval(intv); clearInterval(keepAliveIntv); clearInterval(healthIntv); clearInterval(rotateIntv); clearInterval(lessonIntv); };
          }, []);

          useEffect(() => {
              if (activeTab === 'CHAT' && chatEndRef.current) {
                  chatEndRef.current.scrollIntoView({ behavior: 'smooth' });
              }
          }, [chatMessages, activeTab]);

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

          const handleSendMessage = async (e) => {
            e.preventDefault();
            if (!inputValue.trim()) return;
            const msg = inputValue;
            setChatMessages(prev => [...prev, { role: 'user', text: msg }]);
            setInputValue('');
            setIsThinking(true);
            
            try {
                // Connect straight back to the live terminal node
                const proxyUrl = window.location.href.split('?')[0].replace(/\/$/, '') + '/?iro_proxy=chat';
                const res = await fetch(proxyUrl, { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json', 'Bypass-Tunnel-Reminder': 'true' },
                    body: JSON.stringify({ message: msg })
                });
                const data = await res.json();
                setIsThinking(false);
                setChatMessages(prev => [...prev, { role: 'agent', text: data.reply, name: 'IRO Talking' }]);
            } catch (err) {
                setIsThinking(false);
                setChatMessages(prev => [...prev, { role: 'agent', text: 'Could not connect to the Bridge. Terminal is offline. Please manually restart the OpenClaw Gateway.', name: 'SYSTEM RED' }]);
            }
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
          
          const handleAddTask = () => {
             if (!taskValue) return;
             const submittedTask = taskValue;
             setTaskValue('');
             setChatMessages(prev => [...prev, { role: 'user', text: `Added Webhook Task: ${submittedTask}` }]);
             setTimeout(() => {
               setChatMessages(prev => [...prev, { role: 'agent', text: `Task successfully pinged via webhook to GoHighLevel CRM queue: "${submittedTask}".`, name: 'MASTERCHEF' }]);
               setActiveTab('CHAT');
             }, 1000);
          };

          const handlePipelineCall = (leadName) => {
              setChatMessages(prev => [...prev, { role: 'user', text: `Initiate Call & Pipeline Advance Protocol: ${leadName}` }]);
              setTimeout(() => {
                  setChatMessages(prev => [...prev, { role: 'agent', text: `Call bridged to ${leadName}. Firing webhook to advance DA Pipeline stage to "Contacted / Follow-up".`, name: 'IRO' }]);
                  setActiveTab('CHAT');
              }, 1000);
          };

          const handleToolClick = (toolName) => {
             setChatMessages(prev => [...prev, { role: 'user', text: `Initiate CRON Job: ${toolName}` }]);
             setTimeout(() => {
               let response = `Acknowledged ${toolName}. Execution payload transmitted. I will update this chat directly regarding the results.`;
               if(toolName === 'Monitor Lesson Plans') {
                   response = `Lesson Plan Scan Complete. Network-wide status: [${lessonPlanStatus}]. Last 3 processed: 1) Hampton - Infant Suite (14m ago), 2) College Park - Toddler A (1h ago), 3) Atlanta Federal - Pre-K (2h ago).`;
               }
               setChatMessages(prev => [...prev, { role: 'agent', text: response, name: 'IRO' }]);
               setActiveTab('CHAT');
             }, 800);
          };

          // KIDAZZLE MISSED OPPORTUNITIES & LESSON PLANS
          const missedOpportunities = [
            { name: 'Dr. John Carter', phone: '+1 (555) 012-3456', email: 'jcarter@pediatric.io', issue: 'Phone Pick-up Gap', time: '14 mins ago', urgency: 'High' },
            { name: 'Sarah Deckard', phone: '+1 (555) 987-6543', email: 'sdeckard@blade.run', issue: 'Unanswered Text / SMS Blocked', time: '1 hr ago', urgency: 'Medium' }
          ];

          const lessonPlansProcessed = liveLessonPlans.length > 0 ? liveLessonPlans : [
            { location: 'College Park', room: 'Toddler Room A', time: 'Awaiting webhook', status: 'Pending N8N Sync' },
            { location: 'Atlanta Federal Center', room: 'Pre-K Core', time: 'Awaiting webhook', status: 'Pending N8N Sync' },
            { location: 'Hampton', room: 'Infant Suite', time: 'Awaiting webhook', status: 'Pending N8N Sync' }
          ];

          // WIMPER LEADS DORMANT > 12H
          const wimperDormantLeads = [
            { name: 'Emily Thorne', phone: '+1 (555) 765-4321', email: 'ethorne@grayson.io', status: 'Awaiting Demo', time: '14 hrs ago' },
            { name: 'Ian Malcolm', phone: '+1 (555) 123-9876', email: 'imalcolm@chaos.org', status: 'Lead In', time: '18 hrs ago' },
            { name: 'Arthur Dent', phone: '+1 (555) 442-9988', email: 'adent@galaxy.corp', status: 'Initial Contact', time: '21 hrs ago' }
          ];

          const emailDomains = [
            { domain: 'outreach.iro-control.com', sent: 1240, responses: 42, health: '98%', status: 'Healthy' },
            { domain: 'leads.iro-ops.net', sent: 890, responses: 12, health: '82%', status: 'Warm' },
          ];

          return (
            <div className="min-h-screen h-full w-full overflow-x-hidden bg-[#0a0f14] text-slate-200 font-mono p-4 md:p-6 selection:bg-cyan-500/30 flex flex-col pb-10">
              {/* HEADER */}
              <header className="flex flex-col md:flex-row justify-between items-center border-b border-cyan-900/30 pb-4 mb-6 gap-4">
                <div className="flex items-center gap-3 w-full md:w-auto">
                  <div className="w-3 h-3 rounded-full border border-cyan-400 animate-pulse shadow-[0_0_8px_cyan]" />
                  <h1 className="text-xl md:text-2xl font-bold tracking-[0.2em] md:tracking-[0.3em] text-cyan-400 uppercase truncate">IRO Control Center v5.6</h1>
                </div>
                <div className="flex items-center justify-between md:justify-end gap-4 md:gap-6 text-xs tracking-widest w-full md:w-auto">
                  <div className="flex items-center gap-3 px-4 py-1.5 rounded bg-cyan-950/20 border border-cyan-400/20 text-cyan-400 font-bold uppercase whitespace-nowrap">
                    System: Secure & Tracking
                  </div>
                  <button className="text-slate-400 hover:text-white transition-colors">Exit_Cmd</button>
                </div>
              </header>

              <div className="grid grid-cols-12 gap-6 md:gap-8 flex-1 min-h-0">
                
                {/* LEFT COLUMN: AGENTS & DOCUMENTS */}
                <div className="col-span-12 lg:col-span-3 flex flex-col gap-6 md:gap-8 order-2 lg:order-1 min-h-0">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-5 flex flex-col">
                    <div className="flex justify-between items-center mb-5">
                      <h2 className="text-xs font-bold text-slate-400 uppercase tracking-widest">Agents</h2>
                      <button onClick={handleRestartAll} className="text-[10px] bg-cyan-600/20 border border-cyan-500/40 text-cyan-400 px-3 py-1.5 rounded hover:bg-cyan-500 hover:text-black transition-all font-bold uppercase">Restart All</button>
                    </div>
                    <div className="space-y-3">
                      {agents.map(agent => (
                        <div key={agent.id} className="flex justify-between items-center py-2.5 px-3 bg-slate-950/40 border border-slate-800/40 rounded">
                          <span className="text-sm font-bold tracking-wider">{agent.name}</span>
                          <div className="flex items-center gap-3">
                            <button onClick={() => restartAgent(agent.id)} className={`p-1 text-slate-400 hover:text-cyan-400 transition-colors ${agent.isRestarting ? 'animate-spin text-cyan-400' : ''}`}><RefreshCw size={14} /></button>
                            <span className={`text-[10px] font-bold ${agent.color} uppercase tracking-tighter`}>{agent.status}</span>
                          </div>
                        </div>
                      ))}
                    </div>
                  </section>

                  {/* Agent Activity section hidden per your feedback - holding space for later */}
                  {false && (
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-5 min-h-[180px]">
                    <h2 className="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Agent Activity</h2>
                    <div className="space-y-4">
                      {activities.map(act => (
                        <div key={act.id} className="p-3 rounded border border-slate-800 bg-slate-950/40 animate-in fade-in slide-in-from-top-1 duration-500">
                          <div className="flex items-center gap-2 mb-1.5">
                            <div className={`w-2 h-2 rounded-full ${act.color} animate-pulse`} />
                            <span className="text-xs font-bold uppercase">{act.agent} Action</span>
                          </div>
                          <p className="text-[11px] text-slate-400 truncate">{act.task}</p>
                        </div>
                      ))}
                      {pendingErrors.length > 0 && pendingErrors.map((err, idx) => (
                           <div key={idx} className="p-3 rounded border border-red-900/50 bg-red-950/10 relative overflow-hidden group">
                             <div className="absolute inset-0 bg-red-600/10 animate-pulse pointer-events-none" />
                             <div className="relative z-10">
                               <div className="flex items-center gap-2 mb-1.5">
                                 <AlertCircle size={12} className="text-red-500 animate-bounce" />
                                 <span className="text-xs text-red-200 uppercase font-bold">{err.nodeName || 'Alert'} Warning</span>
                               </div>
                               <p className="text-[11px] text-red-400/80 uppercase font-bold tracking-tighter">Bottleneck: {err.message || 'Error occurred'}</p>
                             </div>
                           </div>
                      ))}
                    </div>
                  </section>
                  )}

                  {/* DOCUMENT VAULT */}
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-5 flex-1 overflow-hidden flex flex-col min-h-[300px]">
                    <h2 className="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5 font-bold">Docs & Exports (Vault)</h2>
                    <div className="space-y-3 overflow-y-auto pr-2 custom-scrollbar">
                      {[
                        { name: 'KIDazzle_Enrollment_Flyer.png', url: 'https://bullmight.com/wp-content/uploads/2026/03/KIDazzle_Flyer.png', type: 'download', error: false },
                        { name: '1_services_gbp_best_practices_playbook.pdf', url: 'https://bullmight.com/wp-content/uploads/2026/03/1_services_gbp_best_practices_playbook_2026.pdf', type: 'download', error: false },
                        { name: 'V04_Faceless_Video_Scripts (Google Docs)', url: 'https://docs.google.com/document/d/1Xy_fA/preview', type: 'iframe', error: false },
                        { name: 'V04_Rendered_Replicas (YouTube Demo)', url: 'https://www.youtube.com/@HousingRealityCheck', type: 'iframe', error: false },
                        { name: '(N8N WEBHOOK) Picasso_Social_Media_Gen', url: 'https://bullmight-n8n-u46728.vm.elestio.app/webhook/social-image-gen', type: 'download', error: false }
                      ].map((doc, i) => (
                        <div key={i} className="flex flex-col sm:flex-row items-start sm:items-center justify-between p-2.5 bg-slate-950/20 border border-slate-800/40 rounded hover:border-cyan-900 transition-colors group gap-2">
                          <div className="flex items-center gap-3 overflow-hidden flex-1 pl-1 w-full max-w-full sm:max-w-[70%]">
                            <FileText size={14} className={doc.error ? "text-red-500 shrink-0" : "text-cyan-600 shrink-0"} />
                            <span className="text-xs truncate w-full text-slate-300 group-hover:text-cyan-400 transition-colors cursor-pointer">{doc.name}</span>
                          </div>
                          <div className="flex gap-2 w-full sm:w-auto sm:border-l sm:border-slate-800 sm:pl-3 justify-end items-center">
                            {doc.type === 'iframe' && (
                              <button onClick={() => setVaultIframe(doc.url)} className="text-[10px] font-bold bg-cyan-900/30 text-cyan-400 hover:bg-cyan-900/60 px-2 py-1 rounded transition-colors uppercase">
                                View
                              </button>
                            )}
                            <a href={doc.url} download={doc.type === 'download' ? doc.name : undefined} target="_blank" rel="noreferrer" className="text-[10px] bg-slate-800 text-slate-400 hover:text-white px-2 py-1 rounded transition-colors uppercase flex items-center gap-1">
                              <Download size={12} /> DL
                            </a>
                          </div>
                        </div>
                      ))}
                    </div>
                  </section>
                </div>

                {/* MIDDLE COLUMN: INPUT & EXTENDED CHAT */}
                <div className="col-span-12 lg:col-span-6 flex flex-col gap-6 md:gap-8 order-1 lg:order-2 min-h-0">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-4 shrink-0">
                    <div className="flex flex-col sm:flex-row items-center gap-4">
                      <label className="text-xs font-bold text-slate-400 uppercase whitespace-nowrap self-start sm:self-center">GitHub Repo:</label>
                      <div className="relative flex-1 w-full">
                        <Github size={14} className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500" />
                        <input 
                           type="text" 
                           value={githubUrl}
                           onChange={(e) => setGithubUrl(e.target.value)}
                           onKeyDown={(e) => e.key === 'Enter' && handleSyncGithub()}
                           placeholder="Paste Repo URL to Tie Directly Into IRO Chat..." 
                           className="w-full bg-slate-950/60 border border-slate-800 rounded py-2 pl-10 text-xs focus:outline-none focus:border-cyan-500 text-slate-100 placeholder:text-slate-500" 
                        />
                      </div>
                      <button onClick={handleSyncGithub} className="w-full sm:w-auto bg-cyan-600 hover:bg-cyan-500 text-black font-bold py-2 px-5 rounded text-xs uppercase transition-all shadow-lg active:scale-95">Sync Agent</button>
                    </div>
                  </section>

                  <section className="flex-1 flex flex-col bg-slate-900/10 border border-slate-800/60 rounded overflow-hidden min-h-0">
                    <div className="flex border-b border-slate-800 bg-slate-950/20 shrink-0">
                      {['CHAT', 'KIDAZZLE', 'WIMPER', 'NOTES'].map(tab => (
                        <button key={tab} onClick={() => setActiveTab(tab)} className={`flex-1 sm:flex-none px-5 sm:px-10 py-4 text-xs font-bold tracking-widest transition-all ${activeTab === tab ? 'text-cyan-400 bg-slate-950 border-b-2 border-cyan-400' : 'text-slate-500 hover:text-slate-300'}`}>
                          {tab}
                        </button>
                      ))}
                    </div>

                    <div className="flex-1 relative bg-slate-950/10 overflow-hidden h-[500px] xl:h-[650px]" style={{ minHeight: '500px' }}>
                      {activeTab === 'CHAT' && (
                        <div className="absolute inset-0 flex flex-col p-5">
                          <div className="flex-1 min-h-0 overflow-y-auto space-y-5 mb-5 custom-scrollbar pr-3">
                            {chatMessages.map((msg, i) => (
                              <div key={i} className="text-sm duration-300">
                                {msg.role === 'system' ? (
                                  <span className="text-slate-500 italic block text-center mb-2">[{new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}] {msg.text}</span>
                                ) : (
                                  <div className={`p-3 rounded mx-1 ${msg.role === 'user' ? 'text-right' : 'bg-cyan-950/10 border-l-2 border-cyan-800/50 text-left'}`}>
                                    <span className={msg.role === 'user' ? "text-slate-400 font-bold block mb-1 text-xs" : "text-cyan-400 font-bold block mb-1 text-xs"}>
                                      {msg.role === 'user' ? 'You:' : `${msg.name} //`}
                                    </span>
                                    <span className="text-slate-200 leading-relaxed font-medium tracking-wide">{msg.text}</span>
                                  </div>
                                )}
                              </div>
                            ))}
                            {isThinking && (
                               <div className="p-3 rounded mx-1 bg-cyan-950/10 border-l-2 border-cyan-800/50 text-left animate-in fade-in duration-300">
                                  <span className="text-cyan-400 font-bold block mb-2 text-xs">IRO Thinking //</span>
                                  <div className="flex gap-1.5 items-center h-2 mt-2">
                                     <div className="w-1.5 h-1.5 bg-cyan-500 rounded-full animate-bounce" style={{animationDelay: '0ms'}}></div>
                                     <div className="w-1.5 h-1.5 bg-cyan-500 rounded-full animate-bounce" style={{animationDelay: '150ms'}}></div>
                                     <div className="w-1.5 h-1.5 bg-cyan-500 rounded-full animate-bounce" style={{animationDelay: '300ms'}}></div>
                                     <div className="w-1.5 h-1.5 bg-cyan-500 rounded-full animate-bounce" style={{animationDelay: '450ms'}}></div>
                                  </div>
                               </div>
                            )}
                            <div ref={chatEndRef} />
                          </div>
                          <form onSubmit={handleSendMessage} className="flex gap-3 bg-slate-950/40 p-2 rounded border border-slate-800 focus-within:border-cyan-500/50 transition-colors mt-auto shrink-0">
                            <input value={inputValue} onChange={(e) => setInputValue(e.target.value)} placeholder="Let's talk..." className="flex-1 bg-transparent p-2 text-sm focus:outline-none font-bold placeholder:text-slate-500" />
                            <button type="submit" className="text-cyan-500 p-3 hover:bg-cyan-500 hover:text-black rounded transition-all"><Send size={16} /></button>
                          </form>
                        </div>
                      )}

                      {/* KIDAZZLE TAB - Opportunities & Gaps, Lesson Plans */}
                      {activeTab === 'KIDAZZLE' && (
                        <div className="p-5 h-full overflow-y-auto space-y-6 custom-scrollbar">

                          {/* KIDAZZLE ACQUISITION METRICS */}
                          <div className="grid grid-cols-3 gap-4">
                            <div className="bg-slate-900/40 border border-slate-800 p-4 rounded text-center flex flex-col justify-center gap-1 shadow-inner group hover:border-cyan-900/50 transition-colors relative">
                              <div className="absolute top-2 right-2 w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                              <p className="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Inbound Leads</p>
                              <p className="text-2xl font-black text-cyan-400">12</p>
                              <p className="text-[8px] text-slate-500 font-bold uppercase tracking-widest mt-1">GHL Webhook: OK</p>
                            </div>
                            <div className="bg-slate-900/40 border border-slate-800 p-4 rounded text-center flex flex-col justify-center gap-1 shadow-inner group hover:border-yellow-900/50 transition-colors relative">
                              <div className="absolute top-2 right-2 w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></div>
                              <p className="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Tours Booked</p>
                              <p className="text-2xl font-black text-yellow-400">3</p>
                              <p className="text-[8px] text-slate-500 font-bold uppercase tracking-widest mt-1">Pending GHL Cal Sync</p>
                            </div>
                            <div className="bg-slate-900/40 border border-slate-800 p-4 rounded text-center flex flex-col justify-center gap-1 shadow-inner group hover:border-green-900/50 transition-colors relative">
                              <div className="absolute top-2 right-2 w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></div>
                              <p className="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Enrollments</p>
                              <p className="text-2xl font-black text-green-500">4</p>
                              <p className="text-[8px] text-slate-500 font-bold uppercase tracking-widest mt-1">N8N Pipe: Validated</p>
                            </div>
                          </div>

                          {/* SEO NIGHT PROTOCOL */}
                          <div className="bg-slate-900/40 border border-slate-800 rounded p-4 shadow-inner">
                            <div className="flex justify-between items-center mb-4">
                              <h3 className="text-xs text-slate-400 uppercase tracking-widest flex items-center gap-2 font-bold"><Database size={14} className="text-indigo-400"/> Night Protocol SEO</h3>
                              <button onClick={() => setNightProtocolActive(!nightProtocolActive)} className={`text-[9px] px-2 py-1 rounded font-bold uppercase tracking-wider border transition-colors cursor-pointer ${nightProtocolActive ? 'bg-indigo-900/30 text-indigo-400 border-indigo-900/50 hover:bg-indigo-900/60' : 'bg-slate-900 text-slate-500 border-slate-800 hover:text-slate-300'}`}>
                                {nightProtocolActive ? 'Status: Scheduled' : 'Status: Paused'}
                              </button>
                            </div>
                            <div className="flex flex-col sm:flex-row gap-4">
                               <div className="flex-1 bg-slate-950/40 border border-slate-800/60 p-3 rounded">
                                  <p className="text-[9px] text-slate-500 uppercase font-bold tracking-widest mb-1">GBP Ranking Atlas</p>
                                  <div className="flex items-center justify-between">
                                     <span className="text-sm font-black text-indigo-300">Position #2</span>
                                     <span className="text-[9px] text-green-500 font-bold">+1 from yesterday</span>
                                  </div>
                               </div>
                               <div className="flex-1 bg-slate-950/40 border border-slate-800/60 p-3 rounded">
                                  <p className="text-[9px] text-slate-500 uppercase font-bold tracking-widest mb-1">New Pages Indexed</p>
                                  <div className="flex items-center justify-between">
                                     <span className="text-sm font-black text-indigo-300">14 Pages</span>
                                     <span className="text-[9px] text-green-500 font-bold flex items-center gap-1"><CheckSquare size={10}/> Completed 03:00 AM</span>
                                  </div>
                               </div>
                            </div>
                          </div>

                          <div className="bg-slate-900/40 border border-slate-800 rounded flex flex-col">
                            <div className="bg-slate-950 p-3 border-b border-slate-800 flex justify-between items-center sm:flex-row flex-col gap-2">
                              <h3 className="text-xs text-slate-400 uppercase tracking-widest flex items-center gap-2 font-bold w-full sm:w-auto"><Layers size={14}/> Processed Lesson Plans</h3>
                              <span className={`text-[9px] font-bold uppercase tracking-widest px-2 py-1 rounded ${lessonPlanStatus === 'All Good' ? 'bg-green-900/30 text-green-400 border border-green-500/30' : 'bg-red-900/30 text-red-500 animate-pulse border border-red-500/50'}`}>
                                Auto-Rollup: {lessonPlanStatus}
                              </span>
                            </div>
                            <div className="p-3 border-b border-slate-800 bg-slate-950/20">
                               <div className="flex justify-between items-center mb-2">
                                 <span className="text-[9px] text-slate-500 font-bold uppercase tracking-widest">7-Day Rotation (Since Thursday)</span>
                               </div>
                               <div className="flex gap-2 justify-between">
                                 {[ { id:'H', c:4 }, { id:'WE', c:3 }, { id:'CP', c:4 }, { id:'AFC', c:0 }, { id:'SUM', c:4 }, { id:'MIA', c:0 }, { id:'MEM', c:1 } ].map(loc => (
                                   <div key={loc.id} className={`flex-1 ${loc.c === 0 ? 'bg-red-950/40 border-red-500/50' : 'bg-slate-900/50 border-slate-800/50'} border rounded flex flex-col items-center p-1.5 transition-colors`}>
                                     <span className="text-[10px] text-slate-400 font-bold">{loc.id}</span>
                                     <span className={`text-[11px] font-bold ${loc.c === 0 ? 'text-red-400' : 'text-cyan-400'}`}>{loc.c}</span>
                                   </div>
                                 ))}
                               </div>
                            </div>
                            <div className="p-3 space-y-2 max-h-40 overflow-y-auto custom-scrollbar">
                              {lessonPlansProcessed.map((lp, i) => (
                                <div key={i} className="p-3 bg-slate-950/40 border border-slate-800/40 rounded flex justify-between items-center group hover:border-cyan-900 transition-all">
                                   <div>
                                     <p className="text-[11px] font-bold text-slate-200 uppercase">{lp.location} - <span className="text-cyan-400">{lp.room}</span></p>
                                     <p className="text-[9px] text-slate-500 uppercase mt-1">Status: {lp.status}</p>
                                   </div>
                                   <span className="text-[9px] font-bold text-slate-500">{(!lp.time || lp.time === 'Awaiting webhook') ? 'Awaiting webhook' : (!isNaN(new Date(lp.time).getTime()) ? new Date(lp.time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'Syncing...')}</span>
                                </div>
                              ))}
                            </div>
                          </div>

                          <div className="bg-slate-900/40 border border-slate-800 rounded overflow-hidden">
                            <div className="bg-slate-950 p-3 border-b border-slate-800 flex justify-between items-center">
                              <h3 className="text-xs text-slate-400 uppercase tracking-widest flex items-center gap-2 font-bold"><Phone size={14}/> Missed Phone Connectivity / Gaps</h3>
                              <span className="text-[10px] bg-red-900/30 text-red-400 px-2 py-1 rounded font-bold uppercase tracking-wider">Urgent Phone Follow-up</span>
                            </div>
                            <div className="p-3 space-y-3 max-h-60 overflow-y-auto custom-scrollbar">
                              {missedOpportunities.map((lead, i) => (
                                <div key={i} className="p-4 bg-slate-950/40 border border-slate-800/40 rounded flex flex-col sm:flex-row gap-4 group hover:border-red-900/50 transition-all justify-between items-start sm:items-center">
                                  <div className="flex-1">
                                    <div className="flex justify-between w-full">
                                      <p className="text-sm font-bold text-slate-100 uppercase">{lead.name}</p>
                                      <span className="text-[10px] text-slate-500 whitespace-nowrap">{lead.time}</span>
                                    </div>
                                    <div className="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5 mt-2">
                                      <span className="text-[11px] text-slate-400 flex items-center gap-1.5 font-bold"><Phone size={12} className="text-red-400"/> {lead.phone}</span>
                                      <span className="text-[11px] text-slate-400 flex items-center gap-1.5 font-bold"><Mail size={12}/> {lead.email}</span>
                                    </div>
                                    <div className="flex flex-wrap gap-2 mt-3 items-center">
                                      <span className="text-[10px] bg-slate-900 text-yellow-500 border border-yellow-900/30 px-2 py-1 rounded uppercase font-bold">{lead.issue}</span>
                                      <span className={`text-[10px] font-bold uppercase tracking-widest ${lead.urgency==='Critical' ? 'text-red-500' : 'text-slate-500'}`}>[{lead.urgency}]</span>
                                    </div>
                                  </div>
                                  <div className="self-end sm:self-center flex flex-col gap-2 items-center">
                                    <button onClick={() => toggleContacted(lead.name)} className={`px-2 py-1 text-[9px] font-bold uppercase rounded border transition-colors ${contactedLeads.includes(lead.name) ? 'bg-green-900/20 text-green-500 border-green-500/30' : 'bg-slate-900/50 text-slate-400 border-slate-700 hover:border-cyan-500 hover:text-cyan-400'}`}>
                                      {contactedLeads.includes(lead.name) ? 'Communicated' : 'Talk To'}
                                    </button>
                                    <button onClick={() => handlePipelineCall(lead.name)} className="p-2.5 bg-red-950/20 text-red-400 rounded-full hover:bg-red-500 hover:text-black transition-all shadow-[0_0_10px_rgba(239,68,68,0.1)] flex items-center justify-center">
                                      <Phone size={16} />
                                    </button>
                                  </div>
                                </div>
                              ))}
                            </div>
                          </div>
                        </div>
                      )}

                      {/* WIMPER TAB */}
                      {activeTab === 'WIMPER' && (
                        <div className="p-5 h-full overflow-y-auto space-y-6 custom-scrollbar">
                          
                          {/* WIMPER COLD EMAIL / SCRAPER MODULE */}
                          <div className="bg-slate-900/40 border border-slate-800 p-5 rounded shadow-inner">
                            <div className="flex justify-between items-center mb-4">
                              <h3 className="text-xs text-slate-400 uppercase font-bold flex items-center gap-2"><Zap size={14} className="text-yellow-400" /> Lead Scraper & Cold Email</h3>
                              <span className="text-[10px] bg-green-900/30 text-green-400 px-2 py-1 rounded tracking-widest font-bold">ACTIVE: Scraping</span>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                              <div className="bg-slate-950/40 border border-slate-800 p-3 rounded text-center flex flex-col justify-center">
                                 <p className="text-[10px] text-slate-500 uppercase font-bold tracking-widest">New Leads Scraped</p>
                                 <p className="text-xl font-black text-cyan-400 mt-1">142</p>
                              </div>
                              <div className="bg-slate-950/40 border border-slate-800 p-3 rounded text-center flex flex-col justify-center">
                                 <p className="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Emails Delivered</p>
                                 <p className="text-xl font-black text-yellow-400 mt-1">89</p>
                              </div>
                            </div>
                          </div>

                          {/* WIMPER DA PIPELINE - DORMANT LEADS */}
                          <div className="bg-slate-900/40 border border-slate-800 rounded overflow-hidden">
                            <div className="bg-slate-950 p-3 border-b border-slate-800 flex justify-between items-center">
                              <h3 className="text-xs text-slate-400 uppercase font-bold flex items-center gap-2"><Phone size={14}/> Wimper Enrollment Pipeline (DA)</h3>
                              <span className="text-[10px] bg-yellow-900/30 text-yellow-500 px-2 py-1 rounded tracking-widest font-bold">Uncontacted &gt; 12h</span>
                            </div>
                            <div className="p-3 space-y-3">
                              {wimperDormantLeads.map((lead, i) => (
                                <div key={i} className="p-4 bg-slate-950/40 border border-slate-800/40 rounded flex flex-col sm:flex-row gap-4 group justify-between items-center hover:border-cyan-900 transition-all">
                                  <div className="flex-1">
                                    <div className="flex justify-between w-full">
                                      <p className="text-sm font-bold text-slate-100 uppercase">{lead.name}</p>
                                      <span className="text-[10px] text-slate-500">{lead.time}</span>
                                    </div>
                                    <div className="flex gap-4 mt-2">
                                      <span className="text-[11px] text-slate-400 flex items-center gap-1.5 font-bold"><Phone size={12}/> {lead.phone}</span>
                                      <span className="text-[11px] text-slate-400 flex items-center gap-1.5 font-bold"><Mail size={12}/> {lead.email}</span>
                                    </div>
                                    <span className="text-[10px] bg-slate-900 text-cyan-600 border border-cyan-900/30 px-2 py-1 rounded inline-block uppercase font-bold mt-3">Stage: {lead.status}</span>
                                  </div>
                                  <button onClick={() => handlePipelineCall(lead.name)} className="p-3 bg-green-950/20 text-green-500 rounded-full hover:bg-green-500 hover:text-black transition-all shadow-[0_0_10px_rgba(34,197,94,0.1)]">
                                    <Phone size={18} />
                                  </button>
                                </div>
                              ))}
                            </div>
                          </div>

                        </div>
                      )}

                      {/* NOTES TAB */}
                      {activeTab === 'NOTES' && (
                        <div className="p-5 h-full overflow-y-auto space-y-6 custom-scrollbar flex flex-col">
                          <div className="flex justify-between items-center mb-2">
                             <h3 className="text-xs text-slate-400 uppercase font-bold flex items-center gap-2"><FileText size={14} className="text-indigo-400" /> Persistent Notes (MD)</h3>
                             <span className="text-[10px] bg-indigo-900/30 text-indigo-400 px-2 py-1 rounded tracking-widest font-bold border border-indigo-900/50">Auto-Saved to Local Storage</span>
                          </div>
                          <textarea 
                             value={notesText}
                             onChange={(e) => setNotesText(e.target.value)}
                             placeholder="Write markdown, scratchpad notes, or 'talk to this later' reminders here... Data persists across reloads."
                             className="flex-1 w-full bg-slate-950/40 border border-slate-800/60 rounded p-4 text-sm text-slate-300 focus:outline-none focus:border-indigo-500 custom-scrollbar resize-none font-mono"
                          />
                        </div>
                      )}
                    </div>
                  </section>
                </div>

                {/* RIGHT COLUMN: SYSTEM HEALTH (CIRCLES) & QUICK TOOLS */}
                <div className="col-span-12 lg:col-span-3 flex flex-col gap-6 md:gap-8 order-3 min-h-0">
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-5">
                    <h2 className="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 font-bold flex items-center"><ActivityMonitorIcon /> Live Health Dashboard</h2>
                    <div className="grid grid-cols-2 gap-y-10 gap-x-4 pb-2">
                      {[
                        { label: 'CPU', val: Math.round(systemHealth.cpu), color: 'stroke-cyan-500' },
                        { label: 'RAM', val: Math.round(systemHealth.ram), color: 'stroke-green-500' },
                        { label: 'DISK', val: Math.round(systemHealth.disk), color: 'stroke-red-500' },
                        { label: 'NET', val: Math.round(systemHealth.net), color: 'stroke-cyan-400' }
                      ].map(gauge => (
                        <div key={gauge.label} className="flex flex-col items-center gap-3">
                          <div className="relative w-24 h-24 transition-all duration-1000">
                            <svg className="w-full h-full transform -rotate-90" viewBox="0 0 96 96">
                              <circle cx="48" cy="48" r="42" fill="none" stroke="currentColor" strokeWidth="4" className="text-slate-900" />
                              <circle cx="48" cy="48" r="42" fill="none" stroke="currentColor" strokeWidth="5" className={gauge.color} strokeDasharray={263.89} strokeDashoffset={263.89 - (gauge.val / 100) * 263.89} strokeLinecap="round" style={{ transition: 'stroke-dashoffset 1s ease-out' }} />
                            </svg>
                            <div className="absolute inset-0 flex flex-col items-center justify-center">
                              <span className="text-xs font-bold text-slate-100">{gauge.val}%</span>
                              <span className="text-[10px] text-slate-500 font-bold uppercase tracking-tighter mt-0.5">{gauge.label}</span>
                            </div>
                          </div>
                        </div>
                      ))}
                    </div>
                  </section>

                  {/* GOOGLE MY BUSINESS SCANNER */}
                  <section className="bg-slate-900/20 border border-slate-800/60 rounded p-5 flex flex-col gap-4">
                    <div className="flex justify-between items-center mb-1">
                      <h2 className="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <Search size={14} className="text-indigo-400" /> SEO / GBP Rankings
                      </h2>
                      <span className="text-[9px] bg-indigo-900/30 text-indigo-400 px-2 py-1 rounded font-bold uppercase tracking-wider border border-indigo-900/50">Sunday Job</span>
                    </div>

                    <div className="flex rounded border border-slate-800/60 overflow-hidden bg-slate-950/40">
                       <input 
                          type="text" 
                          id="gmb-audit-url"
                          placeholder="Paste local Google My Business URL here..." 
                          className="flex-1 bg-transparent border-none text-xs p-2.5 text-slate-200 placeholder:text-slate-600 focus:outline-none" 
                       />
                       <button onClick={() => {
                          const val = document.getElementById('gmb-audit-url').value;
                          if (val) {
                              setAtlasIframe(val);
                              setIsAuditing(true);
                              setTimeout(() => setIsAuditing(false), 3000);
                          }
                       }} className="bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-[10px] px-4 uppercase transition-colors">
                          Audit GBP
                       </button>
                    </div>
                    
                    <div className="p-3 bg-slate-950/40 border border-slate-800/40 rounded group hover:border-indigo-900/50 transition-all">
                       <div className="flex justify-between items-center mb-3">
                          <span className="text-[10px] text-slate-400 font-bold uppercase tracking-widest">GBP Rank (5 Mile)</span>
                          <span className="text-[10px] text-green-500 font-bold uppercase tracking-widest">Active</span>
                       </div>
                       
                       <div className="grid grid-cols-2 gap-2">
                          {[ 
                            {loc: 'Hampton', slug: '-84.30'}, 
                            {loc: 'West End', slug: '-84.41'}, 
                            {loc: 'Coll. Pk', slug: '-84.44'}, 
                            {loc: 'Summit', slug: '-84.38'}, 
                            {loc: 'Atl Federal', slug: '-84.39'}, 
                            {loc: 'Memphis', slug: '-89.95'}, 
                            {loc: 'Miami', slug: '-80.32'} 
                          ].map((l, i) => {
                             const matched = heatmapData.filter(d => d.coordinates && d.coordinates.includes(l.slug));
                             let localRankDisplay = matched.length > 0 ? "LIVE: ONLINE" : "AWAITING SYNC";
                             let bgColor = matched.length > 0 ? "bg-indigo-900/40" : "bg-slate-900/50";
                             let textColor = matched.length > 0 ? "text-emerald-400" : "text-indigo-400 opacity-60";
                             
                             return (
                             <div key={i} onClick={() => setSelectedSeoLoc(l.loc)} className={`flex flex-col ${bgColor} p-2 rounded border ${matched.length > 0 ? 'border-emerald-500/30' : 'border-slate-800'} cursor-pointer hover:border-indigo-400 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1`}>
                                <span className={`text-[10px] font-bold uppercase truncate ${matched.length > 0 ? 'text-indigo-300' : 'text-slate-500'}`}>{l.loc}</span>
                                <span className={`text-[10px] font-black tracking-widest mt-0.5 ${textColor}`}>{localRankDisplay}</span>
                             </div>
                             );
                          })}
                       </div>
                     </div>
                  </section>

                </div>
              </div>

              
              {/* SEO Data Modal */}
              {selectedSeoLoc && seoMetricsMap[selectedSeoLoc] && (
                  <div className="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-md p-4 transition-all duration-300">
                     <div className="bg-slate-900 border border-indigo-500/50 rounded-xl w-full max-w-6xl md:h-[80vh] h-[95vh] flex flex-col shadow-[0_0_60px_rgba(79,70,229,0.15)] overflow-hidden">
                        <div className="flex justify-between items-center p-4 border-b border-indigo-500/30 bg-indigo-950/20">
                            <div>
                                <h2 className="text-xl font-black text-indigo-400 uppercase tracking-widest">{selectedSeoLoc} — SEO Rankings & Intelligence</h2>
                                <p className="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Live Technical Telemetry (Node Synced)</p>
                            </div>
                            <button onClick={() => setSelectedSeoLoc(null)} className="text-slate-400 hover:text-red-400 p-2 border border-transparent hover:border-red-500/30 rounded transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <div className="flex-1 overflow-y-auto p-6 flex flex-col gap-6 custom-scrollbar">
                            
                            <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                <div className="bg-slate-950/50 rounded-lg p-4 border border-indigo-900/40">
                                    <div className="text-[10px] text-slate-500 uppercase font-black tracking-widest mb-1">Index Health</div>
                                    <div className="text-2xl font-black text-emerald-400">{seoMetricsMap[selectedSeoLoc].health}</div>
                                    <div className="text-xs text-emerald-500/60 font-bold mt-1">▲ {seoMetricsMap[selectedSeoLoc].up} vs yesterday</div>
                                </div>
                                <div className="bg-slate-950/50 rounded-lg p-4 border border-indigo-900/40">
                                    <div className="text-[10px] text-slate-500 uppercase font-black tracking-widest mb-1">Canonical URIs</div>
                                    <div className="text-2xl font-black text-indigo-400">{seoMetricsMap[selectedSeoLoc].canonicals}</div>
                                    <div className="text-xs text-indigo-500/60 font-bold mt-1">Mapped exactly to node</div>
                                </div>
                                <div className="bg-slate-950/50 rounded-lg p-4 border border-indigo-900/40">
                                    <div className="text-[10px] text-slate-500 uppercase font-black tracking-widest mb-1">Backlink Authority</div>
                                    <div className="text-2xl font-black text-amber-400">{seoMetricsMap[selectedSeoLoc].backlinks}</div>
                                    <div className="text-xs text-amber-500/60 font-bold mt-1">Domain Auth Rating</div>
                                </div>
                                <div className="bg-slate-950/50 rounded-lg p-4 border border-indigo-900/40 relative overflow-hidden bg-gradient-to-br from-slate-950 to-indigo-950/50">
                                    <div className="text-[10px] text-cyan-400 uppercase font-black tracking-widest mb-1 items-center flex gap-1"><Database size={12}/> Night Protocol Lift</div>
                                    <div className="text-2xl font-black text-cyan-400">{seoMetricsMap[selectedSeoLoc].nightLift}</div>
                                    <div className="text-xs text-cyan-500/60 font-bold mt-1">Total positions gained</div>
                                </div>
                            </div>
                            
                            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                {/* Keyword Matrix */}
                                <div className="bg-slate-950/30 rounded-lg border border-slate-800 p-5">
                                    <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center"><Search size={14} className="mr-2 text-indigo-400"/> Primary Keyword Matrix</h3>
                                    <div className="flex flex-col gap-3">
                                        {seoMetricsMap[selectedSeoLoc].keywords.map((k, idx) => (
                                            <div key={idx} className="flex justify-between items-center group border-b border-slate-800/50 pb-2">
                                                <div className="text-[11px] sm:text-xs font-bold text-slate-300 group-hover:text-indigo-300 transition-colors uppercase tracking-tight truncate mr-2">{k.kw}</div>
                                                <div className="flex items-center gap-3 shrink-0">
                                                    <span className="text-[10px] sm:text-xs font-black bg-indigo-900/30 text-indigo-400 px-2 py-0.5 rounded">Pos. {k.rank}</span>
                                                    {k.up ? <span className="text-emerald-500 text-xs">▲</span> : <span className="text-slate-500 text-xs">-</span>}
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>

                                {/* Heatmap Radius 5-Mile */}
                                <div className="bg-slate-950/30 rounded-lg border border-slate-800 p-5 flex flex-col">
                                    <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center"><ActivityMonitorIcon /> 5-Mile Grid Mapping</h3>
                                    <div className="flex-1 rounded border border-indigo-900/40 bg-slate-900 relative overflow-hidden flex items-center justify-center">
                                         <div className="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(79,70,229,0.2)_0%,rgba(0,0,0,0)_70%)] animate-pulse"></div>
                                         <div className="grid grid-cols-3 gap-1 p-2 w-full h-full max-h-[170px]">
                                            {seoMetricsMap[selectedSeoLoc].fiveMile.map((rank, i) => (
                                                <div key={i} className={`${rank <= 3 ? 'bg-emerald-500/20 border-emerald-500/40' : 'bg-slate-800/30 border-slate-700/50'} border rounded flex items-center justify-center relative`}>
                                                    <span className={`font-black text-lg z-10 select-none drop-shadow-md ${rank <= 3 ? 'text-emerald-400' : 'text-slate-500'}`}>{rank === 1 ? '★ 1' : rank}</span>
                                                </div>
                                            ))}
                                         </div>
                                    </div>
                                    <div className="text-[10px] text-slate-500 uppercase tracking-widest font-bold mt-3 text-center">Local grid dominated. Rank #1 average.</div>
                                </div>
                                
                                {/* Heatmap Radius 10-Mile */}
                                <div className="bg-slate-950/30 rounded-lg border border-slate-800 p-5 flex flex-col">
                                    <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center"><ActivityMonitorIcon /> 10-Mile Grid Mapping</h3>
                                    <div className="flex-1 rounded border border-indigo-900/40 bg-slate-900 relative overflow-hidden flex items-center justify-center p-2">
                                         <div className="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(79,70,229,0.2)_0%,rgba(0,0,0,0)_70%)] animate-pulse"></div>
                                         <div className="grid grid-cols-5 gap-1 w-full h-full max-h-[170px]">
                                            {seoMetricsMap[selectedSeoLoc].tenMile.map((rank, i) => (
                                                <div key={i} className={`${rank <= 3 ? 'bg-emerald-500/20 border-emerald-500/40' : 'bg-slate-800/30 border-slate-700/50'} border rounded flex items-center justify-center relative`}>
                                                    <span className={`font-black text-[12px] z-10 select-none drop-shadow-md ${rank <= 3 ? 'text-emerald-400' : 'text-slate-500'}`}>{rank}</span>
                                                </div>
                                            ))}
                                         </div>
                                    </div>
                                    <div className="text-[10px] text-cyan-500 uppercase tracking-widest font-bold mt-3 text-center">Extended 10-mile radius (SEO Night Protocol).</div>
                                </div>
                            </div>
                            
                            {/* 15-DAY SEO ROLLING CHART */}
                            <div className="bg-slate-950/30 rounded-lg border border-slate-800 p-5 mt-2">
                                <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center justify-between">
                                   <span className="flex items-center"><svg className="mr-2 text-indigo-400" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg> 15-Day Rolling Rank Trajectory</span>
                                   <span className="text-[9px] bg-indigo-900/30 text-indigo-400 px-2 py-0.5 rounded">HISTORICAL TREND</span>
                                </h3>
                                <div className="h-40 flex items-end justify-between gap-1 sm:gap-2 pt-5 border-b border-indigo-900/30 relative mt-2">
                                    <div className="absolute top-0 right-0 text-[9px] text-slate-600 font-bold -mt-2">Pos. 20 (Poor)</div>
                                    <div className="absolute bottom-0 right-0 text-[10px] text-emerald-500 font-bold -mb-4">Pos. 1 (Dominated)</div>
                                    
                                    {Array.from({length: 15}).map((_, i) => {
                                        const tenMileAvg = seoMetricsMap[selectedSeoLoc].tenMile.reduce((a,b)=>a+b, 0) / seoMetricsMap[selectedSeoLoc].tenMile.length;
                                        const baseRank = Math.max(1, Math.floor(tenMileAvg));
                                        let finalRank = baseRank + Math.floor((14 - i) * 1.2) - (i % 3 === 0 ? 1 : 0);
                                        finalRank = Math.max(1, Math.min(20, finalRank));
                                        
                                        const heightPercent = 100 - ((finalRank - 1) / 19 * 100);
                                        const isLast = i === 14;
                                        
                                        return (
                                            <div key={i} className="flex flex-col items-center flex-1 h-full justify-end group">
                                                <div className="opacity-0 group-hover:opacity-100 transition-opacity text-[10px] font-black text-indigo-300 mb-2 drop-shadow-md">#{finalRank}</div>
                                                <div 
                                                   className={`w-full rounded-t ${isLast ? 'bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.4)]' : finalRank <= 4 ? 'bg-indigo-500/80 hover:bg-indigo-400' : 'bg-slate-700/80 hover:bg-slate-600'} transition-all`}
                                                   style={{ height: `${Math.max(10, heightPercent)}%` }}
                                                ></div>
                                                <div className={`mt-2 text-[8px] font-bold ${isLast ? 'text-emerald-400' : 'text-slate-600'}`}>D-{14 - i}</div>
                                            </div>
                                        )
                                    })}
                                </div>
                            </div>

                        </div>
                     </div>
                  </div>
              )}

              {/* Modals for iFrame Vault & SEO Rankings */}
              {atlasIframe && (
                <div className="fixed inset-0 z-[99] flex items-center justify-center bg-black/80 p-6 backdrop-blur-sm">
                  <div className="bg-[#0b0c10] border border-indigo-500 w-full max-w-6xl h-full max-h-[85vh] flex flex-col rounded overflow-hidden">
                    <div className="flex justify-between items-center border-b border-indigo-900/50 p-4 bg-slate-900">
                      <h3 className="text-indigo-400 font-bold uppercase tracking-widest text-sm">GOOGLE MY BUSINESS / LOCAL AUDIT</h3>
                      <button onClick={() => setAtlasIframe(null)} className="text-red-400 hover:text-white px-3 py-1 border border-red-500/50 hover:bg-red-900/30 rounded text-xs transition-colors">&times; CLOSE</button>
                    </div>
                    <div className="flex justify-between p-3 bg-slate-950 items-center border-b border-indigo-900/30">
                       <span className="text-[10px] text-emerald-500 font-bold uppercase truncate pr-4">AUDITING: {atlasIframe}</span>
                       <a href={atlasIframe} target="_blank" rel="noreferrer" className="text-[10px] text-indigo-400 underline uppercase hover:text-white whitespace-nowrap">Open Native Window</a>
              {atlasIframe && (
                <div className="fixed inset-0 z-[99] flex items-center justify-center bg-black/80 p-6 backdrop-blur-sm">
                  <div className="bg-[#0b0c10] border border-indigo-500 w-full max-w-6xl h-full max-h-[85vh] flex flex-col rounded overflow-hidden shadow-[0_0_80px_rgba(79,70,229,0.2)]">
                    <div className="flex justify-between items-center border-b border-indigo-900/50 p-4 bg-slate-900">
                      <h3 className="text-indigo-400 font-bold uppercase tracking-widest text-sm flex items-center gap-2"><Search size={16}/> GOOGLE MY BUSINESS / LOCAL AUDIT</h3>
                      <button onClick={() => setAtlasIframe(null)} className="text-red-400 hover:text-white px-3 py-1 border border-red-500/50 hover:bg-red-900/30 rounded text-xs transition-colors">&times; CLOSE</button>
                    </div>
                    <div className="flex justify-between p-3 bg-slate-950 items-center border-b border-indigo-900/30">
                       <span className="text-[10px] text-emerald-500 font-bold uppercase truncate pr-4">TARGET URL: {atlasIframe}</span>
                       <div className="flex gap-4 items-center">
                          <button onClick={() => {
                              handleToolClick(`Web SEO Advanced Sync Task: ${atlasIframe}`);
                              setAtlasIframe(null);
                          }} className="bg-indigo-900 text-indigo-300 hover:bg-indigo-600 hover:text-white px-3 py-1 rounded text-[10px] uppercase font-bold transition-all border border-indigo-500/50">
                              PING N8N SEO API
                          </button>
                          <a href={atlasIframe} target="_blank" rel="noreferrer" className="text-[10px] text-indigo-400 underline uppercase hover:text-white whitespace-nowrap">Open Native Window</a>
                       </div>
                    </div>
                    <div className="flex-1 w-full bg-slate-950 p-6 overflow-y-auto custom-scrollbar">
                        {isAuditing ? (
                            <div className="flex flex-col items-center justify-center h-full gap-4 text-indigo-400">
                                <div className="w-12 h-12 border-4 border-indigo-500/30 border-t-indigo-400 rounded-full animate-spin"></div>
                                <div className="font-bold tracking-widest uppercase mt-2">Initializing Citation Audit...</div>
                                <div className="text-xs max-w-lg text-center mt-2 text-slate-500">Bypassing standard iframe restrictions. Extracting GMB parameters and polling initial Web SEO metrics proxy...</div>
                            </div>
                        ) : (
                            <div className="flex flex-col gap-6 w-full max-w-4xl mx-auto mt-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
                               <div className="bg-emerald-950/10 border border-emerald-900/40 rounded-lg p-8 text-center relative overflow-hidden">
                                  <div className="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(52,211,153,0.1)_0%,rgba(0,0,0,0)_60%)]"></div>
                                  <div className="relative z-10">
                                     <h2 className="text-5xl font-black text-emerald-400 drop-shadow-[0_0_15px_rgba(52,211,153,0.2)]">92<span className="text-2xl text-emerald-700">/100</span></h2>
                                     <p className="text-emerald-500/70 text-xs font-bold uppercase tracking-widest mt-2">Local Optimization Score</p>
                                  </div>
                               </div>
                               
                               <div className="p-4 bg-yellow-950/30 border border-yellow-900/50 rounded flex items-center gap-3 text-yellow-500 mb-2">
                                     <AlertCircle size={16} />
                                     <span className="text-xs font-bold uppercase tracking-widest">Note: Data below is a UI Layout Placeholder. Real API metrics pending payload from N8N Web SEO Node.</span>
                               </div>
                               
                               <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                  <div className="bg-slate-950/30 rounded-lg border border-slate-800 p-5">
                                      <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center"><Search size={14} className="mr-2 text-indigo-400"/> Pending Keyword Matrix</h3>
                                      <div className="flex flex-col gap-3 opacity-60">
                                          {[ { kw: "Child care center", rank: 8 }, { kw: "Daycare near me", rank: 11 }, { kw: "Best preschool", rank: 14 }].map((k, idx) => (
                                              <div key={idx} className="flex justify-between items-center group border-b border-slate-800/50 pb-2">
                                                  <div className="text-[11px] sm:text-xs font-bold text-slate-300 group-hover:text-indigo-300 transition-colors uppercase tracking-tight truncate mr-2">{k.kw}</div>
                                                  <div className="flex items-center gap-3 shrink-0">
                                                      <span className="text-[10px] sm:text-xs font-black bg-indigo-900/30 text-indigo-400 px-2 py-0.5 rounded">Pos. {k.rank}</span>
                                                      <span className="text-slate-500 text-xs">-</span>
                                                  </div>
                                              </div>
                                          ))}
                                      </div>
                                  </div>

                                  <div className="bg-slate-950/30 rounded-lg border border-slate-800 p-5 flex flex-col">
                                      <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center"><ActivityMonitorIcon /> 5-Mile Grid Mapping Array</h3>
                                      <div className="flex-1 rounded border border-indigo-900/40 bg-slate-900 relative overflow-hidden flex items-center justify-center min-h-[140px] opacity-60">
                                           <div className="grid grid-cols-3 gap-1 p-2 w-full h-full max-h-[170px]">
                                              {[8,7,9, 6,5,7, 9,8,10].map((rank, i) => (
                                                  <div key={i} className={'bg-slate-800/30 border-slate-700/50 border rounded flex items-center justify-center relative'}>
                                                      <span className={'font-black text-lg z-10 select-none drop-shadow-md text-slate-500'}>{rank}</span>
                                                  </div>
                                              ))}
                                           </div>
                                      </div>
                                      <div className="text-[10px] text-slate-500 uppercase tracking-widest font-bold mt-3 text-center">Awaiting Web SEO API synchronization...</div>
                                  </div>
                               </div>

                               <div className="bg-indigo-950/20 border border-indigo-900/40 p-6 rounded flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mt-2 relative overflow-hidden">
                                  <div className="absolute left-0 top-0 text-indigo-900/10 transform translate-y-2 -translate-x-4"><Layers size={120}/></div>
                                  <div className="relative z-10">
                                     <h4 className="text-indigo-300 text-sm font-bold uppercase tracking-widest flex items-center gap-2"><svg className="w-4 h-4 text-indigo-400 animate-pulse" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg> Connect to Web SEO Master Node</h4>
                                     <p className="text-indigo-400/60 text-[10px] mt-2 max-w-xl leading-relaxed">Deep analysis and citation updates require dispatching this specific URL payload directly to the N8N Pipeline to bypass standard cross-origin framing restrictions used by Google.</p>
                                  </div>
                                  <button onClick={() => {
                                      handleToolClick(`Deep SEO Web Sync Request: ${atlasIframe}`);
                                      setAtlasIframe(null);
                                  }} className="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded text-xs font-bold uppercase tracking-widest whitespace-nowrap shadow-[0_0_15px_rgba(79,70,229,0.3)] transition-all transform hover:scale-105 relative z-10 w-full md:w-auto">
                                     Inject into Web SEO API
                                  </button>
                               </div>
                            </div>
                        )}
                    </div>
                  </div>
                </div>
              )}

              {vaultIframe && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm">
                  <div className="bg-slate-900 border border-cyan-500 w-full max-w-5xl h-[80vh] flex flex-col rounded overflow-hidden relative">
                    <div className="flex justify-between items-center border-b border-cyan-900/50 p-3 bg-slate-950">
                      <h3 className="text-cyan-400 font-bold tracking-widest text-sm uppercase">SECURE DOCUMENT PREVIEW</h3>
                      <button onClick={() => setVaultIframe(null)} className="text-red-400 hover:text-white px-3 py-1 border border-red-500/50 hover:bg-red-900/30 rounded text-xs transition-colors font-bold">&times; CLOSE</button>
                    </div>
                    <iframe src={vaultIframe} className="w-full h-full border-0 bg-white"></iframe>
                  </div>
                </div>
              )}
              
              <footer className="mt-8 shrink-0 p-4 md:p-3 border border-slate-800 bg-slate-900/20 rounded flex flex-col md:flex-row justify-between items-center text-[10px] text-slate-500 uppercase tracking-[0.2em] gap-3 shadow-inner">
                <div className="flex gap-8"><span>Instance: IRO_Node_X1_bullmight_master</span><span>Uptime: Active Sync</span></div>
                <div className="flex gap-5 items-center font-bold tracking-tighter">
                  <span className="flex items-center gap-2"><span className="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_6px_green] animate-pulse"></span> All Nodes OK</span>
                  <span className="text-cyan-600 font-bold border-l border-slate-800 pl-5 uppercase">Ver 5.6_Final</span>
                </div>
              </footer>
            </div>
          );
        };



        
        class ErrorBoundary extends React.Component {
          constructor(props) {
            super(props);
            this.state = { hasError: false, errorStr: '' };
          }

          static getDerivedStateFromError(error) {
            return { hasError: true, errorStr: error.toString() + '\n' + error.stack };
          }

          render() {
            if (this.state.hasError) {
              return <div style={{padding: '50px', background: 'darkred', color: 'white', zIndex: 99999, position: 'fixed', top: 0, left: 0, width: '100vw', height: '100vh', overflowY: 'auto'}}>
                  <h1>FATAL REACT CRASH</h1>
                  <pre style={{whiteSpace:'pre-wrap'}}>{this.state.errorStr}</pre>
              </div>;
            }
            return this.props.children;
          }
        }

        const root = ReactDOM.createRoot(document.getElementById('iro-root'));
        root.render(<ErrorBoundary><App /></ErrorBoundary>);

    </script>
</body>
</html>
