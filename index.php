<!DOCTYPE html ng-app>

<head>
    <link rel="stylesheet" type="text/css" href="css/design.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">

    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/jQuery.js"></script>
    <script type="text/javascript" src="js/angulasApp.js"></script>
    <script type="text/javascript" src="js/jQueryCode.js"></script>

</head>
<body>

    <?php
        include_once "classes/RestaurantsList.php";
        include_once "classes/Header.php";
        include_once "resources/strings.php";
        include_once "resources/functions.php";
        include_once "View/RegistrationV.php";

        $header = new Header();
        $header->displayHeader();
        if(isset($_GET['page'])) {
            echo isSessionActive();
            if(isSessionActive()) {
                $page = $_GET['page'];

                if ($page == "registration") {
                    $registration = new RegistrationV();
                    $registration->displayView();
                } else if ($page == "login") {
                    $login = new Login();
                    $login->displayView();
                } else {
                    $view = new RestaurantsList();
                    $view->displayList();
                }
            } else {
                if($_GET['page']=="registration") {
                    $registration = new RegistrationV();
                    $registration->displayView();
                } else {
                    $login = new Login();
                    $login->displayView();

                }
                // ..index.php?page=login&redirect=SITEkOJIjEhTIO
                // header("Location: ../index.php?page=login&errorNmbr=1&redirect=
            }
        } else {
            $view = new RestaurantsList();
            $view->displayList();
        }

    ?>


</body>


</html>