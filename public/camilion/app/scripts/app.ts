///<reference path="../../../../typings/main/ambient/angular/index.d.ts"/>
///<reference path="../../../../typings/main/ambient/angular-route/index.d.ts"/>
///<reference path="controllers/main.ts"/>
///<reference path="controllers/navigation.ts"/>
///<reference path="services/TableService.ts"/>

module Camilion {

    export var Gcc: ng.IModule;

    export class app {

        static create(): ng.IModule
        {
            return angular.module('camilionApp', ['ngRoute']).config(["$routeProvider", (routeProvider: angular.route.IRouteProvider) =>
            {
                routeProvider.when('/', {
                    templateUrl : 'public/camilion/app/partials/main.html',
                    controller : 'MainController',
                    controllerAs : 'vm'
                }).when('/navigation', {
                    templateUrl : 'public/camilion/app/partials/nav.html',
                    controller : 'NavController',
                    controllerAs : 'nav'
                }).otherwise({
                    redirectTo : '/'
                });
            }]).run(function ($http)
            {
                $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
            })
            //Services
                .service('TableService', TableService)
                //Controllers
                .controller('MainController', MainController).controller('NavController', NavController)
        }
    }
    export function init()
    {
        Gcc = app.create();
    }
}
Camilion.init();
