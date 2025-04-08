<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    public mixed $faceData;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'first_name',
        'last_name',
        'middle_initial',
        'extension',
        'gender',
        'birth_date',
        'email',
        'phone_number',
        'year_level',
        'student_id',
        'campus_id',
        'college_id',
        'program_id',
        'program_major_id',
        'username',
        'password',
        'face_descriptor',
        'google_id',
        'account_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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

    public function campus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function faceData(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FaceData::class, 'user_id');
    }

    public function college(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(college::class, 'college_id');
    }

    public function program(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function programMajor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(program_major::class, 'program_major_id');
    }

    public function candidates(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'user_id');
    }

    public function electionExcludedVoters(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ElectionExcludedVoter::class, 'user_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'user_id');

    }

    public function sessions()
    {
        return $this->hasMany(\Session::class, 'user_id');
    }

}
