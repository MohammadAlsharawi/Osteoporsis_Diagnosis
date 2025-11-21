<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'doctor_id',
        'first_name',
        'father_name',
        'last_name',
        'gender',
        'age',
        'menopause_age',
        'height_m',
        'weight_kg',
        'bmi',
        'occupation',
        'phone_number',
        'address'
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function medicalHistory()
    {
        return $this->hasOne(PatientMedicalHistory::class);
    }

    public function medications()
    {
        return $this->hasMany(PatientMedication::class);
    }

    public function radiologyAnalyses()
    {
        return $this->hasMany(RadiologyAnalysis::class);
    }
}
