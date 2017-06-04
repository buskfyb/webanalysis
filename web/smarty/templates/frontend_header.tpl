 <!DOCTYPE html>
<html>
<head>
<title>Bibliotekindeks</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    {* loading jquerty *}
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>

    {* loading bootstrap *}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    {* loading datatables *}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.0.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/responsive/2.0.1/js/dataTables.responsive.min.js"></script>

    {* loading local javascript*}
    <script src="/js/frontend.js"></script>

   
    {* loading stylesheet for frontend application *}
    <link rel="stylesheet" href="/styles_frontend.css">

    {* loading chart library *}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 
    {* loading font library *}
    <script src="https://use.typekit.net/bov1tzo.js"></script>
    <script>{literal}try{Typekit.load({ async: true });}catch(e){}{/literal}</script>
    
    {* favicons *}
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/manifest.json">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">

{* Initialization for this library *}
<script>
var start_site_id = {$start_site_id};
var start_site_name = '{$start_site_name}';

// global variables
var period_type = '{$period_type}';
var year = {$currentYear};
var field = 'average'; // field is a global variable PMB 2017-06-04
var sitesInGraph = []; // holder of siteids
var period = {$period};

</script>

{if $tracking == 1}
{include file="frontend_tracking.tpl"}
{/if}

</head>

<body>
    {* outer container *}    
<header>
    <div class="container-fluid">
 		<h1><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>  {if $development == 1}DEVELOPMENT - {/if}Norsk bibliotekindeks</h1>
 		<h4>– Nettsidestatistikk fra norske bibliotek</h4>   
    </div>
</header>
<div class="container-fluid content">
    
 
