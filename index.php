<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="css/design.css">

    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/jQuery.js"></script>
    <script type="text/javascript" src="js/jQueryCode.js"></script>

</head>
<body>

    <?php
        include_once "classes/RestaurantsList.php";
        include_once "classes/Header.php";
        include_once "resources/strings.php";
        include_once "resources/functions.php";
        include_once "View/RegistrationV.php";
        include_once "View/RestaurantsV.php";
        include_once "View/ReservationV.php";

        $header = new Header();
        $header->displayHeader();
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
            if(isSessionActive()) {
                switch($page) {
                    case "registration" :
                        $registration = new RegistrationV();
                        $registration->displayView();
                        break;
                    case "reservation" :
                        $reservation = new ReservationV();
                        $reservation->displayView();
                        break;
                    default :
                        $login = new Login();
                        $login->displayView();
                }
            } else {
                switch($page) {
                    case "registration" :
                        $registration = new RegistrationV();
                        $registration->displayView();
                        break;
                    case "reservation" :
                        $reservation = new ReservationV();
                        $reservation->displayView();
                        break;
                    case "login" :
                        $login = new Login();
                        $login->displayView();
                        break;
                    default :
                        $view = new RestaurantsV();
                        $view->displayList();
                }
            }
        } else {
            $view = new RestaurantsV();
            $view->displayList();
        }

    ?>


</body>


</html>