var app = angular.module(
    'app',['ngRoute','angular-oauth2','app.controllers','app.services','app.filters','app.directives',
            'ui.bootstrap.typeahead','ui.bootstrap.tpls','ui.bootstrap.datepicker','ngFileUpload'
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
           .when('/client/new', {
               requireLogin: true,
               templateUrl: 'build/views/client/new.html',
               controller: 'ClientNewController'
           })
           .when('/client/:id/edit', {
               requireLogin: true,
               templateUrl: 'build/views/client/edit.html',
               controller: 'ClientEditController'
           })
           .when('/client/:id/remove', {
               requireLogin: true,
               templateUrl: 'build/views/client/remove.html',
               controller: 'ClientRemoveController'
           })
        .when('/projects', {
            requireLogin: false,
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListController'
        })
        .when('/project/new', {
            requireLogin: false,
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewController'
        })
        .when('/project/:id/edit', {
            requireLogin: false,
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditController'
        })
        .when('/project/:id/remove', {
            requireLogin: false,
            templateUrl: 'build/views/project/remove.html',
            controller: 'ProjectRemoveController'
        })
            .when('/project/:id/notes', {
                requireLogin: false,
                templateUrl: 'build/views/project-note/list.html',
                controller: 'ProjectNoteListController'
            })
            .when('/project/:id/note/:idNote/show', {
                requireLogin: false,
                templateUrl: 'build/views/project-note/show.html',
                controller: 'ProjectNoteShowController'
            })
            .when('/project/:id/note/new', {
                requireLogin: false,
                templateUrl: 'build/views/project-note/new.html',
                controller: 'ProjectNoteNewController'
            })
            .when('/project/:id/note/:idNote/edit', {
                requireLogin: false,
                templateUrl: 'build/views/project-note/edit.html',
                controller: 'ProjectNoteEditController'
            })
            .when('/project/:id/note/:idNote/remove', {
                requireLogin: false,
                templateUrl: 'build/views/project-note/remove.html',
                controller: 'ProjectNoteRemoveController'
            })

        .when('/project/:id/tasks', {
            requireLogin: false,
            templateUrl: 'build/views/project-task/list.html',
            controller: 'ProjectTaskListController'
        })
        .when('/project/:id/task/:idTask/show', {
            requireLogin: false,
            templateUrl: 'build/views/project-task/show.html',
            controller: 'ProjectTaskShowController'
        })
        .when('/project/:id/task/new', {
            requireLogin: false,
            templateUrl: 'build/views/project-task/new.html',
            controller: 'ProjectTaskNewController'
        })
        .when('/project/:id/task/:idTask/edit', {
            requireLogin: false,
            templateUrl: 'build/views/project-task/edit.html',
            controller: 'ProjectTaskEditController'
        })
        .when('/project/:id/task/:idTask/remove', {
            requireLogin: false,
            templateUrl: 'build/views/project-task/remove.html',
            controller: 'ProjectTaskRemoveController'
        })
            .when('/project/:id/members', {
                requireLogin: false,
                templateUrl: 'build/views/project-member/list.html',
                controller: 'ProjectMemberListController'
            })
            .when('/project/:id/member/:idMember/remove', {
                requireLogin: false,
                templateUrl: 'build/views/project-member/remove.html',
                controller: 'ProjectMemberRemoveController'
            })
        .when('/project/:id/files', {
            //requireLogin: false,
            templateUrl: 'build/views/project-file/list.html',
            controller: 'ProjectFileListController'
        })
        .when('/project/:id/file/new', {
            requireLogin: false,
            templateUrl: 'build/views/project-file/new.html',
            controller: 'ProjectFileNewController'
        })
        .when('/project/:id/file/:idFile/edit', {
            requireLogin: false,
            templateUrl: 'build/views/project-file/edit.html',
            controller: 'ProjectFileEditController'
        })
        .when('/project/:id/file/:idFile/remove', {
            requireLogin: false,
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