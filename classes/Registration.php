<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 21.10.2014.
 * Time: 20:19
 */

class Registration {

    function displayView (){
        ?>
        <div class="formHolder">
            <form action="php/registration.php" method="POST" enctype="multipart/form-data" >
                <label class="inputLabel"><?=USERNAME?></label>
                <input type="text" name="username" id="username" class="textInput" placeholder="<?=USERNAME?>"/>
                <div id="usernameErrorOutput" class="errorOutput"></div>
                <br>
                <?php ?>


                <label class="inputLabel"><?=PASSWORD?></label>
                <input type="password" name="password" id="password" class="textInput" placeholder="<?=PASSWORD?>"/>
                <br>
                <label class="inputLabel"><?=REPEAT_PASSWORD?></label>
                <input type="password" id="repeatPassword" name="repeatPassword" class="textInput" placeholder="<?=REPEAT_PASSWORD?>"/>
                <div id="passwordErrorOutput" class="errorOutput"></div>
                <br>
                <label class="inputLabel"><?=EMAIL?></label>
                <input type="text" id="email" name="email" class="textInput" placeholder="<?=EMAIL?>"/>
                <div id="emailErrorOutput" class="errorOutput"></div>
                <br>
                <label class="inputLabel"><?=NAME?></label>
                <input type="text" id="name" name="name" class="textInput" placeholder="<?=NAME?>"/>
                <div id="nameErrorOutput" class="errorOutput"></div>
                <br>
                <label class="inputLabel"><?=LAST_NAME?></label>
                <input type="text" id="lastname" name="lastname" class="textInput" placeholder="<?=LAST_NAME?>"/>
                <div id="lastnameErrorOutput" class="errorOutput"></div>
                <br>

                <br>
                <button id="submit" class="submitBtn"><?=SUBMIT?></button>
            </form>
        </div>
        <script>
            setupListeners();</script>

<?php

    }
} 