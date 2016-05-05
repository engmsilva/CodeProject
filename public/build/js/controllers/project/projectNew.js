angular.module('app.controllers')
    .controller('ProjectNoteNewController',
            ['$scope','$location','$routeParams','ProjectNote',
     function($scope,$location, $routeParams, ProjectNote){
        $scope.projectNote = new ProjectNote();

        $scope.save = function () {
            if($scope.form.$valid) {
                $scope.projectNote.$save({id: $routeParams.id}).then(function () {
                    $location.path('/project/'+$routeParams.id + '/notes');
                })
            }
        }
    }]);