<?php

namespace App\Providers;

use App\Merlion\Fields\Password;
use App\Merlion\Fields\TreeCheckbox;
use App\Merlion\Fields\TreeSelect;
use Illuminate\Support\ServiceProvider;
use Merlion\Components\Form\Fields\Field;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 注册自定义 Merlion 表单字段
        Field::$fieldsMap['password'] = Password::class;
        Field::$fieldsMap['treeSelect'] = TreeSelect::class;
        Field::$fieldsMap['treeCheckbox'] = TreeCheckbox::class;
    }
}
