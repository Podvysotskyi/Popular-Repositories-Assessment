<?php

namespace App\Models\GitHub;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property int $import_id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property int $stars_count
 * @property Carbon $repository_created_at
 * @property Carbon $repository_pushed_at
 */
class Repository extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'github_repositories';

    protected $fillable = [
        'import_id',
        'name',
        'url',
        'description',
        'stars_count',
        'repository_created_at',
        'repository_pushed_at',
    ];

    protected $casts = [
        'repository_created_at' => 'datetime',
        'repository_pushed_at' => 'datetime',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(RepositoryOwner::class , 'owner_id');
    }
}
