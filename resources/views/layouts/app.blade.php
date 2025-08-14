{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Gestor Financeiro')</title>
    
    {{-- Bootstrap CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome para ícones --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    {{-- Fonts do Google --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /*
        |--------------------------------------------------------------------------
        | CSS Customizado com Paleta de Cores Específica
        |--------------------------------------------------------------------------
        | 
        | Paleta baseada na imagem fornecida:
        | #E58E16 (Laranja) - Para entradas/receitas
        | #E3C924 (Amarelo) - Para destaques e hover states  
        | #426163 (Verde-azulado) - Para saldo e elementos neutros
        | #29271B (Cinza escuro) - Para textos importantes
        | #000000 (Preto) - Para contrastes e textos
        */
        
        :root {
            --cor-entrada: #E58E16;    /* Laranja - Entradas */
            --cor-destaque: #E3C924;   /* Amarelo - Destaques */
            --cor-saldo: #426163;      /* Verde-azulado - Saldo */
            --cor-texto-escuro: #29271B; /* Cinza escuro - Textos */
            --cor-contraste: #000000;  /* Preto - Contrastes */
            --cor-saida: #dc3545;      /* Vermelho Bootstrap para saídas */
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #181a1b;
            color: #f1f1f1;
            line-height: 1.6;
        }

        body.dark-mode, html.dark-mode {
            background-color: #181a1b !important;
            color: #f1f1f1 !important;
        }

        .bg-light, .navbar-light, footer.bg-light {
            background-color: #23272b !important;
            color: #f1f1f1 !important;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #23272b 0%, #181a1b 100%) !important;
        }


        .card, .month-selector {
            background-color: #23272b !important;
            color: #e0e0e0 !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
            border: 1px solid #222 !important;
        }

        .card-header-entrada {
            background: linear-gradient(135deg, rgba(229,142,22,0.7) 0%, rgba(244,167,66,0.5) 100%) !important;
            color: #fff !important;
        }
        .card-header-saida {
            background: linear-gradient(135deg, rgba(220,53,69,0.7) 0%, rgba(231,76,60,0.5) 100%) !important;
            color: #fff !important;
        }
        .card-header-saldo {
            background: linear-gradient(135deg, rgba(66,97,99,0.7) 0%, rgba(90,124,126,0.5) 100%) !important;
            color: #fff !important;
        }
        .card-header-destaque {
            background: linear-gradient(135deg, rgba(227,201,36,0.7) 0%, rgba(241,212,36,0.5) 100%) !important;
            color: #23272b !important;
        }

        .table {
            background-color: #181a1b !important;
            color: #e0e0e0 !important;
            border-radius: 10px;
        }
        .table thead th {
            background-color: #23272b !important;
            color: #e0e0e0 !important;
            border-bottom: 1px solid #333 !important;
        }
        .table tbody tr {
            background-color: #181a1b !important;
            transition: background-color 0.2s ease;
        }
        .table tbody tr:hover {
            background-color: #23272b !important;
        }
        .table tbody td {
            border-bottom: 1px solid #333 !important;
        }

        /* Botões de ação escuros */
        .btn, .btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-info, .btn-entrada, .btn-saida, .btn-saldo {
            background-color: #23272b !important;
            color: #e0e0e0 !important;
            border: 1px solid #333 !important;
            box-shadow: none !important;
        }
        .btn:hover, .btn-primary:hover, .btn-success:hover, .btn-danger:hover, .btn-warning:hover, .btn-info:hover, .btn-entrada:hover, .btn-saida:hover, .btn-saldo:hover {
            background-color: #181a1b !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .alert-success, .alert-danger {
            background-color: #23272b !important;
            color: #f1f1f1 !important;
            border-color: var(--cor-entrada);
        }

        .btn, .btn-entrada, .btn-saida, .btn-saldo {
            color: #fff !important;
        }

        /* Navbar personalizada com gradiente */
        .navbar-custom {
            background: linear-gradient(135deg, var(--cor-saldo) 0%, var(--cor-texto-escuro) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
        }

        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--cor-destaque) !important;
        }

        /* Cards com sombras suaves */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        /* Headers dos cards com cores da paleta */
        .card-header {
            border: none;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            padding: 1.5rem;
        }

        .card-header-entrada {
            background: linear-gradient(135deg, var(--cor-entrada) 0%, #f4a742 100%);
            color: white;
        }

        .card-header-saida {
            background: linear-gradient(135deg, var(--cor-saida) 0%, #e74c3c 100%);
            color: white;
        }

        .card-header-saldo {
            background: linear-gradient(135deg, var(--cor-saldo) 0%, #5a7c7e 100%);
            color: white;
        }

        .card-header-destaque {
            background: linear-gradient(135deg, var(--cor-destaque) 0%, #f1d424 100%);
            color: var(--cor-texto-escuro);
        }

        /* Botões personalizados */
        .btn-entrada {
            background: linear-gradient(135deg, var(--cor-entrada) 0%, #f4a742 100%);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-entrada:hover {
            background: linear-gradient(135deg, #d17a0a 0%, var(--cor-entrada) 100%);
            transform: translateY(-1px);
            color: white;
        }

        .btn-saida {
            background: linear-gradient(135deg, var(--cor-saida) 0%, #e74c3c 100%);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-saida:hover {
            background: linear-gradient(135deg, #c82333 0%, var(--cor-saida) 100%);
            transform: translateY(-1px);
            color: white;
        }

        .btn-saldo {
            background: linear-gradient(135deg, var(--cor-saldo) 0%, #5a7c7e 100%);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-saldo:hover {
            background: linear-gradient(135deg, #365557 0%, var(--cor-saldo) 100%);
            transform: translateY(-1px);
            color: white;
        }

        /* Cards de resumo (dashboard) */
        .resumo-entrada {
            background: linear-gradient(135deg, var(--cor-entrada) 0%, #f4a742 100%);
            color: white;
        }

        .resumo-saida {
            background: linear-gradient(135deg, var(--cor-saida) 0%, #e74c3c 100%);
            color: white;
        }

        .resumo-saldo {
            background: linear-gradient(135deg, var(--cor-saldo) 0%, #5a7c7e 100%);
            color: white;
        }

        /* Badges de status */
        .badge-pago {
            background-color: var(--cor-entrada);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-pendente {
            background-color: var(--cor-destaque);
            color: var(--cor-texto-escuro);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Tabelas estilizadas */
        .table {
            border-radius: 10px;
            overflow: hidden;
            background: white;
        }

        .table thead th {
            background-color: var(--cor-texto-escuro);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(227, 201, 36, 0.1);
        }

        .table tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid #e9ecef;
        }

        /* Seletor de mês/ano */
        .month-selector {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            border-left: 5px solid var(--cor-destaque);
        }

        .form-select, .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--cor-destaque);
            box-shadow: 0 0 0 0.2rem rgba(227, 201, 36, 0.25);
        }

        /* Alertas personalizados */
        .alert-success {
            background-color: rgba(229, 142, 22, 0.1);
            border-color: var(--cor-entrada);
            color: var(--cor-texto-escuro);
            border-radius: 10px;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: var(--cor-saida);
            color: var(--cor-texto-escuro);
            border-radius: 10px;
        }

        /* Responsive design melhorado */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 1.5rem;
            }
            
            .month-selector {
                text-align: center;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
            
            .btn {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Animações suaves */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Loading states */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Valores monetários */
        .valor-positivo {
            color: var(--cor-entrada);
            font-weight: 600;
        }

        .valor-negativo {
            color: var(--cor-saida);
            font-weight: 600;
        }

        .valor-neutro {
            color: var(--cor-saldo);
            font-weight: 600;
        }

        /* Cards do dashboard com ícones */
        .dashboard-card {
            text-align: center;
            padding: 2rem;
        }

        .dashboard-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .dashboard-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
        }

        .dashboard-card h5 {
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 1rem;
        }
    </style>

    {{-- CSS adicional específico da página --}}
    @stack('styles')
</head>
<body>
    {{-- Navbar principal --}}
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            {{-- Logo/Brand --}}
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-chart-line me-2"></i>
                Gestor Financeiro
            </a>

            {{-- Toggle para mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    style="border-color: rgba(255,255,255,0.3);">
                <span class="navbar-toggler-icon" style="background-image: url('data:image/svg+xml;charset=utf8,<svg viewBox=\"0 0 30 30\" xmlns=\"http://www.w3.org/2000/svg\"><path stroke=\"rgba(255,255,255,0.8)\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-miterlimit=\"10\" d=\"m 4 7 h 22 M 4 15 h 22 M 4 23 h 22\"/></svg>');"></span>
            </button>

            {{-- Menu de navegação --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transactions*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                            <i class="fas fa-list me-1"></i>Movimentações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.monthly') }}">
                            <i class="fas fa-chart-bar me-1"></i>Relatórios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('current-month') }}">
                            <i class="fas fa-calendar me-1"></i>Mês Atual
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Conteúdo principal --}}
    <main class="container mt-4 fade-in">
        {{-- Seletor de mês/ano (presente em todas as páginas) --}}
        <div class="month-selector">
            <form method="GET" action="{{ request()->route()->getName() === 'dashboard' ? route('dashboard') : route('transactions.index') }}">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar me-2" style="color: var(--cor-destaque);"></i>
                            Período de Análise
                        </h5>
                        <small class="text-muted">Selecione o mês e ano para visualizar</small>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <select class="form-select" name="month" onchange="this.form.submit()">
                                    <option value="01" {{ request('month', date('m')) == '01' ? 'selected' : '' }}>Janeiro</option>
                                    <option value="02" {{ request('month', date('m')) == '02' ? 'selected' : '' }}>Fevereiro</option>
                                    <option value="03" {{ request('month', date('m')) == '03' ? 'selected' : '' }}>Março</option>
                                    <option value="04" {{ request('month', date('m')) == '04' ? 'selected' : '' }}>Abril</option>
                                    <option value="05" {{ request('month', date('m')) == '05' ? 'selected' : '' }}>Maio</option>
                                    <option value="06" {{ request('month', date('m')) == '06' ? 'selected' : '' }}>Junho</option>
                                    <option value="07" {{ request('month', date('m')) == '07' ? 'selected' : '' }}>Julho</option>
                                    <option value="08" {{ request('month', date('m')) == '08' ? 'selected' : '' }}>Agosto</option>
                                    <option value="09" {{ request('month', date('m')) == '09' ? 'selected' : '' }}>Setembro</option>
                                    <option value="10" {{ request('month', date('m')) == '10' ? 'selected' : '' }}>Outubro</option>
                                    <option value="11" {{ request('month', date('m')) == '11' ? 'selected' : '' }}>Novembro</option>
                                    <option value="12" {{ request('month', date('m')) == '12' ? 'selected' : '' }}>Dezembro</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-select" name="year" onchange="this.form.submit()">
                                    <option value="2024" {{ request('year', date('Y')) == '2024' ? 'selected' : '' }}>2024</option>
                                    <option value="2025" {{ request('year', date('Y')) == '2025' ? 'selected' : '' }}>2025</option>
                                    <option value="2026" {{ request('year', date('Y')) == '2026' ? 'selected' : '' }}>2026</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Mensagens de alerta --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Atenção!</strong> Corrija os seguintes erros:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Conteúdo específico da página --}}
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-5 py-4 bg-light" style="background-color: #23272b !important; color: #f1f1f1 !important;">
        <div class="container text-center">
            <small class="text-muted" style="color: #f1f1f1 !important;">
                &copy; {{ date('Y') }} Gestor Financeiro - Sistema de Controle Pessoal
                <br>
                <i class="fas fa-code me-1"></i>Desenvolvido com Laravel & Bootstrap
            </small>
        </div>
    </footer>
    <script>
        // Força dark mode sempre
        document.body.classList.add('dark-mode');
        document.documentElement.classList.add('dark-mode');
    </script>

    {{-- Scripts do Bootstrap --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    {{-- jQuery para funcionalidades adicionais --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    {{-- Script comum para todas as páginas --}}
    <script>
        // Configuração global do CSRF token para AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Função para formatar valores monetários
        function formatMoney(value) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value);
        }

        // Confirmação para exclusões
        function confirmDelete(element, message = 'Tem certeza que deseja excluir este item?') {
            if (confirm(message)) {
                element.closest('form').submit();
            }
        }

        // Auto-hide dos alertas após 5 segundos
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Loading state para formulários
        $('form').on('submit', function() {
            $(this).addClass('loading');
            $(this).find('button[type="submit"]').prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin me-2"></i>Processando...'
            );
        });
    </script>

    {{-- Scripts específicos da página --}}
    @stack('scripts')
</body>
</html>