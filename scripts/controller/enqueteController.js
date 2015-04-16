//CONTROLLER PARA CRIAR NOVA ENQUETE
enquete.controller('FormEnquete', function($rootScope, $scope, $mdDialog, $http, $location, requisicaoService) {
    $rootScope.tituloBarra = "Criar Enquete";
    $scope.enquete = [];
    $scope.respostas = [{}, {}];

    //MOSTRA A MODAL PRA ADICIONAR PERGUNTA E OPÇÃO NA ENQUETE
    $scope.showAdvanced = function(ev) {
        $mdDialog.show({
            controller: DialogController,
            templateUrl: 'templates/enquete/modal.html',
            targetEvent: ev,
        })
                .then(function(resposta) {
                    if (resposta != "") {
                        $scope.enquete.push(resposta);
                    } else {

                    }
                }, function() {
                    //$scope.alert = 'You cancelled the dialog.';
                });
    };

    //INSERE A PERGUNTA NO ARRAY
    $scope.salvarPergunta = function() {
        $scope.enquete.push($scope.pergunta);
    };
    
    //REMOVE A PERGUNTA DA ENQUETE
    $scope.removerPergunta = function(index) {
        $scope.enquete.splice(index, 1);
    };

    //FAKE PARA ADICIONAR CAMPOS DE OPÇÕES NA MODAL
    $scope.addResposta = function() {
        $scope.respostas.push({});
    };

    //REMOVE A RESPOSTA DA ENQUETE PASSADA PELO INDEX
    $scope.removerResposta = function(index) {
        $scope.respostas.splice(index, 1);
        delete $scope.pergunta.opcao[index];
    };
    
    //SALVA A ENQUETE INTEIRA NO SERVIDOR VIA POST
    $scope.salvar = function() {
        requisicaoService.post("./slim/enquete/salvar", {titulo: $scope.tituloEnquete, descricao: $scope.descricaoEnquete, pergunta: $scope.enquete})
        .success(function(data) {
            if (data.resultado === true) {
                alert("Salvou!");
                $location.path("/");
            }
        });
    };
})

//CONTROLLER PARA RESPONDER A ENQUETE
enquete.controller("enqueteResposta", function($rootScope, $scope, $http, $routeParams, $location, requisicaoService) {
    $rootScope.tituloBarra = "Responder Enquete";
    $scope.enquete = '';
    $scope.selecionado = [];

    //RESTAURA A ENQUETE POR ID
    //IMPLEMENTAR SERVICE
    
    $rootScope.restaurarEnquete = function(id) {
        requisicaoService.restaurarEnquete(id)
        .success(function(data){
            $scope.enquete = data.resultado;
        })            
    };

    //SALVA AS RESPOSTAS SELECIONADAS NO SERVIDOR VIA POST
    $scope.salvar = function() {
        requisicaoService.post("./slim/enquete/responder", {respostas: $scope.selecionado})
            .success(function(data) {
                if (data.resultado === true) {
                    alert("Salvo com sucesso! \nObrigado!!");
                    $location.path('/')
                } else {
                    alert("Houve algum erro ao salvar!");
                }
            });
    }

    //QUANDO O CONTROLLER É CARREGADO, IMEDIATMENTE RESTAURA DO SERVIDOR A ENQUETE
    $scope.restaurarEnquete($routeParams.id);
})

//CONTROLLER PARA EDITAR ENQUETE
enquete.controller("EnqueteEditar", function($rootScope, $scope, $http, $routeParams, $location, requisicaoService) {
    $rootScope.tituloBarra = "Editar Enquete";
    $scope.enquete = '';
    $scope.selecionado = [];

    //RESTAURA A ENQUETE POR ID
    $rootScope.restaurarEnquete = function(id) {
        requisicaoService.restaurarEnquete(id)
        .success(function(data){
            $scope.enquete = data.resultado;
        }) 
    };

    //SALVA A EDIÇÃO NO SERVIDOR VIA POST
    $scope.salvar = function() {
        
        requisicaoService.post("./slim/enquete/editar",  $scope.enquete )
        .success(function(data) {
            if (data.resultado === true) {
                alert("Salvo com sucesso! \nObrigado!!");
                $location.path('/')
            } else {
                alert("Houve algum erro ao salvar!");
            }
        });
    }
    
    //QUANDO O CONTROLLER É CARREGADO, IMEDIATMENTE RESTAURA DO SERVIDOR A ENQUETE
    $scope.restaurarEnquete($routeParams.id);
})

//Controller para listar as enquetes
enquete.controller('EnqueteListagem', function($rootScope, $location, $scope, $mdDialog, $http, requisicaoService) {
    $scope.lista = '';
    
    $rootScope.restaurarEnquetes = function() {
        requisicaoService.get("./slim/")
        .success(function(data) {
            $scope.lista = data.resultado;
        });
    };

    $rootScope.responder = function(id) {
        $location.path('/enquete/' + id);
    };

    $rootScope.editar = function(id) {
        $location.path('/enquete/editar/' + id);
    }

    //FUNÇÃO PARA CONFIRMAR REMOÇÃO DA ENQUETE
    $rootScope.confirmarRemocao = function(ev) {
        // Appending dialog to document.body to cover sidenav in docs app
        var confirm = $mdDialog.confirm()
                .title('Remover')
                .content('Você tem certeza que deseja remover esta enquete?')
                .ok('Sim')
                .cancel('Cancelar')
                .targetEvent(ev);
        $mdDialog.show(confirm).then(function() {
            requisicaoService.post("./slim/enquete/remover", {id: ev})
                    .success(function(data) {
                        if (data.resultado === 1) {
                            alert("Removido com sucesso!!");
                            window.location.reload();
                        } else {
                            alert("Erro ao remover!");
                        }
                    });
        }, function() {

        });
    };

    //ABRE MODAL PARA CONFIRMAR REMOÇÃO
    $rootScope.remover = function(id) {
        $rootScope.confirmarRemocao(id);
    };

    $rootScope.restaurarEnquetes();
});