angular.module('app.directives')
    .directive('loginForm',
        ['appConfig',function(appConfig){
            return {
                restrict: 'E',
                templateUrl: appConfig.baseUrl + '/build/views/templates/form-Login.html',
                scope: false

            };

        }]);