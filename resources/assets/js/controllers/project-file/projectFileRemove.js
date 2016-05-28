angular.module('app.controllers')
    .controller('ProjectFileRemoveController', ['$scope','$location','$routeParams','ProjectFile',
        function($scope,$location,$routeParams, ProjectFile){
            $scope.projectFile = ProjectFile.get({
                id: $routeParams.id,
                idFile: $routeParams.idFile
            });

        $scope.remove = function () {
           $scope.projectFile.$delete({id: $scope.projectFile.id, idFile: $routeParams.idFile}).then(function () {
               $location.path('/project/'+$routeParams.id + '/files');
           });
        };

        $scope.cancel = function () {
            $location.path('/project/'+$routeParams.id + '/files');
        };

    }]);