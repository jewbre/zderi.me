<?php
session_start();
?>
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
include_once "View/UserV.php";
include_once "View/SupplierV.php"

?>
</body>
    <div class="topLine">
        CMS for Zderi.me
    </div>
    <div class="separateLine">
        <a href="./" class="menu-item">
            Home
        </a>
        <a href="./profile.php" class="menu-item">
            Profile
        </a>
        <?php if($_SESSION["userType"]>1) {?>
            <a href="cms.php" class="menu-item">
                CMS
            </a>
        <?php } ?>
    </div>

<?php
    switch(intval($_SESSION["userType"]) ) {
        case 1:
        case 2:
        case 3:
        case 4:
            $user = new UserV();
            $user->displayView();
            break;

        default: ?>
            <script>window.location.href="index.php?page=login"</script>
    <?php
    }


?>
</html>