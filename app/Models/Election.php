<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Election extends Model
{
    protected $table = 'elections';
    protected $fillable = ['name', 'type', 'campus_id', 'date_started', 'date_ended', 'status', 'image_path'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($election) {
            $election->slug = Str::slug($election->name . '-' . uniqid());
        });
    }
    public function campus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function positions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'election_positions');
    }

    public function election_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(election_type::class, 'type');
    }

    public function candidates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Candidate::class, 'election_id');
    }

    public function vote(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vote::class, 'election_id');
    }


}
