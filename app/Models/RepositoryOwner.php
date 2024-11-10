<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property int $import_id
 * @property string $login
 */
class RepositoryOwner extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'github_repository_owners';

    protected $fillable = [
        'import_id',
        'login',
    ];
}
