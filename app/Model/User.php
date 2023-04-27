<?php

declare(strict_types=1);

namespace App\Model;


use Hyperf\Database\Model\Relations\BelongsToMany;
use Qbhy\HyperfAuth\Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model implements Authenticatable
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'user';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function expense(): BelongsToMany
    {
        return $this->belongsToMany(Expense::class, 'expense_user', 'user_id',  'expense_id', 'id');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param $key
     * @return Authenticatable|null
     */
    public static function retrieveById($key): ?Authenticatable
    {
        /**
         * @var User $user
         */
        $user = User::query()->find($key);

        return $user;
    }
}
