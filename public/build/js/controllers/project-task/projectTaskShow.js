angular.module('app.controllers')
    .controller('ProjectTaskShowController', ['$scope','ProjectTask', function($scope, ProjectTask){
        $scope.projectTasks = ProjectTask.query();
    }]);