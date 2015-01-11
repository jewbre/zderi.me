<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 11.1.2015.
 * Time: 2:40
 */

class ContactV {

    public function displayView(){
        ?>
        <script src="js/contact.js"></script>
        <link href="css/contact.css" rel="stylesheet" type="text/css" />

            <div ng-app="contactApp" ng-controller="contactCtrl" class="contactHolder">
                <h2>Contact us</h2>
                <hr>
                <p>{{output}}</p>
                <input type="email" ng-model="email" placeholder="Email" />
                <input type="text" ng-model="subject" placeholder="Subject"/>
                <textarea ng-model="message" placeholder="Message"></textarea>
                <br>
                <button class="saveBtn" ng-click="sendMessage()">Send message</button>
            </div>
        <?php
    }
} 