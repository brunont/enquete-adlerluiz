var enquete = angular.module('enquete', ['ngMaterial', 'ngRoute', 'requisicaoService']);

enquete.config(function ($mdIconProvider, $routeProvider, $locationProvider, $mdThemingProvider) {
    $mdIconProvider
            .icon('menu', 'img/icones/menu.svg', 24)
            .icon('plus', 'img/icones/plus.svg', 24)
            .icon('menos', 'img/icones/minus.svg', 24)
            .icon('enquete', 'img/icones/format-list-bulleted.svg', 24)
            .icon('eye', 'img/icones/eye.svg', 24);

    $routeProvider
            .when('/', {
                templateUrl: 'templates/enquete/lista.html',
                controller: 'EnqueteListagem'
            })
            .when('/novo', {
                templateUrl: 'templates/enquete/novo.html',
                //controller: 'PhoneDetailCtrl'
            })
            .when('/enquete/:id', {
                templateUrl: 'templates/enquete/responder.html',
                controller: 'enqueteResposta'
            })
            .when('/enquete/editar/:id', {
                templateUrl: 'templates/enquete/editar.html',
                controller: 'enqueteResposta'
            })
            .when('/relatorio/', {
                templateUrl: 'templates/relatorio/lista.html',
                controller: 'relatorio'
            })
            .when('/relatorio/:id', {
                templateUrl: 'templates/relatorio/visualizar.html',
                controller: 'relatorioVisualizar'
            })
            .otherwise({
                redirectTo: '/'
            });
    $mdThemingProvider
            .theme('docs-dark', 'default')
            .primaryPalette('yellow')
            .dark();
    $mdThemingProvider.theme('docs-blue', 'default')
            .primaryPalette('teal')
            .backgroundPalette('blue');

    //$locationProvider.html5Mode(true);
});


enquete.run(function ($rootScope) {
    $rootScope.tituloBarra = "Enquetes";
});

//CONTROLLER GERAL DO APP
enquete.controller('AppCtrl', function ($scope, $rootScope, $timeout, $mdBottomSheet, $http, $location, $mdDialog) {
    $scope.lista = 'Carregando...';
    $scope.location = $location;

    $scope.voltar = function () {
        history.go(-1);
    };

    //MOSTRA O MENU BOTTOM AO CLICAR NO FAB
    $scope.mostrarMenu = function ($event) {
        $mdBottomSheet.show({
            templateUrl: './templates/botton-sheet-template.html',
            controller: 'mostrarMenu',
            targetEvent: $event
        }).then(function (clickedItem) {
            
        });
    };
});

//CONTROLLER DO MENU
enquete.controller('mostrarMenu', function ($scope, $mdBottomSheet, $location) {
    $scope.items = [
        {name: 'Enquete', icon: 'plus', url: '#/novo'},
        {name: 'Enquetes', icon: 'eye', url: '#/'},                
        {name: 'Relatorios', icon: 'eye', url: "#/relatorio"}
    ];
    $scope.listItemClick = function ($index) {
        var clickedItem = $scope.items[$index];
        $location.path(clickedItem.url)
        $mdBottomSheet.hide(clickedItem);
    };
});

function DialogController($scope, $mdDialog) {
    $scope.hide = function () {
        $mdDialog.hide();
    };
    $scope.cancel = function () {
        $mdDialog.cancel();
    };
    $scope.answer = function (answer) {
        $mdDialog.hide(answer);
    };
}