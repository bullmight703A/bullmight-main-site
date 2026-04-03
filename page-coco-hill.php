<?php
/**
 * Template Name: Coco Hill Console
 */
if (isset($_GET['iro_proxy'])) {
    $action = $_GET['iro_proxy'];
    $url = ($action === 'action') 
        ? "https://iro-bullmight-action16.loca.lt/api/" . $action 
        : "https://iro-bullmight-bridge14.loca.lt/api/" . $action;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Bypass-Tunnel-Reminder: true", "Content-Type: application/json"]);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));
    }
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    http_response_code($httpCode ? $httpCode : 500);
    echo $response;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coco Hill Console</title>
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

        const Mic = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" x2="12" y1="19" y2="22"/></svg>;
        const Paperclip = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>;
        const Send = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>;
        const FileText = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>;
        const Camera = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>;
        const Sparkles = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>;
        const ChevronRight = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><path d="m9 18 6-6-6-6"/></svg>;
        const Palette = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.992 6.012 17.5 2 12 2z"/></svg>;
        const ShoppingBag = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>;
        const Calendar = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>;
        const Layers = ({size=24, className=''}) => <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 12 12 17 22 12"/><polyline points="2 17 12 22 22 17"/></svg>;

        

const CocoHill = () => {
  const [currentTime, setCurrentTime] = useState(new Date());
  
  const [projects, setProjects] = useState([
    { name: "The Hamptons Estate", client: "Vanderbilt", stage: "Procurement", color: "bg-rose-100 text-rose-600" },
    { name: "Tribeca Penthouse", client: "Sterling", stage: "Concept", color: "bg-amber-100 text-amber-700" },
    { name: "Soho Studio", client: "Chen", stage: "Final Install", color: "bg-emerald-100 text-emerald-600" }
  ]);

  const [feed, setFeed] = useState([
    { id: 1, type: 'approval', user: 'Lead Architect', text: 'Floor plan for Hamptons Wing B is ready for your sign-off.', time: '12m ago' },
    { id: 2, type: 'status', user: 'Procurement Bot', text: 'Custom Velvet Sofa (Rosewood) has cleared customs. Estimated delivery: Tuesday.', time: '1h ago' },
    { id: 3, type: 'inquiry', user: 'New Client', text: 'Inquiry received for a 5-bedroom renovation in Greenwich.', time: '3h ago' }
  ]);

  const [inputValue, setInputValue] = useState('');
  const [isThinking, setIsThinking] = useState(false);
  const [isTTSActive, setIsTTSActive] = useState(true);
  const [isListening, setIsListening] = useState(false);
  const [activeTab, setActiveTab] = useState('chat');
  const [notes, setNotes] = useState('');
  const chatEndRef = useRef(null);

  const [attachment, setAttachment] = useState(null);
  const fileInputRef = useRef(null);

  const initialMessages = [
    { role: 'agent', text: 'Coco Hill Chat API online. Coi is at your service. How can I assist with your design queue?', name: 'COI' }
  ];
  const [chatMessages, setChatMessages] = useState(() => {
     try {
        const saved = localStorage.getItem('coco_chat_history');
        return saved ? JSON.parse(saved) : initialMessages;
     } catch(e) { return initialMessages; }
  });

  useEffect(() => {
    const timer = setInterval(() => setCurrentTime(new Date()), 1000);
    return () => clearInterval(timer);
  }, []);

  useEffect(() => {
      localStorage.setItem('coco_chat_history', JSON.stringify(chatMessages));
      chatEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [chatMessages]);

  const speakReply = (text) => {
      if (!isTTSActive || !('speechSynthesis' in window)) return;
      window.speechSynthesis.cancel();
      const utterance = new SpeechSynthesisUtterance(text);
      const voices = window.speechSynthesis.getVoices();
      const preferredVoice = voices.find(v => v.name.includes('Female')) || voices[0];
      if (preferredVoice) utterance.voice = preferredVoice;
      window.speechSynthesis.speak(utterance);
  };

  const handleDictation = () => {
      if (isListening) return;
      const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
      if (!SpeechRecognition) return;
      const recognition = new SpeechRecognition();
      recognition.onstart = () => setIsListening(true);
      recognition.onresult = (event) => {
          setInputValue(prev => prev + (prev.trim() ? " " : "") + event.results[0][0].transcript);
          setIsListening(false);
      };
      recognition.onerror = () => setIsListening(false);
      recognition.onend = () => setIsListening(false);
      recognition.start();
  };

  const handleFileSelect = (e) => {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (event) => setAttachment({ name: file.name, type: file.type, data: event.target.result, preview: file.type.startsWith('image/') ? event.target.result : null });
      reader.readAsDataURL(file);
  };

  const handleSendMessage = async (e) => {
      e.preventDefault();
      if (!inputValue.trim() && !attachment) return;
      const msg = inputValue;
      
      const newMsg = { role: 'user', text: msg };
      if (attachment) {
          newMsg.attachment = attachment.preview;
          newMsg.text = msg ? `${msg} [Attached File: ${attachment.name}]` : `[Attached File: ${attachment.name}]`;
      }
      
      setChatMessages(prev => [...prev, newMsg]);
      setInputValue('');
      setAttachment(null);
      setIsThinking(true);
      
      try {
          const proxyUrl = window.location.href.split('?')[0].replace(/\/$/, '') + '/?iro_proxy=chat';
          const payload = { message: msg, agentId: 'princess' };
          if (attachment) {
              payload.file = attachment.data;
              payload.fileName = attachment.name;
              payload.fileType = attachment.type;
          }

          const res = await fetch(proxyUrl, { 
              method: 'POST', 
              headers: { 'Content-Type': 'application/json', 'Bypass-Tunnel-Reminder': 'true' },
              body: JSON.stringify(payload)
          });
          const data = await res.json();
          setIsThinking(false);
          setChatMessages(prev => [...prev, { role: 'agent', text: data.reply || 'Acknowledged.', name: 'COI' }]);
          if(data.reply) speakReply(data.reply);
      } catch (err) {
          setIsThinking(false);
          setChatMessages(prev => [...prev, { role: 'agent', text: 'Bridge Offline. Cannot connect to OpenClaw.', name: 'SYSTEM' }]);
      }
  };

  return (
    <div className="min-h-screen bg-[#FDFCFB] text-[#5C524F] font-sans flex flex-col p-6 gap-6 selection:bg-rose-100">
      
      {/* HEADER: ELEVATED BRANDING */}
      <header className="flex items-center justify-between border-b border-[#EAE0D5] pb-6">
        <div className="flex items-center gap-5">
          <div className="w-12 h-12 bg-gradient-to-tr from-[#F4ACB7] to-[#D4A373] rounded-full flex items-center justify-center shadow-sm">
            <Sparkles className="text-white w-6 h-6" />
          </div>
          <div>
            <h1 className="text-2xl font-light tracking-[0.2em] uppercase text-[#4A423F]">
              Coco Hill <span className="font-bold text-[#D4A373]">Designs</span>
            </h1>
            <p className="text-[10px] uppercase tracking-widest text-[#B4A7A0] font-semibold mt-1">
              Mission Control <span className="mx-2">•</span> Royal Access V1.0
            </p>
          </div>
        </div>
        
        <div className="flex items-center gap-8">
          <div className="flex flex-col items-end">
            <span className="text-xs font-bold text-[#D4A373] uppercase tracking-tighter">System Status</span>
            <div className="flex items-center gap-2 text-[10px] text-emerald-500 font-bold uppercase">
              <div className="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse" />
              Creative Engines Online
            </div>
          </div>
          <div className="h-10 w-[1px] bg-[#EAE0D5]" />
          <div className="text-right">
            <div className="text-lg font-light tracking-tight text-[#4A423F]">
              {currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}
            </div>
            <div className="text-[10px] uppercase tracking-widest text-[#B4A7A0]">
              {currentTime.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}
            </div>
          </div>
        </div>
      </header>

      <div className="flex-1 grid grid-cols-12 gap-6 overflow-hidden">
        
        {/* LEFT: PROJECT FLEET & NAVIGATION */}
        <aside className="col-span-3 flex flex-col gap-6">
          <div className="space-y-4">
            <h3 className="text-[10px] uppercase tracking-[0.25em] font-black text-[#B4A7A0] px-1">Active Projects</h3>
            {projects.map((proj, i) => (
              <div key={i} className="group p-4 bg-white border border-[#EAE0D5] rounded-2xl shadow-sm hover:shadow-md hover:border-[#D4A373]/30 transition-all cursor-pointer relative overflow-hidden">
                <div className={`absolute left-0 top-0 bottom-0 w-1 ${proj.color.split(' ')[0]}`} />
                <div className="flex justify-between items-start mb-2">
                  <span className="text-sm font-bold text-[#4A423F]">{proj.name}</span>
                  <ChevronRight size={14} className="text-[#D4A373] opacity-0 group-hover:opacity-100 transition-opacity" />
                </div>
                <div className="flex justify-between items-center">
                  <span className="text-[10px] text-[#B4A7A0] uppercase font-bold tracking-tighter">{proj.client}</span>
                  <span className={`text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tighter ${proj.color}`}>
                    {proj.stage}
                  </span>
                </div>
              </div>
            ))}
          </div>

          <nav className="mt-auto space-y-2">
             <div className="text-[10px] uppercase tracking-[0.25em] font-black text-[#B4A7A0] px-1 mb-4">Studio Tools</div>
             {[
               { icon: Palette, label: 'Mood Boards', active: true },
               { icon: Layers, label: 'Render Queue', active: false },
               { icon: ShoppingBag, label: 'Procurement', active: false },
               { icon: Calendar, label: 'Install Schedule', active: false }
             ].map((item, i) => (
               <button key={i} className={`w-full flex items-center gap-3 p-3 rounded-xl transition-all font-bold text-xs ${item.active ? 'bg-[#D4A373] text-white shadow-lg shadow-tan-200' : 'text-[#8B7E74] hover:bg-white hover:text-[#D4A373]'}`}>
                 <item.icon size={16} />
                 {item.label}
               </button>
             ))}
          </nav>
        </aside>

        <main className="col-span-9 flex flex-col gap-6 overflow-hidden">

          <div className="flex-1 bg-white border border-[#EAE0D5] rounded-3xl overflow-hidden flex flex-col shadow-sm relative sticky h-[650px]" style={{ minHeight: '650px' }}>
             
             {/* TABS FOR CHAT & NOTES */}
             <div className="shrink-0 flex justify-center py-0 border-b border-[#EAE0D5] bg-[#FAF7F2]">
                <div className="flex w-full px-6 pt-4 gap-8">
                  <button 
                    onClick={() => setActiveTab('chat')} 
                    className={`pb-3 font-bold text-[10px] tracking-[0.2em] w-1/2 uppercase border-b-2 transition-all ${activeTab === 'chat' ? 'border-[#D4A373] text-[#D4A373]' : 'border-transparent text-[#B4A7A0] hover:text-[#D4A373]'}`}
                  >
                    Chat Console
                  </button>
                  <button 
                    onClick={() => setActiveTab('notes')} 
                    className={`pb-3 font-bold text-[10px] tracking-[0.2em] w-1/2 uppercase border-b-2 transition-all ${activeTab === 'notes' ? 'border-[#D4A373] text-[#D4A373]' : 'border-transparent text-[#B4A7A0] hover:text-[#D4A373]'}`}
                  >
                    Workspace Notes
                  </button>
                </div>
             </div>

             {activeTab === 'chat' ? (
                <div className="flex-1 min-h-0 overflow-y-auto p-6 space-y-6 flex flex-col pt-4">
                  {chatMessages.map((msg, i) => (
                      <div key={i} className={`flex gap-4 ${msg.role === 'user' ? 'justify-end' : 'justify-start'}`}>
                         {msg.role !== 'user' && (
                             <div className="w-10 h-10 rounded-full bg-[#FAF7F2] border border-[#EAE0D5] flex-shrink-0 flex items-center justify-center">
                                <Sparkles size={16} className="text-[#F4ACB7]" />
                             </div>
                         )}
                         <div className={`space-y-1 max-w-[85%] ${msg.role === 'user' ? 'items-end flex flex-col' : ''}`}>
                            <div className={`flex justify-between w-full ${msg.role === 'user' ? 'justify-end' : ''}`}>
                               <span className="text-[11px] font-black uppercase tracking-tighter text-[#D4A373]">
                                 {msg.role === 'user' ? 'You' : msg.name}
                               </span>
                            </div>
                            <div className={`text-sm leading-relaxed ${msg.role === 'user' ? 'bg-[#D4A373] text-white p-4 rounded-2xl rounded-tr-none shadow-sm' : 'bg-[#FAF7F2] text-[#5C524F] p-4 rounded-2xl rounded-tl-none border border-[#EAE0D5]'}`}>
                               {msg.attachment && (
                                  <div className="mb-2">
                                      <img src={msg.attachment} alt="attachment" className="max-w-[200px] rounded-lg border border-[#EAE0D5] shadow-sm inline-block" />
                                  </div>
                               )}
                               {msg.text}
                            </div>
                         </div>
                      </div>
                  ))}
                  {isThinking && (
                      <div className="flex gap-4">
                         <div className="w-10 h-10 rounded-full bg-[#FAF7F2] border border-[#EAE0D5] flex-shrink-0 flex items-center justify-center">
                            <Sparkles size={16} className="text-[#F4ACB7] animate-pulse" />
                         </div>
                         <div className="bg-[#FAF7F2] text-[#5C524F] p-4 rounded-2xl rounded-tl-none border border-[#EAE0D5] flex items-center gap-1.5 h-12">
                            <div className="w-1.5 h-1.5 bg-[#D4A373] rounded-full animate-bounce" style={{animationDelay:'0ms'}}></div>
                            <div className="w-1.5 h-1.5 bg-[#D4A373] rounded-full animate-bounce" style={{animationDelay:'150ms'}}></div>
                            <div className="w-1.5 h-1.5 bg-[#D4A373] rounded-full animate-bounce" style={{animationDelay:'300ms'}}></div>
                         </div>
                      </div>
                  )}
                  <div ref={chatEndRef} />
                </div>
             ) : (
                <div className="flex-1 min-h-0 overflow-y-auto p-6 space-y-6 flex flex-col bg-[#FAF7F2] pt-4">
                  <textarea 
                    className="flex-1 w-full bg-transparent p-5 outline-none resize-none text-[15px] leading-loose text-[#5C524F] placeholder-[#B4A7A0]"
                    placeholder="Jot down active GHL contacts, mood board thoughts, or daily tasks here... This notepad persists across your session."
                    value={notes}
                    onChange={(e) => setNotes(e.target.value)}
                  />
                </div>
             )}

             {activeTab === 'chat' && (
               <form onSubmit={handleSendMessage} className="shrink-0 p-4 bg-white border-t border-[#EAE0D5] flex gap-3 items-center relative z-20">
                  <input type="file" ref={fileInputRef} onChange={handleFileSelect} className="hidden" accept="image/*,.pdf,.doc,.docx" />
                  
                  <button type="button" onClick={() => setIsTTSActive(!isTTSActive)} className={`p-3 rounded-xl transition-all ${isTTSActive ? 'bg-[#F4ACB7]/20 text-[#F4ACB7]' : 'bg-[#FAF7F2] text-[#B4A7A0] hover:text-[#D4A373]'}`} title="Voice Output Toggle">
                      <Mic size={16} />
                  </button>
                  <button type="button" onClick={() => fileInputRef.current && fileInputRef.current.click()} className={`p-3 rounded-xl transition-all ${attachment ? 'bg-[#D4A373]/20 text-[#D4A373]' : 'bg-[#FAF7F2] text-[#B4A7A0] hover:text-[#D4A373]'}`} title="Attach File/Screenshot">
                      <Paperclip size={16} />
                  </button>
                  <button type="button" onClick={handleDictation} className={`p-3 rounded-xl transition-all ${isListening ? 'bg-red-100 text-red-500 animate-pulse' : 'bg-[#FAF7F2] text-[#B4A7A0] hover:text-[#D4A373]'}`} title="Dictate to Coco">
                      <Mic size={16} />
                  </button>

                  <div className="flex-1 relative flex flex-col mt-0">
                      {attachment && (
                          <div className="absolute -top-14 left-0 bg-white border border-[#EAE0D5] text-[#4A423F] text-xs px-3 py-1.5 rounded-lg shadow flex items-center gap-2">
                              <span className="truncate max-w-[200px] font-bold">{attachment.name}</span>
                              <button type="button" onClick={() => setAttachment(null)} className="text-red-400 hover:text-red-500 font-bold ml-2 text-sm">&times;</button>
                          </div>
                      )}
                      <input 
                        value={inputValue} 
                        onChange={(e) => setInputValue(e.target.value)} 
                        placeholder="Discuss floor plans or review vendor specs..." 
                        className="w-full bg-[#FAF7F2] p-3.5 text-sm outline-none rounded-xl text-[#4A423F] placeholder:text-[#B4A7A0] font-medium border border-transparent focus:border-[#EAE0D5]" 
                      />
                  </div>
                  
                  <button type="submit" className="bg-[#D4A373] text-white p-3.5 rounded-xl hover:bg-[#C28E5E] transition-all shadow-sm">
                      <Send size={16} />
                  </button>
               </form>
             )}
          </div>
        </main>

        {/* RIGHT: RENDER QUEUE ONLY */}
        <aside className="col-span-12 xl:col-span-3 flex flex-col gap-6 overflow-y-auto">
          <div className="bg-[#4A423F] rounded-2xl p-5 shadow-xl shrink-0">
             <div className="flex justify-between items-center mb-4">
                <h3 className="text-[10px] font-black tracking-widest uppercase text-white/40 flex items-center gap-2">
                  <Camera size={14} className="text-[#F4ACB7]" /> Picasso Engine
                </h3>
                <span className="text-[8px] px-2 py-0.5 bg-[#F4ACB7]/20 text-[#F4ACB7] rounded-full font-bold">READY</span>
             </div>
             <button className="w-full py-3 bg-white/10 text-white text-[9px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-white/20 transition-all border border-white/20 hover:border-white/40 shadow-sm">
                 Request Design Manifest
             </button>
          </div>

        </aside>
      </div>
    </div>
  );
};




        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<CocoHill />);
    </script>
</body>
</html>
