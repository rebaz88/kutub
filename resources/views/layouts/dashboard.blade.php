<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Samanco') }}</title>

    <!-- Scripts -->
    <!-- include libraries(jQuery, bootstrap) -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>

    <!-- include summernote css/js -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/summernote.css')}}">
    <script type="text/javascript" src="{{asset('js/summernote.js')}}"></script>

    {{-- <script type="text/javascript" src="{{asset('jeasyui/jquery.min.js')}}"></script> --}}
    <script type="text/javascript" src="{{asset('jeasyui/jquery.easyui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/jquery.edatagrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/datagrid-filter.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/jeasyui-texteditor/texteditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lodash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/jeasyui.customized.js')}}"></script>


    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/default/easyui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/color.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/demo/demo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/jeasyui-texteditor/texteditor.css')}}">
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

            <div class="easyui-tabs" id="DashboardMainTab"
                data-options="fit:true,border:false,showHeader:false">

                @yield('content')

            </div>


        </div>
        {{-- /Center panel of dashboard --}}



    </div>
    {{-- /Dashboard Layout --}}


    {{-- Dock Panel --}}
    <div id="dock-container">
     <div id="dock">
       <ul>

             <li><span>Home</span><a href="#" onclick="switchDashboardMainTab('Home', '')"><img src="/img/dock/home.svg" alt="home" /></a></li>
             <li><span>Books</span><a href="#" onclick="switchDashboardMainTab('Books', '/books')"><img src="/img/dock/books.svg" alt="Books" /></a></li>
             <li><span>Videos</span><a href="#" onclick="switchDashboardMainTab('Videos', '/videos')"><img src="/img/dock/videos.svg" alt="Videos" /></a></li>
             <li><span>Manager Users</span><a href="#" onclick="switchDashboardMainTab('Manage Users', '/users')"><img src="/img/dock/manage_users.svg" alt="Settings" /></a></li>

       </ul>
     </div>
    </div>
    {{-- /Dock Panel --}}


    <script>

        function switchDashboardMainTab(title, url) {

            var tabExists = $('#DashboardMainTab').tabs('exists', title);

            if(tabExists){

                $('#DashboardMainTab').tabs('select', title);

            } else {

                // add a new tab panel
                $('#DashboardMainTab').tabs('add',{
                    title: title,
                    href: url,
                });

            }

            return

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
