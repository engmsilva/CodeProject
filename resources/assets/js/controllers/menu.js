angular.module('app.controllers')
    .controller('MenuController', ['$scope','$route','$location','$cookies','OAuth',
        function($scope,$route,$location,$cookies,OAuth){
            $scope.user = $cookies.getObject('user');
        }]);