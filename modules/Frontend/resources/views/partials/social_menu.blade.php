<ul class="social-list list-plain mt-15px">
    @foreach(getSocialMenu() as $social)
        <li>
            <a href="{{ $social['url'] }}" title="{{ $social['title'] }}" class="item" target="_blank"
               rel="noopener noreferrer">
                <i class="icon-{{ $social['title'] }}"></i>
            </a>
        </li>
    @endforeach
</ul>
