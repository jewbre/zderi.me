<?php
/**
 * Created by PhpStorm.
 * User: OJ
 * Date: 22-Oct-14
 * Time: 4:07 PM
 */

class Login {
    function displayView(){
        ?>
        <div class="formHolder">
            <form action="php/login.php" method="POST" enctype="multipart/form-data" onsubmit="">
                <label class="inputLabel"><?=USERNAME?></label>
                <input type="text" name="username" id="username" class="textInput" placeholder="<?=USERNAME?>"/>
                <label class="inputLabel"><?=USERNAME?></label>
                <input type="password" name="password" id="password" class="textInput" placeholder="<?=PASSWORD?>"/>
                <br>
                <button id="submit" class="submitBtn"><?=SUBMIT?></button>
            </form>
            <br>
            Log in or <a href="index.php?page=login">register here</a>!
        </div>
    <?php
    }
}
?>