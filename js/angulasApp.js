
    var restaurants = angular.module("restaurants",[]);

    restaurants.controller("restaurantsList", function($scope){


        $scope.restaurants = [
            {
                name : "Meksikanac",
                img : "resources/images/res1.jpg",
                address : "Address fake 3321",
                city: "Face city",
                contact: "Fake contact number",
                description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            },
            {
                    name : "Kokopeli",
                    img : "resources/images/res2.jpg",
                    address : "Address fake 3321",
                    city: "Face city",
                    contact: "Fake contact number",
                    description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            } ,
            {
                name : "Kum",
                    img : "resources/images/res3.jpg",
                    address : "Address fake 3321",
                    city: "Face city",
                    contact: "Fake contact number",
                    description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            },
            {
                name : "Mrvica",
                    img : "resources/images/res4.jpg",
                address : "Address fake 3321",
                city: "Face city",
                contact: "Fake contact number",
                description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            },
            {
                name: "Flash",
                img: "resources/images/res5.jpg",
                address: "Address fake 3321",
                city: "Face city",
                contact: "Fake contact number",
                description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            },
            {
                name: "Kremenko",
                img: "resources/images/res6.jpg",
                address: "Address fake 3321",
                city: "Face city",
                contact: "Fake contact number",
                description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            },
            {
                name: "Mlinar",
                img: "resources/images/res7.jpg",
                address: "Address fake 3321",
                city: "Face city",
                contact: "Fake contact number",
                description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            },
            {
                name: "Admiral",
                img: "resources/images/res8.jpg",
                address: "Address fake 3321",
                city: "Face city",
                contact: "Fake contact number",
                description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            },
            {
                name: "Test restoran",
                img: "resources/images/res9.jpg",
                address: "Address fake 3321",
                city: "Face city",
                contact: "Fake contact number",
                description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin egestas est ac nisi pretium, ac dignissim ex efficitur. Mauris condimentum a erat ut dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam a quam sit amet velit cursus rutrum. Sed odio justo, euismod nec tincidunt a, efficitur sit amet mi. Donec luctus, ipsum sed fringilla convallis, libero felis aliquet nisl, at consectetur massa mauris lobortis nisi. Ut nec tortor sit amet odio tincidunt efficitur. Duis efficitur, sapien quis blandit ullamcorper, lorem felis consectetur enim, ac sodales ex mi et justo. Nulla pretium quam in leo finibus, vitae dictum"
            }
        ]

        $scope.checkRestaurant = {
            name: "No data",
            img: "",
            address: "No address",
            city: "No city",
            contact: "No contact",
            description: "No descript"
        };

        $scope.displayRestaurant = function (data) {
            $scope.checkRestaurant = data;
        }
    });


