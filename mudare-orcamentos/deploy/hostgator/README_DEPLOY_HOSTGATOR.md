# Deploy em HostGator / cPanel

Guia de publicação do sistema **Orçamentos Alto Padrão** (Laravel + MySQL) em
hospedagem compartilhada HostGator/cPanel, **sem acesso root, sem Docker, sem Node**.

> Substitua `USUARIO_CPANEL` pelo seu usuário real do cPanel e
> `dominio.com.br` pelo seu domínio.

---

## ⚠️ Segurança: o que pode ficar exposto

**APENAS** a pasta `public/` pode ser exposta à internet.

**NUNCA** exponha (mantenha fora do Document Root):
`.env`, `app/`, `bootstrap/`, `config/`, `database/`, `resources/`,
`routes/`, `storage/`, `vendor/`, `tests/`.

---

## Pré-requisitos no cPanel

1. **PHP 8.2 ou superior** (MultiPHP Manager). O projeto usa Laravel 13 (requer PHP >= 8.2).
   Se o seu plano só oferecer PHP 8.1, use Laravel 10 (veja a seção "Compatibilidade" no README).
2. Extensões PHP habilitadas: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`,
   `ctype`, `json`, `bcmath`, `fileinfo`, `xml`, `dom`, `zip`, `gd`.
3. Acesso a **Terminal** do cPanel (ou SSH) para rodar comandos artisan/composer.
   Se não houver terminal, veja "Sem terminal" mais abaixo.

---

## Opção A — Subdomínio apontando para `/public` (RECOMENDADO)

1. Crie a pasta do projeto:
   `/home/USUARIO_CPANEL/laravel-orcamentos`
2. Suba o projeto **inteiro** para essa pasta (via Git, File Manager ou FTP).
3. Crie o subdomínio: `orcamentos.dominio.com.br`
4. Ao criar o subdomínio, aponte o **Document Root** para:
   `/home/USUARIO_CPANEL/laravel-orcamentos/public`
5. Crie o **banco MySQL** no cPanel (MySQL® Databases): ex. `USUARIO_orcamentos_db`.
6. Crie um **usuário MySQL**: ex. `USUARIO_orc_user` com uma senha forte.
7. **Vincule** o usuário ao banco com **ALL PRIVILEGES**.
8. Configure o `.env` (copie de `.env.example`):
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://orcamentos.dominio.com.br

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=USUARIO_orcamentos_db
   DB_USERNAME=USUARIO_orc_user
   DB_PASSWORD=suasenhaforte

   ANTHROPIC_API_KEY=coloque_sua_chave_aqui
   ANTHROPIC_MODEL=claude-3-5-sonnet-latest
   ```
9. No Terminal do cPanel, dentro de `/home/USUARIO_CPANEL/laravel-orcamentos`:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --seed
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
10. Ajuste permissões:
    ```bash
    chmod -R 775 storage bootstrap/cache
    ```
11. Acesse `https://orcamentos.dominio.com.br/login` e entre com
    `admin@exemplo.com` / `password`. **Troque a senha imediatamente.**

---

## Opção B — Conteúdo de `/public` em `public_html/orcamentos`

Use quando o cPanel **não** permite apontar o Document Root para `/public`.

1. Projeto completo em: `/home/USUARIO_CPANEL/laravel-orcamentos`
2. Copie **o conteúdo** de `/home/USUARIO_CPANEL/laravel-orcamentos/public`
   para: `/home/USUARIO_CPANEL/public_html/orcamentos`
3. Edite `/home/USUARIO_CPANEL/public_html/orcamentos/index.php` para apontar
   para o projeto (use o arquivo `index.php.example` deste diretório como base):
   - `require __DIR__.'/home/USUARIO_CPANEL/laravel-orcamentos/vendor/autoload.php';`
   - app carregado de `/home/USUARIO_CPANEL/laravel-orcamentos/bootstrap/app.php`
4. Coloque o `.htaccess` correto em
   `/home/USUARIO_CPANEL/public_html/orcamentos/.htaccess`
   (use `.htaccess.example` deste diretório).
5. **NUNCA** copie o `.env` para `public_html`. Ele permanece só em
   `/home/USUARIO_CPANEL/laravel-orcamentos/.env`.
6. Rode os mesmos comandos artisan da Opção A (passo 9 e 10), dentro de
   `/home/USUARIO_CPANEL/laravel-orcamentos`.

---

## Sem terminal no cPanel?

- Rode `composer install` localmente e suba a pasta `vendor/` junto.
- Gere a `APP_KEY` localmente (`php artisan key:generate --show`) e cole no `.env`.
- Para migrations sem terminal: use um plano com terminal/SSH, ou rode as
  migrations via um script temporário protegido (e remova depois). O ideal é ter terminal.

---

## Atualizações futuras

```bash
cd /home/USUARIO_CPANEL/laravel-orcamentos
git pull            # se usar git
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## Checklist pós-deploy

- [ ] `/login` abre por HTTPS.
- [ ] Login com admin funciona e a senha foi trocada.
- [ ] `.env` NÃO acessível via navegador (`/. env` retorna 403/404).
- [ ] `storage/` e `bootstrap/cache` com permissão 775.
- [ ] PDF comercial e interno geram e baixam.
- [ ] CSV exporta e baixa.
- [ ] Webhook registra log mesmo com URL inválida (não derruba o sistema).
- [ ] Anthropic responde mensagem amigável se a chave não estiver configurada.
