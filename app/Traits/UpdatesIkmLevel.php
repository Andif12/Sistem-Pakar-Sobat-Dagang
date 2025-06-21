<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait UpdatesIkmLevel
{
    public static function bootUpdatesIkmLevel()
    {
        static::saved(function ($model) {
            $model->updateLevel();
        });

        static::deleted(function ($model) {
            $model->updateLevel();
        });
    }

    public function updateLevel()
    {
        if (method_exists($this, 'dataIkm')) {
            $ikm = $this->dataIkm()->first();
            if ($ikm) {
                Log::info('[UpdatesIkmLevel] Recalculating level for IKM ID: ' . $ikm->id_ikm);
                $ikm->level = $ikm->hitungLevel();
                $ikm->save();
            } else {
                Log::warning('[UpdatesIkmLevel] dataIkm() tidak mengembalikan model.');
            }
        } else {
            Log::warning('[UpdatesIkmLevel] Relasi "dataIkm" tidak ditemukan pada model: ' . get_class($this));
        }
    }
}
