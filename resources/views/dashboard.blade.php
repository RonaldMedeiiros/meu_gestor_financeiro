{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard - Gestor Financeiro')

{{-- CSS específico para o dashboard --}}
@push('styles')
<style>
    /* Animações específicas para os cards do dashboard */
    .dashboard-card {
        animation: slideInUp 0.6s ease-out;
    }
    
    .dashboard-card:nth-child(2) {
        animation-delay: 0.1s;
    }
    
    .dashboard-card:nth-child(3) {
        animation-delay: 0.2s;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estatísticas adicionais */
    .stats-box {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        border-left: 4px solid var(--cor-destaque);
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--cor-saldo);
    }

    /* Progress bars para visualizar percentuais */
    .progress-custom {
        height: 10px;
        border-radius: 50px;
        background-color: #e9ecef;
    }

    .progress-bar-entrada {
        background: linear-gradient(90deg, var(--cor-entrada) 0%, #f4a742 100%);
    }

    .progress-bar-saida {
        background: linear-gradient(90deg, var(--cor-saida) 0%, #e74c3c 100%);
    }
</style>
@endpush

@section('content')
<div class="row">
    {{-- Cards de Resumo Financeiro - Baseados na sua planilha --}}
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card resumo-entrada">
            <div class="card-body text-center">
                <i class="fas fa-arrow-up fa-3x mb-3" style="opacity: 0.9;"></i>
                <h5 class="card-title mb-2">Total de Entradas</h5>
                <h2 class="mb-0">{{ number_format($totalEntries, 2, ',', '.') }}</h2>
                <small class="d-block mt-2" style="opacity: 0.9;">
                    <i class="fas fa-coins me-1"></i>
                    {{ $stats['entries_count'] }} transação{{ $stats['entries_count'] != 1 ? 'ões' : '' }}
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card dashboard-card resumo-saida">
            <div class="card-body text-center">
                <i class="fas fa-arrow-down fa-3x mb-3" style="opacity: 0.9;"></i>
                <h5 class="card-title mb-2">Total de Saídas</h5>
                <h2 class="mb-0">{{ number_format($totalExpenses, 2, ',', '.') }}</h2>
                <small class="d-block mt-2" style="opacity: 0.9;">
                    <i class="fas fa-credit-card me-1"></i>
                    {{ $stats['expenses_count'] }} transação{{ $stats['expenses_count'] != 1 ? 'ões' : '' }}
                </small>
                <div class="mt-3">
                    <div class="progress progress-custom">
                        <div class="progress-bar progress-bar-saida" style="width: {{ $stats['paid_percentage'] }}%"></div>
                    </div>
                    <small class="text-light mt-1 d-block">{{ $stats['paid_percentage'] }}% pago</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card dashboard-card resumo-saldo">
            <div class="card-body text-center">
                <i class="fas fa-balance-scale fa-3x mb-3" style="opacity: 0.9;"></i>
                <h5 class="card-title mb-2">Saldo do Mês</h5>
                <h2 class="mb-0 {{ $balance >= 0 ? 'text-light' : 'text-warning' }}">
                    {{ $balance >= 0 ? '+' : '' }}{{ number_format($balance, 2, ',', '.') }}
                </h2>
                <small class="d-block mt-2" style="opacity: 0.9;">
                    @if($balance >= 0)
                        <i class="fas fa-thumbs-up me-1"></i>Situação positiva
                    @else
                        <i class="fas fa-exclamation-triangle me-1"></i>Atenção ao orçamento
                    @endif
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Estatísticas Detalhadas --}}
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stats-box">
            <div class="stats-number">{{ $stats['total_transactions'] }}</div>
            <div class="text-muted">Total de Movimentações</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-box">
            <div class="stats-number valor-positivo">{{ number_format($paidExpenses, 0, ',', '.') }}</div>
            <div class="text-muted">Despesas Pagas</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-box">
            <div class="stats-number valor-negativo">{{ number_format($pendingExpenses, 0, ',', '.') }}</div>
            <div class="text-muted">Despesas Pendentes</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-box">
            <div class="stats-number valor-neutro">{{ $stats['paid_percentage'] }}%</div>
            <div class="text-muted">Contas Quitadas</div>
        </div>
    </div>
</div>

{{-- Controle Rápido de Pendências --}}
@if($pendingExpenses > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="alert" style="background: linear-gradient(135deg, var(--cor-destaque) 0%, #f1d424 100%); border: none; color: var(--cor-texto-escuro);">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                <div>
                    <h5 class="mb-1">Atenção: Você tem R$ {{ number_format($pendingExpenses, 2, ',', '.') }} em contas pendentes</h5>
                    <p class="mb-0">Lembre-se de quitar suas pendências para manter o controle financeiro em dia.</p>
                </div>
                <a href="{{ route('transactions.index') }}" class="btn btn-saldo ms-auto">
                    <i class="fas fa-eye me-1"></i>Ver Pendências
                </a>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Últimas Movimentações --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-destaque">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Últimas Movimentações
                    </h5>
                    <span class="badge" style="background-color: var(--cor-texto-escuro); color: white;">
                        {{ Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ $transaction->description }}</strong>
                                    </td>
                                    <td>
                                        @if($transaction->type === 'ENTRADA')
                                            <span class="badge" style="background-color: var(--cor-entrada); color: white;">
                                                <i class="fas fa-arrow-up me-1"></i>ENTRADA
                                            </span>
                                        @else
                                            <span class="badge" style="background-color: var(--cor-saida); color: white;">
                                                <i class="fas fa-arrow-down me-1"></i>SAÍDA
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="{{ $transaction->type === 'ENTRADA' ? 'valor-positivo' : 'valor-negativo' }}">
                                            R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($transaction->status === 'PAGO')
                                            <span class="badge badge-pago">
                                                <i class="fas fa-check me-1"></i>PAGO
                                            </span>
                                        @else
                                            <span class="badge badge-pendente">
                                                <i class="fas fa-clock me-1"></i>PENDENTE
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($transaction->type === 'SAIDA')
                                            <form action="{{ route('transactions.toggle-status', $transaction) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning me-1" 
                                                        title="Alternar Status">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete(this, 'Tem certeza que deseja excluir {{ $transaction->description }}?')"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('transactions.index', ['month' => $currentMonth, 'year' => $currentYear]) }}" 
                           class="btn btn-saldo">
                            <i class="fas fa-list me-2"></i>
                            Ver Todas as Movimentações
                        </a>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhuma movimentação encontrada</h5>
                        <p class="text-muted">Comece adicionando suas entradas e saídas do mês.</p>
                        <a href="{{ route('transactions.index') }}" class="btn btn-entrada">
                            <i class="fas fa-plus me-2"></i>
                            Adicionar Primeira Movimentação
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Resumo de Categorias (futuro enhancement) --}}
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-entrada">
                <h6 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Maiores Entradas
                </h6>
            </div>
            <div class="card-body">
                @php
                    $topEntries = App\Models\Transaction::byMonth($currentMonth, $currentYear)
                                                      ->entries()
                                                      ->orderBy('amount', 'desc')
                                                      ->limit(3)
                                                      ->get();
                @endphp
                
                @if($topEntries->count() > 0)
                    @foreach($topEntries as $entry)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $entry->description }}</span>
                            <strong class="valor-positivo">R$ {{ number_format($entry->amount, 2, ',', '.') }}</strong>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">Nenhuma entrada registrada.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-saida">
                <h6 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Maiores Gastos
                </h6>
            </div>
            <div class="card-body">
                @php
                    $topExpenses = App\Models\Transaction::byMonth($currentMonth, $currentYear)
                                                       ->expenses()
                                                       ->orderBy('amount', 'desc')
                                                       ->limit(3)
                                                       ->get();
                @endphp
                
                @if($topExpenses->count() > 0)
                    @foreach($topExpenses as $expense)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span>{{ $expense->description }}</span>
                                <small class="d-block text-muted">
                                    @if($expense->status === 'PAGO')
                                        <i class="fas fa-check text-success"></i> Pago
                                    @else
                                        <i class="fas fa-clock text-warning"></i> Pendente
                                    @endif
                                </small>
                            </div>
                            <strong class="valor-negativo">R$ {{ number_format($expense->amount, 2, ',', '.') }}</strong>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">Nenhuma saída registrada.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Scripts específicos do dashboard --}}
