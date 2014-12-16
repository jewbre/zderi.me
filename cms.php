<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="css/cms.css">

    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/jQuery.js"></script>
    <script type="text/javascript" src="js/jQueryCode.js"></script>

</head>
<body>

<?php
include_once "resources/strings.php";
include_once "resources/functions.php";
include_once "View/HostV.php";
include_once "View/AdminV.php";

?>
</body>
    <div class="topLine">
        CMS for Zderi.me
    </div>
    <div class="separateLine"></div>

<?php
    // ovo ce inace citati iz sessiona nakon logina...
    // sve ovakve hardkodirane stvari su jer nemam jos login...xD
    // btw: 1 = user (to zanemari, to se treba redirectati na home)
    //      2 = host
    //      3 = supplier
    //      4 = admin
    $userType =2;

    switch($userType) {
        case 2:
            $host = new HostV();
            $host->displayView();
            break;


        case 4:
            $admin = new AdminV();
            $admin->displayView();
            break;

        default: ?>
            <script>window.location.href="index.php"</script>
    <?php
    }


?>
</html>