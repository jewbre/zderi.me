<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 14.12.2014.
 * Time: 17:43
 */

class HostV {
    public function displayView(){
        ?>

        <link href="css/host.css" rel="stylesheet" type="text/css" />
        <script src="js/host.js" type="text/javascript"></script>
        <div ng-app="hostApp" ng-controller="hostCtrl" class="mainHolder">

            <div class="menu">
                <div class="menuItem" ng-click="toggleFunc(1)">
                    Item1
                </div>
                <div class="menuItem" ng-click="toggleFunc(2)">
                    Item2
                </div>
                <div class="menuItem" ng-click="toggleFunc(3)">
                    Item3
                </div>
            </div>

            <div class="mainContent">
                <div class="functionalityWindow func1">
                    func1
                </div>
                <div class="functionalityWindow func2">
                    func2
                </div>
                <div class="functionalityWindow func3">
                    func3
                </div>
            </div>
        </div>





<?php
    }
} 