@can($item['permission'] ?? null)
    <li class="nav-item {{ $item['parent_attributes']['class'] ?? '' }}">
        <a class="nav-link {{ $item['attributes']['class'] ?? '' }}"
            @if (!empty($item['children'])) data-bs-toggle="collapse"
                data-toggle="collapse"
                aria-expanded="false"
                aria-controls="{{ str_replace(' ', '_', $item['title']) }}"
                href="#{{ $item['url'] }}"
            @else
                href="@php match ($item['type']) {
                    'PATH' => url($item['url']),
                    'FULL_URL' => $item['url'],
                    'ROUTE' => route($item['url']),
                    default => '#' .$item['url']
                } @endphp"> @endif
            <span class="menu-title">{{ $item['title'] }}</span>

            @if (!empty($item['children']))
                <i class="menu-arrow"></i>
            @endif
            @isset($item['icon'])
                <i class="{{ $item['icon'] }}"></i>
            @endisset
        </a>
        @if (!empty($item['children']))
            <div class="collapse" id="{{ $item['url'] }}">
                <ul class="nav flex-column sub-menu">
                    @foreach ($item['children'] as $child)
                        @include(config('laranav.default.directory') . '.layouts.link', ['item' => $child])
                    @endforeach
                </ul>
            </div>
        @endif
    </li>
@endcan