@push('scripts')
<script>
    // Atualização automática dos dados a cada 30 segundos (opcional)
    setInterval(function() {
        // Função para atualizar dados via AJAX sem recarregar a página
        updateDashboardData();
    }, 30000); // 30 segundos

    function updateDashboardData() {
        const month = $('select[name="month"]').val();
        const year = $('select[name="year"]').val();
        
        $.get('{{ route("api.dashboard-data") }}', { month: month, year: year })
            .done(function(data) {
                // Atualizar valores nos cards sem recarregar a página
                // Esta funcionalidade pode ser expandida conforme necessário
                console.log('Dados atualizados:', data);
            })
            .fail(function() {
                console.log('Erro ao atualizar dados do dashboard');
            });
    }

    // Efeito de hover nos cards de estatísticas
    $('.stats-box').hover(
        function() {
            $(this).css('transform', 'scale(1.05)');
            $(this).css('transition', 'transform 0.3s ease');
        },
        function() {
            $(this).css('transform', 'scale(1)');
        }
    );

    // Função para destacar valores conforme o saldo
    function highlightBalance() {
        const balance = {{ $balance }};
        if (balance < 0) {
            $('.resumo-saldo').addClass('border-warning');
        } else if (balance > 1000) {
            $('.resumo-saldo').addClass('border-success');
        }
    }

    // Executar quando a página carregar
    $(document).ready(function() {
        highlightBalance();
        
        // Tooltip para botões de ação
        $('[title]').tooltip();
        
        // Confirmação amigável para exclusões
        window.confirmDelete = function(element, message) {
            if (confirm(message || 'Tem certeza que deseja excluir este item?')) {
                element.closest('form').submit();
            }
        };
    });
</script>
@endpush