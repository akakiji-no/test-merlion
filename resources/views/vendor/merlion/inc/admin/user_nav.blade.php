@php
    $currentLocale = request()->cookie('locale', 'en');
@endphp
<div class="navbar-nav flex-row order-md-last">
    {{-- Language Switcher --}}
    <div class="nav-item dropdown me-2">
        <a href="#" class="nav-link px-2" data-bs-toggle="dropdown" aria-label="Language">
            <i class="ti ti-language icon"></i>
            <span class="d-none d-xl-inline ms-1">{{ $currentLocale == 'zh_CN' ? '中文' : 'EN' }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item {{ $currentLocale == 'en' ? 'active' : '' }}" 
               href="{{ route('admin.language.switch', 'en') }}">
                <span class="me-2">🇺🇸</span> English
            </a>
            <a class="dropdown-item {{ $currentLocale == 'zh_CN' ? 'active' : '' }}" 
               href="{{ route('admin.language.switch', 'zh_CN') }}">
                <span class="me-2">🇨🇳</span> 中文
            </a>
        </div>
    </div>

    {{-- User Menu --}}
    <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm overflow-hidden">
                @if($avatar = auth()->user()->avatar)
                    <img src="{{$avatar}}" alt="Avatar">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="icon"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"/>
                    </svg>
                @endif
            </span>
            <div class="d-none d-xl-block ps-2">
                <div>{{auth()->user()->name ?? '-'}}</div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            @foreach(admin()->getMenus('user') as $menu)
                @if($menu->getDivider())
                    <div class="dropdown-divider"></div>
                @else
                    <a class="dropdown-item" href="{{$menu->getLink()}}"
                       @if($target = $menu->getTarget())
                           target="{{$target}}"
                            @endif
                    >
                        @if($icon = $menu->getIcon())
                            {!! render($icon) !!}
                        @endif
                        {!! $menu->getLabel() !!}
                    </a>
                @endif
            @endforeach
            @if(admin()->hasLogin())
                <a href="{{admin()->getRoute('auth.logout')}}" class="dropdown-item">
                    <i class="ti ti-logout icon"></i>
                    {{__('merlion::base.logout')}}
                </a>
            @endif
        </div>
    </div>
</div>
