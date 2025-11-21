<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nationality',
        'phone_number',
        'birthdate',
        'address',
        'first_name',
        'father_name',
        'last_name',
        'gender',
        'status',
        'medical_specialty'
    ];
    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctor_id');
    }

    public function radiologyAnalyses()
    {
        return $this->hasMany(RadiologyAnalysis::class, 'doctor_id');
    }

    public function chatSessions()
    {
        return $this->hasMany(ChatSession::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
