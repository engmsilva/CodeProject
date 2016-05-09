angular.module('app.controllers')
    .controller('ProjectEditController',
        ['$scope','$location','$cookies', '$routeParams','Project','Client', 'appConfig',
            function($scope,$location, $cookies, $routeParams, Project, Client, appConfig){

                Project.get({id: $routeParams.id}, function (data) {
                    $scope.project = data;
                    $scope.clientSelected = $scope.project.client.data;
                });
                
                $scope.status = appConfig.project.status;

                $scope.due_date = {
                    status: {
                        opened: false
                    }
                };

                $scope.open = function ($event) {
                    $scope.due_date.status.opened = true;
                };

                $scope.save = function () {
                    if($scope.form.$valid) {
                        $scope.project.owner_id = $cookies.getObject('user').id;
                        Project.update({id: $scope.project.id}, $scope.project, function () {
                            $location.path('/projects/');
                        })
                    }
                };

                $scope.formatName = function (model) {
                    if(model){
                        return model.name;
                    }
                    return '';
                };

                $scope.getClients = function (name) {
                    return Client.query({
                        search: name,
                        searchFields: 'name:like'
                    }).$promise;
                };

                $scope.selectClient = function (item){
                   $scope.project.client_id = item.id;
                };
    }]);