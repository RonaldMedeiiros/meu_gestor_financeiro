# 💰 Gestor Financeiro Laravel

Uma aplicação web moderna para controle financeiro pessoal, desenvolvida em Laravel com interface responsiva e banco SQLite local. Este projeto nasceu da necessidade de digitalizar e modernizar o controle financeiro tradicionalmente feito em planilhas Excel, oferecendo uma experiência mais intuitiva e visualmente atrativa.

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3.x-003B57?style=for-the-badge&logo=sqlite&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

## 🎯 Sobre o Projeto

Este sistema foi projetado para substituir planilhas Excel no controle financeiro pessoal, mantendo a simplicidade e familiaridade do método tradicional, mas adicionando recursos modernos como interface responsiva, validações automáticas, navegação intuitiva por períodos e visualizações gráficas dos dados financeiros.

A filosofia por trás do projeto é simples: **manter a essência do controle financeiro em planilhas, mas com a praticidade e segurança de uma aplicação web moderna**. Isso significa que você encontrará os mesmos conceitos familiares (entradas, saídas, status de pagamento, organização mensal), mas apresentados de forma mais elegante e funcional.

## ✨ Funcionalidades Principais

### Dashboard Interativo
O coração da aplicação é um dashboard que oferece uma visão panorâmica das suas finanças mensais. Aqui você encontra cards visuais mostrando total de entradas, saídas e saldo atual, além de estatísticas detalhadas como percentual de contas quitadas e lista das últimas movimentações. O dashboard é automaticamente atualizado conforme você adiciona novas transações.

### Gestão de Transações
O sistema permite o cadastro completo de movimentações financeiras divididas em duas categorias principais: entradas (receitas como salários, freelances, vendas) e saídas (despesas como aluguel, cartões, compras). Cada transação pode ter seu status controlado entre "PAGO" e "PENDENTE", facilitando o acompanhamento de contas a pagar.

### Navegação Temporal
Uma funcionalidade essencial é a capacidade de navegar entre diferentes meses e anos, permitindo tanto o acompanhamento histórico quanto o planejamento futuro. O sistema organiza automaticamente todas as transações por período, mantendo um histórico completo acessível.

### Interface Responsiva
A aplicação funciona perfeitamente em dispositivos desktop, tablets e smartphones, adaptando-se automaticamente ao tamanho da tela. Isso significa que você pode controlar suas finanças em qualquer lugar, a qualquer momento.

## 🚀 Tecnologias Utilizadas

### Backend - Laravel Framework
O Laravel foi escolhido como framework principal por sua robustez, segurança e facilidade de desenvolvimento. Ele fornece uma base sólida com recursos como ORM Eloquent para manipulação de dados, sistema de rotas RESTful, validações automáticas e proteção contra ataques comuns como CSRF.

### Banco de Dados - SQLite
Para máxima portabilidade e simplicidade, optamos pelo SQLite como banco de dados. Isso significa que todos os seus dados ficam armazenados em um único arquivo local, sem necessidade de configurar servidores de banco de dados externos. É perfeito para uso pessoal e garante total privacidade dos dados.

### Frontend - Bootstrap & CSS Customizado
A interface utiliza Bootstrap 5.3 como base, garantindo responsividade e componentes modernos. Sobre esta base, aplicamos uma camada de CSS personalizado que implementa uma paleta de cores específica e animações suaves, criando uma experiência visual única e profissional.

### Recursos Adicionais
O projeto incorpora Font Awesome para ícones, Google Fonts para tipografia moderna, e JavaScript vanilla para interatividade, mantendo a performance alta sem dependências desnecessárias.

## 🎨 Design e Experiência do Usuário

### Paleta de Cores Estratégica
A paleta de cores foi cuidadosamente escolhida para criar associações visuais intuitivas: laranja para entradas (transmitindo prosperidade), amarelo para destaques (chamando atenção), verde-azulado para saldo (neutralidade e confiança), e tons escuros para textos importantes (legibilidade e seriedade).

### Navegação Intuitiva
A navegação foi projetada para ser autoexplicativa, com ícones claros, textos descritivos e fluxos lógicos. Um usuário que nunca viu a aplicação consegue rapidamente entender como adicionar transações, navegar entre meses e visualizar relatórios.

### Feedback Visual
Todas as ações importantes fornecem feedback visual imediato através de notificações coloridas, animações suaves e mudanças de estado dos elementos. Isso cria uma sensação de responsividade e confiança no sistema.

## 📋 Pré-requisitos

Para executar esta aplicação em seu ambiente, você precisará ter instalado:

