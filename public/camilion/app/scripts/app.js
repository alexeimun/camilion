///<reference path="../../../../typings/main/ambient/angular/index.d.ts"/>
///<reference path="../../../../typings/main/ambient/angular-route/index.d.ts"/>
///<reference path="controllers/main.ts"/>
///<reference path="controllers/navigation.ts"/>
///<reference path="services/TableService.ts"/>
var Camilion;
(function (Camilion) {
    var app = (function () {
        function app() {
        }
        app.create = function () {
            return angular.module('camilionApp', ['ngRoute']).config(["$routeProvider", function (routeProvider) {
                    routeProvider.when('/', {
                        templateUrl: 'public/camilion/app/partials/main.html',
                        controller: 'MainController',
                        controllerAs: 'vm'
                    }).when('/navigation', {
                        templateUrl: 'public/camilion/app/partials/nav.html',
                        controller: 'NavController',
                        controllerAs: 'nav'
                    }).otherwise({
                        redirectTo: '/'
                    });
                }]).run(function ($http) {
                $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
            })
                .service('TableService', Camilion.TableService)
                .controller('MainController', Camilion.MainController).controller('NavController', Camilion.NavController);
        };
        return app;
    }());
    Camilion.app = app;
    function init() {
        Camilion.Gcc = app.create();
    }
    Camilion.init = init;
})(Camilion || (Camilion = {}));
Camilion.init();
