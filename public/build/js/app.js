var app = angular.module('app',['ngRoute','angular-oauth2','app.controllers','app.services']);

angular.module('app.controllers',['ngMessages','angular-oauth2']);
angular.module('app.services',['ngResource']);

app.provider('appConfig',function(){
    var config = {
        baseUrl: 'http://localhost:8000',
    };

    return {
        config: config,
        $get: function(){
            return config;
        }
    }
});

app.config(['$routeProvider','OAuthProvider','OAuthTokenProvider','appConfigProvider',
    function($routeProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider){
   $routeProvider
       .when('/login',{
           requireLogin: false,
           templateUrl: 'build/views/login.html',
           controller: 'LoginController'
       })
       .when('/home', {
           requireLogin: true,
           templateUrl: 'build/views/home.html',
           controller: 'HomeController'
       })
       .when('/clients',{
           requireLogin: true,
           templateUrl: 'build/views/client/list.html',
           controller: 'ClientListController'
       })
       .when('/clients/new', {
           requireLogin: true,
           templateUrl: 'build/views/client/new.html',
           controller: 'ClientNewController'
       })
       .when('/clients/:id/edit', {
           requireLogin: true,
           templateUrl: 'build/views/client/edit.html',
           controller: 'ClientEditController'
       })
       .when('/clients/:id/remove', {
           requireLogin: true,
           templateUrl: 'build/views/client/remove.html',
           controller: 'ClientRemoveController'
       })
       .otherwise({redirectTo: function () {
           return '/login';
       }
          
       });


    OAuthProvider
        .configure({
            baseUrl: appConfigProvider.config.baseUrl,
            clientId: 'appid1',
            clientSecret: 'secret', // optional
            grantPath: 'oauth/access_token'
        });

    OAuthTokenProvider
        .configure({
           name: 'token',
           options: {
               secure: false,
           }
        });
}]);

app.run(['$rootScope','$window','$route','$location','OAuth', function($rootScope,$window,$route,$location,OAuth) {
    $rootScope.$on('oauth:error', function(event, rejection) {
        // Ignore `invalid_grant` error - should be catched on `LoginController`.
        if ('invalid_grant' === rejection.data.error) {
            return;
        }

        // Refresh token when a `invalid_token` error occurs.
        if ('invalid_token' === rejection.data.error) {
            return OAuth.getRefreshToken();
        }

        // Redirect to `/login` with the `error_reason`.
        $location.path('/login');
        console.log(rejection.data.error);
       //return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });

    $rootScope.$on('$routeChangeStart', function(ev, next, current) {

        var requireLogin = next.requireLogin;

        if(requireLogin) { //
            if(!OAuth.isAuthenticated()){
               $location.path('/login');
                console.log('Acesso Negado!');
            }
        }
    });
    

}]);