# Orçamentos Alto Padrão — MVP

Sistema web (Laravel + MySQL) para **orçamento de obras residenciais de altíssimo
padrão**, com extração assistida por IA (Anthropic/Claude), revisão humana
obrigatória, rastreabilidade de preços, malha fina orçamentária, geração de PDFs
(comercial e técnico interno), exportação CSV e webhook Make/Zapier.
Hospedável em **HostGator/cPanel** (hospedagem compartilhada, sem Node/Docker/root).

> **Aviso:** este sistema **não substitui** engenheiro civil, engenheiro
> orçamentista ou validação humana. Ele **assiste** o processo. Nenhuma
> especificação e nenhum preço são inventados: quando não há dado, registra-se
> **"não identificado"**.

---

## 1. Visão geral

Fluxo principal:

1. Cadastra **cliente**, **arquiteto** e **obra**.
2. Anexa o **memorial descritivo** (PDF **ou** texto colado manualmente — fallback obrigatório).
3. **Processa com a IA** (Anthropic) → gera **itens extraídos** (sempre `pending`).
4. **Revisão humana** dos itens (aprovar / rejeitar / revisar).
5. Cadastra **fornecedores** e **preços** (com rastreabilidade completa).
6. Roda a **malha fina orçamentária** → gera **alertas técnicos** por severidade.
7. Gera **PDF comercial** (cliente) e **PDF técnico interno** (engenharia).
8. **Exporta CSV** e dispara **webhook** para Make/Zapier.

---

## 2. Requisitos

- PHP **8.2+** (o projeto usa Laravel 13). Em planos com PHP 8.1, use Laravel 10 (ver "Compatibilidade").
- Composer 2.
- MySQL 5.7+/8 (produção). SQLite apenas para teste local.
- Extensões PHP: `pdo_mysql`/`pdo_sqlite`, `mbstring`, `openssl`, `tokenizer`,
  `ctype`, `json`, `bcmath`, `fileinfo`, `xml`, `dom`, `zip`, `gd`.
- **Sem Node, sem Vite, sem Docker, sem Redis obrigatório.** Bootstrap 5 via CDN.

---

## 3. Instalação local

```bash
# 1. Dependências
composer install

# 2. Ambiente
cp .env.example .env
php artisan key:generate

# 3a. Teste local rápido SEM MySQL (SQLite):
#     edite o .env -> DB_CONNECTION=sqlite  (comente as linhas DB_* de MySQL)
touch database/database.sqlite

# 3b. OU use MySQL: crie o banco e ajuste DB_* no .env (ver seção 5)

# 4. Migrations + seeders
php artisan migrate --seed

# 5. Servidor local
php artisan serve
# Acesse http://127.0.0.1:8000/login
```

---

## 4. Configuração `.env`

Principais variáveis (ver `.env.example`):

```env
APP_NAME=OrcamentosAltoPadrao
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=orcamentos_db
DB_USERNAME=orcamentos_user
DB_PASSWORD=

ANTHROPIC_API_KEY=            # deixe vazio para ver o fallback amigável
ANTHROPIC_MODEL=claude-3-5-sonnet-latest
ANTHROPIC_TIMEOUT=60

WEBHOOK_DEFAULT_URL=
PDF_BRAND_COLOR=#DD5600
```

> A chave da Anthropic **nunca** aparece em tela ou log. Se estiver vazia, o
> processamento retorna: *"API Anthropic não configurada. Verifique o arquivo .env."*

---

## 5. Criação do banco (MySQL)

```sql
CREATE DATABASE orcamentos_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'orcamentos_user'@'127.0.0.1' IDENTIFIED BY 'suasenha';
GRANT ALL PRIVILEGES ON orcamentos_db.* TO 'orcamentos_user'@'127.0.0.1';
FLUSH PRIVILEGES;
```

No HostGator, use **MySQL® Databases** no cPanel (ver `deploy/hostgator/`).

---

## 6. Migrations e seeders

```bash
php artisan migrate --seed          # cria tabelas e popula dados iniciais
php artisan migrate:fresh --seed    # recria do zero (apaga tudo)
```

Seeders:
- `AdminUserSeeder` — usuário admin.
- `BudgetHistorySeeder` — histórico orçamentário fictício (alto padrão) para a malha fina.
- `DemoSeeder` — cliente, arquiteto, fornecedores e preços de exemplo.

---

## 7. Login

Usuário padrão criado pelo seeder:

- **E-mail:** `admin@exemplo.com`
- **Senha:** `password`

> **Troque a senha imediatamente** após o primeiro acesso.

---

## 8. Uso básico

- **Obras**: hub central. Dentro de cada obra: memoriais, itens extraídos,
  malha fina, alertas, propostas, exportações e webhook.
- **Memoriais**: upload de PDF **ou** texto colado. O sistema tenta extrair o
  texto do PDF; se falhar (PDF digitalizado/protegido), o **texto manual** é o
  fallback funcional.
- **Itens extraídos**: nascem `pending`. Só `approved` entram sem alerta crítico
  no PDF comercial.
