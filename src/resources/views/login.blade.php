@extends('vrm::layouts.master')

@section('content')
    <div class="container">
        <div style="display: flex; justify-content: center; height: 100%;">
            <article class="message is-primary">
                <div class="message-header">
                    <h3 class="title is-3" style="padding: 5px; color: #FFFFFF">Login</h3>
                </div>
                <div class="message-body">
                    <form method="post">
                        {{ csrf_field() }}

                        <div class="control" style="margin-bottom: 15px;">
                            <label class="label">Password</label>
                            <p class="control has-icon has-icon-right">
                                <input class="input  @if (session()->has('message')) is-danger @endif" type="password"
                                       placeholder="********" name="password">
                                <span class="icon is-small">
                            <i class="fa fa-check"></i>
                        </span>
                                <span class="help is-danger">{{ session('message') }}</span>
                            </p>
                        </div>

                        <div class="control is-grouped">
                            <p class="control">
                                <button type="submit" class="button is-primary">Login</button>
                            </p>
                            <p class="command-info" style="font-size: 14px; line-height: 30px;">
                                <span>php artisan vrm:generate --password=&lt;PASSWORD&gt;</span>
                            </p>
                        </div>
                    </form>
                </div>
            </article>
        </div>
    </div>
@stop