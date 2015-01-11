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
                <div class="align-left">
                    <a href="./" class="menuItem">
                        Home
                    </a>
                    <?php if(isSessionActive()){?>
                    <a href="cms.php" class="menuItem">
                        Profile
                    </a>
                    <?php } ?>
                    <a href="?page=contact" class="menuItem">
                        Contact
                    </a>
                </div>
                <div class="align-right">
                    <?php if(!isSessionActive()) {?>
                    <a href="?page=login" class="menuItem">
                        Sign in
                    </a>
                    <a href="?page=registration" class="menuItem">
                        Sign up
                    </a>
                    <?php } else { ?>
                    <a href="index.php?page=logout" class="menuItem">
                        Sign out
                    </a>
                    <?php }?>
                </div>
            </div>

        </div>

    <?php
    }
} 