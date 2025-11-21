<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadiologyAnalysis extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'original_image_path',
        'ai_processed_image_path',
        'site',
        't_score_value',
        'z_score_value',
        'diagnosis',
        'status'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
