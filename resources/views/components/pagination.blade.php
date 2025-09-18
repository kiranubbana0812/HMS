{{--Hey Coming here 

<pre>{{ print_r($pagination) }}</pre>--}}

@if(isset($pagination) && $pagination['total'] > $pagination['per_page'])
    @php
        // Current frontend URL without query params
        $currentBaseUrl = url()->current();

        // Start with current request filters, but remove 'page'
        $filtersWithoutPage = $filters ?? request()->except('page');
    @endphp

    <nav class="mt-3">
        <ul class="pagination justify-content-end">
            @foreach ($pagination['links'] as $link)
                @php
                    $url = null;

                    if ($link['url']) {
                        // Extract query string (e.g., page=2&per_page=2...)
                        $queryParams = [];
                        parse_str(parse_url($link['url'], PHP_URL_QUERY), $queryParams);

                        // Merge API query params with filters (filters win, except 'page')
                        $finalParams = array_merge($filtersWithoutPage, $queryParams);

                        // Build clean URL
                        $url = $currentBaseUrl . '?' . http_build_query($finalParams);
                    }
                @endphp

                <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ !$url ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $url ?: '#' }}">{!! $link['label'] !!}</a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif
