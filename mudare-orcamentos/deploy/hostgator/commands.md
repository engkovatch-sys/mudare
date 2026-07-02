# Comandos úteis — Deploy e manutenção (HostGator/cPanel)

## Instalação inicial (produção)

```bash
cd /home/USUARIO_CPANEL/laravel-orcamentos

composer install --no-dev --optimize-autoloader
cp .env.example .env          # depois edite o .env com os dados reais
php artisan key:generate
php artisan migrate --seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
```

## Atualização (novas versões)

```bash
cd /home/USUARIO_CPANEL/laravel-orcamentos
git pull                       # se usar git
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Limpeza de cache (quando algo "não atualiza")

```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## Diagnóstico

```bash
php -v                         # confirmar PHP >= 8.2
php artisan about              # visão geral do ambiente
php artisan route:list         # conferir rotas
tail -n 100 storage/logs/laravel.log
```

## Banco de dados

```bash
# Recriar do zero (CUIDADO: apaga tudo) — apenas em ambiente de teste
php artisan migrate:fresh --seed --force

# Rodar apenas migrations pendentes (produção)
php artisan migrate --force
```

## Anthropic (IA)

- Configure `ANTHROPIC_API_KEY` no `.env`. Sem a chave, o processamento
  retorna a mensagem: "API Anthropic não configurada. Verifique o arquivo .env."
- A chave **nunca** aparece em tela ou log.