**PHP versão 8.1 ou superior** - O Laravel 10 requer esta versão mínima do PHP para funcionar corretamente. O PHP precisa ter as extensões padrão habilitadas, incluindo SQLite, OpenSSL, PDO, Mbstring, Tokenizer, XML e Ctype.

**Composer** - O gerenciador de dependências do PHP, necessário para instalar o Laravel e suas bibliotecas. Pode ser baixado gratuitamente do site oficial do Composer.

**Servidor Web** (opcional) - Para desenvolvimento, o comando `php artisan serve` do Laravel é suficiente. Para produção, você pode usar Apache, Nginx ou qualquer servidor web compatível com PHP.

## 🛠️ Instalação Completa

### Passo 1: Configuração Inicial
Comece criando um novo projeto Laravel através do Composer. Este processo baixa o framework e todas as dependências necessárias, criando a estrutura básica do projeto.

```bash
composer create-project laravel/laravel gestor-financeiro
cd gestor-financeiro
```

### Passo 2: Configuração do Banco de Dados
Configure o SQLite como banco de dados criando o arquivo necessário e ajustando as variáveis de ambiente.

```bash
# Criar arquivo do banco SQLite
touch database/database.sqlite

# Editar .env para configurar SQLite
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### Passo 3: Implementação dos Componentes
Agora você precisa implementar os componentes específicos da aplicação financeira. Isto inclui:

**Migration para a tabela de transações** - Define a estrutura do banco de dados com campos para descrição, valor, tipo (entrada/saída), status (pago/pendente), mês e ano.

**Model Transaction** - Classe que representa as transações no código, incluindo relacionamentos, validações e métodos auxiliares para cálculos financeiros.

**Controller TransactionController** - Controlador que gerencia todas as operações CRUD (criar, ler, atualizar, deletar) das transações, além de gerar dados para dashboard e relatórios.

**Views Blade** - Templates para as páginas web, incluindo layout principal, dashboard e página de gerenciamento de transações.

**Rotas Web** - Definições de URLs que conectam as requisições HTTP aos métodos do controlador.

**Seeders** - Scripts para popular o banco com dados iniciais baseados em planilhas existentes.

### Passo 4: Execução e Primeira Utilização
Finalize a instalação executando as migrações e populando o banco com dados iniciais.

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Após estes comandos, a aplicação estará disponível em `http://localhost:8000` com dados de exemplo já carregados.

## 📊 Estrutura de Dados

### Tabela de Transações
A tabela principal armazena todas as movimentações financeiras com a seguinte estrutura:

**id** - Identificador único da transação  
**description** - Descrição da movimentação (ex: "Aluguel", "Freelance Web")  
**amount** - Valor monetário com precisão de duas casas decimais  
**type** - Tipo da movimentação ("ENTRADA" ou "SAIDA")  
**status** - Status do pagamento ("PAGO" ou "PENDENTE")  
**month** - Mês da movimentação (formato "01" a "12")  
**year** - Ano da movimentação (formato "YYYY")  
**created_at** e **updated_at** - Timestamps de criação e atualização

Esta estrutura permite consultas eficientes por período, tipo de transação e status, além de manter um histórico completo de quando cada registro foi criado ou modificado.

## 🎯 Como Usar

### Navegação Básica
Ao acessar a aplicação, você chegará ao dashboard principal. No topo de todas as páginas, encontrará um seletor de mês e ano que permite navegar entre diferentes períodos. Esta navegação é o ponto central da aplicação, pois todos os dados são organizados temporalmente.

### Adicionando Transações
Na página "Movimentações", você encontrará dois formulários lado a lado: um para entradas (receitas) e outro para saídas (despesas). Para entradas, você precisa apenas informar descrição e valor, pois são automaticamente marcadas como "PAGO". Para saídas, você também escolhe o status inicial entre "PAGO" ou "PENDENTE".

### Gerenciando Status
As saídas podem ter seu status alternado entre "PAGO" e "PENDENTE" a qualquer momento através do botão de alternância nas listas de transações. Isso é útil para acompanhar quais contas ainda precisam ser pagas no mês.

### Visualizando Relatórios
O dashboard oferece uma visão consolidada com totais, percentuais e listas das movimentações mais recentes. Cards coloridos facilitam a identificação rápida de entradas (laranja), saídas (vermelho) e saldo (verde-azulado).

## 🔧 Comandos Úteis para Desenvolvimento

Durante o desenvolvimento ou manutenção da aplicação, alguns comandos Laravel são particularmente úteis:

