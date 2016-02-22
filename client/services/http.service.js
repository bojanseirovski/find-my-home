(function() {
    'use strict';
    
    angular
        .module('app')
        .factory('HttpService', HttpService);
        
    HttpService.inject = [$http];
    
    function HttpService($http) {
        var services = {
            GET: GET,
            POST: POST,
        };
        
        return services;
        
        /////////////////////
        
        function GET(url, callback) {
            var request = {
                method: 'GET',
                url: url
            };
            
            httpSessionWithRequest(request, function(error, data) {
               if (!error) {
                   callback(null, data);
               } else {
                   callback(error, null);
               }
            });
        }
        
        function POST(url, data, callback) {
            var request = {
                method: 'POST',
                url: url,
                data: data,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            };
            
            httpSessionWithRequest(request, function(error, data) {
               if (!error) {
                   callback(null, data);
               } else {
                   callback(error, null);
               }
            });
        }
        
        function httpSessionWithRequest(request, callback) {
            $http(request)
            .success(function (data, status, headers, config) {
                console.log(request);
                // console.log('headers: ' + headers);
                // console.log('config: ' + config);
                console.log('status: ' + status);
                console.log(data);
                callback(null, data);
            })
            .error(function (data, status, headers, config) {
                // console.log(request);
                // console.log('headers: ' + headers);
                // console.log('config: ' + config);
                console.log('status: ' + status);
                console.log(data);
                callback(data, null);
            });
        }
    }
})();