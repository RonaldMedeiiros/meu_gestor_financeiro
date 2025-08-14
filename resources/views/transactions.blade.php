{{-- resources/views/transactions.blade.php --}}

@extends('layouts.app')

@section('title', 'Movimentações - Gestor Financeiro')

{{-- CSS específico para a página de transações --}}
@push('styles')
<style>
    /* Estilo para os formulários de entrada e saída */
    .form-container {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .form-container:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    /* Animação para os formulários */
    .form-slide-in {
        animation: slideInLeft 0.6s ease-out;
    }

    .form-slide-in:nth-child(even) {
        animation: slideInRight 0.6s ease-out;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Estilo especial para inputs com foco */
    .form-control:focus, .form-select:focus {
        border-color: var(--cor-destaque);
        box-shadow: 0 0 0 0.2rem rgba(227, 201, 36, 0.25);
    }

    /* Tabelas melhoradas */
    .transaction-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .table tbody tr:hover {
        background-color: rgba(227, 201, 36, 0.1);
        transform: scale(1.002);
        transition: all 0.2s ease;
    }

    /* Botões de ação nas tabelas */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-action {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    /* Cards de totais */
    .total-card {
        background: linear-gradient(135deg, white 0%, #f8f9fa 100%);
        border-left: 5px solid;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .total-entradas {
        border-left-color: var(--cor-entrada);
    }

    .total-saidas {
        border-left-color: var(--cor-saida);
    }

    .total-saldo {
        border-left-color: var(--cor-saldo);
    }
</style>
@endpush

@section('content')

{{-- Resumo dos Totais --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="total-card total-entradas">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Entradas</h6>
                    <h4 class="valor-positivo mb-0">R$ {{ number_format($totalEntries, 2, ',', '.') }}</h4>
                </div>
                <i class="fas fa-arrow-up fa-2x" style="color: var(--cor-entrada); opacity: 0.7;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="total-card total-saidas">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Saídas</h6>
                    <h4 class="valor-negativo mb-0">R$ {{ number_format($totalExpenses, 2, ',', '.') }}</h4>
                </div>
                <i class="fas fa-arrow-down fa-2x" style="color: var(--cor-saida); opacity: 0.7;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="total-card total-saldo">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Saldo</h6>
                    <h4 class="valor-neutro mb-0 {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $balance >= 0 ? '+' : '' }}R$ {{ number_format($balance, 2, ',', '.') }}
                    </h4>
                </div>
                <i class="fas fa-balance-scale fa-2x" style="color: var(--cor-saldo); opacity: 0.7;"></i>
            </div>
        </div>
    </div>
</div>

{{-- Formulários para Adicionar Novas Transações --}}
<div class="row mb-5">
    {{-- Formulário de Nova Entrada --}}
    <div class="col-md-6 mb-4">
        <div class="form-container form-slide-in">
            <div class="d-flex align-items-center mb-3">
                <div class="p-3 rounded-circle me-3" style="background-color: var(--cor-entrada);">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Nova Entrada</h5>
                    <small class="text-muted">Receitas como Kikker, Dakila, etc.</small>
                </div>
            </div>

            <form action="{{ route('entries.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="month" value="{{ $currentMonth }}">
                <input type="hidden" name="year" value="{{ $currentYear }}">

                <div class="mb-3">
                    <label for="entrada_descricao" class="form-label">
                        <i class="fas fa-tag me-1"></i>Descrição
                    </label>
                    <input type="text" 
                           class="form-control @error('description') is-invalid @enderror" 
                           id="entrada_descricao" 
                           name="description" 
                           placeholder="Ex: Kikker, Dakila, Freelance..."
                           value="{{ old('description') }}"
                           required>
                    <div class="invalid-feedback">
                        Por favor, informe uma descrição válida.
                    </div>
                    @error('description')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="entrada_valor" class="form-label">
                        <i class="fas fa-dollar-sign me-1"></i>Valor
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" 
                               class="form-control @error('amount') is-invalid @enderror" 
                               id="entrada_valor" 
                               name="amount" 
                               step="0.01" 
                               min="0.01"
                               placeholder="0,00"
                               value="{{ old('amount') }}"
                               required>
                        <div class="invalid-feedback">
                            Por favor, informe um valor válido.
                        </div>
                    </div>
                    @error('amount')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-entrada w-100">
                    <i class="fas fa-save me-2"></i>
                    Adicionar Entrada
                </button>
            </form>
        </div>
    </div>

    {{-- Formulário de Nova Saída --}}
    <div class="col-md-6 mb-4">
        <div class="form-container form-slide-in">
            <div class="d-flex align-items-center mb-3">
                <div class="p-3 rounded-circle me-3" style="background-color: var(--cor-saida);">
                    <i class="fas fa-minus text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Nova Saída</h5>
                    <small class="text-muted">Despesas como Aluguel, Cartões, etc.</small>
                </div>
            </div>

            <form action="{{ route('expenses.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="month" value="{{ $currentMonth }}">
                <input type="hidden" name="year" value="{{ $currentYear }}">

                <div class="mb-3">
                    <label for="saida_descricao" class="form-label">
                        <i class="fas fa-tag me-1"></i>Descrição
                    </label>
                    <input type="text" 
                           class="form-control @error('description') is-invalid @enderror" 
                           id="saida_descricao" 
                           name="description" 
                           placeholder="Ex: Aluguel, Cartão Neon, VIP..."
                           value="{{ old('description') }}"
                           required>
                    <div class="invalid-feedback">
                        Por favor, informe uma descrição válida.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="saida_valor" class="form-label">
                        <i class="fas fa-dollar-sign me-1"></i>Valor
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" 
                               class="form-control @error('amount') is-invalid @enderror" 
                               id="saida_valor" 
                               name="amount" 
                               step="0.01" 
                               min="0.01"
                               placeholder="0,00"
                               value="{{ old('amount') }}"
                               required>
                        <div class="invalid-feedback">
                            Por favor, informe um valor válido.
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="saida_status" class="form-label">
                        <i class="fas fa-info-circle me-1"></i>Status
                    </label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="saida_status" 
                            name="status" 
                            required>
                        <option value="">Selecione o status</option>
                        <option value="PENDENTE" {{ old('status') == 'PENDENTE' ? 'selected' : '' }}>
                            💰 Pendente
                        </option>
                        <option value="PAGO" {{ old('status') == 'PAGO' ? 'selected' : '' }}>
                            ✅ Pago
                        </option>
                    </select>
                    <div class="invalid-feedback">
                        Por favor, selecione o status.
                    </div>
                </div>

                <button type="submit" class="btn btn-saida w-100">
                    <i class="fas fa-save me-2"></i>
                    Adicionar Saída
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Listas de Transações --}}
<div class="row">
    {{-- Lista de Entradas --}}
    <div class="col-md-6 mb-4">
        <div class="transaction-table">
            <div class="card-header card-header-entrada">
                <h5 class="mb-0">
                    <i class="fas fa-arrow-up me-2"></i>
                    Entradas do Mês
                    <span class="badge bg-light text-dark ms-2">{{ $entries->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($entries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: var(--cor-entrada); color: white;">
                                <tr>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entries as $entry)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-coins text-warning me-2"></i>
                                            <div>
                                                <strong>{{ $entry->description }}</strong>
                                                <small class="d-block text-muted">
                                                    {{ $entry->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="valor-positivo">
                                            R$ {{ number_format($entry->amount, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('transactions.destroy', $entry) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger btn-action" 
                                                        onclick="confirmDelete(this, 'Tem certeza que deseja excluir a entrada {{ $entry->description }}?')"
                                                        title="Excluir entrada">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Nenhuma entrada registrada</h6>
                        <p class="text-muted small">Adicione suas receitas usando o formulário ao lado.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Lista de Saídas --}}
    <div class="col-md-6 mb-4">
        <div class="transaction-table">
            <div class="card-header card-header-saida">
                <h5 class="mb-0">
                    <i class="fas fa-arrow-down me-2"></i>
                    Saídas do Mês
                    <span class="badge bg-light text-dark ms-2">{{ $expenses->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($expenses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: var(--cor-saida); color: white;">
                                <tr>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                <tr class="{{ $expense->status === 'PENDENTE' ? 'table-warning' : '' }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-credit-card text-primary me-2"></i>
                                            <div>
                                                <strong>{{ $expense->description }}</strong>
                                                <small class="d-block text-muted">
                                                    {{ $expense->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="valor-negativo">
                                            R$ {{ number_format($expense->amount, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($expense->status === 'PAGO')
                                            <span class="badge badge-pago">
                                                <i class="fas fa-check me-1"></i>PAGO
                                            </span>
                                        @else
                                            <span class="badge badge-pendente">
                                                <i class="fas fa-clock me-1"></i>PENDENTE
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('transactions.toggle-status', $expense) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-warning btn-action" 
                                                        title="Alternar status ({{ $expense->status === 'PAGO' ? 'Marcar como Pendente' : 'Marcar como Pago' }})">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('transactions.destroy', $expense) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger btn-action" 
                                                        onclick="confirmDelete(this, 'Tem certeza que deseja excluir a saída {{ $expense->description }}?')"
                                                        title="Excluir saída">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Nenhuma saída registrada</h6>
                        <p class="text-muted small">Adicione suas despesas usando o formulário ao lado.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Ações Rápidas --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-destaque">
                <h6 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Ações Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-saldo w-100" onclick="location.href='{{ route('dashboard') }}'">
                            <i class="fas fa-chart-line me-2"></i>
                            Ver Dashboard
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-outline-secondary w-100" onclick="marcarTodasPagas()">
                            <i class="fas fa-check-double me-2"></i>
                            Marcar Todas Pagas
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-outline-secondary w-100" onclick="exportarDados()">
                            <i class="fas fa-download me-2"></i>
                            Exportar Dados
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-outline-secondary w-100" onclick="location.href='{{ route('reports.monthly', ['month' => $currentMonth, 'year' => $currentYear]) }}'">
                            <i class="fas fa-file-alt me-2"></i>
                            Relatório Mensal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- Scripts específicos da página de transações --}}
@push('scripts')
<script>
    // Validação em tempo real dos formulários
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Auto-formato para campos de valor
    $('input[type="number"]').on('input', function() {
        var value = $(this).val();
        if (value && !isNaN(value)) {
            $(this).val(parseFloat(value).toFixed(2));
        }
    });

    // Função para marcar todas as saídas como pagas
    function marcarTodasPagas() {
        if (confirm('Tem certeza que deseja marcar todas as saídas pendentes como pagas?')) {
            // Aqui você pode implementar uma rota específica para esta ação
            $('.badge-pendente').closest('tr').find('form[action*="toggle-status"] button').click();
        }
    }

    // Função para exportar dados (placeholder)
    function exportarDados() {
        alert('Funcionalidade de exportação será implementada em breve!');
        // Aqui você pode implementar a exportação para Excel/PDF
    }

    // Confirmação melhorada para exclusões
    window.confirmDelete = function(element, message) {
        if (confirm(message || 'Tem certeza que deseja excluir este item?')) {
            element.closest('form').submit();
        }
    };

    // Efeito de foco nos formulários
    $('.form-control, .form-select').on('focus', function() {
        $(this).closest('.form-container').addClass('shadow-lg');
    }).on('blur', function() {
        $(this).closest('.form-container').removeClass('shadow-lg');
    });

    // Tooltip para botões de ação
    $('[title]').tooltip();

    // Destacar linhas de transações pendentes
    $('.badge-pendente').closest('tr').addClass('border-warning');

    // Contador de caracteres para descrição (opcional)
    $('input[name="description"]').on('input', function() {
        var maxLength = 255;
        var currentLength = $(this).val().length;
        var remaining = maxLength - currentLength;
        
        // Você pode adicionar um contador visual se quiser
        if (remaining < 50) {
            $(this).addClass('border-warning');
        } else {
            $(this).removeClass('border-warning');
        }
    });

    // Auto-save para rascunhos (funcionalidade futura)
    let autoSaveTimer;
    $('form input').on('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            // Implementar auto-save se necessário
            console.log('Auto-save triggered');
        }, 3000);
    });

    // Atalhos de teclado
    $(document).on('keydown', function(e) {
        // Ctrl+E para focar no formulário de entrada
        if (e.ctrlKey && e.key === 'e') {
            e.preventDefault();
            $('#entrada_descricao').focus();
        }
        // Ctrl+S para focar no formulário de saída
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            $('#saida_descricao').focus();
        }
    });
</script>
@endpush