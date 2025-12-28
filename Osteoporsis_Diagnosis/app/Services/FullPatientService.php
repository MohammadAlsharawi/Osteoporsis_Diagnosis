<?php

namespace App\Services;

use App\Models\Patient;
use Symfony\Component\Process\Process;

class FullPatientService
{
    public function getAll()
    {
        // ,'radiologyAnalyses'
        return Patient::with(['medicalHistory'])->get();
    }

    public function getById($id)
    {
        // ,'radiologyAnalyses'
        return Patient::with(['medicalHistory'])->findOrFail($id);
    }

    public function create(array $data)
    {
        $patient = Patient::create($data);

        if (!empty($data['medical_history'])) {
            $patient->medicalHistory()->create($data['medical_history']);
        }

        if (!empty($data['radiology'])) {
            $analysis = $patient->radiologyAnalyses()->create([
                'doctor_id' => $data['doctor_id'],
                'original_image_path' => $data['radiology']['original_image_path'],
                'status' => 'pending'
            ]);

            // $this->runAI($analysis);
        }

        return $patient->load(['medicalHistory','radiologyAnalyses']);
    }

    public function update($id, array $data)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($data);

        if (!empty($data['medical_history'])) {
            $patient->medicalHistory()->updateOrCreate(
                ['patient_id' => $patient->id],
                $data['medical_history']
            );
        }

        if (!empty($data['radiology'])) {
            $analysis = $patient->radiologyAnalyses()->updateOrCreate(
                ['patient_id' => $patient->id],
                [
                    'doctor_id' => $data['doctor_id'],
                    'original_image_path' => $data['radiology']['original_image_path'],
                    'status' => $data['radiology']['status'] ?? 'pending'
                ]
            );
            // $this->runAI($analysis);
        }

        return $patient->load(['medicalHistory','radiologyAnalyses']);
    }

    protected function runAI($analysis)
    {
        $process = new Process([
            'python',
            base_path('AImodel1/predict.py'),
            $analysis->original_image_path
        ]);
        $process->run();

        if (!$process->isSuccessful()) {
            $analysis->update([
                'status'                  => 'failed',
            ]);
            throw new \Exception('AI process failed: ' . $process->getErrorOutput());
        }

        $result = json_decode($process->getOutput(), true);

        $analysis->update([
            'ai_processed_image_path' => $result['ai_processed_image_path'] ?? null,
            'diagnosis'               => $result['diagnosis'] ?? null,
            'diagnostic_accuracy'     =>$result['diagnostic_accuracy'] ?? null,
            'healthy_accuracy'        =>$result['healthy_accuracy'] ?? null ,
            'status'                  => 'processed',
        ]);
    }

}
