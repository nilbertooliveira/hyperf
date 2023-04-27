<?php

declare(strict_types=1);

namespace App\Model;


use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $description
 * @property string $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Expense extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'expense';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'description',
        'price',
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'expense_user', 'expense_id',  'user_id', 'id');
    }
}
