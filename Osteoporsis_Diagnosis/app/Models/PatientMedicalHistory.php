<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedicalHistory extends Model
{
    protected $table = 'patient_medical_history';

    protected $fillable = [
        'patient_id',
        'joint_pain',
        'smoker',
        'alcoholic',
        'diabetic',
        'hypothyroidism',
        'seizure_disorder',
        'estrogen_use',
        'history_of_fracture',
        'dialysis',
        'family_history_osteoporosis',
        'number_of_pregnancies',
        'maximum_walking_distance',
        'daily_eating_habits',
        'obesity',
        'notes'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
