<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'parent_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_has_roles');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Role::class, 'parent_id');
    }

    public static function tree(): array
    {
        $roles = self::with('children')->whereNull('parent_id')->get();

        return self::buildTree($roles);
    }

    protected static function buildTree($roles, $level = 0): array
    {
        $tree = [];
        foreach ($roles as $role) {
            $prefix = str_repeat('— ', $level);
            $tree[$role->id] = $prefix.$role->display_name;
            if ($role->children->count() > 0) {
                $tree += self::buildTree($role->children, $level + 1);
            }
        }

        return $tree;
    }
}