```bash
# Limpar caches durante desenvolvimento
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recriar banco do zero (ATENÇÃO: apaga todos os dados)
php artisan migrate:fresh --seed

# Visualizar todas as rotas disponíveis
php artisan route:list

# Executar apenas seeders específicos
php artisan db:seed --class=TransactionSeeder

# Abrir terminal interativo para testes
php artisan tinker
```

## 📁 Estrutura do Projeto

### Diretórios Principais
**app/Models/** - Contém o model Transaction com toda lógica de negócio  
**app/Http/Controllers/** - Controladores que gerenciam requisições HTTP  
**database/migrations/** - Scripts de criação e modificação do banco  
**database/seeders/** - Scripts para popular banco com dados iniciais  
**resources/views/** - Templates Blade para as páginas web  
**routes/web.php** - Definições de rotas da aplicação  
**public/** - Arquivos públicos acessíveis via web  

### Arquivos de Configuração
**.env** - Variáveis de ambiente e configurações locais  
**config/database.php** - Configurações de conexão com banco  
**composer.json** - Dependências PHP do projeto  

## 🛡️ Segurança e Boas Práticas

### Proteção CSRF
Todas as operações de modificação de dados utilizam tokens CSRF do Laravel, protegendo contra ataques de requisição forjada entre sites.

### Validação de Dados
Tanto no frontend (HTML5) quanto no backend (Laravel), os dados são validados antes de serem processados, garantindo integridade e consistência.

### Sanitização de Entrada
Todas as entradas do usuário passam por processos de sanitização automática do Laravel, prevenindo ataques de injeção de código.

### Banco Local
O uso do SQLite mantém todos os dados localmente, eliminando riscos de exposição em servidores externos e garantindo total privacidade.

## 🔄 Backup e Recuperação

### Estratégia de Backup
Como todos os dados ficam no arquivo `database/database.sqlite`, o backup é simples: basta copiar este arquivo para um local seguro regularmente.

```bash
# Criar backup com timestamp
cp database/database.sqlite backups/backup_$(date +%Y%m%d_%H%M%S).sqlite

# Restaurar backup
cp backups/backup_20250814_143022.sqlite database/database.sqlite
```

### Exportação de Dados
O SQLite permite exportação fácil para diversos formatos através de ferramentas como DB Browser for SQLite ou comandos SQL diretos.

## 📈 Expansões Futuras

### Funcionalidades Planejadas
O sistema foi arquitetado para permitir expansões futuras sem grandes modificações na base existente. Algumas melhorias planejadas incluem:

**Sistema de Categorias** - Organização mais detalhada de receitas e despesas por categorias customizáveis, permitindo análises mais granulares dos hábitos financeiros.

**Gráficos e Relatórios Avançados** - Implementação de charts interativos mostrando evolução temporal, distribuição por categorias e comparações entre períodos.

**Notificações e Lembretes** - Sistema para lembrar de contas a vencer, metas financeiras e análises periódicas.

**Exportação Avançada** - Geração de relatórios em PDF, Excel e outros formatos para compartilhamento ou arquivo.

**Aplicativo Mobile (PWA)** - Transformação em Progressive Web App para instalação em dispositivos móveis com funcionalidade offline.

### Integrações Possíveis
**APIs Bancárias** - Importação automática de extratos bancários via Open Banking  
**Sincronização em Nuvem** - Backup automático em serviços como Google Drive ou Dropbox  
**Calculadora de Impostos** - Módulo para cálculo de impostos baseado nas movimentações  

## 🤝 Contribuição e Suporte

### Estrutura para Contribuições
O projeto segue padrões do Laravel e PSR-4, facilitando contribuições da comunidade. O código é bem documentado e organizado seguindo princípios SOLID.

### Relatório de Bugs
Para reportar problemas, inclua informações sobre versão do PHP, sistema operacional, passos para reproduzir o erro e logs relevantes da aplicação.

### Sugestões de Melhorias
Sugestões são bem-vindas, especialmente aquelas que mantêm a simplicidade e foco no controle financeiro pessoal sem complexidade desnecessária.

## 📄 Licença

Este projeto está sob licença MIT, permitindo uso, modificação e distribuição livre, tanto para projetos pessoais quanto comerciais.

## 🙏 Agradecimentos

Agradecimentos especiais à comunidade Laravel pela excelente documentação e frameworks, à equipe Bootstrap pela interface base responsiva, e a todos os desenvolvedores que contribuem para o ecossistema PHP/Laravel.

---

**Desenvolvido com ❤️ para simplificar o controle financeiro pessoal**

*Transformando planilhas em experiências web modernas e intuitivas*