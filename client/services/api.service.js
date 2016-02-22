(function () {
    'use strict';

    angular
        .module('app')
        .factory('ApiService', ApiService);

        ApiService.inject = [HttpService];

        function ApiService(HttpService) {
            var url = 'http://ubks59ec4c49.bojanseirovski.koding.io';
            var key = 'NwvprhfBkGuPJnjJp77UPJWJUpgC7mLz';

            var service = {
                getLocationInfoWithPosition: getLocationInfoWithPosition,
                getGdpWithCountryCode: getGdpWithCountryCode,
                getEcoDataWithCountryCode: getEcoDataWithCountryCode,
                getCountryInfoWithCountryCode: getCountryInfoWithCountryCode
            }

            return service;

            //////////////////////

            // get location info from google
            function getLocationInfoWithPosition(position, callback) {
                HttpService.GET('http://maps.googleapis.com/maps/api/geocode/json?latlng='+ position.coords.latitude + ',' + position.coords.longitude + '&sensor=true', function(error, data) {
                    if (!error) {
                        callback(null, data);
                    } else {
                        callback(error, null);
                    }
                });
            }

            function getGdpWithCountryCode(country, callback) {
                var data = {
                    "country"   : country,
                    "key"       : key
                };

                HttpService.POST(url + '/gdp', data, function(error, data) {
                   if (!error) {
                       if (data.success === true) {
                            callback(null, data.data);
                       } else {
                           callback(data);
                       }
                   } else {
                       callback(error, null);
                   }
                });
            }
            
            function getEcoDataWithCountryCode(country, callback) {
                var data = {
                    "country"   : country,
                    "key"       : key
                };
                
                HttpService.POST(url + '/eco', data, function(error, data) {
                   if (!error) {
                       if (data.success === true) {
                            callback(null, data.data);
                       } else {
                           callback(data);
                       }
                   } else {
                       callback(error, null);
                   }
                });
            }
            
            function getCountryInfoWithCountryCode(country, callback) {
                var data = {
                    "country"   : country,
                    "key"       : key
                };
                
                HttpService.POST(url + '/country', data, function(error, data) {
                   if (!error) {
                        if (data.success === true) {
                            callback(null, data.data[0]);
                        } else {
                           callback(data);
                        }
                   } else {
                       callback(error, null);
                   }
                });
            }
        }
})();