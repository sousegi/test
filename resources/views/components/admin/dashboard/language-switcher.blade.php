@props(['languages'])

<!-- Lang Switcher -->
<div class="btn-group lang__switcher ms-2" id="language-switcher" role="group">
    @if(is_array($languages))
        @foreach($languages as $key => $lang)
            <button type="button"
                    class="btn btn-sm {{ $key === 0 ? 'btn-primary' : 'btn-alt-secondary' }}"
                    data-locale="{{ $lang['locale'] }}"
            >{{ strtoupper($lang['title']) }}</button>
        @endforeach
    @endif
</div><!-- END Lang Switcher -->
