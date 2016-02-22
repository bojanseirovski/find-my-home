(function () {
    'use strict';

    angular
        .module('app')
        .controller('IndexController', Controller);

    Controller.$inject = ['ArrayService', 'ApiService'];

    function Controller(ArrayService, ApiService) {
        var vm = this;

        var selfGdp;
        var opponentGdp;

        var opponentCarbon
        var selfCarbon

        vm.title = 'IndexController';
        vm.selfCountry;
        vm.selfGdp;
        vm.selfCarbon;

        vm.opponentCountry = "Choose from map";
        vm.opponentGdp;
        vm.opponentCarbon;

        vm.carbonDifference;
        vm.gdpDifference;

        activate();

        //////////////////
        function activate() {
            getLocation();
            createDataMap();
            showLoader();
        }

        function createDataMap() {
            var map = new Datamap({
                element: document.getElementById('map'),
                fills: {
                    defaultFill: 'rgba(23,48,210,0.9)' //any hex, color name or rgb/rgba value
                },
                done: function(datamap) {
                    datamap.svg.selectAll('.datamaps-subunit').on('click', function(geography) {
                       getCountryInfo(geography.id);
                    });
                }
            });
        }

        function removeLoader() {
            $("#loader").remove();
        }

        function showLoader() {
            $("body").append('<button class="btn btn-lg btn-warning" id="loader"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...</button>');
        }

        function createChartForCountry(id ,carbon){
            new Chartist.Line(id, {
              labels: ['past', 'present', 'future'],
              series: [
                [carbon.past, carbon.present,carbon.future]
              ]
            }, {
              fullWidth: true,
              chartPadding: {
                right: 10
              }
            });
        }


        function createChartForCountryGdp(id,yf, yt, from,to){
            new Chartist.Line(id, {
              labels: [yf,yt],
              series: [
                [from,to]
              ]
            }, {
              fullWidth: true,
              chartPadding: {
                right: 10
              }
            });
        }

        // get user lat lon location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getCountryCodeWithPosition);
            } else {
                console.log('Geolocation is not supported by this browser');
            }
        }

        function getCountryCodeWithPosition(position) {
            ApiService.getLocationInfoWithPosition(position, function (error, data) {
                if (!error) {
                    locationDataParser(data);
                } else {
                    console.log(error);
                }
            });
        }

        // Parse location info
        function locationDataParser(data) {
            var countryCode;
            var formattedAddress;

            if (data.status == "OK") {
                var results = data.results[0];
                var addressComponents = results['address_components'];
                var i = {};

                for (i in addressComponents) {
                    if (ArrayService.doesArrayContainObject(addressComponents[i]['types'], 'country')) {
                        countryCode = addressComponents[i]['short_name'];
                        vm.selfCountry =  addressComponents[i]['long_name'];
                    }
                    formattedAddress = results['formatted_address'];
                }
            }

            if (countryCode) {
                getSelfGdp(countryCode);
                getSelfEco(countryCode);
            }
        }

        function getOpponentDataWithCountryCode(countryCode) {
            getOpponentGdp(countryCode);
            getOpponentEco(countryCode);
        }

        function getSelfGdp(country) {
            ApiService.getGdpWithCountryCode(country, function(error, data) {
               if (!error) {
                   removeLoader();
                   selfGdp = data.average;
                   vm.selfGdp = data.average + " " + data.info;
                   createChartForCountryGdp('#chart-gdp',data.year_from, data.year_to,data.year_from_val, data.year_to_val );
               } else {
                   console.log(error);
               }
            });
        }

        function getSelfEco(country) {
            ApiService.getEcoDataWithCountryCode(country, function(error, data) {
               if (!error) {
                   selfCarbon = data.average_carbon;
                   vm.selfCarbon = data.average_carbon  + " KT";
                   createChartForCountry('#chart-carbon',data.carbon);
               } else  {
                   console.log(error);
               }
            });
        }

        function getCountryInfo(country) {
            showLoader();
            ApiService.getCountryInfoWithCountryCode(country, function(error, data) {
                if (!error) {
                    getOpponentDataWithCountryCode(data.iso2);
                    vm.opponentCountry = data.country;
                } else  {
                    console.log(error);
                }
            });
        }

        function getOpponentGdp(country) {
            ApiService.getGdpWithCountryCode(country, function(error, data) {
                if (!error) {
                    opponentGdp = data.average;
                    vm.opponentGdp = data.average + " " + data.info;
                    createChartForCountryGdp('#chart-gdp',data.year_from, data.year_to,data.year_from_val, data.year_to_val );
                    calculateGDPDifference();
                } else {
                    console.log(error);
                }
            });
        }

        function getOpponentEco(country) {
            ApiService.getEcoDataWithCountryCode(country, function(error, data) {
               if (!error) {
                   opponentCarbon = data.average_carbon;
                   vm.opponentCarbon = data.average_carbon + " KT";
                   createChartForCountry('#chart-carbon',data.carbon);
                   calculateCarbonDifference()
               } else  {
                   console.log(error);
               }
            });
        }

        function twoDecimalPlaces(number) {
            return parseFloat(Math.round(number * 100) / 100).toFixed(2);
        }

        function calculateGDPDifference() {
            removeLoader();
            vm.gdpDifference = twoDecimalPlaces(((selfGdp - opponentGdp) / 100)) + "%";
        }

        function calculateCarbonDifference() {
            vm.carbonDifference = twoDecimalPlaces(((selfCarbon - opponentCarbon) / 100)) + "%";
        }
    }
})();