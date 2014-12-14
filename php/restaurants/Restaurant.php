<?php
/**
 * Created by PhpStorm.
 * User=> Vilim Stubičan
 * Date=> 14.12.2014.
 * Time=> 2=>38
 */

include_once "../../resources/constants.php";

class Restaurant {

    public function getRestaurantsList() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("
            SELECT restaurant.id AS id, restaurant.name AS name, restaurant.description AS description,
            restaurant.address as address, restaurant.city as city, images.url as url
            FROM restaurant
            LEFT JOIN images
            ON restaurant.picture = images.id
            ");
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        foreach($sql as $restaurant) {
            $set = array();
            $set["id"] = $restaurant->id;
            $set["name"] = $restaurant->name;
            $set["description"] = $restaurant->description;
            $set["address"] = $restaurant->address;
            $set["city"] = $restaurant->city;
            $set["img"] = $restaurant->img;
            $data[] = $set;
        }

        $array = [
        [
            "id" => 1,
            "name" => "Meksikanac",
            "img" => "resources/images/res1.jpg",
            "address" => "address fake 1",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ],
        [
            "id" => 2,
            "name" => "Kokopeli",
            "img" => "resources/images/res2.jpg",
            "address" => "address fake 2",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ] ,
        [
            "id" => 3,
            "name" => "Kum",
            "img" => "resources/images/res3.jpg",
            "address" => "address fake 3",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ],
        [
            "id" => 4,
            "name" => "Mrvica",
            "img" => "resources/images/res4.jpg",
            "address" => "address fake 4",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ],
        [
            "id" => 5,
            "name"=> "Flash",
            "img"=> "resources/images/res5.jpg",
            "address"=> "address fake 5",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ],
        [
            "id" => 6,
            "name"=> "Kremenko",
            "img"=> "resources/images/res6.jpg",
            "address"=> "address fake 6",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ],
        [
            "id" => 7,
            "name"=> "Mlinar",
            "img"=> "resources/images/res7.jpg",
            "address"=> "address fake 7",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ],
        [
            "id" => 8,
            "name"=> "Admiral",
            "img"=> "resources/images/res8.jpg",
            "address"=> "address fake 8",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ],
        [
            "id" => 9,
            "name"=> "Test restoran",
            "img"=> "resources/images/res9.jpg",
            "address"=> "address fake 9",
            "city"=> "Face city",
            "contact"=> "Fake contact number",
            "description"=> "Opis restoarana"
        ]
    ];
        echo json_encode($array);
        //echo json_encode($data);
    }


    public function getRestaurantMenu($index) {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("
            SELECT meal.id as id, meal.name as name, meal.price as price, ingredient.name as ingredient, mealconsistsof.amount as amount, mealconsistsof.units as unit
            FROM meal
            INNER JOIN mealconsistsof
            ON meal.id = mealconsistsof.mealId
            INNER JOIN ingredient
            ON mealconsistsof.ingredientId = ingredient.id
            WHERE meal.restaurantId = ?
            ORDER BY meal.categoryId
            ");
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->bindParam(1, intval($index));
        $sql->execute();

        $data = array();
        $set["id"] = -1;
        foreach($sql as $meal) {
            if($set["id"] != $meal->id) {
                if($set["id"] > 0) {
                    $data[] = $set;
                }
                $set = array();
                $set["id"] = $meal->id;
                $set["name"] = $meal->name;
                $set["price"] = ($meal->price)." kn";
                $set["description"] = ($meal->ingredient)."(".($meal->amount)." ".($meal->unit).")";

            } else {
                $set["description"].=", ".($meal->ingredient)."(".($meal->amount)." ".($meal->unit).")";
            }
        }

        $data[] = $set;


        $array = [
            [
                "id" => 1,
                "name" => "Meksikanac",
                "img" => "resources/images/res1.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ],
            [
                "id" => 2,
                "name" => "Kokopeli",
                "img" => "resources/images/res2.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ] ,
            [
                "id" => 3,
                "name" => "Kum",
                "img" => "resources/images/res3.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ],
            [
                "id" => 4,
                "name" => "Mrvica",
                "img" => "resources/images/res4.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ],
            [
                "id" => 5,
                "name"=> "Flash",
                "img"=> "resources/images/res5.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ],
            [
                "id" => 6,
                "name"=> "Kremenko",
                "img"=> "resources/images/res6.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ],
            [
                "id" => 7,
                "name"=> "Mlinar",
                "img"=> "resources/images/res7.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ],
            [
                "id" => 8,
                "name"=> "Admiral",
                "img"=> "resources/images/res8.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ],
            [
                "id" => 9,
                "name"=> "Test restoran",
                "img"=> "resources/images/res9.jpg",
                "price"=> "25kn",
                "description"=> "Opis restoarana"
            ]
        ];
        echo json_encode($array);
        //echo json_encode($data);
    }
} 