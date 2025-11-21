<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedication extends Model
{
    protected $fillable = [
        'patient_id',
        'medication_name',
        'dosage',
        'frequency',
        'notes'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
