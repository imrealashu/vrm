<div class="columns">
    <div class="column">
        <div class="tabs is-boxed">
            <ul>
                @if($middlewares_group_id == 1)
                    <li>
                        <a class="is-disabled"></a>
                    </li>
                @endif
                <li class="@if ($middlewares_group_id == 1) is-active @endif">
                    <a href="/vrm/?controller_id={{ $controller_id }}&middlewares_group_id=1">WEB</a>
                </li>
                <li class="@if ($middlewares_group_id == 2) is-active @endif">
                    <a href="/vrm/?controller_id={{ $controller_id }}&middlewares_group_id=2">API</a>
                </li>
            </ul>
        </div>

        <div class="is-pulled-right" style="margin-top: -60px;">
            <p class="control">
                <input class="input" style="width: 300px;" placeholder="Search routes by name, controller, action etc"/>
            </p>
        </div>
    </div>
</div>
