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

        const Home = (props) => <IconWrapper name="Home" {...props} />;
        const Palette = (props) => <IconWrapper name="Palette" {...props} />;
        const ShoppingBag = (props) => <IconWrapper name="ShoppingBag" {...props} />;
        const Users = (props) => <IconWrapper name="Users" {...props} />;
        const Calendar = (props) => <IconWrapper name="Calendar" {...props} />;
        const Camera = (props) => <IconWrapper name="Camera" {...props} />;
        const Heart = (props) => <IconWrapper name="Heart" {...props} />;
        const MessageCircle = (props) => <IconWrapper name="MessageCircle" {...props} />;
        const Clock = (props) => <IconWrapper name="Clock" {...props} />;
        const ChevronRight = (props) => <IconWrapper name="ChevronRight" {...props} />;
        const MoreVertical = (props) => <IconWrapper name="MoreVertical" {...props} />;
        const Layers = (props) => <IconWrapper name="Layers" {...props} />;
        const Sparkles = (props) => <IconWrapper name="Sparkles" {...props} />;
        const CreditCard = (props) => <IconWrapper name="CreditCard" {...props} />;
        const CheckCircle2 = (props) => <IconWrapper name="CheckCircle2" {...props} />;
        const FileText = (props) => <IconWrapper name="FileText" {...props} />;
        const Mic = (props) => <IconWrapper name="Mic" {...props} />;
        const Paperclip = (props) => <IconWrapper name="Paperclip" {...props} />;
        const Send = (props) => <IconWrapper name="Send" {...props} />;

        

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
  const chatEndRef = useRef(null);

  const [attachment, setAttachment] = useState(null);
  const fileInputRef = useRef(null);

  const initialMessages = [
    { role: 'agent', text: 'Coco Hill Chat API online. How can I assist with your design queue?', name: 'COCO AI' }
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
          const payload = { message: msg };
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
          setChatMessages(prev => [...prev, { role: 'agent', text: data.reply || 'Acknowledged.', name: 'COCO AI' }]);
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

        <main className="col-span-6 flex flex-col gap-6 overflow-hidden">

          <div className="flex-1 bg-white border border-[#EAE0D5] rounded-3xl overflow-hidden flex flex-col shadow-sm relative sticky h-[650px]" style={{ minHeight: '650px' }}>
             <div className="shrink-0 flex justify-center py-4 border-b border-[#EAE0D5] bg-[#FAF7F2]">
                <span className="text-[10px] bg-white px-4 py-1.5 rounded-full border border-[#EAE0D5] text-[#B4A7A0] uppercase tracking-[0.3em] font-bold">
                  Design Studio Intelligence
                </span>
             </div>

             <div className="flex-1 overflow-y-auto p-6 space-y-6 flex flex-col pt-4">
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
          </div>
        </main>

        {/* RIGHT: PROCUREMENT & FINANCIALS */}
        <aside className="col-span-3 flex flex-col gap-6 overflow-y-auto">
          
          {/* BUDGET MODULE */}
          <div className="bg-white border border-[#EAE0D5] rounded-2xl p-5 shadow-sm">
            <div className="flex justify-between items-center mb-5">
              <h3 className="text-[10px] font-black tracking-widest uppercase text-[#B4A7A0] flex items-center gap-2">
                <CreditCard size={14} className="text-[#D4A373]" /> Financials
              </h3>
              <span className="text-sm font-black text-[#D4A373]">$428.5k</span>
            </div>
            <div className="space-y-4">
              <div>
                <div className="flex justify-between text-[11px] mb-1">
                  <span className="text-[#8B7E74] font-bold">Retainers Collected</span>
                  <span className="text-[#4A423F] font-black">$120k</span>
                </div>
                <div className="w-full h-1 bg-[#FAF7F2] rounded-full overflow-hidden">
                  <div className="h-full bg-[#D4A373] w-[75%]" />
                </div>
              </div>
              <div>
                <div className="flex justify-between text-[11px] mb-1">
                  <span className="text-[#8B7E74] font-bold">Procurement Spend</span>
                  <span className="text-[#4A423F] font-black">$280k</span>
                </div>
                <div className="w-full h-1 bg-[#FAF7F2] rounded-full overflow-hidden">
                  <div className="h-full bg-[#F4ACB7] w-[45%]" />
                </div>
              </div>
            </div>
          </div>

          {/* SOURCING TRACKER */}
          <div className="bg-white border border-[#EAE0D5] rounded-2xl p-5 shadow-sm">
            <h3 className="text-[10px] font-black tracking-widest uppercase text-[#B4A7A0] flex items-center gap-2 mb-5">
              <ShoppingBag size={14} className="text-[#F4ACB7]" /> Procurement Tracking
            </h3>
            <div className="space-y-4">
              {[
                { item: "Vintage Chandelier", status: "In Transit", date: "Oct 12" },
                { item: "Italian Marble Slab", status: "Delivered", date: "Oct 08" },
                { item: "Custom Silk Rug", status: "In Production", date: "Nov 22" }
              ].map((item, i) => (
                <div key={i} className="flex items-center gap-3 group">
                  <div className="w-8 h-8 rounded-lg bg-[#FAF7F2] border border-[#EAE0D5] flex items-center justify-center group-hover:bg-[#F4ACB7]/10 group-hover:border-[#F4ACB7]/30 transition-colors">
                    <CheckCircle2 size={12} className={i === 1 ? "text-emerald-500" : "text-[#B4A7A0]"} />
                  </div>
                  <div className="flex-1">
                    <div className="text-[11px] font-black text-[#4A423F]">{item.item}</div>
                    <div className="text-[9px] text-[#B4A7A0] font-bold uppercase tracking-tighter">{item.status} <span className="mx-1">•</span> {item.date}</div>
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* RENDERING QUEUE (PICASSO INTEGRATION) */}
          <div className="bg-[#4A423F] rounded-2xl p-5 shadow-xl">
             <div className="flex justify-between items-center mb-4">
                <h3 className="text-[10px] font-black tracking-widest uppercase text-white/40 flex items-center gap-2">
                  <Camera size={14} className="text-[#F4ACB7]" /> Picasso Render Engine
                </h3>
                <span className="text-[8px] px-2 py-0.5 bg-[#F4ACB7]/20 text-[#F4ACB7] rounded-full font-bold">ACTIVE</span>
             </div>
             <div className="space-y-3">
                <div className="p-3 bg-white/5 border border-white/10 rounded-xl">
                   <div className="flex justify-between items-center mb-2">
                      <span className="text-[10px] text-white font-bold tracking-tight">Master Bedroom - View 2</span>
                      <span className="text-[10px] text-[#F4ACB7] font-black">82%</span>
                   </div>
                   <div className="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                      <div className="h-full bg-gradient-to-r from-[#F4ACB7] to-[#D4A373] w-[82%]" />
                   </div>
                </div>
                <button className="w-full py-2 bg-white/10 text-white text-[9px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-white/20 transition-all">
                   Submit New Scene
                </button>
             </div>
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
