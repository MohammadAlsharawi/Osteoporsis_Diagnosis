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
        'diagnosis',
        'status',
        'healthy_accuracy',
        'diagnostic_accuracy',
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
