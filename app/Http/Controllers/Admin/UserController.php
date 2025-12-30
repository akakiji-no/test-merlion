<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasTranslation;
use App\Models\Role;
use App\Models\User;
use Merlion\Components\Button;
use Merlion\Http\Controllers\CrudController;

class UserController extends CrudController
{
    use HasTranslation;

    protected string $model = User::class;

    protected function getLabel(): string
    {
        return $this->t('用户', 'User');
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
            'name' => [
                'name' => 'name',
                'label' => $this->label('name'),
                'rules' => 'required|string|max:255',
                'sortable' => true,
                'filterable' => true,
            ],
            'email' => [
                'name' => 'email',
                'label' => $this->label('email'),
                'rules' => 'required|email|max:255',
                'sortable' => true,
                'filterable' => true,
            ],
            'password' => [
                'name' => 'password',
                'label' => $this->label('password'),
                'type' => 'password',
                'rules' => 'nullable|string|min:8',
                'show_index' => false,
                'show_show' => false,
            ],
            'roles' => [
                'name' => 'roles',
                'label' => $this->label('roles'),
                'type' => 'belongsToMany',
                'show_index' => false,
                'options' => fn () => Role::pluck('display_name', 'id')->toArray(),
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
        return ['name', 'email'];
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
