<div class="column is-3" style="border: 1px solid #eee; margin: 10px; padding: 0px;">
    <p class="has-text-centered" style="line-height: 30px; padding: 10px 0px 5px 0px">
        <label for="filter_type"
               style="margin-right: 5px; font-weight: 500; font-size: 11px; text-transform: uppercase">
            Filter By Prefix</label>

        <span class="select">
            <select name="filter_type" id="">
                @foreach($prefixes as $data)
                    <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                @endforeach
            </select>
        </span>
    </p>

    <div class="controller-wrapper">
        @foreach($controllers as $data)
            <div class="controller-list @if ($data['id'] == $controller_id) is-active @endif">
                <a href="/vrm/?middlewares_group_id={{$middlewares_group_id}}&controller_id={{ $data['id'] }}">
                    {{ $data['name'] }}
                </a>
            </div>
        @endforeach
    </div>
</div>