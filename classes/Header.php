<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 12.10.2014.
 * Time: 18:05
 */

class Header {
    function displayHeader() {
        ?>
        <div class="header"  >
            <div id="slider">
                <img src="resources/images/res1.jpg" class="sliderImage" id="sliderImage1">
                <img src="resources/images/res2.jpg" class="sliderImage" id="sliderImage2">
            </div>

            <div class="menu">
                <div class="menuItem">
                    Menu Item 1
                </div>
                <div class="menuItem">
                    Menu Item 2
                </div>
                <div class="menuItem">
                    Menu Item 3
                </div>
                <div class="menuItem">
                    Menu Item 4
                </div>
                <div class="menuItem" id="loginLink">
                    <a href="index.php?page=login">Log In</a>
                </div>

            </div>

        </div>

    <?php
    }
} 