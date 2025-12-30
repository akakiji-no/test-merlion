<?php

declare(strict_types=1);

namespace App\Merlion\Fields;

use Merlion\Components\Form\Fields\Field;

/**
 * Tree Select field for hierarchical data selection
 *
 * Usage:
 * TreeSelect::make()
 *     ->name('parent_id')
 *     ->label('Parent')
 *     ->options(fn () => Permission::tree())
 */
class TreeSelect extends Field
{
    public mixed $options = [];

    public mixed $placeholder = '-- Select --';

    protected mixed $view = 'merlion.fields.tree-select';

    public function getOptions(): array
    {
        $options = $this->options;

        if (is_callable($options)) {
            $options = call_user_func($options);
        }

        return $options;
    }
}
