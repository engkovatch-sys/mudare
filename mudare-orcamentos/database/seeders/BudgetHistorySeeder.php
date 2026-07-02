<?php

namespace Database\Seeders;

use App\Models\BudgetHistory;
use Illuminate\Database\Seeder;

/**
 * Dados fictícios de histórico orçamentário para obra residencial de alto
 * padrão. Valores meramente ILUSTRATIVOS para o MVP — não usar em produção
 * sem substituir por dados reais validados por engenheiro orçamentista.
 */
class BudgetHistorySeeder extends Seeder
{
    public function run(): void
    {
        $baseDate = '2025-01-01';

        $rows = [
            ['Impermeabilização', 'Impermeabilização de piscinas', 'Área externa', 'm²', 320.00, 0.15, 'luxo'],
            ['Impermeabilização', 'Impermeabilização de floreiras', 'Jardim', 'm²', 280.00, 0.05, 'especial'],
            ['Impermeabilização', 'Impermeabilização de lajes ajardinadas', 'Cobertura', 'm²', 260.00, 0.20, 'especial'],
            ['Drenagem', 'Drenagem de jardim / caixas', 'Área externa', 'm', 190.00, 0.10, 'especial'],
            ['Esquadrias', 'Esquadrias minimalistas de alumínio', 'Geral', 'm²', 3800.00, 0.35, 'luxo'],
            ['Esquadrias', 'Vidros jumbo laminados', 'Sala / fachada', 'm²', 2600.00, 0.20, 'luxo'],
            ['Revestimento', 'Pedras naturais especiais', 'Áreas nobres', 'm²', 1450.00, 0.30, 'luxo'],
            ['Revestimento', 'Mármore importado', 'Banheiros suíte', 'm²', 2200.00, 0.10, 'luxo'],
            ['Revestimento', 'Microcimento monolítico', 'Áreas internas', 'm²', 420.00, 0.25, 'especial'],
            ['Marcenaria', 'Marcenaria fina sob medida', 'Geral', 'm²', 2900.00, 0.40, 'luxo'],
            ['Marcenaria', 'Portas mimetizadas', 'Circulação', 'un', 6800.00, 0.01, 'luxo'],
            ['Serralheria', 'Serralheria fina / guarda-corpos', 'Escadas / varandas', 'm', 1900.00, 0.08, 'luxo'],
            ['Serralheria', 'Brises metálicos sob medida', 'Fachada', 'm²', 1600.00, 0.12, 'especial'],
            ['Automação', 'Automação residencial', 'Casa toda', 'vb', 180000.00, null, 'luxo'],
            ['Climatização', 'Sistema VRF/VRV', 'Casa toda', 'vb', 220000.00, null, 'luxo'],
            ['Iluminação', 'Luminotécnica / luminárias importadas', 'Geral', 'pt', 1200.00, 0.50, 'luxo'],
            ['Paisagismo', 'Paisagismo técnico e irrigação', 'Jardins', 'm²', 650.00, 0.20, 'especial'],
            ['Concreto', 'Concreto aparente pigmentado', 'Estrutura aparente', 'm²', 780.00, 0.15, 'especial'],
            ['Piso', 'Piso monolítico de alto padrão', 'Áreas sociais', 'm²', 540.00, 0.35, 'especial'],
            ['Serviços', 'Gerenciamento técnico de obra', 'Administração', 'mês', 25000.00, null, 'especial'],
        ];

        foreach ($rows as [$category, $item, $env, $unit, $price, $qtyM2, $standard]) {
            BudgetHistory::updateOrCreate(
                ['category' => $category, 'item_name' => $item, 'environment' => $env],
                [
                    'unit' => $unit,
                    'unit_price' => $price,
                    'quantity_per_m2' => $qtyM2,
                    'finish_standard' => $standard,
                    'city' => 'São Paulo',
                    'state' => 'SP',
                    'base_date' => $baseDate,
                    'source' => 'Base histórica fictícia (MVP)',
                    'notes' => 'Valor ilustrativo. Validar com dados reais.',
                ]
            );
        }
    }
}
