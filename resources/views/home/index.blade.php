@extends('layouts.dashboard')
@section('content')
    <div title="Home">

        <div class="easyui-layout" fit="true">

            <div data-options="region:'north'" style="height:30%;padding:20px;border-top:0;border-left:0;border-bottom: 0;">

                <div style="width:200px;">

                    <label class="username-label">
                             {{ucfirst(Auth::user()->name)}}
                    </label>

                    <a href="{{ url('/logout') }}"
                        class="easyui-linkbutton c6"
                        style="margin-bottom:10px;"
                        data-options="size:'large',width:'100%'">
                        Logout
                    </a>

                    <a href="{{ url('/chgpwd') }}"
                        class="easyui-linkbutton c5"
                        data-options="size:'large',width:'100%'">
                        Change Password
                    </a>

                </div>


            </div>

            <div data-options="region:'center',border:false" id="home-center-panel">

                <h1 style="font-size:80px;color:mediumseagreen;text-align: center;">Saman Company</h1>
            </div>


        </div>


    </div>
@endsection

<style>
    .username-label {
        font-weight:normal;
        padding: 5px;
        border: 1px solid #eee;
        font-size:12px;
        margin-bottom:10px;
        display:block;
        text-align:center;
    }
</style>