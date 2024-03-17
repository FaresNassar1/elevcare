@if ($data['meta']['last_page'] > 1)
    <ul class="pagination">
        @foreach ($data['meta']['links'] as $page)
            @if ($page['active'])
                <li>
                    <span class="page-link active">{{ $page['label'] }}</span>
                </li>
            @else
                <li>
                    <a href="{{ $page['url'] }}" title="{{ $page['label'] }}"
                       class="page-link @if(empty($page['url'])) disabled @endif"
                       @if ($page['url'] == '/') onclick="event.preventDefault(); @endif">{{ $page['label'] }}</a>
                </li>
            @endif
        @endforeach
    </ul>
@endif
