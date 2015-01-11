<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.1.2015.
 * Time: 2:43
 */
session_start();
include_once "../../resources/constants.php";

class Gastro {

    public function createLink(){
        $data = array(
            "restaurantId" => 6,
            "timestamp" => time()
        );
        $iv = openssl_random_pseudo_bytes(16);
        $cryptedData = base64_encode(json_encode($data));

        ?>

            <div class="rating-system">
                <script>
                    $.ajax({
                        url: "http://vdl.hr/zderi.me/php/gastro/",
                        type : "POST",
                        data : {
                            calltype : 2,
                            value : "<?=$cryptedData?>"
                        }
                    }).success(function(msg){
                        $(".rating-system").html(msg);
                    })
                </script>
            </div><?php
    }

    public function getContent(){
        $data = json_decode(base64_decode($_POST["value"]));
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $query = $db->prepare("SELECT * FROM restaurant WHERE id = ?");
        $query->setFetchMode(PDO::FETCH_OBJ);
        $query->bindParam(1, $data->restaurantId);
        $query->execute();
        $restaurant = $query->fetch();
        ?>
            <style>
                .rating-system {
                    font-family: "Agency FB";
                    display:inline-block;
                    padding:20px;
                    border-radius: 10px;
                    border: 3px outset #9ecb2d;
                    background: rgba(255,255,255,0.5);
                    box-shadow:5px 5px 5px rgba(0,0,0,0.6);
                }

                .rating-system h3{
                    margin:0 auto;
                }

                .restaurantDescription {
                    font-size: 12px;
                    color: #919191;
                    margin-bottom: 10px;
                }

                .commentOnRank {
                    margin:0 auto;
                    font-size: 12px;
                    color: #919191;
                }
                .rank {
                    display:inline-block;
                    height:25px;
                    width:25px;
                    padding:0px;
                    margin-right:-4px;
                    content: url('http://oi60.tinypic.com/2mxnis.jpg');
                }
                .rank:hover ~ .rank {
                    content: url('http://oi61.tinypic.com/35a6pgz.jpg');
                }

                .rankComment {
                    height:50px;
                    width:200px;
                    resize: none;
                }
            </style>
            <h3><?=$restaurant->name?></h3>
            <div class="restaurantDescription"><?=substr($restaurant->description,0,100)."..."?></div>
            <div class="rankHolder">
                <textarea class="rankComment" placeholder="Insert your comment"></textarea>
                <br>
                <div class="rank" onclick="rate(1)"></div>
                <div class="rank" onclick="rate(2)"></div>
                <div class="rank" onclick="rate(3)"></div>
                <div class="rank" onclick="rate(4)"></div>
                <div class="rank" onclick="rate(5)"></div>
                <p class="commentOnRank">Once you click on a star, rating is done.</p>
            </div>
            <p class="rankOutput"></p>

            <script>
                function rate(rank) {
                    var value = parseInt(rank);
                    if(value < 1 || value > 5) {
                        $(".rankOutput").html("Not a bad try, but you are not allowed to do this.")
                    }

                    $.ajax({
                        url: "http://vdl.hr/zderi.me/php/gastro/",
                        type: "POST",
                        data: {
                            calltype: 3,
                            rank : value,
                            comment : $(".rankComment").val(),
                            restaurantId : <?=$restaurant->id?>
                        }
                    }).success(function(msg){
                        $(".rankOutput").html("Thank you for your opinion.");
                        $(".rankHolder").slideUp("fast");
                        setTimeout(function(){
                            $(".rankHolder").remove();
                        }, 250)
                    })
                }
            </script>
        <?php
    }

    public function savePublicRank(){
        $comment = (isset($_POST["comment"]) ? $_POST["comment"] : "");
        $rank = intval($_POST["rank"]);
        $restaurantId = intval($_POST["restaurantId"]);
        $userId = 0;

        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $query = $db->prepare("INSERT INTO rating(rating, restaurantId, comment, userId) VALUES(?,?,?,?)");
        $query->bindParam(1,$rank);
        $query->bindParam(2,$restaurantId);
        $query->bindParam(3,$comment);
        $query->bindParam(4,$userId);
        $query->execute();
    }

    public function saveUserRank(){
        $comment = (isset($_POST["comment"]) ? $_POST["comment"] : "");
        $rank = intval($_POST["rate"]);
        $restaurantId = intval($_POST["restaurantId"]);
        $userId = intval($_SESSION["userId"]);

        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $query = $db->prepare("INSERT INTO rating(rating, restaurantId, comment, userId) VALUES(?,?,?,?)");
        $query->bindParam(1,$rank);
        $query->bindParam(2,$restaurantId);
        $query->bindParam(3,$comment);
        $query->bindParam(4,$userId);
        $query->execute();
        echo "Thank you for your opinion.";
    }
} 