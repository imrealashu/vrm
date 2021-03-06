<td id="designLayout">
    <pre @click="currentLayout = {status: false, name: ''}">
    <span class="route-segment">Route::</span>

    <span class="editable method-segment" :class="{'is-active': isActive('Method')}"
          @click.stop="setRouteData('Method')"
          v-text="designLayout.method"></span>
    <div class="info method" v-if="isActive('Method')">
        <p v-for="method in methodsList" v-text="method.toUpperCase()"
           @click.prevent="designLayout.method = method; hideActive()"></p>
    </div>

    <span>(</span>
    <span class="editable path-segment" :class="{'is-active': isActive('Prefix')}"
          @click.stop="setRouteData('Prefix')" v-text="getFullPath()"></span>
    <div class="info path" v-if="isActive('Prefix')">
        <p class="control has-addons">
            <span class="select" style="font-size: 14px;">
                <select @change.prevent="applyPrefix($event)" @click.stop>
                    <option :value="JSON.stringify({id: 0,name: 'None'})"
                            :selected="designLayout.prefix && designLayout.prefix.id == '0'">None</option>
                    <option :value="JSON.stringify(prefix)" v-for="prefix in prefixes"
                            :selected="designLayout.prefix && designLayout.prefix.id == prefix.id"
                            v-text="prefix.name"></option>
                </select>
            </span>
            <input type="text" class="input path-input" v-model="designLayout.path"
                   @keydown.enter.prevent="hideActive()" @click.stop/>
        </p>
    </div>

    <span>, [</span>
    <br/>
    <span class="as-segment">
                <span>"as"</span><span class="as-separator">=></span>
            </span>

    <span class="editable" :class="{'is-active': isActive('As')}"
          @click.stop="setRouteData('As')" v-text=`"${designLayout.as}"`></span>
    <div class="info as" v-if="isActive('As')">
        <input class="input" v-model="designLayout.as"
               @keydown.enter.prevent="hideActive()" placeholder="alias"/>
    </div>
    <span>,</span>
    <br/>

    <span class="uses-segment">
                <span>"uses"</span><span class="uses-separator">=></span>
            </span>
    <span>"</span>
    <span class="editable controller-segment" :class="{'is-active': isActive('Controller')}"
          @click.stop="setRouteData('Controller')" v-text="designLayout.controller.name"></span>
    <div class="info controller" v-if="isActive('Controller')">
        <p class="control has-addons">
            <span class="select" style="font-size: 14px;">
                <select @change.prevent="applyController($event)" @click.stop>
                    <option :value="JSON.stringify(controller)" v-for="controller in controllers"
                            :selected="designLayout.controller && designLayout.controller.id == controller.id"
                            v-text="controller.name"></option>
                </select>
            </span>
        </p>
    </div>

    <span style="color: #c71212;">@</span>

    <span class="editable" :class="{'is-active': isActive('Action')}"
          @click.stop="setRouteData('Action')" v-text="designLayout.action"></span>
    <div class="info action" v-if="isActive('Action')">
        <input class="input" placeholder="Action" v-model="designLayout.action"
               @keydown.enter.prevent="hideActive()"/>
    </div>
    <span>"</span>
    <br/>

    <span class="middlewares-segment">
                <span>"middlewares"</span><span class="middlewares-separator">=></span>
            </span>
    <span class="editable middlewares-array" :class="{'is-active': isActive('Middlewares')}"
          @click.stop="setRouteData('Middlewares')">@{{ getAppliedMiddlewares() }}</span>
    <div class="info middlewares" v-if="isActive('Middlewares')">
        <label class="checkbox" style="display: block; margin: 5px;" v-for="middleware in middlewares" @click.stop>
            <input type="checkbox" :checked="designLayout.middleware_ids.indexOf(middleware.id) > -1"
                   @change.prevent="applyMiddlewares($event, middleware)">
            <span v-text="middleware.name"></span>
        </label>
    </div>
    <br/>

    <span>])</span>
    </pre>
</td>