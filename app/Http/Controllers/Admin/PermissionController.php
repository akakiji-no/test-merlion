<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HasTranslation;
use App\Models\Permission;
use Merlion\Components\Button;
use Merlion\Http\Controllers\CrudController;

class PermissionController extends CrudController
{
    use HasTranslation;

    protected string $model = Permission::class;

    protected function getLabel(): string
    {
        return $this->t('权限', 'Permission');
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
                'label' => $this->label('parent_permission'),
                'type' => 'treeSelect',
                'options' => fn () => Permission::tree(),
                'placeholder' => $this->t('-- 无 --', '-- None --'),
                'show_index' => false,
            ],
            'name' => [
                'name' => 'name',
                'label' => $this->label('name'),
                'rules' => 'required|string|max:255',
                'sortable' => true,
                'filterable' => true,
                'displayValueUsing' => function ($column) {
                    $model = $column->getModel();
                    $level = $model->_level ?? 0;
                    $prefix = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);

                    return $prefix.$model->name;
                },
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

    public function index(...$args)
    {
        if (! request('search') && ! request('sort') && ! request('filter')) {
            $this->authorize('viewAny', $this->getModel());
            $this->callMethods('beforeIndex', ...$args);

            $models = Permission::flatTree();

            $card = \Merlion\Components\Containers\Card::make();
            $table = $this->table(...$args);

            $actions = $this->getRowActions();
            if (! empty($actions)) {
                $table->column(\Merlion\Components\Table\Columns\Actions::make()
                    ->class('float-end', 'wrapper')
                    ->icon('ti ti-dots')
                    ->dropdown()
                    ->actions($actions));
            }

            $table->models($models);
            $card->content($table);

            admin()->content($this->getIndexTools(), 'header');
            admin()->pageTitle($this->getLabelPlural())
                ->title($this->getLabelPlural())
                ->content($card);

            $this->callMethods('afterIndex', ...$args);

            return admin()->render();
        }

        return parent::index(...$args);
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
