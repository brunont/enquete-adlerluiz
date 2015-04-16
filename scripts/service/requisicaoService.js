var requisicao = angular.module('requisicaoService', []);

requisicao.factory('requisicaoService', function($http){
    function get(url, params) {
        return $http.get(url, params);
    }
    
    function post(url, params) {
        return $http.post(url, params);
    }
    
    restaurarEnquete = function(id) {
        try {
            r = get("./slim/enquete/" + id);
            return r
        } finally {
            
        }
    }
    
    restaurarEnquetes = function() {
        try {
            return get("./slim/");
        } finally {
            
        }
    }
    
    restaurarEnqueteRelatorio = function(id) {
        try {
            return get("./slim/relatorio/enquete/" + id);
        } finally {
            
        }
    }
   
    return {
        get                : get,
        post               : post,
        restaurarEnquete   : restaurarEnquete,
        restaurarEnquetes  : restaurarEnquetes,
        restaurarEnqueteRelatorio : restaurarEnqueteRelatorio
    };
})