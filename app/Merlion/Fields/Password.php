<?php

declare(strict_types=1);

namespace App\Merlion\Fields;

use Illuminate\Support\Facades\Hash;
use Merlion\Components\Concerns\AsInput;
use Merlion\Components\Form\Fields\Field;

/**
 * Custom Password field for Merlion
 *
 * Usage in Controller schemas():
 * 'password' => [
 *     'type' => 'password',
 *     'name' => 'password',
 *     'rules' => 'nullable|string|min:8',
 * ]
 */
class Password extends Field
{
    use AsInput;

    public mixed $confirmation = false;

    public mixed $hashOnSave = true;

    protected mixed $view = 'merlion.fields.password';

    public function registerPassword(): void
    {
        $this->inputType = 'password';
    }

    public function getValue()
    {
        return null;
    }

    public function save($model)
    {
        $value = $this->getDataFromRequest();

        if (empty($value)) {
            return $model;
        }

        if ($this->hashOnSave) {
            $value = Hash::make($value);
        }

        $model->{$this->getName()} = $value;

        return $model;
    }

    public function getDataFromRequest($request = null)
    {
        if (empty($request)) {
            $request = request();
        }

        $value = $request->input($this->getName());

        if ($this->confirmation) {
            $confirmation = $request->input($this->getName().'_confirmation');
            if ($value !== $confirmation) {
                return null;
            }
        }

        return $value;
    }

    public function getRules(): array|string|null
    {
        $rules = parent::getRules() ?? [];

        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }

        if ($this->confirmation) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }
}
