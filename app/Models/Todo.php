<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\TodoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Todo extends Model
{
    /** @use HasFactory<\Database\Factories\TodoFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
