<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

/**
 * Extrai texto de PDFs de memorial descritivo.
 *
 * IMPORTANTE (regra do MVP): a extração automática PODE falhar dependendo
 * do PDF (imagem escaneada, fontes incorporadas, proteção). Neste caso o
 * fluxo NÃO deve quebrar — o campo manual_text é o fallback obrigatório.
 */
class MemorialTextExtractorService
{
    /**
     * Tenta extrair texto de um arquivo PDF.
     *
     * @return array{success: bool, text: ?string, error: ?string}
     */
    public function extractFromFile(string $absolutePath): array
    {
        if (! is_file($absolutePath)) {
            return ['success' => false, 'text' => null, 'error' => 'Arquivo não encontrado no servidor.'];
        }

        if (! class_exists(Parser::class)) {
            return [
                'success' => false,
                'text' => null,
                'error' => 'Biblioteca de leitura de PDF indisponível no ambiente. Use o texto manual como fallback.',
            ];
        }

        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($absolutePath);
            $text = trim($pdf->getText());

            if ($text === '') {
                return [
                    'success' => false,
                    'text' => null,
                    'error' => 'Não foi possível extrair texto (PDF pode ser digitalizado/imagem). Use o texto manual como fallback.',
                ];
            }

            return ['success' => true, 'text' => $this->cleanup($text), 'error' => null];
        } catch (\Throwable $e) {
            Log::warning('Falha na extração de PDF do memorial', ['message' => $e->getMessage()]);

            return [
                'success' => false,
                'text' => null,
                'error' => 'Falha ao ler o PDF neste ambiente. Use o texto manual como fallback.',
            ];
        }
    }

    protected function cleanup(string $text): string
    {
        // Normaliza quebras de linha e remove excesso de espaços em branco.
        $text = preg_replace("/\r\n|\r/", "\n", $text);
        $text = preg_replace("/[ \t]+/", ' ', $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        return trim($text);
    }
}
