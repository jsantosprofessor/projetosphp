<?php

// ==========================================
// BACK-END PHP: PROCESSAMENTO DE FORMULÁRIO
// ==========================================
// Este bloco processa o formulário de newsletter antes de renderizar o HTML.
// Em ambiente real, ligaria isto a uma base de dados (MySQL/PostgreSQL).

$feedback_msg = "";
$feedback_type = ""; // 'success' ou 'error'

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_newsletter'])) {
    // Sanitização e Validação Básica
    $nome = htmlspecialchars(trim($_POST["nome"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $equipa_favorita = htmlspecialchars(trim($_POST["equipa"]));

    if (empty($nome) || empty($email)) {
        $feedback_msg = "Por favor, preencha todos os campos obrigatórios.";
        $feedback_type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedback_msg = "Formato de e-mail inválido. Tente novamente.";
        $feedback_type = "error";
    } else {
        // Simulação de gravação na base de dados
        
        $feedback_msg = "Sucesso, $nome! Agora irá receber as atualizações dos $equipa_favorita e da NBA no seu e-mail.";
        $feedback_type = "success";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-PT" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBA Playoff Zone 2026 | Estatísticas Oficiais e Jogos</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;800;900&family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Configuração do Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        nba: {
                            blue: '#1D428A',
                            red: '#C8102E',
                            dark: '#0F172A', 
                            darker: '#020617', 
                            gray: '#334155', 
                            light: '#F8FAFC' 
                        }
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                        heading: ['Oswald', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'marquee': 'marquee 25s linear infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        marquee: {
                            '0%': { transform: 'translateX(100%)' },
                            '100%': { transform: 'translateX(-100%)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Estilos Personalizados Premium -->
    <style>
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #020617; }
        ::-webkit-scrollbar-thumb { background: #C8102E; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #A00C24; }

        .glass {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .glass-card {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(200, 16, 46, 0.2);
            border-color: rgba(29, 66, 138, 0.5);
        }

        .text-gradient {
            background: linear-gradient(to right, #C8102E, #1D428A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1504450758481-7338eba7524a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Estilos para os Tabs */
        .tab-btn {
            position: relative;
            transition: all 0.3s ease;
        }
        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0%;
            height: 2px;
            background-color: #C8102E;
            transition: width 0.3s ease;
        }
        .tab-btn.active {
            color: #C8102E;
            font-weight: bold;
        }
        .tab-btn.active::after {
            width: 100%;
        }
        .tab-content {
            display: none;
            animation: fadeInUp 0.4s ease-out forwards;
        }
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-nba-darker text-nba-light font-sans antialiased overflow-x-hidden">

    <!-- ==========================================
         CABEÇALHO / NAVEGAÇÃO
         ========================================== -->
    <header class="fixed w-full top-0 z-50 transition-all duration-300" id="navbar">
        <!-- Fita de Notícias (Ticker) -->
        <div class="bg-nba-red text-white text-xs py-1.5 overflow-hidden whitespace-nowrap border-b border-red-800">
            <div class="inline-block animate-marquee font-semibold tracking-wider">
                <span class="mx-4">🔥 ÚLTIMA HORA: Playoffs da NBA ao rubro! Jogo 6 decisivo entre Hawks e Knicks hoje à noite.</span>
                <span class="mx-4">⭐ Luka Dončić lidera a liga em pontos com 33.5 PPG pelos Lakers.</span>
                <span class="mx-4">🛡️ Wembanyama dominador na defesa com 3.1 desarmes por jogo.</span>
                <span class="mx-4">🏆 Thunder garantem o 1º lugar no Oeste com impressionantes 64 vitórias!</span>
                <span class="mx-4">🔥 ÚLTIMA HORA: Playoffs da NBA ao rubro! Jogo 6 decisivo entre Hawks e Knicks hoje à noite.</span>
            </div>
        </div>

        <div class="glass border-b border-gray-800/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logótipo -->
                    <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer" onclick="window.scrollTo(0,0)">
                        <img src="https://upload.wikimedia.org/wikipedia/pt/thumb/a/a9/NBA_logo.svg/1200px-NBA_logo.svg.png" alt="NBA Logo" class="h-12 w-auto">
                        <span class="font-heading font-bold text-2xl tracking-wider uppercase border-l-2 border-nba-gray pl-3">Playoff <span class="text-nba-red">Zone</span></span>
                    </div>

                    <!-- Menu Desktop -->
                    <nav class="hidden md:flex space-x-8 items-center">
                        <a href="#jogos" class="text-sm font-semibold hover:text-nba-red transition-colors duration-200">Jogos</a>
                        <a href="#estatisticas" class="text-sm font-semibold hover:text-nba-red transition-colors duration-200">Estatísticas</a>
                        <a href="#tabela-classificacao" class="text-sm font-semibold hover:text-nba-red transition-colors duration-200">Classificação Oficial</a>
                        <a href="#newsletter" class="bg-nba-blue hover:bg-blue-800 text-white px-6 py-2 rounded-full font-bold transition-transform duration-200 transform hover:scale-105 shadow-[0_0_15px_rgba(29,66,138,0.4)]">
                            Apoiar Equipa
                        </a>
                    </nav>

                    <!-- Botão Menu Mobile -->
                    <div class="md:hidden flex items-center">
                        <button id="mobile-menu-btn" class="text-nba-light hover:text-nba-red focus:outline-none">
                            <i class="ph ph-list text-3xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dropdown Menu Mobile -->
            <div id="mobile-menu" class="hidden md:hidden bg-nba-darker border-t border-gray-800">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 flex flex-col">
                    <a href="#jogos" class="mobile-link block px-3 py-2 rounded-md text-base font-medium hover:text-nba-red hover:bg-gray-800">Jogos</a>
                    <a href="#estatisticas" class="mobile-link block px-3 py-2 rounded-md text-base font-medium hover:text-nba-red hover:bg-gray-800">Estatísticas</a>
                    <a href="#tabela-classificacao" class="mobile-link block px-3 py-2 rounded-md text-base font-medium hover:text-nba-red hover:bg-gray-800">Classificação Oficial</a>
                    <a href="#newsletter" class="mobile-link block px-3 py-2 mt-4 text-center rounded-md text-base font-bold bg-nba-blue text-white">Apoiar Equipa</a>
                </div>
            </div>
        </div>
    </header>

    <!-- ==========================================
         SECÇÃO HERO
         ========================================== -->
    <section class="relative h-screen flex items-center justify-center hero-bg pt-20">
        <div class="absolute inset-0 bg-gradient-to-b from-nba-darker/90 via-nba-darker/70 to-nba-darker z-0"></div>
        
        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto animate-fade-in-up">
            <div class="inline-block px-4 py-1 rounded-full border border-nba-red/50 bg-nba-red/10 text-nba-red font-bold text-sm tracking-widest uppercase mb-6 backdrop-blur-sm">
                <span class="inline-block w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span>
                Playoffs 2026 - Central Oficial
            </div>
            <h1 class="font-heading text-5xl md:text-7xl lg:text-8xl font-black uppercase leading-tight mb-4 tracking-tighter">
                O Caminho para a <br/> <span class="text-gradient">Glória Eterna</span>
            </h1>
            <p class="text-lg md:text-2xl text-gray-300 font-light mb-10 max-w-3xl mx-auto">
                Acompanhe o marcador em tempo real, tabelas de classificação autênticas e os líderes absolutos das estatísticas da liga.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#jogos" class="bg-nba-red hover:bg-red-700 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-[0_0_20px_rgba(200,16,46,0.5)] flex items-center justify-center gap-2">
                    Resultados de Hoje <i class="ph-bold ph-arrow-right"></i>
                </a>
                <a href="#tabela-classificacao" class="bg-nba-blue hover:bg-blue-800 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center gap-2">
                    Ver Classificação <i class="ph-bold ph-list-numbers"></i>
                </a>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-10 animate-bounce cursor-pointer" onclick="document.getElementById('jogos').scrollIntoView({behavior: 'smooth'})">
            <i class="ph ph-caret-down text-4xl text-gray-400 hover:text-white transition-colors"></i>
        </div>
    </section>

    <!-- ==========================================
         JOGOS E MARCADORES
         ========================================== -->
    <section id="jogos" class="py-24 bg-nba-darker relative border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 reveal">
                <div>
                    <h2 class="font-heading text-4xl md:text-5xl font-bold uppercase mb-2">Resultados <span class="text-nba-red">& Partidas</span></h2>
                    <p class="text-gray-400">Primeira ronda dos Playoffs 2026</p>
                </div>
                
                <!-- Cronómetro para jogo em destaque -->
                <div class="mt-6 md:mt-0 glass px-6 py-3 rounded-lg border border-nba-red/30 text-center shadow-lg shadow-nba-red/10">
                    <p class="text-xs text-nba-red font-bold uppercase tracking-wider mb-1 flex justify-center items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-nba-red animate-pulse"></span> Jogo 6 (ATL x NYK)
                    </p>
                    <div id="countdown" class="font-heading text-3xl font-bold flex gap-3 justify-center text-white">
                        <div><span id="cd-hours">00</span><span class="text-[10px] text-gray-400 block -mt-1 font-sans">HRS</span></div>:
                        <div><span id="cd-mins">00</span><span class="text-[10px] text-gray-400 block -mt-1 font-sans">MIN</span></div>:
                        <div><span id="cd-secs" class="text-nba-red">00</span><span class="text-[10px] text-gray-400 block -mt-1 font-sans">SEG</span></div>
                    </div>
                </div>
            </div>

            <div id="games-container" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 reveal">
                <!-- Preenchido via JavaScript -->
            </div>

        </div>
    </section>

    <!-- ==========================================
         CLASSIFICAÇÃO DA FASE REGULAR (NOVA SECÇÃO)
         ========================================== -->
    <section id="tabela-classificacao" class="py-24 bg-nba-dark relative border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <h2 class="font-heading text-4xl md:text-5xl font-bold uppercase mb-4">Classificação <span class="text-nba-blue">Final</span></h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Tabela oficial da Fase Regular 2025-2026 que definiu o alinhamento dos Playoffs.</p>
            </div>

            <!-- Controlos de Tabs da Classificação -->
            <div class="flex justify-center mb-8 reveal">
                <div class="bg-gray-800 p-1 rounded-xl inline-flex shadow-inner">
                    <button class="standings-tab-btn px-6 py-2.5 rounded-lg text-sm font-bold uppercase tracking-wider transition-all duration-300 text-white bg-nba-blue shadow-md" data-target="standings-east">
                        Conferência Este
                    </button>
                    <button class="standings-tab-btn px-6 py-2.5 rounded-lg text-sm font-bold uppercase tracking-wider text-gray-400 hover:text-white transition-all duration-300" data-target="standings-west">
                        Conferência Oeste
                    </button>
                </div>
            </div>

            <!-- Tabela Este -->
            <div id="standings-east" class="standings-content active reveal overflow-hidden glass rounded-xl border border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-800/80 border-b border-gray-700">
                            <tr class="text-gray-300 text-xs uppercase tracking-wider font-semibold">
                                <th class="py-4 px-6 rounded-tl-xl w-16 text-center">Pos</th>
                                <th class="py-4 px-6 w-full">Equipa</th>
                                <th class="py-4 px-6 text-center" title="Vitórias">V</th>
                                <th class="py-4 px-6 text-center" title="Derrotas">D</th>
                                <th class="py-4 px-6 text-center rounded-tr-xl" title="Percentagem">%</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-east" class="text-sm font-medium">
                            <!-- Injetado via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabela Oeste -->
            <div id="standings-west" class="standings-content hidden reveal overflow-hidden glass rounded-xl border border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-800/80 border-b border-gray-700">
                            <tr class="text-gray-300 text-xs uppercase tracking-wider font-semibold">
                                <th class="py-4 px-6 rounded-tl-xl w-16 text-center">Pos</th>
                                <th class="py-4 px-6 w-full">Equipa</th>
                                <th class="py-4 px-6 text-center" title="Vitórias">V</th>
                                <th class="py-4 px-6 text-center" title="Derrotas">D</th>
                                <th class="py-4 px-6 text-center rounded-tr-xl" title="Percentagem">%</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-west" class="text-sm font-medium">
                            <!-- Injetado via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-6 flex justify-center gap-6 text-xs text-gray-400 reveal">
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-blue-500 rounded-sm"></span> Posição garantida no playoff</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-nba-red rounded-sm"></span> Posição garantida na divisão</div>
            </div>

        </div>
    </section>

    <!-- ==========================================
         LÍDERES DE ESTATÍSTICAS EXPANDIDO
         ========================================== -->
    <section id="estatisticas" class="py-24 bg-nba-darker relative border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 reveal">
                <h2 class="font-heading text-4xl md:text-5xl font-bold uppercase mb-4">Líderes de <span class="text-nba-red">Desempenho</span></h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Dados estatísticos oficiais e atualizados dos Playoffs da NBA.</p>
            </div>

            <!-- Tabs de Estatísticas -->
            <div class="flex justify-center border-b border-gray-700 mb-8 reveal">
                <button class="stats-tab-btn active px-6 py-3 text-sm md:text-base text-gray-400 hover:text-white tracking-wide uppercase font-semibold" data-target="stats-group-1">
                    Ataque & Criação
                </button>
                <button class="stats-tab-btn px-6 py-3 text-sm md:text-base text-gray-400 hover:text-white tracking-wide uppercase font-semibold" data-target="stats-group-2">
                    Defesa & Triplos
                </button>
            </div>

            <!-- GRUPO 1: Pts, Res, Ass -->
            <div id="stats-group-1" class="stats-content active">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Pontos -->
                    <div class="glass-card rounded-xl p-6 reveal">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                            <h3 class="font-heading text-2xl font-bold">Pontos <span class="text-gray-400 text-sm">(PPG)</span></h3>
                            <i class="ph-fill ph-fire text-nba-red text-3xl"></i>
                        </div>
                        <ul id="stats-points" class="space-y-4"></ul>
                    </div>

                    <!-- Ressaltos -->
                    <div class="glass-card rounded-xl p-6 reveal" style="transition-delay: 100ms;">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                            <h3 class="font-heading text-2xl font-bold">Ressaltos <span class="text-gray-400 text-sm">(RPG)</span></h3>
                            <i class="ph-fill ph-hand-grabbing text-nba-red text-3xl"></i>
                        </div>
                        <ul id="stats-rebounds" class="space-y-4"></ul>
                    </div>

                    <!-- Assistências -->
                    <div class="glass-card rounded-xl p-6 reveal" style="transition-delay: 200ms;">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                            <h3 class="font-heading text-2xl font-bold">Assistências <span class="text-gray-400 text-sm">(APG)</span></h3>
                            <i class="ph-fill ph-users-three text-nba-red text-3xl"></i>
                        </div>
                        <ul id="stats-assists" class="space-y-4"></ul>
                    </div>
                </div>
            </div>

            <!-- GRUPO 2: Blocos, Roubos, 3PM -->
            <div id="stats-group-2" class="stats-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Desarmes (Blocks) -->
                    <div class="glass-card rounded-xl p-6">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                            <h3 class="font-heading text-2xl font-bold">Desarmes <span class="text-gray-400 text-sm">(BPG)</span></h3>
                            <i class="ph-fill ph-hand text-nba-blue text-3xl"></i>
                        </div>
                        <ul id="stats-blocks" class="space-y-4"></ul>
                    </div>

                    <!-- Roubos (Steals) -->
                    <div class="glass-card rounded-xl p-6" style="transition-delay: 100ms;">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                            <h3 class="font-heading text-2xl font-bold">Roubos <span class="text-gray-400 text-sm">(SPG)</span></h3>
                            <i class="ph-fill ph-sneaker text-nba-blue text-3xl"></i>
                        </div>
                        <ul id="stats-steals" class="space-y-4"></ul>
                    </div>

                    <!-- Triplos Marcados (3PM) -->
                    <div class="glass-card rounded-xl p-6" style="transition-delay: 200ms;">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                            <h3 class="font-heading text-2xl font-bold">Triplos <span class="text-gray-400 text-sm">(3PM)</span></h3>
                            <i class="ph-fill ph-target text-nba-blue text-3xl"></i>
                        </div>
                        <ul id="stats-threes" class="space-y-4"></ul>
                    </div>
                </div>
            </div>

            <!-- Chaveamento (Bracket) Atualizado -->
            <div class="mt-20 reveal">
                <h3 class="font-heading text-3xl font-bold uppercase mb-8 text-center">Chave dos <span class="text-nba-blue">Playoffs 2026</span></h3>
                <div class="glass rounded-xl p-6 overflow-x-auto border border-gray-700 shadow-xl">
                    <table class="w-full text-left min-w-[800px]">
                        <thead>
                            <tr class="text-gray-400 text-sm uppercase tracking-wider border-b border-gray-700 bg-gray-800/30">
                                <th class="py-4 px-6">Conferência Oeste</th>
                                <th class="py-4 px-6 text-center">Situação da Série</th>
                                <th class="py-4 px-6 text-right">Conferência Este</th>
                            </tr>
                        </thead>
                        <tbody class="text-lg font-semibold" id="bracket-table">
                            <!-- Injetado via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <!-- ==========================================
         FORMULÁRIO DE INSCRIÇÃO
         ========================================== -->
    <section id="newsletter" class="py-24 bg-nba-dark relative border-t border-gray-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
            <div class="glass rounded-3xl p-8 md:p-12 relative overflow-hidden border border-gray-700 shadow-[0_0_40px_rgba(0,0,0,0.5)]">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-nba-red/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-nba-blue/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 text-center mb-10">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-nba-red/10 border border-nba-red/30 mb-4">
                        <i class="ph-fill ph-envelope-simple-open text-3xl text-nba-red"></i>
                    </div>
                    <h2 class="font-heading text-4xl font-bold uppercase mb-2">Apoie a sua <span class="text-gradient">Equipa</span></h2>
                    <p class="text-gray-400">Receba resumos diários, resultados das partidas e análises táticas exclusivas diretamente no seu e-mail.</p>
                </div>

                <?php if (!empty($feedback_msg)): ?>
                    <div class="mb-8 p-4 rounded-lg font-bold text-center border <?php echo $feedback_type === 'success' ? 'bg-green-900/30 border-green-500 text-green-400' : 'bg-red-900/30 border-red-500 text-red-400'; ?>">
                        <?php echo $feedback_msg; ?>
                    </div>
                <?php endif; ?>

                <form id="newsletter-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#newsletter" class="space-y-6 relative z-10" onsubmit="return validateForm()">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-400 mb-2">O seu Nome *</label>
                            <input type="text" id="nome" name="nome" required
                                class="w-full bg-nba-darker border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-nba-blue focus:ring-1 focus:ring-nba-blue transition-all placeholder-gray-600 shadow-inner">
                            <span id="error-nome" class="text-red-500 text-xs hidden mt-1">Nome é obrigatório.</span>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-400 mb-2">E-mail *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full bg-nba-darker border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-nba-blue focus:ring-1 focus:ring-nba-blue transition-all placeholder-gray-600 shadow-inner">
                            <span id="error-email" class="text-red-500 text-xs hidden mt-1">Insira um e-mail válido.</span>
                        </div>
                    </div>
                    
                    <div>
                        <label for="equipa" class="block text-sm font-medium text-gray-400 mb-2">Equipa Favorita (Opcional)</label>
                        <select id="equipa" name="equipa" 
                            class="w-full bg-nba-darker border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-nba-blue focus:ring-1 focus:ring-nba-blue transition-all appearance-none cursor-pointer shadow-inner">
                            <option value="Toda a Liga">Acompanho a Liga Inteira</option>
                            <option value="Boston Celtics">Boston Celtics</option>
                            <option value="Los Angeles Lakers">Los Angeles Lakers</option>
                            <option value="New York Knicks">New York Knicks</option>
                            <option value="Denver Nuggets">Denver Nuggets</option>
                            <option value="Oklahoma City Thunder">Oklahoma City Thunder</option>
                            <option value="Cleveland Cavaliers">Cleveland Cavaliers</option>
                            <option value="Minnesota Timberwolves">Minnesota Timberwolves</option>
                            <option value="San Antonio Spurs">San Antonio Spurs</option>
                            <option value="Detroit Pistons">Detroit Pistons</option>
                        </select>
                    </div>

                    <button type="submit" name="submit_newsletter" class="w-full bg-gradient-to-r from-nba-red to-red-800 hover:from-red-600 hover:to-red-900 text-white font-bold text-lg py-4 rounded-lg transition-all duration-300 shadow-[0_4px_14px_0_rgba(200,16,46,0.39)] hover:shadow-[0_6px_20px_rgba(200,16,46,0.23)]">
                        Confirmar Inscrição
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- ==========================================
         RODAPÉ E BOTÃO TO-TOP
         ========================================== -->
    <footer class="bg-nba-darker border-t border-gray-800 pt-16 pb-8 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="https://upload.wikimedia.org/wikipedia/pt/thumb/a/a9/NBA_logo.svg/1200px-NBA_logo.svg.png" alt="NBA" class="h-10 grayscale opacity-80 hover:grayscale-0 transition-all duration-500 cursor-pointer">
                    </div>
                    <p class="text-gray-400 text-sm mb-6 max-w-sm">
                        O seu portal definitivo de acompanhamento da época 2025-2026 da NBA. Estatísticas avançadas, marcadores oficiais e cobertura completa dos Playoffs.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-nba-blue text-white transition-colors"><i class="ph-fill ph-twitter-logo"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-nba-red text-white transition-colors"><i class="ph-fill ph-instagram-logo"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-red-600 text-white transition-colors"><i class="ph-fill ph-youtube-logo"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider mb-4">Atalhos</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#jogos" class="hover:text-nba-red transition-colors">Jogos e Resultados</a></li>
                        <li><a href="#tabela-classificacao" class="hover:text-nba-red transition-colors">Classificação Leste/Oeste</a></li>
                        <li><a href="#estatisticas" class="hover:text-nba-red transition-colors">Líderes Individuais</a></li>
                        <li><a href="#" class="hover:text-nba-red transition-colors">Equipas Oficiais</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Termos de Serviço</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Política de Privacidade</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Definições de Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">
                    &copy; 2026 Playoff Zone. Todos os direitos reservados. (Fictício/Demonstração)
                </p>
                <p class="text-gray-500 text-sm mt-2 md:mt-0 font-bold">
                    Dados atualizados: 30 de Abril de 2026
                </p>
            </div>
        </div>

        <!-- Botão Voltar ao Topo -->
        <button id="btn-back-to-top" class="fixed bottom-6 right-6 w-12 h-12 bg-nba-blue hover:bg-blue-700 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 transition-opacity duration-300 pointer-events-none z-50">
            <i class="ph-bold ph-arrow-up text-xl"></i>
        </button>
    </footer>

    <!-- ==========================================
         JAVASCRIPT: DADOS E INTERATIVIDADE
         ========================================== -->
    <script>
        // ----------------------------------------
        // 1. DADOS EXTRAÍDOS (Com novas adições)
        // ----------------------------------------
        const nbaData = {
            games: [
                { id: 1, status: 'Encerrado', date: 'Ontem', homeTeam: { name: 'Cavaliers', abbr: 'CLE', logo: 'https://cdn.nba.com/logos/nba/1610612739/global/L/logo.svg', score: 125 }, awayTeam: { name: 'Raptors', abbr: 'TOR', logo: 'https://cdn.nba.com/logos/nba/1610612761/global/L/logo.svg', score: 120 }, series: 'CLE lidera 3 - 2' },
                { id: 2, status: 'Encerrado', date: 'Ontem', homeTeam: { name: 'Lakers', abbr: 'LAL', logo: 'https://cdn.nba.com/logos/nba/1610612747/global/L/logo.svg', score: 93 }, awayTeam: { name: 'Rockets', abbr: 'HOU', logo: 'https://cdn.nba.com/logos/nba/1610612745/global/L/logo.svg', score: 99 }, series: 'LAL lidera 3 - 2' },
                { id: 3, status: 'AGENDADO', time: 'Hoje 20:00', date: 'Jogo 6', homeTeam: { name: 'Hawks', abbr: 'ATL', logo: 'https://cdn.nba.com/logos/nba/1610612737/global/L/logo.svg', score: null }, awayTeam: { name: 'Knicks', abbr: 'NYK', logo: 'https://cdn.nba.com/logos/nba/1610612752/global/L/logo.svg', score: null }, series: 'NYK lidera 3 - 2' },
                { id: 4, status: 'AGENDADO', time: 'Hoje 21:00', date: 'Jogo 6', homeTeam: { name: '76ers', abbr: 'PHI', logo: 'https://cdn.nba.com/logos/nba/1610612755/global/L/logo.svg', score: null }, awayTeam: { name: 'Celtics', abbr: 'BOS', logo: 'https://cdn.nba.com/logos/nba/1610612738/global/L/logo.svg', score: null }, series: 'BOS lidera 3 - 2' },
                { id: 5, status: 'AGENDADO', time: 'Hoje 22:30', date: 'Jogo 6', homeTeam: { name: 'Timberwolves', abbr: 'MIN', logo: 'https://cdn.nba.com/logos/nba/1610612750/global/L/logo.svg', score: null }, awayTeam: { name: 'Nuggets', abbr: 'DEN', logo: 'https://cdn.nba.com/logos/nba/1610612743/global/L/logo.svg', score: null }, series: 'MIN lidera 3 - 2' },
                { id: 6, status: 'AGENDADO', time: 'Amanhã 20:00', date: 'Jogo 6', homeTeam: { name: 'Magic', abbr: 'ORL', logo: 'https://cdn.nba.com/logos/nba/1610612753/global/L/logo.svg', score: null }, awayTeam: { name: 'Pistons', abbr: 'DET', logo: 'https://cdn.nba.com/logos/nba/1610612765/global/L/logo.svg', score: null }, series: 'ORL lidera 3 - 2' }
            ],
            leaders: {
                points: [
                    { player: 'Luka Dončić', team: 'Lakers', value: 33.5, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1629029.png' },
                    { player: 'Shai Gilgeous-Alexander', team: 'Thunder', value: 31.1, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1628983.png' },
                    { player: 'Anthony Edwards', team: 'Timberwolves', value: 28.8, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1630162.png' },
                    { player: 'Jaylen Brown', team: 'Celtics', value: 28.7, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1627759.png' },
                    { player: 'Tyrese Maxey', team: '76ers', value: 28.3, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1630178.png' }
                ],
                rebounds: [
                    { player: 'Nikola Jokic', team: 'Nuggets', value: 12.9, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/203999.png' },
                    { player: 'Karl-Anthony Towns', team: 'Knicks', value: 11.9, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1626157.png' },
                    { player: 'Donovan Clingan', team: 'Trail Blazers', value: 11.6, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1642270.png' },
                    { player: 'Victor Wembanyama', team: 'Spurs', value: 11.5, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1641705.png' },
                    { player: 'Rudy Gobert', team: 'Timberwolves', value: 11.5, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/203497.png' }
                ],
                assists: [
                    { player: 'Nikola Jokic', team: 'Nuggets', value: 10.7, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/203999.png' },
                    { player: 'Cade Cunningham', team: 'Pistons', value: 9.9, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1630595.png' },
                    { player: 'Luka Dončić', team: 'Lakers', value: 8.3, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1629029.png' },
                    { player: 'James Harden', team: 'Cavaliers', value: 8.0, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/201935.png' },
                    { player: 'Jalen Johnson', team: 'Hawks', value: 7.9, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1630552.png' }
                ],
                blocks: [
                    { player: 'Victor Wembanyama', team: 'Spurs', value: 3.1, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1641705.png' },
                    { player: 'Chet Holmgren', team: 'Thunder', value: 1.9, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1631096.png' },
                    { player: 'Jay Huff', team: 'Pacers', value: 1.9, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1630643.png' },
                    { player: 'Evan Mobley', team: 'Cavaliers', value: 1.7, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1630596.png' },
                    { player: 'Donovan Clingan', team: 'Trail Blazers', value: 1.7, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1642270.png' }
                ],
                steals: [
                    { player: 'Ausar Thompson', team: 'Pistons', value: 2.0, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1641709.png' },
                    { player: 'Dyson Daniels', team: 'Hawks', value: 2.0, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1631100.png' },
                    { player: 'Cason Wallace', team: 'Thunder', value: 2.0, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1641717.png' },
                    { player: 'Kawhi Leonard', team: 'Clippers', value: 1.9, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/202695.png' },
                    { player: 'Tyrese Maxey', team: '76ers', value: 1.9, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1630178.png' }
                ],
                threes: [
                    { player: 'Kon Knueppel', team: 'Hornets', value: 273, isTotal: true, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1642275.png' },
                    { player: 'LaMelo Ball', team: 'Hornets', value: 272, isTotal: true, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1630163.png' },
                    { player: 'Luka Dončić', team: 'Lakers', value: 254, isTotal: true, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1629029.png' },
                    { player: 'Nickeil Alexander', team: 'Hawks', value: 251, isTotal: true, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1629638.png' },
                    { player: 'Jamal Murray', team: 'Nuggets', value: 245, isTotal: true, img: 'https://cdn.nba.com/headshots/nba/latest/260x190/1627750.png' }
                ]
            },
            standings: {
                east: [
                    { pos: 1, team: 'Detroit Pistons', logo: 'https://cdn.nba.com/logos/nba/1610612765/global/L/logo.svg', w: 60, l: 22, p: '.732', status: 'blue' },
                    { pos: 2, team: 'Boston Celtics', logo: 'https://cdn.nba.com/logos/nba/1610612738/global/L/logo.svg', w: 56, l: 26, p: '.683', status: 'blue' },
                    { pos: 3, team: 'New York Knicks', logo: 'https://cdn.nba.com/logos/nba/1610612752/global/L/logo.svg', w: 53, l: 29, p: '.646', status: 'blue' },
                    { pos: 4, team: 'Cleveland Cavaliers', logo: 'https://cdn.nba.com/logos/nba/1610612739/global/L/logo.svg', w: 52, l: 30, p: '.634', status: 'red' },
                    { pos: 5, team: 'Toronto Raptors', logo: 'https://cdn.nba.com/logos/nba/1610612761/global/L/logo.svg', w: 46, l: 36, p: '.561', status: 'red' },
                    { pos: 6, team: 'Atlanta Hawks', logo: 'https://cdn.nba.com/logos/nba/1610612737/global/L/logo.svg', w: 46, l: 36, p: '.561', status: 'red' },
                    { pos: 7, team: 'Philadelphia 76ers', logo: 'https://cdn.nba.com/logos/nba/1610612755/global/L/logo.svg', w: 45, l: 37, p: '.549', status: '' },
                    { pos: 8, team: 'Orlando Magic', logo: 'https://cdn.nba.com/logos/nba/1610612753/global/L/logo.svg', w: 45, l: 37, p: '.549', status: '' }
                ],
                west: [
                    { pos: 1, team: 'Oklahoma City Thunder', logo: 'https://cdn.nba.com/logos/nba/1610612760/global/L/logo.svg', w: 64, l: 18, p: '.780', status: 'blue' },
                    { pos: 2, team: 'San Antonio Spurs', logo: 'https://cdn.nba.com/logos/nba/1610612759/global/L/logo.svg', w: 62, l: 20, p: '.756', status: 'blue' },
                    { pos: 3, team: 'Denver Nuggets', logo: 'https://cdn.nba.com/logos/nba/1610612743/global/L/logo.svg', w: 54, l: 28, p: '.659', status: 'blue' },
                    { pos: 4, team: 'Los Angeles Lakers', logo: 'https://cdn.nba.com/logos/nba/1610612747/global/L/logo.svg', w: 53, l: 29, p: '.646', status: 'red' },
                    { pos: 5, team: 'Houston Rockets', logo: 'https://cdn.nba.com/logos/nba/1610612745/global/L/logo.svg', w: 52, l: 30, p: '.634', status: 'red' },
                    { pos: 6, team: 'Minnesota Timberwolves', logo: 'https://cdn.nba.com/logos/nba/1610612750/global/L/logo.svg', w: 49, l: 33, p: '.598', status: 'red' },
                    { pos: 7, team: 'Portland Trail Blazers', logo: 'https://cdn.nba.com/logos/nba/1610612757/global/L/logo.svg', w: 42, l: 40, p: '.512', status: '' },
                    { pos: 8, team: 'Phoenix Suns', logo: 'https://cdn.nba.com/logos/nba/1610612756/global/L/logo.svg', w: 45, l: 37, p: '.549', status: '' }
                ]
            },
            bracket: [
                { west: '(1) Thunder vs (8) Suns', wScore: 'Em curso', east: '(1) Pistons vs (8) Magic', eScore: 'ORL 3-2' },
                { west: '(2) Spurs vs (7) Trail Blazers', wScore: 'Em curso', east: '(2) Celtics vs (7) 76ers', eScore: 'BOS 3-2' },
                { west: '(3) Nuggets vs (6) Timberwolves', wScore: 'MIN 3-2', east: '(3) Knicks vs (6) Hawks', eScore: 'NYK 3-2' },
                { west: '(4) Lakers vs (5) Rockets', wScore: 'LAL 3-2', east: '(4) Cavaliers vs (5) Raptors', eScore: 'CLE 3-2' }
            ]
        };

        // ----------------------------------------
        // 2. RENDERIZAÇÃO DO DOM
        // ----------------------------------------
        document.addEventListener('DOMContentLoaded', () => {
            renderGames();
            renderStats();
            renderStandings();
            renderBracket();
            initScrollAnimations();
            initTabs();
            initBackToTop();
        });

        function renderGames() {
            const container = document.getElementById('games-container');
            container.innerHTML = ''; 

            nbaData.games.forEach(game => {
                let statusBadge = '';
                let scoreDisplay = '';
                
                if (game.status === 'Encerrado') {
                    statusBadge = `<span class="bg-gray-700 text-gray-300 text-xs font-bold px-2 py-1 rounded">ENCERRADO</span>`;
                    scoreDisplay = `
                        <div class="text-right">
                            <span class="font-heading font-bold text-2xl ${game.homeTeam.score > game.awayTeam.score ? 'text-white' : 'text-gray-500'}">${game.homeTeam.score}</span><br>
                            <span class="font-heading font-bold text-2xl ${game.awayTeam.score > game.homeTeam.score ? 'text-white' : 'text-gray-500'}">${game.awayTeam.score}</span>
                        </div>`;
                } else {
                    statusBadge = `<span class="bg-nba-blue text-white text-xs font-bold px-2 py-1 rounded">${game.time}</span>`;
                    scoreDisplay = `
                        <div class="text-right text-gray-500 text-sm flex flex-col justify-center h-full">
                            <span>-</span>
                            <span>-</span>
                        </div>`;
                }

                const cardHTML = `
                    <div class="glass-card rounded-xl p-5 relative overflow-hidden group hover:border-nba-blue/50">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-700 pb-2">
                            <span class="text-gray-400 text-sm font-medium">${game.date}</span>
                            ${statusBadge}
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-full p-1.5 bg-white flex items-center justify-center">
                                        <img src="${game.homeTeam.logo}" alt="${game.homeTeam.abbr}" class="max-w-full max-h-full">
                                    </div>
                                    <span class="font-bold text-lg">${game.homeTeam.name}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full p-1.5 bg-white flex items-center justify-center">
                                        <img src="${game.awayTeam.logo}" alt="${game.awayTeam.abbr}" class="max-w-full max-h-full">
                                    </div>
                                    <span class="font-bold text-lg">${game.awayTeam.name}</span>
                                </div>
                            </div>
                            ${scoreDisplay}
                        </div>
                        <div class="bg-gray-800/80 p-2 rounded text-center text-xs text-gray-300 font-semibold tracking-wide uppercase">
                            ${game.series}
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', cardHTML);
            });
        }

        function renderStats() {
            const categories = ['points', 'rebounds', 'assists', 'blocks', 'steals', 'threes'];
            
            categories.forEach(cat => {
                const list = document.getElementById(`stats-${cat}`);
                if(!list) return; // Segurança caso a lista não exista
                
                nbaData.leaders[cat].forEach((player, index) => {
                    const isTop = index === 0;
                    const bgClass = isTop ? 'bg-gradient-to-r from-nba-blue/20 to-transparent border-l-4 border-nba-blue' : 'bg-gray-800/30 hover:bg-gray-800/60 transition-colors';
                    const numberColor = isTop ? 'text-nba-blue' : 'text-gray-500';
                    const valueDisplay = player.isTotal ? player.value : player.value.toFixed(1);
                    
                    const itemHTML = `
                        <li class="flex items-center gap-4 p-2 rounded-lg ${bgClass}">
                            <div class="font-heading font-bold text-xl ${numberColor} w-6 text-center">${index + 1}</div>
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-700 flex-shrink-0 relative pt-1 border border-gray-600">
                                <img src="${player.img}" alt="${player.player}" class="w-full h-full object-cover object-top drop-shadow-md" onerror="this.src='https://cdn.nba.com/headshots/nba/latest/260x190/logoman.png'">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-sm md:text-base">${player.player}</h4>
                                <span class="text-xs text-gray-400">${player.team}</span>
                            </div>
                            <div class="font-heading font-bold text-xl">${valueDisplay}</div>
                        </li>
                    `;
                    list.insertAdjacentHTML('beforeend', itemHTML);
                });
            });
        }

        function renderStandings() {
            ['east', 'west'].forEach(conf => {
                const tbody = document.getElementById(`table-body-${conf}`);
                nbaData.standings[conf].forEach(team => {
                    let statusColor = 'bg-transparent';
                    if (team.status === 'blue') statusColor = 'bg-blue-500';
                    if (team.status === 'red') statusColor = 'bg-nba-red';

                    const rowHTML = `
                        <tr class="border-b border-gray-700/50 hover:bg-white/5 transition-colors">
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full ${statusColor}"></div>
                                    <span class="font-bold ${team.pos <= 6 ? 'text-white' : 'text-gray-400'}">${team.pos}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="${team.logo}" alt="${team.team}" class="w-8 h-8 object-contain">
                                    <span class="font-semibold whitespace-nowrap">${team.team}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center text-gray-300">${team.w}</td>
                            <td class="py-3 px-6 text-center text-gray-300">${team.l}</td>
                            <td class="py-3 px-6 text-center font-bold text-white">${team.p}</td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', rowHTML);
                });
            });
        }

        function renderBracket() {
            const tbody = document.getElementById('bracket-table');
            nbaData.bracket.forEach(series => {
                const row = `
                    <tr class="border-b border-gray-700 hover:bg-white/5 transition-colors">
                        <td class="py-4 px-6 text-gray-300">${series.west}</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-block px-3 py-1 bg-gray-800 rounded text-nba-light font-bold text-sm">${series.wScore}</span>
                            <span class="mx-2 text-gray-600">|</span>
                            <span class="inline-block px-3 py-1 bg-gray-800 rounded text-nba-light font-bold text-sm">${series.eScore}</span>
                        </td>
                        <td class="py-4 px-6 text-right text-gray-300">${series.east}</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }

        // ----------------------------------------
        // 3. INTERATIVIDADE E TABS
        // ----------------------------------------
        function initTabs() {
            // Tabs de Estatísticas
            const statsBtns = document.querySelectorAll('.stats-tab-btn');
            const statsContents = document.querySelectorAll('.stats-content');

            statsBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    statsBtns.forEach(b => { b.classList.remove('active', 'text-white'); b.classList.add('text-gray-400'); b.style.borderBottom = "none"; });
                    statsContents.forEach(c => c.classList.add('hidden'));
                    
                    btn.classList.add('active', 'text-white');
                    btn.classList.remove('text-gray-400');
                    btn.style.borderBottom = "2px solid #C8102E";
                    
                    const targetId = btn.getAttribute('data-target');
                    document.getElementById(targetId).classList.remove('hidden');
                });
            });
            // Ativa o primeiro tab visualmente
            statsBtns[0].style.borderBottom = "2px solid #C8102E";

            // Tabs de Classificação
            const standingsBtns = document.querySelectorAll('.standings-tab-btn');
            const standingsContents = document.querySelectorAll('.standings-content');

            standingsBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    standingsBtns.forEach(b => { 
                        b.classList.remove('bg-nba-blue', 'text-white', 'shadow-md'); 
                        b.classList.add('text-gray-400');
                    });
                    standingsContents.forEach(c => c.classList.add('hidden'));
                    
                    btn.classList.add('bg-nba-blue', 'text-white', 'shadow-md');
                    btn.classList.remove('text-gray-400');
                    
                    const targetId = btn.getAttribute('data-target');
                    document.getElementById(targetId).classList.remove('hidden');
                });
            });
        }

        // Menu Mobile Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            const icon = btn.querySelector('i');
            if (menu.classList.contains('hidden')) {
                icon.classList.remove('ph-x');
                icon.classList.add('ph-list');
            } else {
                icon.classList.remove('ph-list');
                icon.classList.add('ph-x');
            }
        });

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
                btn.querySelector('i').classList.remove('ph-x');
                btn.querySelector('i').classList.add('ph-list');
            });
        });

        // ----------------------------------------
        // 4. SCROLL EVENTS (Navbar & Back to Top)
        // ----------------------------------------
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            const topBtn = document.getElementById('btn-back-to-top');
            
            // Navbar Glass effect
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg', 'bg-nba-darker/90', 'backdrop-blur-md');
            } else {
                navbar.classList.remove('shadow-lg', 'bg-nba-darker/90', 'backdrop-blur-md');
            }

            // Back to top button visibility
            if (window.scrollY > 500) {
                topBtn.classList.remove('opacity-0', 'pointer-events-none');
                topBtn.classList.add('opacity-100', 'cursor-pointer');
            } else {
                topBtn.classList.add('opacity-0', 'pointer-events-none');
                topBtn.classList.remove('opacity-100', 'cursor-pointer');
            }
        });

        function initBackToTop() {
            document.getElementById('btn-back-to-top').addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // ----------------------------------------
        // 5. CRONÓMETRO DE CONTAGEM DECRESCENTE
        // ----------------------------------------
        // Jogo 6 de Hawks x Knicks hoje às 20:00 (baseado em Abril 30, 2026)
        const countDownDate = new Date("April 30, 2026 20:00:00").getTime();

        const x = setInterval(function() {
            const now = new Date().getTime();
            const distance = countDownDate - now;

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("cd-hours").innerText = Math.max(0, hours).toString().padStart(2, '0');
            document.getElementById("cd-mins").innerText = Math.max(0, minutes).toString().padStart(2, '0');
            document.getElementById("cd-secs").innerText = Math.max(0, seconds).toString().padStart(2, '0');

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "<span class='text-nba-red uppercase tracking-widest text-2xl'>AO VIVO AGORA</span>";
            }
        }, 1000);

        // ----------------------------------------
        // 6. ANIMAÇÕES SCROLL (Intersection Observer)
        // ----------------------------------------
        function initScrollAnimations() {
            const reveals = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

            reveals.forEach(reveal => observer.observe(reveal));
        }

        // ----------------------------------------
        // 7. VALIDAÇÃO DE FORMULÁRIO (FRONT-END)
        // ----------------------------------------
        function validateForm() {
            let isValid = true;
            const nome = document.getElementById('nome').value.trim();
            const email = document.getElementById('email').value.trim();
            const errorNome = document.getElementById('error-nome');
            const errorEmail = document.getElementById('error-email');
            
            errorNome.classList.add('hidden');
            errorEmail.classList.add('hidden');
            
            if (nome === '') {
                errorNome.classList.remove('hidden');
                isValid = false;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '' || !emailRegex.test(email)) {
                errorEmail.classList.remove('hidden');
                isValid = false;
            }
            
            if(isValid) {
                const btn = document.querySelector('button[name="submit_newsletter"]');
                btn.innerHTML = '<i class="ph ph-spinner-gap animate-spin inline-block mr-2"></i> A Registar...';
                btn.classList.add('opacity-75', 'cursor-not-allowed');
            }

            return isValid;
        }
    </script>
</body>
</html>