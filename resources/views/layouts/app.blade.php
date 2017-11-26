<!doctype html>

<html lang="{{app()->getLocale()}}" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
  <head>

    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <title>@yield('title', 'SMAG - Sociétés des médecins annestesistes genevois')</title>
    <meta name="description" content="@yield('description', '')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    @if (!Auth::guest() && Auth::user()->isAdmin())
      <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
      <link rel="stylesheet" href="{{url('css/admin.css')}}">
    @else
      <link rel="stylesheet" href="{{url('css/app.css')}}">
    @endif

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/images/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('/images/favicon/manifest.json')}}">
    <link rel="mask-icon" href="{{url('/images/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
    <link rel="shortcut icon" href="{{url('/images/favicon/favicon.ico')}}">
    <meta name="msapplication-config" content="{{url('/images/favicon/browserconfig.xml')}}">
    <meta name="theme-color" content="#ffffff">

    @stack('head')

  </head>

  <body class="@stack('body-class') @if(!Auth::guest()  && Auth::user()->isAdmin())admin @endif">

    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="clearfix">

      <div class="left">
        @foreach (App\Page::staticBlocks() as $i => $block)
          @if ($i == 0 || Auth::check())
          <div data-block-id="{{$block->id}}" __data-model="{{$block}}" __data-model-id="{{$block->block_id}}">
            @include($block->view, ['pageBlock' => $block, 'block' => $block->block, 'members' => $i != 0])
          </div>
          @endif
        @endforeach
      </div>

      <div class="right">
        <div class="top">
          <h1>SMAG</h1>
          <div class="sub">
            Société des médecins anesthésistes genevois
          </div>
        </div>
        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <div class="body">@yield('content')</div>

        <div class="footer"><div>SMAG - Société des Médecins Anesthésistes Genevois - <a href="mailto:contact@smagonline.ch">contact@smagonline.ch</a> - Dernière mise à jour le 6 February 2017 - Visiteurs 347110</div></div>
      <div>


    </div>

   <!--  <div class="breakpoint debug">
      <div class="visible-xs-block">Extra small</div>
      <div class="visible-sm-block">Small</div>
      <div class="visible-md-block">Medium</div>
      <div class="visible-lg-block">Large</div>
    </div> -->

    @if (!Auth::guest() && Auth::user()->isAdmin())
      @include('admin.menu-top')
    @endif

    <script>
        window.basepath = "{{url('/')}}"
    </script>

    <script src="{{url('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{url('bower_components/lodash/dist/lodash.min.js')}}"></script>
    <script src="{{url('bower_components/autosize/dist/autosize.min.js')}}"></script>
    <script src="{{url('bower_components/bootstrap-sass/assets/javascripts/bootstrap/transition.js')}}"></script>
    <script src="{{url('bower_components/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js')}}"></script>
    <script src="{{url('bower_components/bootstrap-sass/assets/javascripts/bootstrap/alert.js')}}"></script>
    <script src="{{url('bower_components/bootstrap-sass/assets/javascripts/bootstrap/collapse.js')}}"></script>
    <!-- <script src="{{url('js/semantic-ui-sass/app/assets/javascripts/semantic-ui.js')}}"></script> -->
    <script src="{{url('bower_components/bootstrap-validator/dist/validator.min.js')}}"></script>
    <script src="{{url('bower_components/tinymce/tinymce.min.js')}}"></script>
    <script src="{{url('js/rte.js')}}"></script>
    <script src="{{url('js/utils.js')}}"></script>
    <script src="{{url('bower_components/bootstrap-sass/assets/javascripts/bootstrap/modal.js')}}"></script>
    <script src="{{url('js/modal.js')}}"></script>
    <script src="{{url('js/form.js')}}"></script>
    <script src="{{url('js/app.js')}}"></script>
    <!-- <script src="{{url('js/bundle.js')}}"></script> -->

    @if (!Auth::guest() && Auth::user()->isAdmin())
    <script src="{{url('bower_components/datetimepicker/build/jquery.datetimepicker.full.min.js')}}"></script>
    <!-- <script src="{{url('bower_components/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js')}}"></script> -->
    <!-- <script src="{{url('bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js')}}"></script> -->
    <!-- <script src="{{url('bower_components/bootstrap-validator/dist/validator.min.js')}}"></script> -->
    <script src="{{url('bower_components/jquery-ui-sortable/jquery-ui-sortable.min.js')}}"></script>
    <!-- <script src="//cloud.tinymce.com/stable/tinymce.min.js"></script> -->
    <script src="{{url('js/admin.js')}}"></script>
    @endif

    @stack('scripts')

    {{-- @include('common.googleanalytics', array('id' => 'UA-XXXXX-X')) --}}

  </body>
</html>
