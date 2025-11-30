<?php

namespace App\Services;

use App\Models\Patient;
use Symfony\Component\Process\Process;

class FullPatientService
{
    public function getAll()
    {
        // ,'radiologyAnalyses'
        return Patient::with(['medicalHistory','medications'])->get();
    }

    public function getById($id)
    {
        // ,'radiologyAnalyses'
        return Patient::with(['medicalHistory','medications'])->findOrFail($id);
    }

    public function create(array $data)
    {
        $patient = Patient::create($data);

        if (!empty($data['medical_history'])) {
            $patient->medicalHistory()->create($data['medical_history']);
        }

        if (!empty($data['medications'])) {
            foreach ($data['medications'] as $med) {
                $patient->medications()->create($med);
            }
        }

        if (!empty($data['radiology'])) {
            $analysis = $patient->radiologyAnalyses()->create([
                'doctor_id' => $data['doctor_id'],
                'original_image_path' => $data['radiology']['original_image_path'],
                'site' => $data['radiology']['site'] ?? null,
                'status' => 'pending'
            ]);

            // $this->runAI($analysis);
        }

        return $patient->load(['medicalHistory','medications','radiologyAnalyses']);
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

        if (!empty($data['medications'])) {
            $patient->medications()->delete();
            foreach ($data['medications'] as $med) {
                $patient->medications()->create($med);
            }
        }

        if (!empty($data['radiology'])) {
            $analysis = $patient->radiologyAnalyses()->updateOrCreate(
                ['patient_id' => $patient->id],
                [
                    'doctor_id' => $data['doctor_id'],
                    'original_image_path' => $data['radiology']['original_image_path'],
                    'site' => $data['radiology']['site'] ?? null,
                    'status' => $data['radiology']['status'] ?? 'pending'
                ]
            );
            // $this->runAI($analysis);
        }

        return $patient->load(['medicalHistory','medications','radiologyAnalyses']);
    }

    public function delete($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return true;
    }
    protected function runAI($analysis)
    {
        $process = new Process([
            'python',
            base_path('ai/process.py'),
            $analysis->original_image_path
        ]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception('AI process failed: ' . $process->getErrorOutput());
        }

        $result = json_decode($process->getOutput(), true);

        $analysis->update([
            'ai_processed_image_path' => $result['ai_processed_image_path'] ?? null,
            't_score_value'           => $result['t_score_value'] ?? null,
            'z_score_value'           => $result['z_score_value'] ?? null,
            'diagnosis'               => $result['diagnosis'] ?? null,
            'status'                  => 'processed',
        ]);
    }

}
