<?php

namespace App\Http\Controllers\Admin;

use Merlion\Components\Layouts\Layout;

class ErrorController
{
    public function forbidden()
    {
        $isZhCN = request()->cookie('locale') === 'zh_CN';

        return Layout::make()
            ->title($isZhCN ? '访问被拒绝' : 'Access Denied')
            ->view('errors.403-content', [
                'isZhCN' => $isZhCN,
            ]);
    }
}
