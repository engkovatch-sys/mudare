<?php

namespace Database\Seeders;

use App\Models\Architect;
use App\Models\Client;
use App\Models\Price;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

/**
 * Dados de demonstração (fornecedores, cliente, arquiteto e alguns preços)
 * para exercitar o fluxo do MVP. Todos fictícios.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        Client::updateOrCreate(
            ['email' => 'cliente@exemplo.com'],
            ['name' => 'Família Exemplo', 'document' => '000.000.000-00', 'phone' => '(11) 90000-0000', 'address' => 'Rua do Alto Padrão, 100 - São Paulo/SP']
        );

        Architect::updateOrCreate(
            ['email' => 'arquiteto@exemplo.com'],
            ['name' => 'Arq. Exemplo', 'office_name' => 'Estúdio Exemplo', 'phone' => '(11) 91111-1111', 'website' => 'https://exemplo.arq.br', 'instagram' => '@estudioexemplo']
        );

        $suppliers = [
            ['name' => 'Esquadrias Premium Ltda', 'category' => 'Esquadrias', 'contact_name' => 'João', 'email' => 'contato@esquadriaspremium.com', 'city' => 'São Paulo', 'state' => 'SP'],
            ['name' => 'Mármores & Pedras Finas', 'category' => 'Revestimento', 'contact_name' => 'Maria', 'email' => 'vendas@marmoresfinos.com', 'city' => 'São Paulo', 'state' => 'SP'],
            ['name' => 'Impermeabiliza Tudo', 'category' => 'Impermeabilização', 'contact_name' => 'Carlos', 'email' => 'orcamento@impermeabiliza.com', 'city' => 'Campinas', 'state' => 'SP'],
        ];

        foreach ($suppliers as $s) {
            $supplier = Supplier::updateOrCreate(['name' => $s['name']], $s);
        }

        $imper = Supplier::where('name', 'Impermeabiliza Tudo')->first();
        $marmore = Supplier::where('name', 'Mármores & Pedras Finas')->first();

        Price::updateOrCreate(
            ['item_name' => 'Impermeabilização de piscinas', 'supplier_id' => $imper?->id],
            [
                'category' => 'Impermeabilização', 'unit' => 'm²', 'unit_price' => 335.00,
                'price_type' => 'referencial', 'source' => 'Tabela do fornecedor', 'collected_at' => '2025-02-01',
                'valid_until' => '2025-12-31', 'taxes_included' => true, 'freight_included' => false,
                'validation_responsible' => 'Eng. Orçamentista', 'validation_status' => 'approved',
            ]
        );

        Price::updateOrCreate(
            ['item_name' => 'Mármore importado', 'supplier_id' => $marmore?->id],
            [
                'category' => 'Revestimento', 'unit' => 'm²', 'unit_price' => 2100.00,
                'price_type' => 'estimado', 'source' => 'Estimativa interna', 'collected_at' => '2025-02-01',
                'valid_until' => null, 'taxes_included' => false, 'freight_included' => false,
                'validation_responsible' => null, 'validation_status' => 'pending',
            ]
        );
    }
}
