<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasTranslation;
use App\Models\Permission;
use App\Models\Role;
use Merlion\Components\Button;
use Merlion\Http\Controllers\CrudController;

class RoleController extends CrudController
{
    use HasTranslation;

    protected string $model = Role::class;

    protected function getLabel(): string
    {
        return $this->t('角色', 'Role');
    }

    protected function schemas(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'label' => 'ID',
                'sortable' => true,
                'show_create' => false,
                'show_edit' => false,
            ],
            'parent_id' => [
                'name' => 'parent_id',
                'label' => $this->label('parent_role'),
                'type' => 'treeSelect',
                'options' => fn () => Role::tree(),
                'placeholder' => $this->t('-- 无 --', '-- None --'),
                'show_index' => false,
            ],
            'name' => [
                'name' => 'name',
                'label' => $this->label('name'),
                'rules' => 'required|string|max:255',
                'sortable' => true,
                'filterable' => true,
            ],
            'display_name' => [
                'name' => 'display_name',
                'label' => $this->label('display_name'),
                'rules' => 'nullable|string|max:255',
                'sortable' => true,
            ],
            'description' => [
                'name' => 'description',
                'label' => $this->label('description'),
                'type' => 'textarea',
                'rules' => 'nullable|string',
                'show_index' => false,
            ],
            'permissions' => [
                'name' => 'permissions',
                'label' => $this->label('permissions'),
                'type' => 'treeCheckbox',
                'show_index' => false,
                'treeData' => fn () => Permission::getTreeData(),
            ],
            'created_at' => [
                'name' => 'created_at',
                'label' => $this->label('created_at'),
                'sortable' => true,
                'show_create' => false,
                'show_edit' => false,
            ],
        ];
    }

    protected function searches(): array
    {
        return ['name', 'display_name'];
    }

    protected function getShowTools($model): array
    {
        return [
            Button::make()
                ->label(__('merlion::base.edit'))
                ->icon('ti ti-edit me-1')
                ->link($this->route('edit', $model->getKey()))
                ->class('btn-outline-primary'),
        ];
    }
}
