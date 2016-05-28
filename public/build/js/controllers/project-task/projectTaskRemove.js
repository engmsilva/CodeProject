angular.module('app.controllers')
    .controller('ProjectTaskRemoveController', ['$scope','$location','$routeParams','ProjectTask',
        function($scope,$location,$routeParams, ProjectTask){
            $scope.projectTask = ProjectTask.get({
                id: $routeParams.id,
                idTask: $routeParams.idTask
            });

        $scope.remove = function () {
           $scope.projectTask.$delete({id: $scope.projectTask.id, idTask: $routeParams.idTask}).then(function () {
               $location.path('/project/'+$routeParams.id + '/tasks');
           });
        };

        $scope.cancel = function () {
            $location.path('/project/'+$routeParams.id + '/tasks');
        };

    }]);