<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 6.1.2015.
 * Time: 21:59
 */
class SupplierV {

    public function displayView() {
        ?>
        <link href="css/admin.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>
        <script src="js/supplier.js" type="text/javascript"></script>
        <div ng-app="supplierApp" ng-controller="supplierCtrl" class="mainHolder">

            <div class="menu">
                <div class="menuItem" ng-click="toggleFunc(1)">Ingredients</div>
                <div class="menuItem" ng-click="toggleFunc(2)">Orders</div>
            </div>

            <div class="mainContent">
                <!-- Ingredients Functionality -->
                <div class="func1 functionalityWindow">
                    <div class="addIngredient" ng-hide="show">
                        <label>Ingredient</label>
                        <select ng-options="ingredient.name for ingredient in ingredients" ng-model="ingredient">
                            <option value="" disabled>-- Select ingredient --</option>
                        </select>
                        <br>
                        <label>Price</label>
                        <input type="number" min="1" ng-model="ingredientPrice"/>
                        <select ng-model="ingredientUnit">
                            <option value="g">g</option>
                            <option value="kg">kg</option>
                            <option value="l">l</option>
                            <option value="dcl">dcl</option>
                            <option value="kom">kom</option>
                        </select>
                        <br>
                        <button ng-click="addIngredient()">Add</button>
                    </div>
                    <div class="editInput" ng-show="show">
                        <h4>{{ingredient.name}}</h4>
                        <p>{{ingredient.fullPrice}}</p>
                        <input type="number" ng-model="ingredientPrice" placeholder="New Price" />
                        <select ng-model="ingredientUnit">
                            <option value="g" selected>g</option>
                            <option value="kg">kg</option>
                            <option value="l">l</option>
                            <option value="dcl">dcl</option>
                            <option value="kom">kom</option>
                        </select>
                        <br>
                        <button ng-click="updateIngredient(this)">Update</button>
                        <button ng-click="cancelEdit()">Cancel</button>
                    </div>
                    <hr>

                    <div class="showIngredients">
                        <input type="text" ng-model="ingredientFilter" placeholder="Filter"><br>
                        <div ng-repeat="supplierIngredient in supplierIngredients | filter:ingredientFilter" class="ingredient">
                            <h3>{{supplierIngredient.name}}</h3>
                            <p>{{supplierIngredient.fullPrice}}</p>
                            <button ng-click="removeIngredient(this)">Delete</button>
                            <button ng-click="editIngredient(this)">Edit</button>
                            <br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

}