- **Preços**: exigem fornecedor, fonte, data, unidade, validade, responsável,
  tipo (referencial/cotado/histórico/estimado), impostos e frete.

---

## 9. Processamento com Anthropic

- Configure `ANTHROPIC_API_KEY` no `.env`.
- O `AnthropicExtractionService`: lê a chave e o prompt
  (`resources/prompts/system_orcamentista.txt`), divide o texto em **chunks**,
  envia à API, valida o **JSON**, consolida e salva os itens (com `raw_payload_json`).
- **Regras:** não inventa especificação; campos ausentes viram "não identificado";
  todo item nasce `pending`; a chave nunca vaza.

---

## 10. Geração de PDF

- **Comercial** (`ProposalPdfService`): capa, dados, premissas, escopo,
  composição de custo direto, indiretos, administração, BDI, itens sob cotação,
  riscos, cronograma macro, diferenciais e fechamento. **Bloqueia** (com aviso) se
  houver item **crítico/sob cotação pendente**; pode ser gerado com confirmação explícita.
- **Interno** (`InternalPdfService`): itens, status, itens sem evidência/sem preço/
  estimados, alertas da malha fina, lacunas e recomendações.
- PDFs salvos em `storage/app/proposals`. Download **por controller** (não depende de `storage:link`).
- Ambos encerram com: *"O rigor da engenharia para a arte da arquitetura"*.

---

## 11. Exportação CSV

- Tipos: `items`, `prices`, `alerts`, `proposal` (`/works/{work}/export/csv?type=...`).
- Salvos em `storage/app/exports`; download por controller (sem symlink).
- CSV com BOM UTF-8 (acentuação correta no Excel) e separador `;`.

---

## 12. Webhook (Make/Zapier)

- `POST /works/{work}/webhook` dispara o payload (obra, cliente, status,
  contagem de itens/alertas, valor estimado, link interno, data).
- **Falha com segurança**: qualquer erro é registrado em `webhook_logs` e
  **não derruba** o fluxo principal. URL configurável por `WEBHOOK_DEFAULT_URL`
  ou informada no formulário.

---

## 13. Deploy HostGator

Ver a pasta [`deploy/hostgator/`](deploy/hostgator/):
- `README_DEPLOY_HOSTGATOR.md` — passo a passo (Opção A: subdomínio → `/public`;
  Opção B: conteúdo do `/public` em `public_html/orcamentos`).
- `index.php.example`, `.htaccess.example`, `check_permissions.md`, `commands.md`.

**Somente a pasta `public/` fica exposta.** `.env`, `app/`, `vendor/`, etc. ficam fora do Document Root.

---

## 14. Testes

```bash
php artisan test
```

Cobrem: login, criação de obra, memorial manual (+fallback), mensagem amigável
sem API, registro do validador, normalização de unidade, chunking, malha fina e
geração de PDF interno.

---

## 15. Compatibilidade Laravel 10/11/13

Este repositório foi gerado com **Laravel 13** (PHP 8.2+). Se o seu HostGator só
oferecer **PHP 8.1**, recrie o projeto com **Laravel 10** e copie os diretórios
`app/`, `database/`, `resources/`, `routes/`, `config/anthropic.php` e o
`.env.example`. A lógica de domínio é portável (enums, models, services e views
não usam recursos exclusivos do Laravel 13).

---

## 16. Limitações do MVP

- A **extração automática de PDF** depende do ambiente (PDF digitalizado/protegido
  pode não render texto). O **fallback manual é obrigatório** e sempre funciona.
- **Scraping** de preços **não** faz parte do núcleo do MVP em HostGator.
- **Processamento pesado** (muitos memoriais/chunks) deve, no futuro, migrar para
  **VPS/API externa/fila dedicada**.
- A **proposta final exige validação humana**. O sistema sinaliza riscos; não decide.
- O sistema **não substitui responsabilidade técnica** (engenheiro civil/orçamentista).

---

## 17. Próximos passos

- Fluxo de troca de senha e gestão de usuários/papéis.
- Envio real de e-mails de cotação (fila + SMTP).
- Normalização automática de unidades aplicada na persistência dos itens.
- Base histórica real de preços por região e data-base.
- Fila dedicada para processamento de IA (queue worker) em VPS.
- Versionamento de propostas e assinatura eletrônica.

---

### Estrutura de domínio (resumo)

- **Enums:** Criticality, BudgetImpact, FinishStandard, PriceType, ValidationStatus, AlertSeverity.
- **Services:** AnthropicExtraction, MemorialTextExtractor, Chunking, ExtractionConsolidator,
  QuoteEmail, BudgetFineComb, ProposalPdf, InternalPdf, CsvExport, WebhookDispatch,
  UnitNormalizer, PriceTraceability.
- **Módulos:** Auth, Clientes, Arquitetos, Obras, Memoriais, Itens extraídos,
  Fornecedores, Preços, Cotações, Histórico, Alertas, Propostas, Webhook.
