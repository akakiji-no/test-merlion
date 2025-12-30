<?php

namespace App\Http\Controllers\Admin\Concerns;

trait HasTranslation
{
    protected function isZhCN(): bool
    {
        return request()->cookie('locale') === 'zh_CN';
    }

    protected function t(string $zh, string $en): string
    {
        return $this->isZhCN() ? $zh : $en;
    }

    protected function labels(): array
    {
        return [
            'id' => 'ID',
            'name' => $this->t('名称', 'Name'),
            'email' => $this->t('邮箱', 'Email'),
            'password' => $this->t('密码', 'Password'),
            'display_name' => $this->t('显示名称', 'Display Name'),
            'description' => $this->t('描述', 'Description'),
            'roles' => $this->t('角色', 'Roles'),
            'permissions' => $this->t('权限', 'Permissions'),
            'parent_role' => $this->t('父级角色', 'Parent Role'),
            'parent_permission' => $this->t('父级权限', 'Parent Permission'),
            'created_at' => $this->t('创建时间', 'Created At'),
            'updated_at' => $this->t('更新时间', 'Updated At'),
        ];
    }

    protected function label(string $key): string
    {
        return $this->labels()[$key] ?? $key;
    }
}
