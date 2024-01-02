<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'body', 'operator_id', 'fullname', 'title', 'msisdn', 'status',
    ];

    public const STATUS_PROGRESS = 1; // На реализации
    public const STATUS_DONE = 2; // Готов

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id', 'id')->withTrashed();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeOrderByStatus($query): void
    {
        $query->orderBy('status', 'asc')->orderBy('id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('uuid', 'like', '%' . $search . '%')
                    ->orWhere('fullname', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%')
                    ->orWhere('msisdn', 'like', '%' . $search . '%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['status'] ?? null, function ($query, $status) {
            if ($status == self::STATUS_PROGRESS) {
                $query->where('status', self::STATUS_PROGRESS);
            } elseif ($status == self::STATUS_DONE) {
                $query->where('status', self::STATUS_DONE);
            }
        });
    }
}
