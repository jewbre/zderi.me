<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 12:24
 */

class AdminV {

    public function displayView() {
        ?>
        <link href="css/admin.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>
        <script src="js/admin.js" type="text/javascript"></script>
        <div ng-app="adminApp" ng-controller="adminCtrl" class="mainHolder">

            <div class="menu">
                <div class="menuItem" ng-click="toggleFunc(1)">
            Users
                </div>
                <div class="menuItem" ng-click="toggleFunc(2)">
            Ingredients
                </div>
                <div class="menuItem" ng-click="toggleFunc(3)">
            Category
                </div>
            </div>

            <div class="mainContent">
                <!-- First functionality : Users -->
                <div class="functionalityWindow func1">
                    <div class="editUser">
                        <h3>Edit user</h3>
                        <label>Name</label>
                        <input type="text" ng-model="editedUser.name" />
                        <br>

                        <label>Lastname</label>
                        <input type="text" ng-model="editedUser.lastName" />
                        <br>

                        <label>Password</label>
                        <input type="password" ng-model="editedUser.password" />
                        <br>

                        <label>Contact</label>
                        <input type="text" ng-model="editedUser.contact" />
                        <br>

                        <label>Credit card</label>
                        <input type="text" ng-model="editedUser.creditCard" />
                        <br>

                        <label>Privilege</label><br>
                        <input type="radio" ng-model="editedUser.privilege" value="1"/> User <br>
                        <input type="radio" ng-model="editedUser.privilege" value="2"/> Host <br>
                        <input type="radio" ng-model="editedUser.privilege" value="3"/> Supplier <br>
                        <input type="radio" ng-model="editedUser.privilege" value="4"/> Admin <br>
                        <br>
                        <button class="saveBtn" ng-click="saveUserChanges()">Save</button>
                        <button class="cancelBtn" ng-click="toggleShow(2)">Cancel</button>
                    </div>

                    <div class="usersHolder">
                        <input type="text" ng-model="userFilter" placeholder="Quick search"/><br>
                        <div ng-repeat="user in users | filter:userFilter" class="user">
                            <h3>{{ user.username }}</h3>
                            <p>{{definePrivilege(user.privilege)}}</p>
                            <p>{{user.name}} {{user.lastName}}</p>
                            <p>{{user.email}}</p>
                            <p>{{user.contact}}</p>
                            <p>{{user.creditCard}}</p>
                            <br>
                            <button class="editBtn" ng-click="editUser(this)">Edit</button>
                        </div>
                    </div>
                </div>


                <!-- Adding, updating and deleting meals -->
                <div class="functionalityWindow func2">
                    <label>Ingredient name</label>
                    <input type="text" ng-model="newIngredient"/><br>
                    <button class="saveBtn" ng-click="addNewIngredient()">Add</button>

                    <div class="ingredientsList">
                        <input type="text" ng-model="ingredientFilter" placeholder="Quick search" /><br>
                        <div ng-repeat="ingredient in ingredients | filter: ingredientFilter" class="ingredient">
                            <p>{{ ingredient.name}}</p>
                            <img src="resources/images/delete.png" ng-click="deleteIngredient(this)"/>
                        </div>
                    </div>
                </div>

                <!-- Adding, updating and deleting meals -->
                <div class="functionalityWindow func3">
                    <label>Category name</label>
                    <input type="text" ng-model="newCategory"/><br>
                    <button class="saveBtn" ng-click="addNewCategory()">Add</button>

                    <div class="categoryList">
                        <input type="text" ng-model="categoryFilter" placeholder="Quick search" /><br>
                        <div ng-repeat="category in categories | filter: categoryFilter" class="category">
                            <p>{{ category.name}}</p>
                            <img src="resources/images/delete.png" ng-click="deleteCategory(this)"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }
} 