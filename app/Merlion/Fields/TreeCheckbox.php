<?php

declare(strict_types=1);

namespace App\Merlion\Fields;

use Merlion\Components\Form\Fields\Field;

/**
 * Tree Checkbox field for hierarchical multi-selection
 *
 * Usage:
 * TreeCheckbox::make()
 *     ->name('permissions')
 *     ->label('Permissions')
 *     ->treeData(fn () => Permission::getTreeData())
 */
class TreeCheckbox extends Field
{
    public mixed $treeData = [];

    public mixed $relationship = true;

    protected mixed $view = 'merlion.fields.tree-checkbox';

    public function getTreeData(): array
    {
        $data = $this->treeData;

        if (is_callable($data)) {
            $data = call_user_func($data);
        }

        return $data;
    }

    public function getValue()
    {
        $model = $this->getModel();
        if ($model && method_exists($model, $this->getName())) {
            return $model->{$this->getName()}()->pluck('id')->toArray();
        }

        return [];
    }

    public function save($model)
    {
        return $model;
    }

    public function saveRelationship($model)
    {
        $values = request()->input($this->getName(), []);

        if (method_exists($model, $this->getName())) {
            $model->{$this->getName()}()->sync($values ?: []);
        }

        return $model;
    }
}
