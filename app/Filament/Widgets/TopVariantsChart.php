<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Models\Variant;
use Filament\Widgets\ChartWidget;

class TopVariantsChart extends ChartWidget
{
    protected static ?string $heading = 'Top Variants (Flavors)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = '1';

    protected function getData(): array
    {
        // 1. Fetch all OrderItems that have variants
        // Optimally, we would limit this query by date (e.g., this year) to avoid scanning the whole table forever.
        $items = OrderItem::query()
            ->whereNotNull('selected_variants')
            ->get();

        $variantCounts = [];

        foreach ($items as $item) {
            $variants = $item->selected_variants;
            if (is_array($variants)) {
                foreach ($variants as $variantId) {
                    if (is_numeric($variantId)) {
                        if (!isset($variantCounts[$variantId])) {
                            $variantCounts[$variantId] = 0;
                        }
                        // We count each occurrence.
                        // If 'quantity' of the item represents multiple boxes,
                        // strictly speaking we should multiply by $item->quantity.
                        // Assuming 'selected_variants' includes the choices for *one* unit of the product.
                        // If I buy 2 boxes of 6, selected_variants might just be the choices for the box?
                        // Or if it's 2 separate lines?
                        // Usually 'quantity' multiplies the entire line.
                        // So we add $item->quantity.
                        $variantCounts[$variantId] += $item->quantity;
                    }
                }
            }
        }

        // 2. Sort by simple count descending
        arsort($variantCounts);

        // 3. Take top 5
        $topVariantIds = array_slice(array_keys($variantCounts), 0, 5);
        $topCounts = array_slice(array_values($variantCounts), 0, 5);

        // 4. Resolve names
        // We preserve the order of $topVariantIds
        $variantModels = Variant::whereIn('id', $topVariantIds)->get()->keyBy('id');

        $labels = [];
        $data = [];

        foreach ($topVariantIds as $index => $id) {
            if (isset($variantModels[$id])) {
                $labels[] = $variantModels[$id]->name;
                $data[] = $topCounts[$index];
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Units Sold',
                    'data' => $data,
                    'backgroundColor' => [
                        '#f59e0b', // Amber 500
                        '#d97706', // Amber 600
                        '#fbbf24', // Amber 400
                        '#b45309', // Amber 700
                        '#fcd34d', // Amber 300
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
