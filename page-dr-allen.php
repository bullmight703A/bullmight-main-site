<?php
/**
 * Template Name: Dr. Diana B. Allen Website
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. Diana B. Allen | Security, Compliance & Leadership</title>
    <meta name="description" content="Decades of expertise in IT security compliance, business administration, and executive leadership. Building trust and resilience in high-stakes tech environments.">
    
    <!-- Google Fonts: Cinzel for premium editorial feel, Inter for clean modern body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts: Tailwind, React, Babel, and Lucide Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            slate: '#ffffff',
                            slateLight: '#f8fafc',
                            teal: '#4f46e5',
                            tealLight: '#6366f1',
                            gold: '#e11d48',
                            goldLight: '#f43f5e',
                            accent: '#f1f5f9',
                            cardBg: 'rgba(255, 255, 255, 0.85)'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Cinzel', 'serif']
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            margin: 0;
            background-color: #ffffff;
            font-family: 'Inter', sans-serif;
            color: #334155;
            overflow-x: hidden;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #4f46e5;
        }
        /* Grid background effect */
        .grid-bg {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.94), rgba(255, 255, 255, 0.94)),
                radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.06) 0%, transparent 60%),
                radial-gradient(circle at 10% 20%, rgba(244, 63, 94, 0.04) 0%, transparent 40%);
        }
        .glow-teal {
            box-shadow: 0 10px 40px -10px rgba(99, 102, 241, 0.12);
        }
        .glow-gold {
            box-shadow: 0 10px 40px -10px rgba(244, 63, 94, 0.1);
        }
        .blur-orb-1 {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.07) 0%, transparent 75%);
        }
        .blur-orb-2 {
            background: radial-gradient(circle, rgba(244, 63, 94, 0.05) 0%, transparent 75%);
        }
    </style>
