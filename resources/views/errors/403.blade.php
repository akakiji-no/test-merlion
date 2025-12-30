@php
    $isZhCN = request()->cookie('locale') === 'zh_CN';
@endphp
<!doctype html>
<html lang="{{ $isZhCN ? 'zh-CN' : 'en' }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>403 - {{ $isZhCN ? '访问被拒绝' : 'Access Denied' }}</title>
    <link href="/vendor/merlion/tabler/css/tabler.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="empty">
                <div class="empty-icon">
                    <i class="ti ti-lock" style="font-size: 4rem;"></i>
                </div>
                <div class="empty-header">403</div>
                <p class="empty-title">{{ $isZhCN ? '访问被拒绝' : 'Access Denied' }}</p>
                <p class="empty-subtitle text-muted">
                    {{ $isZhCN ? '您没有权限访问此资源。' : 'You do not have permission to access this resource.' }}
                </p>
                <div class="empty-action">
                    <a href="/admin" class="btn btn-primary">
                        <i class="ti ti-arrow-left me-2"></i>
                        {{ $isZhCN ? '返回首页' : 'Back to Home' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
