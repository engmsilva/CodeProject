angular.module('app.directives')
    .directive('projectFileDownload',
        ['$timeout','appConfig','ProjectFile',function($timeout, appConfig, ProjectFile){
        return {
            restrict: 'E',
            templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
            link: function (scope, element, attrs) {
                var anchor = element.children()[0];
                var divElem = element.children()[1];
                
                
                scope.$on('salvar-arquivo', function (event, data) {
                    $(anchor).removeClass('disabled');
                    $(anchor).text('Save File');
                    $(divElem).html('');
                    $(anchor).attr({
                        href: 'data:application-octet-stream;base64,' + data.file,
                        download: data.name
                    });
                    $timeout(function () {
                        scope.downloadFile = function () {

                        };
                        $(anchor)[0].click();
                    });
                });

                scope.$on('loading', function () {
                    $(anchor).addClass('disabled');
                    $(anchor).text('');
                    $(divElem).html('<img src="/build/images/ajax-loader.gif" width="20" height="20" />');
                    
                });
            },
            controller: ['$scope', '$element','$attrs','$timeout',
                function ($scope, $element, $attrs) {

                $scope.downloadFile = function () {
                    $scope.$emit('loading');
                    ProjectFile.download({id: null, idFile: $attrs.idFile}, function (data){
                        $scope.$emit('salvar-arquivo',data);

                    });
                }
            }]
        };

    }]);