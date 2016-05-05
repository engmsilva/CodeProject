angular.module('app.controllers')
    .controller('HomeController', ['$scope','$route','$location','$cookies','OAuth',
        function($scope,$route,$location,$cookies,OAuth){
        console.log($cookies.getObject('user').email);
    }]);