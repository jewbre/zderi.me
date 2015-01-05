<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 4.1.2015.
 * Time: 19:39
 */
class UserV {

    public function displayView() {
        ?>

        <script src="js/user.js" type="text/javascript"></script>
        <div ng-app="userApp" ng-controller="userCtrl" class="mainHolder">
            <div class="mainContent">
                <div class="editUser">
                    <h3>Settings</h3>

                    <p ng-bind="error"></p>
                    <br>

                    <label>Name</label>
                    <input type="text" ng-model="userData.name" />
                    <br>

                    <label>Lastname</label>
                    <input type="text" ng-model="userData.lastName" />
                    <br>

                    <label>Password</label>
                    <input type="password" ng-model="userData.password" />
                    <br>

                    <label>Contact</label>
                    <input type="text" ng-model="userData.contact" />
                    <br>

                    <label>Credit card</label>
                    <input type="text" ng-model="userData.creditCard" />
                    <br>
                    <br>
                    <input type="password" ng-model="oldPassword" placeholder="Old password to confirm changes."/>
                    <button class="saveBtn" ng-click="saveUserChanges()">Save</button>
                </div>

            </div>

        </div>

    <?php
    }
}