<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Samanco') }}</title>

    <!-- Scripts -->
    <script type="text/javascript" src="{{asset('jeasyui/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/jquery.easyui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/jquery.edatagrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/datagrid-filter.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lodash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/jeasyui.customized.js')}}"></script>


    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/default/easyui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/color.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/demo/demo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dock.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/application.custom.css')}}">

</head>
<body>

    {{-- Dashboard Layout --}}
    <div class="easyui-layout" fit="true">

        {{-- South panel of dashboard --}}
        <div data-options="region:'south', border:false, height:'57px'">

            {{-- space for dock panel --}}

        </div>
        {{-- /South panel of dashboard --}}



        {{-- Center panel of dashboard --}}
        <div data-options="region:'center'" style="border-left:0;border-right:0;border-top:0;">

            <div class="easyui-tabs" id="MainPanelTab" fit="true" showHeader="false"
                data-options="border:false,showHeader:false, onSelect:loadContentToTab">

                @yield('content')

                @for ($i=1; $i < 12 ; $i++)
                    <div>{{$i}}</div>
                @endfor

            </div>


        </div>
        {{-- /Center panel of dashboard --}}



    </div>
    {{-- /Dashboard Layout --}}


    {{-- Dock Panel --}}
    <div id="dock-container">
     <div id="dock">
       <ul>
             <li><span>Home</span><a href="#" onclick="switchMainPanelTab(0)"><img src="/img/dock/home.svg" alt="home" /></a></li>

             <li><span>Manager Users</span><a href="#" onclick="switchMainPanelTab(1)"><img src="/img/dock/manage_users.svg" alt="Settings" /></a></li>


       </ul>
     </div>
    </div>
    {{-- /Dock Panel --}}


    <script>

        var loadContentsURL = [
            '',
            '/settings',
        ]

        function switchMainPanelTab(index) {
            $('#MainPanelTab').tabs('select', index);
        }

        function loadContentToTab(title,index) {
            if (loadContentsURL) {

                if(loadContentsURL[index] != ''){

                    var tabs = $('#MainPanelTab').tabs('tabs');

                    $('#MainPanelTab').tabs('update', {
                    tab: tabs[index],
                    options: {
                        href: loadContentsURL[index]
                    }
                });

                    loadContentsURL[index] = '';
                }
            }

        }

        // set header for ajax calls
        $(function(){

            const csrf_token = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
            });

            window.CSRF_TOKEN = csrf_token

        });


    </script>

    <style>
        .tabs-header-noborder{
            padding:0;
        }
    </style>

</body>
</html>
