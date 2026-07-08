<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles {
        hasAnyRole as protected spatieHasAnyRole;
    }
    use Notifiable;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_active',
        'preferred_landing',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * @param  UserRole|UserRole[]|string|string[]  $roles
     */
    public function hasAnyRole(UserRole|array|string ...$roles): bool
    {
        $normalized = collect($roles)
            ->flatten()
            ->map(fn (UserRole|string $role) => $role instanceof UserRole ? $role->value : $role)
            ->all();

        return $this->spatieHasAnyRole(...$normalized);
    }

    public function redirectDefault(): string
    {
        if ($this->preferred_landing) {
            return $this->preferred_landing;
        }

        foreach (UserRole::cases() as $role) {
            if ($this->hasRole($role->value)) {
                return $role->defaultRedirect();
            }
        }

        return '/pos';
    }
}
