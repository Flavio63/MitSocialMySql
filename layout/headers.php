<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
$page = filter_input(INPUT_GET, 'page');

if ($page !== 'showStream' && $page !== 'mySocialStream') {?>

    <head>
        <meta charset="UTF-8">
            <title>prova Flavio</title>
            <link href="css/layout.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
            <script type="text/javascript" src="utils/RetrieveIdNumber.js"></script>
    </head>
<?php } else { ?>
    <head>
        <meta charset="UTF-8">
            <title>prova Flavio</title>
            <link href="css/layout.css" rel="stylesheet" type="text/css" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Media Italia</title>
            <link rel="stylesheet" type="text/css" href="page/inc/layout.css" media="all" />
            <link rel="stylesheet" type="text/css" href="page/css/dcsns_wall.css" media="all" />
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
            <script type="text/javascript" src="page/inc/js/jquery.plugins.js"></script>
            <script type="text/javascript" src="page/inc/js/jquery.site.js"></script>
            <script type="text/javascript" src="page/js/jquery.social.stream.wall.1.3.js"></script>
            <script type="text/javascript" src="page/js/jquery.social.stream.1.5.4.js"></script>
            
            <script type="text/javascript" src="page/MITechnology/base.js"></script>
            <script type="text/javascript" src="page/MITechnology/SearchFacebookData.js"></script>
            <script type="text/javascript" src="page/MITechnology/SearchTwitterData.js"></script>
            <script type="text/javascript" src="page/MITechnology/SearchGoogleData.js"></script>
            <script type="text/javascript" src="page/MITechnology/SearchInstagramData.js"></script>
            <script type="text/javascript" src="page/MITechnology/drawTable.js"></script>
            <link rel="stylesheet" type="text/css" href="page/MITechnology/css/tableData.css" media="all"/>

            <style>
                #wall {padding: 10px 0 0; min-height: 2000px;}
            </style>

    </head>    

<?php } ?>
