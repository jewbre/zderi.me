<?php ?>

<html>
    <head>
        <script type="text/javascript" src="js/jQuery.js"></script>
        <style>
            #URL {
                width:100%;
                border: 2px solid black;
                background-color:#b4b9b6;
                padding:10px;
                position:fixed;
                top:0px;
                left:0px;
                opacity:0.1;
                transition: all 0.15s ease;
            }
            #URL:hover {
                opacity:1;
            }
        </style>
    </head>

    <body>
        <div id="URL">
            <input type="text" id="inputValue" placeholder="URL"/>
            <input type="checkbox" id="update" ><label>Update every 10 s?</label>
        </div>

    <div id="view"></div>
    <script>
        $(document).ready(function() {
           setInterval(updateView, 3000);
        });


        function updateView() {
            if($("#update").prop("checked") && $("#inputValue").val() != "") {
                $.ajax({
                    url: $("#inputValue").val(),
                    type: "POST",
                    data: {}
                }).done(function(msg){
                    $("#view").html(msg);
                    console.log("Updated:" + new Date());
                })
            }
        }

    </script>
    </body>
</html>
