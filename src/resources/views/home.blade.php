@extends('vrm::layouts.master')

@section('content')
    <div class="home-wrapper" id="home">
        <div class="container" style="margin-top: 30px">
            @include("vrm::top")
        </div>

        <div class="columns">
            @include('vrm::left')

            <div class="column is-9">
                <div class="columns" style="border: 1px solid #eee; margin: 0px; border-bottom: none;">
                    <div class="column">
                        <div class="columns">
                            <div v-if="show_design_layout" class="column is-5">
                                <button class="button is-danger" :class="{'is-disable': loading}" @click="cancelAddRoute
                                ">Cancel</button>
                                <button class="button is-success" :class="{'is-loading': loading}" @click="addRoute">
                                Save</button>
                            </div>
                            <div class="column" v-if="showRouteData()">
                                <input class="input column" type="text"
                                       :placeholder="'ADD ' + currentLayout.name.toUpperCase()"
                                       @keydown.enter.prevent="addRouteData"/>
                            </div>
                        </div>
                    </div>
                    <div class="column has-text-right">
                        <button class="button is-primary" @click="show_design_layout=true" v-if="!show_design_layout">
                        Add Route
                        </button>
                    </div>
                </div>

                <table class="table is-bordered">
                    <tr class="design-layout" v-if="show_design_layout">
                        @include('vrm::design')
                    </tr>

                    @foreach($routes as $route)
                        @include('vrm::routes')
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop

@section("script")
    <script>
        var home = new Vue({
            el: "#home",
            created(){
                this.middlewares = {!! $middlewares !!};
                this.controllers = {!! $controllers !!};
                this.prefixes = {!! $prefixes !!};

                this.designLayout.controller = {!! $controllers[0] !!};
            },
            data(){
                return {
                    loading: false,
                    show_design_layout: false,
                    currentLayout: {
                        status: false,
                        name: ''
                    },
                    methodsList: ['get', 'post', 'put', 'patch', 'delete'],
                    controllers: [],
                    middlewares: [],
                    prefixes: [],
                    designLayout: {
                        method: 'get',
                        path: 'demo',
                        action: 'demo',
                        as: 'demo',
                        prefix: {},
                        controller: {},
                        middlewares_group_id: {!! $middlewares_group_id !!},
                        middleware_ids: [],
                        middleware_names: []
                    }
                }
            },
            methods: {
                isActive(data){
                    return this.currentLayout.name == data;
                },

                hideActive(){
                    this.currentLayout.name = "";
                    this.currentLayout.status = false;
                },

                showRouteData(){
                    if (this.currentLayout.name.length) {
                        return (['Middlewares', 'Prefix'].indexOf(this.currentLayout.name) > -1) ? true : false;
                    }

                    return false;
                },

                setRouteData(data){
                    var isCurrentLayoutActive = (this.currentLayout.name == data);
                    this.currentLayout.name = isCurrentLayoutActive ? "" : data;
                    this.currentLayout.status = !!isCurrentLayoutActive;
                },

                cancelAddRoute(){
                    this.show_design_layout = false;
                    this.currentLayout.id = null;
                },

                deleteRoute(route){
                    axios.post('/vrm/delete', {id: route.id}).then((response) => {
                        this.loading = false;
//                        location.reload();
                    }).catch(function (error) {
                        this.loading = false;
                    });
                },

                editRoute(route){
                    this.designLayout.id = route.id;
                    this.designLayout.prefix = route.prefix;
                    this.designLayout.path = route.path;
                    this.designLayout.as = route.as;
                    this.designLayout.controller = route.controller;
                    this.designLayout.action = route.action;
                    this.designLayout.method = route.method;
                    this.designLayout.middlewares_group_id = route.middlewares_group_id;

                    route.middlewares.forEach(middleware => {
                        this.designLayout.middleware_ids.push(middleware.id);
                        this.designLayout.middleware_names.push(middleware.name);
                    });

                    this.show_design_layout = true;
                },

                addRoute(){
                    this.loading = true;

                    axios.post('/vrm/create', this.designLayout).then((response) => {
                        this.loading = false;
//                        window.location = `/vrm/?middlewares_group_id=${this.designLayout.middlewares_group_id}&controller_id=${this.designLayout.controller.id}`;
                    }).catch(function (error) {
                        this.loading = false;
                    });
                },

                addRouteData(e){
                    var type = this.currentLayout.name;
                    var value = e.target.value;
                    if (!value.length) return;

                    var data = {
                        "Prefix": this.prefixes,
                        "Controller": this.controllers,
                        "Middlewares": this.middlewares
                    }

                    axios.post('/vrm/route-data/add', {type: type, value: value}).then((response) => {
                        e.target.value = '';

                        data[type].push(response.data.result);
                    });
                },

                getFullPath(){
                    var ds = (this.designLayout.path.length) ? "/" : "";
                    var path = (this.designLayout.prefix && this.designLayout.prefix.id > 0)
                        ? this.designLayout.prefix.name + ds + this.designLayout.path
                        : this.designLayout.path;

                    return `"${path}"`;
                },

                applyPrefix(e){
                    var prefix = JSON.parse(e.target.value);

                    this.designLayout.prefix = {
                        id: prefix.id,
                        name: prefix.name
                    }
                },

                applyController(e){
                    var controller = JSON.parse(e.target.value);

                    this.designLayout.controller = {
                        id: controller.id,
                        name: controller.name
                    }

                    this.hideActive();
                },

                applyMiddlewares(e, middleware){
                    var middleware_ids = this.designLayout.middleware_ids;
                    var middleware_names = this.designLayout.middleware_names;
                    if (e.target.checked) {
                        middleware_ids.push(middleware.id);
                        middleware_names.push(middleware.name);
                    } else {
                        middleware_ids.splice(middleware_ids.indexOf(middleware.id), 1);
                        middleware_names.splice(middleware_names.indexOf(middleware.name), 1);
                    }
                },

                getAppliedMiddlewares(){
                    var array = this.designLayout.middleware_names;
                    if (!array.length) return [];

                    return '["' + array.join('","') + '"]';
                }
            }
        })
    </script>
@stop