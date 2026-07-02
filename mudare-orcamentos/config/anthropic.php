<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Anthropic API
    |--------------------------------------------------------------------------
    | Configuração para integração com a API da Anthropic (Claude).
    | A chave NUNCA deve ser commitada. Use o arquivo .env.
    */

    'api_key' => env('ANTHROPIC_API_KEY', ''),

    'model' => env('ANTHROPIC_MODEL', 'claude-3-5-sonnet-latest'),

    'timeout' => (int) env('ANTHROPIC_TIMEOUT', 60),

    'base_url' => env('ANTHROPIC_BASE_URL', 'https://api.anthropic.com/v1/messages'),

    'version' => env('ANTHROPIC_VERSION', '2023-06-01'),

    'max_tokens' => (int) env('ANTHROPIC_MAX_TOKENS', 4096),

    // Tamanho máximo (em caracteres) de cada chunk enviado ao modelo.
    'chunk_size' => (int) env('ANTHROPIC_CHUNK_SIZE', 12000),

    // Sobreposição entre chunks para não perder contexto de fronteira.
    'chunk_overlap' => (int) env('ANTHROPIC_CHUNK_OVERLAP', 500),
];
