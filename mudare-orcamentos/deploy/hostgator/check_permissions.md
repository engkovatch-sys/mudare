# Permissões no HostGator/cPanel

## Permissões recomendadas

| Caminho                    | Permissão | Observação                                  |
|----------------------------|-----------|---------------------------------------------|
| Diretórios em geral        | `755`     | Padrão para pastas                          |
| Arquivos em geral          | `644`     | Padrão para arquivos                        |
| `storage/`                 | `775`     | Recursivo — Laravel grava logs/cache/PDFs   |
| `bootstrap/cache/`         | `775`     | Recursivo — cache de configuração/rotas     |
| `.env`                     | `600`     | Somente o dono lê/escreve                   |
| `storage/app/proposals/`   | `775`     | PDFs de propostas                           |
| `storage/app/exports/`     | `775`     | Arquivos CSV                                |
| `storage/app/memorials/`   | `775`     | PDFs de memoriais enviados                  |

## Comandos

```bash
cd /home/USUARIO_CPANEL/laravel-orcamentos

# Pastas 755, arquivos 644
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Diretórios graváveis
chmod -R 775 storage bootstrap/cache

# Proteger o .env
chmod 600 .env

# Garantir as subpastas de storage usadas pelo sistema
mkdir -p storage/app/proposals storage/app/exports storage/app/memorials
chmod -R 775 storage/app
```

## Verificação

- O usuário do PHP (geralmente o mesmo do cPanel) deve ser dono das pastas.
  Se necessário: `chown -R USUARIO_CPANEL:USUARIO_CPANEL storage bootstrap/cache`
- Erro **500** logo após o deploy quase sempre é permissão de `storage/`
  ou `APP_KEY` ausente. Rode `php artisan key:generate` e ajuste as permissões.
- Verifique `storage/logs/laravel.log` para detalhes do erro.

## Importante

- **NÃO** use `777` em nenhuma pasta. `775` é suficiente e mais seguro.
- O download de PDFs e CSVs é feito **por controller** (`response()->download()`),
  portanto **NÃO** depende de `php artisan storage:link`.
