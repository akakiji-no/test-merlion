<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'parent_id',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    public static function tree(): array
    {
        $permissions = self::with('children')->whereNull('parent_id')->get();

        return self::buildTree($permissions);
    }

    protected static function buildTree($permissions, $level = 0): array
    {
        $tree = [];
        foreach ($permissions as $permission) {
            $prefix = str_repeat('— ', $level);
            $tree[$permission->id] = $prefix.$permission->display_name;
            if ($permission->children->count() > 0) {
                $tree += self::buildTree($permission->children, $level + 1);
            }
        }

        return $tree;
    }

    public static function getTreeData(): array
    {
        $permissions = self::with('children')->whereNull('parent_id')->get();

        return self::buildTreeData($permissions);
    }

    public static function flatTree(): \Illuminate\Support\Collection
    {
        $permissions = self::with('children')->whereNull('parent_id')->orderBy('id')->get();

        return collect(self::buildFlatTree($permissions));
    }

    protected static function buildFlatTree($permissions, $level = 0): array
    {
        $flat = [];
        foreach ($permissions as $permission) {
            $permission->_level = $level;
            $flat[] = $permission;
            if ($permission->children->count() > 0) {
                $flat = array_merge($flat, self::buildFlatTree($permission->children->sortBy('id'), $level + 1));
            }
        }

        return $flat;
    }

    protected static function buildTreeData($permissions): array
    {
        $tree = [];
        foreach ($permissions as $permission) {
            $item = [
                'id' => $permission->id,
                'name' => $permission->display_name ?: $permission->name,
                'children' => [],
            ];
            if ($permission->children->count() > 0) {
                $item['children'] = self::buildTreeData($permission->children);
            }
            $tree[] = $item;
        }

        return $tree;
    }
}
