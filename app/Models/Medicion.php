<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicion extends Model
{
    use HasFactory;

    protected $table = 'mediciones';

    protected $fillable = [
        'user_id',
        'nombre',
        'tipo_magnitud',
        'unidad',
        'valores',
        'valor_verdadero',
        'analisis_resultado',
        'observaciones'
    ];

    protected $casts = [
        'valores' => 'array',
        'analisis_resultado' => 'array',
        'valor_verdadero' => 'decimal:6'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeTipoMagnitud($query, string $tipo)
    {
        return $query->where('tipo_magnitud', $tipo);
    }

    /**
     * Obtener número de mediciones
     */
    public function getNumeroMedicionesAttribute(): int
    {
        return count($this->valores ?? []);
    }

    /**
     * Obtener media de las mediciones
     */
    public function getMediaAttribute(): ?float
    {
        if (empty($this->valores)) {
            return null;
        }
        return array_sum($this->valores) / count($this->valores);
    }
}