<ul class="footer-list list-plain">
    @foreach(getContactInfo() as $info)
        <li>
            @if(!empty($info['url']))
                <a href="{{ $info['url'] }}" title="{{ $info['input'] }}" class="item" target="_blank"
                   rel="noopener noreferrer">
                    <span>{{ $info['title'] .':' }}</span> {{ $info['input'] }}
                </a>
            @else
                <div class="item">
                    <span>{{ $info['title'] .':' }}</span> {{ $info['input'] }}
                </div>
            @endif
        </li>
    @endforeach
</ul>
