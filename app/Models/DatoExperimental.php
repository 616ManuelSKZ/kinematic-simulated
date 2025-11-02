<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatoExperimental extends Model
{
    use HasFactory;

    protected $table = 'datos_experimentales';

    protected $fillable = [
        'experimento_id',
        'archivo_csv',
        'datos',
        'error_rmse'
    ];

    protected $casts = [
        'datos' => 'array',
        'error_rmse' => 'decimal:6'
    ];

    public function experimento(): BelongsTo
    {
        return $this->belongsTo(Experimento::class);
    }
}