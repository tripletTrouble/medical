<?php

namespace App\Traits;
use Exception;
use App\Models\ItemMeasure;

trait InteractsWithMeasures
{
    public function getMeasures()
    {
        return $this->measures;
    }

    public function getMainMeasure()
    {
        return ItemMeasure::where('item_id', $this->id)
                ->where('parent_id', null)->first();
    }

    public function toMainMeasure(int $amount, int $measure_id)
    {
        $measure = $this->validateMeasure($measure_id);

        if (! $measure->parent_id) {
            return 1.0;
        }

        do {
            $amount *= $measure->scale;
            $measure = $this->getAncestor($measure);
        } while ($measure->parent_id);

        return $amount;
    }

    public function getAncestor(ItemMeasure $itemMeasure)
    {
        return ItemMeasure::find($itemMeasure->parent_id);
    }

    public function validateMeasure(int $id)
    {
        $measure = ItemMeasure::find($id);

        if (! $measure) {
            throw new Exception("Measure not found", 1);
        }

        if ($this->id != $measure->item_id) {
            throw new Exception("Measure not belongs to this item", 2);
        }

        return $measure;
    }
}
