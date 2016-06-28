///<reference path="../../../../../typings/main/ambient/angular/index.d.ts"/>
///<reference path="../models/Table.ts"/>
var Camilion;
(function (Camilion) {
    var TableService = (function () {
        function TableService($http, $q, $log) {
            this.$http = $http;
            this.$q = $q;
            this.$log = $log;
        }
        TableService.prototype.getTables = function () {
            var def = this.$q.defer();
            this.$http.get('ccg/gettables').then(function (response) {
                def.resolve(response.data);
            }).catch(function (reason) {
                def.reject(reason);
            });
            return def.promise;
        };
        TableService.prototype.getallTableFields = function () {
            var def = this.$q.defer();
            this.$http.get('ccg/getalltablefields').then(function (response) {
                def.resolve(response.data);
            }).catch(function (reason) {
                def.reject(reason);
            });
            return def.promise;
        };
        TableService.prototype.sendForm = function (data) {
            var def = this.$q.defer();
            this.$http.post('ccg', $.param(data)).then(function (response) {
                def.resolve(response.data);
            }).catch(function (reason) {
                def.reject(reason);
            });
            return def.promise;
        };
        TableService.$inject = ["$http", "$q", "$log"];
        return TableService;
    }());
    Camilion.TableService = TableService;
})(Camilion || (Camilion = {}));
