<?php

namespace App\Http\Controllers\Admin;

use App\Merlion\Fields\Password;
use App\Merlion\Fields\TreeSelect;
use App\Models\Permission;
use Illuminate\Routing\Controller;
use Merlion\Components\Button;
use Merlion\Components\Containers\Card;
use Merlion\Components\Form\Form;

class CustomFieldDemoController extends Controller
{
    public function index()
    {
        $card = Card::make();

        $form = Form::make();

        // 演示 Password 自定义字段
        $form->field(
            Password::make()
                ->name('password')
                ->label('Password Field')
                ->placeholder('Enter your password')
        );

        $form->field(
            Password::make()
                ->name('password_with_confirm')
                ->label('Password with Confirmation')
                ->confirmation(true)
        );

        // 演示 TreeSelect 自定义字段
        $form->field(
            TreeSelect::make()
                ->name('permission_id')
                ->label('Tree Select (Permissions)')
                ->options(fn () => Permission::tree())
                ->placeholder('-- Select Permission --')
        );

        $form->content(
            Button::make()
                ->primary()
                ->class('mt-3')
                ->label('Submit (Demo Only)')
        );

        $card->body($form);

        admin()
            ->pageTitle('Custom Field Demo')
            ->title('Custom Field Demo')
            ->content($card);

        return admin()->render();
    }
}
