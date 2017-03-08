<tr v-if="designLayout.id != {!! $route->id !!}">
    <td>
        <div style="position: absolute; right: 0px">
            <div><a href="javascript:void(0)" @click.prevent="editRoute({{$route}})">edit</a></div>
            <div><a href="javascript:void(0)" @click.prevent="deleteRoute({{$route}})">delete</a></div>
        </div>

        <pre>
            <span class="route-segment">Route::</span>

            <span class="method-segment">{{$route->method}}</span>

            <span>(</span>

            <span class="path-segment">
                "{{$middlewares_group->prefix ? $middlewares_group->prefix . '/' : ''}}{{$route->full_path}}"
            </span>

            <span>, [</span>
            <br/>
            <span class="as-segment">
                <span>"as"</span><span class="as-separator">=></span>
            </span>

            <span>"{{$route->as}}"</span>
            <span>,</span>
            <br/>

            <span class="uses-segment">
                <span>"uses"</span><span class="uses-separator">=></span>
            </span>
            <span>"</span>
            <span>{{$route->controller->name}}</span>

            <span style="color: #c71212;">@</span>

            <span>{{$route->action}}</span>
            <span>"</span>
            <br/>

            <span class="middlewares-segment">
                <span>"middlewares"</span><span class="middlewares-separator">=></span>
            </span>
            <span class="middlewares-array">{{$route->middlewares->pluck('name')}}</span>
            <br/>

            <span>])</span>
            </pre>
    </td>
</tr>