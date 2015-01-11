<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/design.css">

    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/jQuery.js"></script>
    <script type="text/javascript" src="js/jQueryCode.js"></script>

</head>
<body>

    <?php
        include_once "classes/Header.php";
        include_once "resources/strings.php";
        include_once "resources/functions.php";
        include_once "View/RegistrationV.php";
        include_once "View/RestaurantsV.php";
        include_once "View/ReservationV.php";
        include_once "View/LoginV.php";
        include_once "View/ContactV.php";

        $header = new Header();
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
            if(isSessionActive()) {
                switch($page) {
                    case "registration" :
                        $registration = new RegistrationV();
                        $header->displayHeader();
                        $registration->displayView();
                        break;
                    case "reservation" :
                        $reservation = new ReservationV();
                        $header->displayHeader();
                        $reservation->displayView();
                        break;
                    case "logout" :
                        session_destroy();
                        header("Location: ./");
                        break;
                    case "contact" :
                        $contact = new ContactV();
                        $header->displayHeader();
                        $contact->displayView();
                        break;
                    default :
                        $login = new LoginV();
                        $header->displayHeader();
                        $login->displayView();
                }
            } else {
                switch($page) {
                    case "registration" :
                        $registration = new RegistrationV();
                        $header->displayHeader();
                        $registration->displayView();
                        break;

                    // ne moze
                    case "reservation" :
                    case "login" :
                        $login = new LoginV();
                        $header->displayHeader();
                        $login->displayView();
                        break;
                    case "contact" :
                        $contact = new ContactV();
                        $header->displayHeader();
                        $contact->displayView();
                        break;
                    default :
                        $view = new RestaurantsV();
                        $header->displayHeader();
                        $view->displayList();
                }
            }
        } else {
            $view = new RestaurantsV();
            $header->displayHeader();
            $view->displayList();
        }

    ?>


</body>


</html>