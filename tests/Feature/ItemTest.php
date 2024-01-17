<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemTest extends TestCase
{
    public function test_it_must_return_error_when_measure_not_found(): void
    {
        $this->expectExceptionMessage('Measure not found');

        $item = Item::where('code', 'pct-001')->first();

        $item->toMainMeasure(1, 6);
    }

    public function test_it_must_return_error_when_measure_not_belongs_to_item(): void
    {
        $this->expectExceptionMessage('Measure not belongs to this item');

        $item = Item::where('code', 'pct-001')->first();

        $item->toMainMeasure(1, 4);
    }

    public function test_it_must_return_1_when_use_main_measure(): void
    {
        $item = Item::where('code', 'pct-001')->first();

        $this->assertSame(1.0, $item->toMainMeasure(1, 1));
    }

    public function test_it_must_return_10_when_use_second_measure(): void
    {
        $item = Item::where('code', 'pct-001')->first();

        $this->assertSame(10.0, $item->toMainMeasure(1, 2));
    }

    public function test_it_must_return_500_when_use_third_measure(): void
    {
        $item = Item::where('code', 'pct-001')->first();

        $this->assertSame(500.0, $item->toMainMeasure(5, 3));
    }

    public function test_it_must_return_zero_when_send_zero_amount(): void
    {
        $item = Item::where('code', 'pct-001')->first();

        $this->assertSame(0.0, $item->toMainMeasure(0, 3));
    }
}
