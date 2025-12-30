<?php

namespace App\Providers;

use App\Http\Controllers\Admin\CustomFieldDemoController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Merlion\AdminProvider;
use Merlion\Components\Layouts\Admin;
use Merlion\Components\Menu;

class AdminServiceProvider extends AdminProvider
{
    public function admin(Admin $admin): Admin
    {
        return $admin
            ->id('admin')
            ->default()
            ->brandName('Merlion Admin')
            ->username('name')
            ->usernameType('text')
            ->menus($this->getMainMenus())
            ->authenticatedRoutes(function () {
                Route::resource('users', UserController::class)->middleware('permission:users.view');
                Route::resource('roles', RoleController::class)->middleware('permission:roles.view');
                Route::resource('permissions', PermissionController::class)->middleware('permission:permissions.view');
                Route::get('custom-field-demo', [CustomFieldDemoController::class, 'index'])->name('custom-field-demo');
                Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
            })
            ->path('admin');
    }

    protected function getMainMenus(): array
    {
        return [
            Menu::make()
                ->label(fn () => $this->t('仪表盘', 'Dashboard'))
                ->icon('ti ti-dashboard')
                ->link(fn () => admin()->getRoute('home'))
                ->priority(0),

            Menu::make()
                ->label(fn () => $this->t('用户管理', 'Users'))
                ->icon('ti ti-users')
                ->link(fn () => admin()->getRoute('users.index'))
                ->priority(10),

            Menu::make()
                ->label(fn () => $this->t('角色管理', 'Roles'))
                ->icon('ti ti-shield')
                ->link(fn () => admin()->getRoute('roles.index'))
                ->priority(20),

            Menu::make()
                ->label(fn () => $this->t('权限管理', 'Permissions'))
                ->icon('ti ti-lock')
                ->link(fn () => admin()->getRoute('permissions.index'))
                ->priority(30),

            Menu::make()
                ->label(fn () => $this->t('自定义表单项', 'Custom Fields'))
                ->icon('ti ti-forms')
                ->link(fn () => admin()->getRoute('custom-field-demo'))
                ->priority(40),
        ];
    }

    protected function t(string $zh, string $en): string
    {
        $locale = request()->cookie('locale', 'en');

        return $locale === 'zh_CN' ? $zh : $en;
    }
}
