//CONTROLLER DOS RELATÓRIOS
enquete.controller('relatorio', function ($rootScope, $scope, $http, $location, requisicaoService) {
    $rootScope.tituloBarra = "Relatórios";

    $scope.restaurarEnquetes = function () {
        requisicaoService.restaurarEnquetes()
        .success(function (data) {
            $scope.lista = data.resultado;
            //$scope.$digest();
        });
    };

    $scope.visualizar = function (id) {
        $location.path('/relatorio/' + id);
    };

    //QUANDO O CONTROLLER É CARREGADO, IMEDIATMENTE RESTAURA DO SERVIDOR AS ENQUETES
    $scope.restaurarEnquetes();
})

//CONTROLLER PARA VISUALIZAR RELATÓRIO
enquete.controller('relatorioVisualizar', function ($rootScope, $scope, $http, $routeParams, requisicaoService) {
    $rootScope.tituloBarra = "Visualizar Relatório";
    $scope.totalVotosPergunta = [];

    
    $rootScope.restaurarEnqueteRelatorio = function (id) {
        requisicaoService.restaurarEnqueteRelatorio(id)
                .success(function (data) {
                    $scope.enquete = data.resultado;
                    //$scope.$digest();
                });
    };

    $scope.somaTotal = function (obj) {
        var total = 0;

        angular.forEach(obj, function (item) {
            total += item;
        });
        $scope.totais = total;
        return total;
    };

    //QUANDO O CONTROLLER É CARREGADO, IMEDIATMENTE RESTAURA DO SERVIDOR A ENQUETE
    $scope.restaurarEnqueteRelatorio($routeParams.id);
})