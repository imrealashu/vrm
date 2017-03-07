<div class="column is-3">
    <div style="border: 1px solid #eee; margin: 0px; padding: 0px;">
        <p class="has-text-centered" style="line-height: 30px; padding: 10px 0px 5px 0px">
            <label for="filter_type" style="margin-right: 5px; text-transform: uppercase">Filter Prefix</label>

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

    <div style="border: 1px solid #eee; margin-top: 10px; padding: 5px;">
        <div class="controller has-text-centered">
            <input class="input" placeholder="Namespace (optional)" @keydown.enter.prevent="hideActive()"/>
            <div style="margin-top: 5px">
                <input class="input" placeholder="Add Controller" @keydown.enter.prevent="AddController()"/>
            </div>
        </div>
    </div>
</div>