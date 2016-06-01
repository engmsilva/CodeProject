var app = angular.module(
    'app',['ngRoute','angular-oauth2','app.controllers','app.services','app.filters','app.directives',
            'ui.bootstrap.typeahead','ui.bootstrap.tpls','ui.bootstrap.datepicker','ui.bootstrap.modal',
        'ngFileUpload','http-auth-interceptor','angularUtils.directives.dirPagination','mgcrea.ngStrap.navbar',
        'ui.bootstrap.dropdown'
    ]);

angular.module('app.controllers',['ngMessages','angular-oauth2']);
angular.module('app.filters',[]);
angular.module('app.directives',[]);
angular.module('app.services',['ngResource']);

app.provider('appConfig',['$httpParamSerializerProvider' ,function($httpParamSerializerProvider){
    var config = {
        baseUrl: 'http://localhost:8000',
        project: {
            status: [
                {value: 1, label: 'Não iniciado'},
                {value: 2, label: 'Iniciado'},
                {value: 3, label: 'Concluído'}
            ]
        },
        projectTask: {
            status: [
                {value: 1, label: 'Incompleta'},
                {value: 2, label: 'Completa'}
            ]
        },
        urls: {
            projectFile: '/project/{{id}}/file/{{idFile}}'
        },
        utils: {
            transformRequest: function (data) {
                if(angular.isObject(data)){
                   return $httpParamSerializerProvider.$get()(data);
                }
                return data;
            },
            transformResponse: function (data,headers) {
                var headersGetter = headers();
                if(headersGetter['content-type'] == 'application/json' ||
                    headersGetter['content-type'] == 'text/json'){
                    var dataJson = JSON.parse(data);
                    if(dataJson.hasOwnProperty('data') && Object.keys(dataJson).length == 1){
                        dataJson = dataJson.data;
                    }
                    return dataJson;
                }
                return data;
            }
        }
    };

    return {
        config: config,
        $get: function(){
            return config;
        }
    }
}]);

