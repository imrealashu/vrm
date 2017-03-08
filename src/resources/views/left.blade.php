<div class="column is-3">
    <div style="border: 1px solid #eee; margin: 0px; padding: 0px;">
        <p class="has-text-centered" style="line-height: 30px; padding: 10px 0px 5px 0px">
            <label for="filter_type" style="margin-right: 5px; text-transform: uppercase">Filter Prefix</label>

            <span class="select">
            <select name="filter_type" id="">
                @foreach($prefixes as $data)
                    <option value="0">None</option>
                    <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                @endforeach
            </select>
        </span>
        </p>

        <div class="controller-wrapper">
            <div class="controller-list" :class="{'is-active' : {!! $controller_id !!} == controller.id}"
                 v-for="controller in controllers">
                <a :href="getLeftNavLink({!! $middlewares_group["id"] !!}, controller)">
                    @{{ controller.name }}
                </a>
            </div>
        </div>
    </div>

    <div style="border: 1px solid #eee; margin-top: 10px; padding: 5px;">
        <h1 class="title is-4"
            style="border-bottom: 1px solid rgb(238, 238, 238); padding: 5px 0px 10px 5px; margin-bottom: 10px;">
            Add Controller</h1>

        <div class="controller has-text-centered">
            <input class="input" placeholder="Namespace (optional)" v-model="credentials.controller.namespace"/>
            <div style="margin-top: 5px">
                <input class="input" placeholder="Add Controller" v-model="credentials.controller.name"
                       @keydown.enter.prevent="addController()"/>
            </div>
        </div>
    </div>
</div>