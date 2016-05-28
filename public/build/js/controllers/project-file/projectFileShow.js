angular.module('app.controllers')
    .controller('ProjectFileShowController', ['$scope','ProjectFile', function($scope, ProjectFile){
        $scope.projectFiles = ProjectFile.query();
    }]);