(function() {
    'use strict';
    
    angular
        .module('app')
        .factory('ArrayService', ArrayService);
    
    ArrayService.inject = [];
    
    function ArrayService() {
        var services = {
            findIndexByKeyValue: findIndexByKeyValue,
            doesArrayContainObject: doesArrayContainObject
        };
        
        return services;
        
        //////////////////
        function findIndexByKeyValue(obj, key, value) {
            for (var i = 0; i < obj.count; i++) {
                if (obj[i][key] == value) {
                    return i;
                }
            }
            
            return null;
        }
        
        function doesArrayContainObject(array, object) {
            var i = {};
            for (i in array) {
                if (array[i] == object) {
                    return true;
                }
            }
            
            return false;
        }
    }
})();