app.config(['$routeProvider','$httpProvider','OAuthProvider','OAuthTokenProvider','appConfigProvider',
    function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider){

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

        $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

        $httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;

        $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

        $httpProvider.interceptors.splice(0,1);
        $httpProvider.interceptors.splice(0,1);

        $httpProvider.interceptors.push('oauthFixInterceptor');
        
        $routeProvider
       .when('/login',{
           requireLogin: false,
           templateUrl: 'build/views/login.html',
           controller: 'LoginController'
       })
            .when('/logout',{
                requireLogin: false,
                resolve: {
                    logout: ['$location', 'OAuthToken', function ($location, OAuthToken) {
                        OAuthToken.removeToken();
                        return $location.path('/login');
                    }]
                }
            })
       .when('/home', {
           requireLogin: true,
           templateUrl: 'build/views/home.html',
           controller: 'HomeController',
           title: 'Home'
       })
            .when('/clients/dashboard',{
                requireLogin: true,
                templateUrl: 'build/views/client/dashboard.html',
                controller: 'ClientDashboardController',
                title: 'Clientes'
            })
            .when('/clients',{
               requireLogin: true,
               templateUrl: 'build/views/client/list.html',
               controller: 'ClientListController',
               title: 'Clientes'
           })
           .when('/client/new', {
               requireLogin: true,
               templateUrl: 'build/views/client/new.html',
               controller: 'ClientNewController',
               title: 'Clientes'
           })
           .when('/client/:id/edit', {
               requireLogin: true,
               templateUrl: 'build/views/client/edit.html',
               controller: 'ClientEditController',
               title: 'Clientes'
           })
           .when('/client/:id/remove', {
               requireLogin: true,
               templateUrl: 'build/views/client/remove.html',
               controller: 'ClientRemoveController',
               title: 'Clientes'
           })
        .when('/projects', {
            requireLogin: true,
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListController',
            title: 'Projetos'
        })
        .when('/project/new', {
            requireLogin: true,
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewController',
            title: 'Projetos'
        })
        .when('/project/:id/edit', {
            requireLogin: true,
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditController',
            title: 'Projetos'
        })
        .when('/project/:id/remove', {
            requireLogin: true,
            templateUrl: 'build/views/project/remove.html',
            controller: 'ProjectRemoveController',
            title: 'Projetos'
        })
            .when('/project/:id/notes', {
                requireLogin: true,
                templateUrl: 'build/views/project-note/list.html',
                controller: 'ProjectNoteListController',
                title: 'Projetos'
            })
            .when('/project/:id/note/:idNote/show', {
                requireLogin: true,
                templateUrl: 'build/views/project-note/show.html',
                controller: 'ProjectNoteShowController',
                title: 'Projetos'
            })
            .when('/project/:id/note/new', {
                requireLogin: true,
                templateUrl: 'build/views/project-note/new.html',
                controller: 'ProjectNoteNewController',
                title: 'Projetos'
            })
            .when('/project/:id/note/:idNote/edit', {
                requireLogin: true,
                templateUrl: 'build/views/project-note/edit.html',
                controller: 'ProjectNoteEditController',
                title: 'Projetos'
            })
            .when('/project/:id/note/:idNote/remove', {
                requireLogin: true,
                templateUrl: 'build/views/project-note/remove.html',
                controller: 'ProjectNoteRemoveController',
                title: 'Projetos'
            })

        .when('/project/:id/tasks', {
            requireLogin: true,
            templateUrl: 'build/views/project-task/list.html',
            controller: 'ProjectTaskListController'
        })
        .when('/project/:id/task/:idTask/show', {
            requireLogin: true,
            templateUrl: 'build/views/project-task/show.html',
            controller: 'ProjectTaskShowController'
        })
        .when('/project/:id/task/new', {
            requireLogin: true,
            templateUrl: 'build/views/project-task/new.html',
            controller: 'ProjectTaskNewController'
        })
        .when('/project/:id/task/:idTask/edit', {
            requireLogin: true,
            templateUrl: 'build/views/project-task/edit.html',
            controller: 'ProjectTaskEditController'
        })
        .when('/project/:id/task/:idTask/remove', {
            requireLogin: true,
            templateUrl: 'build/views/project-task/remove.html',
            controller: 'ProjectTaskRemoveController'
        })
            .when('/project/:id/members', {
                requireLogin: true,
                templateUrl: 'build/views/project-member/list.html',
                controller: 'ProjectMemberListController'
            })
            .when('/project/:id/member/:idMember/remove', {
                requireLogin: true,
                templateUrl: 'build/views/project-member/remove.html',
                controller: 'ProjectMemberRemoveController'
            })
        .when('/project/:id/files', {
            //requireLogin: true,
            templateUrl: 'build/views/project-file/list.html',
            controller: 'ProjectFileListController'
        })
        .when('/project/:id/file/new', {
            requireLogin: true,
            templateUrl: 'build/views/project-file/new.html',
            controller: 'ProjectFileNewController'
        })
        .when('/project/:id/file/:idFile/edit', {
            requireLogin: true,
            templateUrl: 'build/views/project-file/edit.html',
            controller: 'ProjectFileEditController'
        })
        .when('/project/:id/file/:idFile/remove', {
            requireLogin: true,
            templateUrl: 'build/views/project-file/remove.html',
            controller: 'ProjectFileRemoveController'
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

app.run(['$rootScope','$route','$location','$http','$modal','$cookies','httpBuffer','OAuth',
    function($rootScope,$route,$location,$http,$modal,$cookies,httpBuffer,OAuth) {

        $rootScope.$on('$routeChangeStart', function(event, next, current) {

            var requireLogin = next.requireLogin;

            $rootScope.loginModalOpened = false;

            if(next.$$route.originalPath != "/login") {
                if(!OAuth.isAuthenticated()){
                    return $location.path('/login');
                }
            }
        });

        $rootScope.$on('$routeChangeSuccess', function(event, next, current) {
            $rootScope.pageTitle = next.$$route.title;

        });

    $rootScope.$on('oauth:error', function(event, data) {
        // Ignore `invalid_grant` error - should be catched on `LoginController`.
        if ('invalid_grant' === data.rejection.data.error) {
            return;
        }

        // Refresh token when a `invalid_token` error occurs.
        if ('access_denied' === data.rejection.data.error) {
            httpBuffer.append(data.rejection.config, data.deferred);
            if(!$rootScope.loginModalOpened){
                var modalInstance = $modal.open({
                    templateUrl: 'build/views/templates/loginModal.html',
                    controller: 'LoginModalController'
                });
                $rootScope.loginModalOpened = true;

            }
            return;
        }

        // Redirect to `/login` with the `error_reason`.
        $location.path('/login');
    });


    

}]);