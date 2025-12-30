<div class="card">
    <div class="card-body text-center py-5">
        <div class="mb-4">
            <i class="ti ti-lock text-muted" style="font-size: 4rem;"></i>
        </div>
        <h1 class="text-muted mb-3">403</h1>
        <p class="h3 mb-3">{{ $isZhCN ? '访问被拒绝' : 'Access Denied' }}</p>
        <p class="text-muted mb-4">
            {{ $isZhCN ? '您没有权限访问此资源。' : 'You do not have permission to access this resource.' }}
        </p>
        <a href="/admin" class="btn btn-primary">
            <i class="ti ti-arrow-left me-2"></i>
            {{ $isZhCN ? '返回首页' : 'Back to Home' }}
        </a>
    </div>
</div>