</head>
<body class="grid-bg min-h-screen relative">

    <!-- Ambient Glow Orbs -->
    <div class="absolute top-[20%] left-[-10%] w-[500px] h-[500px] blur-orb-1 rounded-full pointer-events-none z-0"></div>
    <div class="absolute bottom-[20%] right-[-10%] w-[500px] h-[500px] blur-orb-2 rounded-full pointer-events-none z-0"></div>

    <div id="root" class="relative z-10"></div>

    <script type="text/babel">
        const { useState, useEffect, useRef } = React;

        // Custom wrapper to cleanly render Lucide icons in React standalone
        const Icon = ({ name, size = 20, className = '' }) => {
            const iconRef = useRef(null);
            
            useEffect(() => {
                if (iconRef.current && window.lucide) {
                    iconRef.current.innerHTML = '';
                    const iconName = name.replace(/([a-z0-9])([A-Z])/g, '$1-$2').toLowerCase();
                    const iconData = window.lucide.icons[iconName];
                    
                    if (iconData) {
                        const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                        svg.setAttribute('width', size);
                        svg.setAttribute('height', size);
                        svg.setAttribute('viewBox', '0 0 24 24');
                        svg.setAttribute('fill', 'none');
                        svg.setAttribute('stroke', 'currentColor');
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
            }, [name, size, className]);
            
            return <i ref={iconRef} className="inline-block leading-none"></i>;
        };

        // Main App Component
        const App = () => {
            const [activeTab, setActiveTab] = useState('home');
            const [selectedBlog, setSelectedBlog] = useState(null);
            
            // Calculator State
            const [calcScore, setCalcScore] = useState(null);
            const [calcAnswers, setCalcAnswers] = useState({
                security: 2,
                compliance: 2,
                leadership: 2
            });

            // Contact Form State
            const [formSubmitted, setFormSubmitted] = useState(false);
            const [formData, setFormData] = useState({
                name: '',
                email: '',
                org: '',
                interest: 'Advisory Consulting',
                message: ''
            });

            const handleCalcChange = (category, value) => {
                setCalcAnswers(prev => ({ ...prev, [category]: value }));
            };

            const calculatePosture = () => {
                // Compute score out of 100 based on selections
                const totalPoints = calcAnswers.security + calcAnswers.compliance + calcAnswers.leadership;
                const finalScore = Math.round((totalPoints / 12) * 100);
                setCalcScore(finalScore);
            };

            const handleFormSubmit = (e) => {
                e.preventDefault();
                // Simple validation check
                if (formData.name && formData.email && formData.message) {
                    setFormSubmitted(true);
                    setTimeout(() => {
                        setFormData({ name: '', email: '', org: '', interest: 'Advisory Consulting', message: '' });
                    }, 1000);
                }
            };

            const toggleBlog = (blog) => {
                setSelectedBlog(blog);
            };

            // Headshot Image URL
            const headshotUrl = "<?php echo esc_url(get_template_directory_uri() . '/images/dr_allen_headshot.png'); ?>";

            return (
                <div className="max-w-6xl mx-auto px-4 md:px-8 py-6 flex flex-col min-h-screen">
                    
                    {/* Top Navigation Header */}
                    <header className="flex flex-col md:flex-row items-center justify-between border-b border-slate-200 pb-6 mb-10 gap-4">
                        <div className="text-center md:text-left">
                            <h1 className="font-display text-2xl md:text-3xl font-bold tracking-widest text-slate-900 leading-tight uppercase cursor-pointer" onClick={() => setActiveTab('home')}>
                                Dr. Diana B. Allen
                            </h1>
                            <p className="text-xs uppercase tracking-[0.25em] text-brand-teal mt-1 font-semibold">
                                Security &bull; Compliance &bull; Leadership
                            </p>
                        </div>
                        <nav className="flex flex-wrap justify-center gap-1 md:gap-3 bg-brand-slateLight/60 p-1.5 rounded-xl border border-slate-200/60 backdrop-blur-md">
                            {['home', 'about', 'advisory', 'insights', 'contact'].map(tab => (
                                <button
                                    key={tab}
                                    onClick={() => { setActiveTab(tab); setSelectedBlog(null); }}
                                    className={`px-4 py-2 rounded-lg text-xs md:text-sm font-semibold uppercase tracking-wider transition-all duration-200 ${
                                        activeTab === tab 
                                            ? 'bg-brand-teal text-white shadow-md shadow-brand-teal/20' 
                                            : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                                    }`}
                                >
                                    {tab === 'advisory' ? 'Advisory & Speaking' : tab}
                                </button>
                            ))}
                        </nav>
                    </header>

                    {/* Main Dynamic Viewport */}
                    <main className="flex-1">
                        
                        {/* TAB 1: HOME VIEW */}
                        {activeTab === 'home' && (
                            <section className="animate-fade-in grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                                {/* Bio Content */}
                                <div className="lg:col-span-7 space-y-6">
                                    <div className="inline-flex items-center gap-2 px-3 py-1 bg-brand-teal/10 border border-brand-teal/30 rounded-full text-brand-teal text-xs font-bold uppercase tracking-wider">
                                        <Icon name="Award" size={14} className="text-brand-teal" />
                                        Evidence-Based Enterprise Advisory
                                    </div>
                                    <h2 className="font-display text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                                        Transforming <span className="text-brand-teal">Complexity</span> Into Resilience
                                    </h2>
                                    <p className="text-base md:text-lg leading-relaxed text-slate-600 font-light">
                                        I partner with enterprise organizations, boards, and leaders to align strategy with technical compliance, mitigate organizational risks, and develop high-performing executive leadership frameworks in high-stakes environments.
                                    </p>
                                    
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                                        <div className="flex items-start gap-3 p-3 bg-brand-slateLight/40 border border-slate-200/50 rounded-xl">
                                            <div className="p-2 bg-brand-teal/10 rounded-lg text-brand-teal mt-0.5">
                                                <Icon name="Shield" size={18} />
                                            </div>
                                            <div>
                                                <h4 className="text-sm font-bold text-slate-900 uppercase tracking-wider">IT Security & Governance</h4>
                                                <p className="text-xs text-slate-500 mt-0.5 leading-relaxed">Securing core infrastructures and setting governance benchmarks.</p>
                                            </div>
                                        </div>
                                        <div className="flex items-start gap-3 p-3 bg-brand-slateLight/40 border border-slate-200/50 rounded-xl">
                                            <div className="p-2 bg-brand-gold/10 rounded-lg text-brand-gold mt-0.5">
                                                <Icon name="FileCheck" size={18} />
                                            </div>
                                            <div>
                                                <h4 className="text-sm font-bold text-slate-900 uppercase tracking-wider">Compliance Alignment</h4>
                                                <p className="text-xs text-slate-500 mt-0.5 leading-relaxed">Systematic roadmap design for SOC2, ISO27001, and regulatory standards.</p>
                                            </div>
                                        </div>
                                        <div className="flex items-start gap-3 p-3 bg-brand-slateLight/40 border border-slate-200/50 rounded-xl">
                                            <div className="p-2 bg-brand-teal/10 rounded-lg text-brand-teal mt-0.5">
                                                <Icon name="TrendingUp" size={18} />
                                            </div>
                                            <div>
                                                <h4 className="text-sm font-bold text-slate-900 uppercase tracking-wider">Executive Administration</h4>
                                                <p className="text-xs text-slate-500 mt-0.5 leading-relaxed">Strategic growth optimization, operations audit, and data alignment.</p>
                                            </div>
                                        </div>
                                        <div className="flex items-start gap-3 p-3 bg-brand-slateLight/40 border border-slate-200/50 rounded-xl">
                                            <div className="p-2 bg-brand-gold/10 rounded-lg text-brand-gold mt-0.5">
                                                <Icon name="Users" size={18} />
                                            </div>
                                            <div>
                                                <h4 className="text-sm font-bold text-slate-900 uppercase tracking-wider">Women in Tech Leadership</h4>
                                                <p className="text-xs text-slate-500 mt-0.5 leading-relaxed">Dedicated leadership coaching and high-performance framework building.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="flex flex-col sm:flex-row gap-4 pt-4">
                                        <button 
                                            onClick={() => setActiveTab('contact')}
                                            className="px-6 py-3 bg-brand-teal hover:bg-brand-tealLight text-white font-bold rounded-lg uppercase tracking-wider transition-colors shadow-lg shadow-brand-teal/20 text-sm flex items-center justify-center gap-2"
                                        >
                                            <Icon name="Mail" size={16} /> Book Private Consultation
                                        </button>
                                        <button 
                                            onClick={() => setActiveTab('advisory')}
                                            className="px-6 py-3 bg-slate-100 border border-slate-200/80 hover:border-brand-teal text-slate-700 font-bold rounded-lg uppercase tracking-wider transition-colors text-sm flex items-center justify-center gap-2"
                                        >
                                            Explore Advisory Services <Icon name="ArrowRight" size={16} />
                                        </button>
                                    </div>
                                </div>

                                {/* Portrait and Credentials Column */}
                                <div className="lg:col-span-5 flex flex-col items-center">
                                    <div className="relative group">
                                        {/* Background ambient glow behind picture */}
                                        <div className="absolute inset-0 bg-gradient-to-tr from-brand-teal/30 to-brand-gold/30 rounded-3xl blur-2xl opacity-40 group-hover:opacity-60 transition-opacity duration-300"></div>
                                        {/* Headshot Card Container */}
                                        <div className="relative bg-white border border-slate-200/60 p-4 rounded-3xl shadow-xl flex flex-col items-center max-w-[340px] text-center">
                                            <img 
                                                src={headshotUrl} 
                                                alt="Dr. Diana B. Allen Executive Portrait" 
                                                className="w-full h-80 object-cover rounded-2xl border border-slate-100 mb-4 shadow-sm"
                                            />
                                            <h3 className="font-display text-lg font-bold text-slate-900">Dr. Diana B. Allen</h3>
                                            <p className="text-xs text-brand-teal font-semibold tracking-wider uppercase mt-1">PhD &bull; MBA &bull; CISSP</p>
                                            <div className="w-12 h-[1px] bg-slate-200 my-3"></div>
                                            <p className="text-[11px] text-slate-500 font-light leading-relaxed">
                                                IT security compliance governance, organizational strategy and research-driven leadership for women in tech.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        )}

                        {/* TAB 2: ABOUT VIEW */}
                        {activeTab === 'about' && (
                            <section className="animate-fade-in space-y-12">
                                <div className="text-center max-w-3xl mx-auto space-y-4">
                                    <h2 className="font-display text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                                        Strategic Consulting, <span className="text-brand-teal">Elevated</span>
                                    </h2>
                                    <div className="w-16 h-[2px] bg-brand-teal mx-auto"></div>
                                    <p className="text-lg text-slate-600 font-light leading-relaxed">
                                        Our mission is to translate multi-dimensional compliance frameworks into clear, execution-ready roadmaps that elevate operational value.
                                    </p>
                                </div>

                                <div className="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                                    <div className="p-6 bg-brand-slateLight/50 border border-slate-200/50 shadow-sm rounded-2xl space-y-3">
                                        <h3 className="font-display text-xl font-bold text-slate-900 uppercase tracking-wider">Decades of Multi-Dimensional Expertise</h3>
                                        <p className="text-sm text-slate-600 leading-relaxed font-light">
                                            With deep capability spanning operations, business administration, and information technology systems, we offer structured advisory services that align enterprise controls with organizational growth. 
                                        </p>
                                        <p className="text-sm text-slate-600 leading-relaxed font-light">
                                            Our methodology bridges the divide between corporate executive officers and IT architects, providing clear translation and absolute transparency in governance.
                                        </p>
                                    </div>
                                    <div className="p-6 bg-brand-slateLight/50 border border-slate-200/50 shadow-sm rounded-2xl space-y-3">
                                        <h3 className="font-display text-xl font-bold text-slate-900 uppercase tracking-wider">Evidence-Based Leadership</h3>
                                        <p className="text-sm text-slate-600 leading-relaxed font-light">
                                            Our advisory projects are grounded in a data-driven approach. We map structural inefficiencies, define strategic pathways, and implement governance structures that secure organizational outcomes.
                                        </p>
                                        <p className="text-sm text-slate-600 leading-relaxed font-light">
                                            By providing ongoing measurement of security operations and compliance audits, we ensure our clients realize measurable value and maintain robust security postures over time.
                                        </p>
                                    </div>
                                </div>

                                {/* Custom trust-building section for Women in Tech */}
                                <div className="p-8 bg-gradient-to-r from-brand-teal/5 to-brand-gold/5 border border-slate-200/60 shadow-sm rounded-2xl relative overflow-hidden">
                                    <div className="absolute top-0 right-0 w-[300px] h-[300px] bg-brand-gold/5 blur-3xl rounded-full pointer-events-none"></div>
                                    <div className="relative z-10 flex flex-col md:flex-row gap-6 items-center">
                                        <div className="p-4 bg-brand-gold/10 rounded-full text-brand-gold">
                                            <Icon name="TrendingUp" size={32} />
                                        </div>
                                        <div className="space-y-2">
                                            <h4 className="font-display text-lg font-bold text-slate-900 uppercase tracking-wide">Executive Leadership Development</h4>
                                            <p className="text-sm text-slate-600 font-light leading-relaxed">
                                                A key focus of our consulting practice is mentoring and empowering women in technology to assume leadership, manage compliance risks, and lead high-profile governance structures confidently.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        )}

                        {/* TAB 3: ADVISORY VIEW */}
                        {activeTab === 'advisory' && (
                            <section className="animate-fade-in space-y-12">
                                <div className="text-center max-w-3xl mx-auto space-y-4">
                                    <h2 className="font-display text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                                        Evidence-Based <span className="text-brand-teal">Solutions</span>
                                    </h2>
                                    <div className="w-16 h-[2px] bg-brand-teal mx-auto"></div>
                                    <p className="text-lg text-slate-600 font-light leading-relaxed">
                                        Delivering clear direction, structural diagnostics, and educational programs to secure compliance and build resilience.
                                    </p>
                                </div>

                                {/* Services Grid */}
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div className="bg-white border border-slate-200/60 p-6 rounded-2xl flex flex-col justify-between hover:border-brand-teal/30 hover:bg-brand-slateLight/20 shadow-sm transition-all duration-300">
                                        <div className="space-y-4">
                                            <div className="p-3 bg-brand-teal/10 rounded-xl w-fit text-brand-teal">
                                                <Icon name="Activity" size={24} />
                                            </div>
                                            <h3 className="font-display text-xl font-bold text-slate-900 uppercase tracking-wider">Executive Advisory</h3>
                                            <p className="text-sm text-slate-500 leading-relaxed font-light">
                                                Strategic governance, operational audits, and risk assessment for leadership teams navigating technology shifts and regulatory compliance.
                                            </p>
                                        </div>
                                        <button onClick={() => { setActiveTab('contact'); setFormData(prev => ({ ...prev, interest: 'Advisory Consulting' })); }} className="w-full mt-6 py-2.5 bg-brand-teal/10 hover:bg-brand-teal border border-brand-teal/30 text-brand-tealLight hover:text-white font-bold rounded-lg uppercase tracking-wider transition-colors text-xs">
                                            Select Advisory
                                        </button>
                                    </div>

                                    <div className="bg-white border border-slate-200/60 p-6 rounded-2xl flex flex-col justify-between hover:border-brand-gold/30 hover:bg-brand-slateLight/20 shadow-sm transition-all duration-300">
                                        <div className="space-y-4">
                                            <div className="p-3 bg-brand-gold/10 rounded-xl w-fit text-brand-gold">
                                                <Icon name="MessageSquare" size={24} />
                                            </div>
                                            <h3 className="font-display text-xl font-bold text-slate-900 uppercase tracking-wider">Keynotes & Speaking</h3>
                                            <p className="text-sm text-slate-500 leading-relaxed font-light">
                                                Inspirational and research-backed keynote presentations, panels, and masterclasses designed to challenge thinking and create alignment on cybersecurity governance.
                                            </p>
                                        </div>
                                        <button onClick={() => { setActiveTab('contact'); setFormData(prev => ({ ...prev, interest: 'Speaking & Keynotes' })); }} className="w-full mt-6 py-2.5 bg-brand-gold/10 hover:bg-brand-gold border border-brand-gold/30 text-brand-goldLight hover:text-white font-bold rounded-lg uppercase tracking-wider transition-colors text-xs">
                                            Book Speaking
                                        </button>
                                    </div>

                                    <div className="bg-white border border-slate-200/60 p-6 rounded-2xl flex flex-col justify-between hover:border-brand-teal/30 hover:bg-brand-slateLight/20 shadow-sm transition-all duration-300">
                                        <div className="space-y-4">
                                            <div className="p-3 bg-brand-teal/10 rounded-xl w-fit text-brand-teal">
                                                <Icon name="Shield" size={24} />
                                            </div>
                                            <h3 className="font-display text-xl font-bold text-slate-900 uppercase tracking-wider">Thought Leadership</h3>
                                            <p className="text-sm text-slate-500 leading-relaxed font-light">
                                                Custom framework formulation, research writing, and strategic positioning at the intersection of business administration, governance, and advanced IT systems.
                                            </p>
                                        </div>
                                        <button onClick={() => { setActiveTab('contact'); setFormData(prev => ({ ...prev, interest: 'Thought Leadership' })); }} className="w-full mt-6 py-2.5 bg-brand-teal/10 hover:bg-brand-teal border border-brand-teal/30 text-brand-tealLight hover:text-white font-bold rounded-lg uppercase tracking-wider transition-colors text-xs">
                                            Inquire Thought Leadership
                                        </button>
                                    </div>
                                </div>

                                {/* DYNAMIC POSTURE CALCULATOR CARD (TRUST BUILDING) */}
                                <div className="border border-brand-teal/20 bg-brand-slateLight/50 rounded-2xl p-6 md:p-8 glow-teal">
                                    <div className="flex flex-col md:flex-row gap-8">
                                        {/* Inputs Section */}
                                        <div className="flex-1 space-y-6">
                                            <div>
                                                <span className="text-[10px] bg-brand-teal/10 text-brand-teal px-2 py-0.5 rounded-md font-bold uppercase tracking-wider">
                                                    Interactive Posture Tool
                                                </span>
                                                <h3 className="font-display text-2xl font-bold text-slate-900 mt-2 uppercase tracking-wide">
                                                    Audit Your Organization
                                                </h3>
                                                <p className="text-xs text-slate-500 mt-1 leading-relaxed">
                                                    Identify alignment gaps in security, regulatory compliance readiness, and administrative leadership. Use the inputs to get your preliminary score.
                                                </p>
                                            </div>

                                            {/* Audits controls */}
                                            <div className="space-y-4">
                                                <div>
                                                    <label className="text-xs text-slate-600 uppercase tracking-wider font-bold block mb-2">
                                                        1. Security Architecture & Controls
                                                    </label>
                                                    <div className="flex gap-2">
                                                        {['Deficient', 'Partial', 'Mature', 'Optimized'].map((val, idx) => (
                                                            <button 
                                                                key={val}
                                                                onClick={() => handleCalcChange('security', idx + 1)}
                                                                className={`flex-1 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider border transition-colors ${
                                                                    calcAnswers.security === (idx + 1)
                                                                        ? 'bg-brand-teal/15 border-brand-teal text-brand-teal'
                                                                        : 'bg-slate-100 border-slate-200 text-slate-500 hover:text-slate-800'
                                                                }`}
                                                            >
                                                                {val}
                                                            </button>
                                                        ))}
                                                    </div>
                                                </div>

                                                <div>
                                                    <label className="text-xs text-slate-600 uppercase tracking-wider font-bold block mb-2">
                                                        2. Regulatory Compliance Readiness (SOC2 / ISO)
                                                    </label>
                                                    <div className="flex gap-2">
                                                        {['Deficient', 'Partial', 'Mature', 'Optimized'].map((val, idx) => (
                                                            <button 
                                                                key={val}
                                                                onClick={() => handleCalcChange('compliance', idx + 1)}
                                                                className={`flex-1 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider border transition-colors ${
                                                                    calcAnswers.compliance === (idx + 1)
                                                                        ? 'bg-brand-teal/15 border-brand-teal text-brand-teal'
                                                                        : 'bg-slate-100 border-slate-200 text-slate-500 hover:text-slate-800'
                                                                }`}
                                                            >
                                                                {val}
                                                            </button>
                                                        ))}
                                                    </div>
                                                </div>

                                                <div>
                                                    <label className="text-xs text-slate-600 uppercase tracking-wider font-bold block mb-2">
                                                        3. Administrative Leadership & Policy Alignment
                                                    </label>
                                                    <div className="flex gap-2">
                                                        {['Deficient', 'Partial', 'Mature', 'Optimized'].map((val, idx) => (
                                                            <button 
                                                                key={val}
                                                                onClick={() => handleCalcChange('leadership', idx + 1)}
                                                                className={`flex-1 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider border transition-colors ${
                                                                    calcAnswers.leadership === (idx + 1)
                                                                        ? 'bg-brand-teal/15 border-brand-teal text-brand-teal'
                                                                        : 'bg-slate-100 border-slate-200 text-slate-500 hover:text-slate-800'
                                                                }`}
                                                            >
                                                                {val}
                                                            </button>
                                                        ))}
                                                    </div>
                                                </div>
                                            </div>

                                            <button 
                                                onClick={calculatePosture}
                                                className="w-full py-3 bg-brand-teal hover:bg-brand-tealLight text-white font-bold rounded-lg uppercase tracking-wider transition-colors text-xs"
                                            >
                                                Generate Posture Diagnostics
                                            </button>
                                        </div>

                                        {/* Score / Output Section */}
                                        <div className="w-full md:w-[300px] flex flex-col justify-center items-center p-6 bg-white border border-slate-200/60 shadow-sm rounded-xl text-center">
                                            {calcScore === null ? (
                                                <div className="space-y-2 py-10">
                                                    <Icon name="Activity" size={40} className="text-slate-400 animate-pulse mx-auto" />
                                                    <p className="text-xs text-slate-400 font-bold uppercase tracking-wider">Awaiting Diagnostics</p>
                                                </div>
                                            ) : (
                                                <div className="space-y-4 animate-scale-up">
                                                    <p className="text-[10px] text-slate-400 uppercase tracking-[0.2em] font-black">Score Result</p>
                                                    <div className="relative flex items-center justify-center">
                                                        <span className="text-5xl font-black text-slate-900 font-display">{calcScore}%</span>
                                                        <div className="absolute inset-0 rounded-full border border-brand-teal/10 animate-ping"></div>
                                                    </div>
                                                    
                                                    {/* Custom advisory recommendation output */}
                                                    <div className="text-xs text-slate-600 leading-relaxed font-light bg-brand-slateLight/50 border border-slate-200/60 p-3 rounded-lg">
                                                        {calcScore < 50 ? (
                                                            <span className="text-red-500 font-bold block mb-1">Status: High Risk Gaps</span>
                                                        ) : calcScore < 80 ? (
                                                            <span className="text-brand-gold font-bold block mb-1">Status: Moderate Alignment</span>
                                                        ) : (
                                                            <span className="text-emerald-600 font-bold block mb-1">Status: Highly Aligned</span>
                                                        )}
                                                        {calcScore < 80 
                                                            ? "Critical gaps detected in your operations. I recommend scheduling a priority assessment review to design a compliance roadmap."
                                                            : "Your organization has standard benchmarks in place. Contact Dr. Allen to audit optimizations and scale leadership policy framework."}
                                                    </div>
                                                    
                                                    <button 
                                                        onClick={() => { 
                                                            setActiveTab('contact');
                                                            setFormData(prev => ({ 
                                                                ...prev, 
                                                                interest: 'Assessment Review', 
                                                                message: `I generated an interactive posture score of ${calcScore}% and would like to schedule a consulting review.` 
                                                            }));
                                                        }}
                                                        className="px-4 py-2 bg-brand-gold hover:bg-brand-goldLight text-white font-black text-[10px] rounded uppercase tracking-wider transition-colors inline-block shadow-sm"
                                                    >
                                                        Discuss Score Review
                                                    </button>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </section>
                        )}

                        {/* TAB 4: INSIGHTS (BLOGS) VIEW */}
                        {activeTab === 'insights' && (
                            <section className="animate-fade-in space-y-12">
                                <div className="text-center max-w-3xl mx-auto space-y-4">
                                    <h2 className="font-display text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                                        Executive <span className="text-brand-teal">Insights</span>
                                    </h2>
                                    <div className="w-16 h-[2px] bg-brand-teal mx-auto"></div>
                                    <p className="text-lg text-slate-600 font-light leading-relaxed">
                                        Professional perspectives and research-backed frameworks at the intersection of business strategy, compliance operations, and security governance.
                                    </p>
                                </div>

                                {selectedBlog === null ? (
                                    /* Blog list */
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                                        {[
                                            {
                                                title: "Redefine Success",
                                                date: "May 28, 2026",
                                                desc: "Confidence doesn’t always arrive with a bold entrance. Sometimes, it builds quietly, step by step, as we show up for ourselves day after day...",
                                                p1: "Confidence doesn’t always arrive with a bold entrance. Sometimes, it builds quietly, step by step, as we show up for ourselves day after day. It grows when we choose to try, even when we’re unsure of the outcome. Every time you take action despite self-doubt, you reinforce the belief that you’re capable. Confidence isn’t about having all the answers — it’s about trusting that you can figure it out along the way.",
                                                p2: "The key to making things happen isn’t waiting for the perfect moment; it’s starting with what you have, where you are. Big goals can feel overwhelming when viewed all at once, but momentum builds through small, consistent action. Whether you’re working toward a personal milestone or a professional dream, progress comes from showing up — not perfectly, but persistently. Action creates clarity, and over time, those steps forward add up to something real.",
                                                p3: "You don’t need to be fearless to reach your goals, you just need to be willing. Willing to try, willing to learn, and willing to believe that you’re capable of more than you know. The road may not always be smooth, but growth rarely is. What matters most is that you keep going, keep learning, and keep believing in the version of yourself you’re becoming."
                                            },
                                            {
                                                title: "Small Steps Create Big Shifts",
                                                date: "May 28, 2026",
                                                desc: "The key to making things happen isn’t waiting for the perfect moment; it’s starting with what you have, where you are. Big goals can feel overwhelming...",
                                                p1: "The key to making things happen isn’t waiting for the perfect moment; it’s starting with what you have, where you are. Big goals can feel overwhelming when viewed all at once, but momentum builds through small, consistent action. Whether you’re working toward a personal milestone or a professional dream, progress comes from showing up — not perfectly, but persistently. Action creates clarity, and over time, those steps forward add up to something real.",
                                                p2: "Confidence doesn’t always arrive with a bold entrance. Sometimes, it builds quietly, step by step, as we show up for ourselves day after day. It grows when we choose to try, even when we’re unsure of the outcome. Every time you take action despite self-doubt, you reinforce the belief that you’re capable. Confidence isn’t about having all the answers — it’s about trusting that you can figure it out along the way.",
                                                p3: "You don’t need to be fearless to reach your goals, you just need to be willing. Willing to try, willing to learn, and willing to believe that you’re capable of more than you know. The road may not always be smooth, but growth rarely is. What matters most is that you keep going, keep learning, and keep believing in the version of yourself you’re becoming."
                                            },
                                            {
                                                title: "Turn Intention Into Action",
                                                date: "May 28, 2026",
                                                desc: "You don’t need to be fearless to reach your goals, you just need to be willing. Willing to try, willing to learn, and willing to believe...",
                                                p1: "You don’t need to be fearless to reach your goals, you just need to be willing. Willing to try, willing to learn, and willing to believe that you’re capable of more than you know. The road may not always be smooth, but growth rarely is. What matters most is that you keep going, keep learning, and keep believing in the version of yourself you’re becoming.",
                                                p2: "Confidence doesn’t always arrive with a bold entrance. Sometimes, it builds quietly, step by step, as we show up for ourselves day after day. It grows when we choose to try, even when we’re unsure of the outcome. Every time you take action despite self-doubt, you reinforce the belief that you’re capable. Confidence isn’t about having all the answers — it’s about trusting that you can figure it out along the way.",
                                                p3: "The key to making things happen isn’t waiting for the perfect moment; it’s starting with what you have, where you are. Big goals can feel overwhelming when viewed all at once, but momentum builds through small, consistent action. Whether you’re working toward a personal milestone or a professional dream, progress comes from showing up — not perfectly, but persistently. Action creates clarity, and over time, those steps forward add up to something real."
                                            },
                                            {
                                                title: "Make Room for Growth",
                                                date: "May 28, 2026",
                                                desc: "The road may not always be smooth, but growth rarely is. What matters most is that you keep going, keep learning, and keep believing...",
                                                p1: "The road may not always be smooth, but growth rarely is. What matters most is that you keep going, keep learning, and keep believing in the version of yourself you’re becoming.",
                                                p2: "Confidence doesn’t always arrive with a bold entrance. Sometimes, it builds quietly, step by step, as we show up for ourselves day after day. It grows when we choose to try, even when we’re unsure of the outcome. Every time you take action despite self-doubt, you reinforce the belief that you’re capable. Confidence isn’t about having all the answers — it’s about trusting that you can figure it out along the way.",
                                                p3: "The key to making things happen isn’t waiting for the perfect moment; it’s starting with what you have, where you are. Big goals can feel overwhelming when viewed all at once, but momentum builds through small, consistent action. Whether you’re working toward a personal milestone or a professional dream, progress comes from showing up — not perfectly, but persistently. Action creates clarity, and over time, those steps forward add up to something real."
                                            }
                                        ].map((post, idx) => (
                                            <div 
                                                key={idx}
                                                onClick={() => toggleBlog(post)}
                                                className="bg-white border border-slate-200/60 p-6 rounded-2xl hover:border-brand-teal/30 hover:bg-brand-slateLight/20 cursor-pointer group transition-all duration-300 shadow-sm"
                                            >
                                                <div className="flex justify-between items-start text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">
                                                    <span>Governance Report</span>
                                                    <span>{post.date}</span>
                                                </div>
                                                <h3 className="font-display text-lg font-bold text-slate-900 group-hover:text-brand-tealLight transition-colors uppercase tracking-wide">
                                                    {post.title}
                                                </h3>
                                                <p className="text-xs text-slate-500 mt-2 leading-relaxed font-light line-clamp-3">
                                                    {post.desc}
                                                </p>
                                                <div className="flex items-center gap-1 text-[10px] text-brand-tealLight font-bold uppercase tracking-wider mt-4">
                                                    Read Article <Icon name="ChevronRight" size={10} />
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    /* Single Blog View */
                                    <div className="bg-white border border-slate-200/80 shadow-md rounded-2xl p-6 md:p-10 space-y-6 animate-scale-up relative">
                                        <button 
                                            onClick={() => setSelectedBlog(null)}
                                            className="px-3 py-1.5 bg-slate-100 hover:bg-brand-teal border border-slate-200 text-slate-700 hover:text-white font-bold rounded-lg uppercase tracking-wider transition-colors text-[10px] flex items-center gap-1.5 w-fit"
                                        >
                                            <Icon name="ArrowLeft" size={10} /> Back to Insights
                                        </button>
                                        <div className="border-b border-slate-100 pb-4">
                                            <div className="flex justify-between items-center text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">
                                                <span>Framework Article</span>
                                                <span>{selectedBlog.date}</span>
                                            </div>
                                            <h3 className="font-display text-2xl md:text-4xl font-black text-slate-900 leading-tight uppercase tracking-wide">
                                                {selectedBlog.title}
                                            </h3>
                                        </div>
                                        <div className="text-sm leading-relaxed text-slate-600 space-y-4 font-light">
                                            <p>{selectedBlog.p1}</p>
                                            <p>{selectedBlog.p2}</p>
                                            <p>{selectedBlog.p3}</p>
                                        </div>
                                    </div>
                                )}
                            </section>
                        )}

                        {/* TAB 5: CONTACT VIEW */}
                        {activeTab === 'contact' && (
                            <section className="animate-fade-in grid grid-cols-1 lg:grid-cols-12 gap-12">
                                {/* Details column */}
                                <div className="lg:col-span-5 space-y-6">
                                    <div className="space-y-2">
                                        <span className="text-[10px] bg-brand-gold/10 text-brand-gold px-2 py-0.5 rounded-md font-bold uppercase tracking-wider">
                                            Contact
                                        </span>
                                        <h2 className="font-display text-3xl md:text-5xl font-black text-slate-900 leading-tight uppercase tracking-wide">
                                            Submit An <span className="text-brand-teal">Inquiry</span>
                                        </h2>
                                        <div className="w-12 h-[2px] bg-brand-teal mt-2"></div>
                                    </div>
                                    <p className="text-sm text-slate-600 font-light leading-relaxed">
                                        Initiate a private conversation to discuss your organizational goals, regulatory parameters, and strategic leadership objectives.
                                    </p>
                                    
                                    <div className="space-y-4 pt-4 border-t border-slate-200">
                                        <div className="flex items-center gap-3">
                                            <div className="p-2.5 bg-brand-teal/10 rounded-xl text-brand-teal">
                                                <Icon name="Mail" size={16} />
                                            </div>
                                            <div>
                                                <p className="text-[10px] text-slate-400 uppercase tracking-widest font-black">Direct Communication</p>
                                                <p className="text-sm text-slate-900 font-bold font-mono">info@dianaballen.com</p>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-3">
                                            <div className="p-2.5 bg-brand-gold/10 rounded-xl text-brand-gold">
                                                <Icon name="MapPin" size={16} />
                                            </div>
                                            <div>
                                                <p className="text-[10px] text-slate-400 uppercase tracking-widest font-black">Consulting Range</p>
                                                <p className="text-sm text-slate-900 font-semibold">Global Virtual & On-Site</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {/* Form Column */}
                                <div className="lg:col-span-7 bg-white border border-slate-200/60 p-6 md:p-8 rounded-2xl shadow-sm relative overflow-hidden">
                                    {formSubmitted ? (
                                        <div className="flex flex-col items-center justify-center text-center py-16 space-y-4 animate-scale-up">
                                            <div className="p-4 bg-brand-teal/10 border border-brand-teal/40 rounded-full text-brand-teal animate-bounce">
                                                <Icon name="CheckCircle" size={40} />
                                            </div>
                                            <h3 className="font-display text-xl font-bold text-slate-900 uppercase tracking-wider">Inquiry Dispatched</h3>
                                            <p className="text-xs text-slate-500 max-w-sm leading-relaxed">
                                                Thank you. Your consultation parameters have been securely logged. Dr. Allen's office will respond shortly to coordinate.
                                            </p>
                                            <button 
                                                onClick={() => setFormSubmitted(false)}
                                                className="px-4 py-2 bg-slate-100 text-xs font-bold uppercase tracking-wider border border-slate-200 rounded-lg hover:border-brand-teal hover:text-white transition-all text-slate-600"
                                            >
                                                Submit Another
                                            </button>
                                        </div>
                                    ) : (
                                        <form onSubmit={handleFormSubmit} className="space-y-4">
                                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div className="space-y-1.5">
                                                    <label className="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Full Name *</label>
                                                    <input 
                                                        type="text" 
                                                        required
                                                        value={formData.name}
                                                        onChange={(e) => setFormData(prev => ({ ...prev, name: e.target.value }))}
                                                        placeholder="Dr. Sarah Jenkins"
                                                        className="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 outline-none focus:border-brand-teal focus:bg-white placeholder:text-slate-400 transition-all"
                                                    />
                                                </div>
                                                <div className="space-y-1.5">
                                                    <label className="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Email Address *</label>
                                                    <input 
                                                        type="email" 
                                                        required
                                                        value={formData.email}
                                                        onChange={(e) => setFormData(prev => ({ ...prev, email: e.target.value }))}
                                                        placeholder="jenkins@enterprise.com"
                                                        className="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 outline-none focus:border-brand-teal focus:bg-white placeholder:text-slate-400 transition-all"
                                                    />
                                                </div>
                                            </div>

                                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div className="space-y-1.5">
                                                    <label className="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Organization</label>
                                                    <input 
                                                        type="text" 
                                                        value={formData.org}
                                                        onChange={(e) => setFormData(prev => ({ ...prev, org: e.target.value }))}
                                                        placeholder="SecCorp Global"
                                                        className="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 outline-none focus:border-brand-teal focus:bg-white placeholder:text-slate-400 transition-all"
                                                    />
                                                </div>
                                                <div className="space-y-1.5">
                                                    <label className="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Consultation Focus</label>
                                                    <select 
                                                        value={formData.interest}
                                                        onChange={(e) => setFormData(prev => ({ ...prev, interest: e.target.value }))}
                                                        className="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 outline-none focus:border-brand-teal focus:bg-white transition-all"
                                                    >
                                                        <option value="Advisory Consulting">Executive Advisory</option>
                                                        <option value="Speaking & Keynotes">Keynotes & Speaking</option>
                                                        <option value="Thought Leadership">Thought Leadership</option>
                                                        <option value="Assessment Review">Assessment Score Review</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div className="space-y-1.5">
                                                <label className="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Message Summary *</label>
                                                <textarea 
                                                    rows="4" 
                                                    required
                                                    value={formData.message}
                                                    onChange={(e) => setFormData(prev => ({ ...prev, message: e.target.value }))}
                                                    placeholder="Detail your operational parameters, compliance constraints, and strategic timeline..."
                                                    className="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 outline-none focus:border-brand-teal focus:bg-white placeholder:text-slate-400 transition-all resize-none"
                                                ></textarea>
                                            </div>

                                            <button 
                                                type="submit"
                                                className="w-full py-3 bg-brand-teal hover:bg-brand-tealLight text-white font-bold rounded-lg uppercase tracking-wider transition-colors text-xs flex items-center justify-center gap-2 shadow-md shadow-brand-teal/10"
                                            >
                                                <Icon name="Send" size={14} /> Submit Secure Inquiry
                                            </button>
                                        </form>
                                    )}
                                </div>
                            </section>
                        )}

                    </main>

                    {/* Footer Section */}
                    <footer className="border-t border-slate-200 mt-20 py-8 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
                        <div className="space-y-1">
                            <p className="text-sm font-semibold text-slate-900 uppercase tracking-wider">Dr. Diana B. Allen</p>
                            <p className="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em]">Security &bull; Compliance &bull; Leadership</p>
                        </div>
                        <div className="flex flex-col md:flex-row items-center gap-2 md:gap-6 text-[11px] font-mono text-slate-400">
                            <span>Copyright &copy; 2026. All Rights Reserved.</span>
                            <span className="hidden md:inline text-slate-200">|</span>
                            <span>Contact: info@dianaballen.com</span>
                        </div>
                    </footer>

                </div>
            );
        };

        // Render React Application
        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<App />);
    </script>

</body>
</html>
