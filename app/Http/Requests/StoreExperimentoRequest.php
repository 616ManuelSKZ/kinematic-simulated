<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperimentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:mruv,parabolico',
            'notas' => 'nullable|string|max:1000',
            'parametros' => 'required|array',
        ];

        // Reglas específicas para MRUV
        if ($this->input('tipo') === 'mruv') {
            $rules['parametros.velocidad_inicial'] = 'required|numeric';
            $rules['parametros.aceleracion'] = 'required|numeric';
            $rules['parametros.tiempo_total'] = 'required|numeric|min:0.1|max:1000';
            $rules['parametros.posicion_inicial'] = 'nullable|numeric';
            $rules['parametros.intervalo'] = 'nullable|numeric|min:0.001|max:1';
        }

        // Reglas específicas para Movimiento Parabólico
        if ($this->input('tipo') === 'parabolico') {
            $rules['parametros.velocidad_inicial'] = 'required|numeric|min:0.1|max:500';
            $rules['parametros.angulo'] = 'required|numeric|min:1|max:89';
            $rules['parametros.altura_inicial'] = 'nullable|numeric|min:0|max:1000';
            $rules['parametros.gravedad'] = 'nullable|numeric|min:0.1|max:20';
            $rules['parametros.intervalo'] = 'nullable|numeric|min:0.001|max:1';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del experimento es obligatorio.',
            'tipo.required' => 'Debe seleccionar un tipo de experimento.',
            'tipo.in' => 'El tipo de experimento debe ser MRUV o Parabólico.',
            'parametros.velocidad_inicial.required' => 'La velocidad inicial es obligatoria.',
            'parametros.velocidad_inicial.min' => 'La velocidad inicial debe ser mayor a :min m/s.',
            'parametros.velocidad_inicial.max' => 'La velocidad inicial no puede exceder :max m/s.',
            'parametros.angulo.min' => 'El ángulo debe ser mayor a :min grados.',
            'parametros.angulo.max' => 'El ángulo debe ser menor a :max grados.',
            'parametros.tiempo_total.min' => 'El tiempo total debe ser al menos :min segundos.',
            'parametros.aceleracion.required' => 'La aceleración es obligatoria.',
            'notas.max' => 'Las notas no pueden exceder :max caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'parametros.velocidad_inicial' => 'velocidad inicial',
            'parametros.aceleracion' => 'aceleración',
            'parametros.tiempo_total' => 'tiempo total',
            'parametros.posicion_inicial' => 'posición inicial',
            'parametros.angulo' => 'ángulo',
            'parametros.altura_inicial' => 'altura inicial',
            'parametros.gravedad' => 'gravedad',
        ];
    }
}