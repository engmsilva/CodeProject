angular.module('app.controllers')
    .controller('ProjectFileNewController',
            ['$scope','$location','$routeParams','appConfig','Url','Upload',
     function($scope,$location, $routeParams, appConfig, Url, Upload){
        $scope.projectFile = {
            id: $routeParams.id
        };
         
        $scope.save = function () {
            if($scope.form.$valid) {
                var url = appConfig.baseUrl + Url.getUrlFromUrlSymbol(appConfig.urls.projectFile,{
                        id: $routeParams.id                       
                    });

                Upload.upload({
                    url: url,
                    data: {
                            file: $scope.projectFile.file,
                            name: $scope.projectFile.name,
                            description: $scope.projectFile.description
                    }
                }).then(function (resp) {
                    $location.path('/project/'+$routeParams.id + '/files');
                });
            }
        }
    }]);