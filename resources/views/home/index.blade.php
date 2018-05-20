@extends('layouts.dashboard')
@section('content')
    <div title="Home">

        <div class="easyui-layout" fit="true">

            <div data-options="region:'west',border:false" style="width:200px;padding:20px;">

                <div>

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
                <h1 id="company-title">{{ env('SITE_TITLE') }}</h1>
            </div>


        </div>


    </div>
@endsection

<style>
    #company-title{
      font-size:80px;
      color:#9e91b9;
      text-align: center;
      position: absolute;
      top: 50%;
      left: 50%;
      margin-top: -100px;
      margin-left: -250px;
      width: 100px;
      height: 100px;
    }
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
