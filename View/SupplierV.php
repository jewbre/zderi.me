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
        <link href="css/supplier.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>
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
                        <label>Quantity</label>
                        <input type="number" min="1" ng-model="ingredientPrice"/>
                        <select ng-model="ingredientUnit">
                            <option value="g">g</option>
                            <option value="kg">kg</option>
                            <option value="l">l</option>
                            <option value="dcl">dcl</option>
                            <option value="kom">kom</option>
                        </select>
                        <br>
                        <button class="saveBtn" ng-click="addIngredient()">Add</button>
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
                        <button class="saveBtn" ng-click="updateIngredient(this)">Update</button>
                        <button class="cancelBtn" ng-click="cancelEdit()">Cancel</button>
                    </div>
                    <hr>

                    <div class="showIngredients">
                        <input type="text" ng-model="ingredientFilter" placeholder="Filter"><br>
                        <div ng-repeat="supplierIngredient in supplierIngredients | filter:ingredientFilter" class="ingredient">
                            <h3>{{supplierIngredient.name}}</h3>
                            <p>{{supplierIngredient.fullPrice}}</p>
                            <button class="cancelBtn" ng-click="removeIngredient(this)">Delete</button>
                            <button class="editBtn" ng-click="editIngredient(this)">Edit</button>
                            <br>

                        </div>
                    </div>
                </div>
                <div class="func2 functionalityWindow">
                    <h2>Orders</h2>
                    <table class="ordersTable">
                        <tr>
                            <th>
                                Supplier
                            </th>
                            <th>
                                Restaurant
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Order Items
                            </th>
                            <th>
                                Total price
                            </th>
                            <th></th>
                        </tr>
                        <tr ng-repeat="order in orders">
                            <td>
                                {{order.name}}
                            </td>
                            <td>
                                {{order.address}}
                            </td>
                            <td>
                                {{order.date}}
                            </td>
                            <td>
                                {{order.status}}
                            </td>
                            <td>
                                <div ng-repeat="ingredient in order.ingredients">
                                    {{ingredient.ingredientName}} :
                                    {{ingredient.ingredientAmount}} {{ingredient.ingredientUnit}}
                                </div>
                            </td>
                            <td>
                                {{order.totalPrice}} kn
                            </td>
                            <td>
                                <img src="resources/images/confirm.png" ng-click="acceptOrder(order)" />
                                <img src="resources/images/delete.png" ng-click="declineOrder(order)" />
                            </td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

}