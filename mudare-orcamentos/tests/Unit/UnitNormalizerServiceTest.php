<?php

namespace Tests\Unit;

use App\Services\ChunkingService;
use App\Services\UnitNormalizerService;
use PHPUnit\Framework\TestCase;

class UnitNormalizerServiceTest extends TestCase
{
    public function test_normalizes_common_units(): void
    {
        $svc = new UnitNormalizerService();

        $this->assertSame('m²', $svc->normalize('m2'));
        $this->assertSame('m²', $svc->normalize('M2'));
        $this->assertSame('m³', $svc->normalize('m3'));
        $this->assertSame('m', $svc->normalize('ml'));
        $this->assertSame('un', $svc->normalize('unidade'));
        $this->assertSame('vb', $svc->normalize('verba'));
    }

    public function test_returns_nao_identificado_for_empty(): void
    {
        $svc = new UnitNormalizerService();

        $this->assertSame('não identificado', $svc->normalize(null));
        $this->assertSame('não identificado', $svc->normalize(''));
    }

    public function test_keeps_unknown_unit(): void
    {
        $svc = new UnitNormalizerService();
        $this->assertSame('parsec', $svc->normalize('parsec'));
        $this->assertFalse($svc->isKnown('parsec'));
        $this->assertTrue($svc->isKnown('m2'));
    }

    public function test_chunking_splits_long_text_with_overlap(): void
    {
        $chunker = new ChunkingService();
        $text = str_repeat('Frase de teste do memorial. ', 2000); // texto longo

        $chunks = $chunker->chunk($text, 1000, 100);

        $this->assertGreaterThan(1, count($chunks));
        foreach ($chunks as $chunk) {
            $this->assertLessThanOrEqual(1000, mb_strlen($chunk));
        }
    }

    public function test_chunking_short_text_returns_single_chunk(): void
    {
        $chunker = new ChunkingService();
        $chunks = $chunker->chunk('Texto curto.', 1000, 100);
        $this->assertCount(1, $chunks);
    }
}
