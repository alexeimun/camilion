///<reference path="../../../../../typings/main/ambient/angular/index.d.ts"/>
///<reference path="../models/Table.ts"/>

module Camilion {
    export interface ITableService {
        getallTableFields(): ng.IPromise<Table[]>;
        getTables(Table): ng.IPromise<string[]>;
        sendForm(any): ng.IPromise<string>;
    }

    export class TableService implements ITableService {

        static $inject = ["$http", "$q", "$log"];

        constructor(private $http: ng.IHttpService, private $q: ng.IQService, private $log: ng.ILogService)
        {
        }

        getTables(): ng.IPromise<string[]>
        {
            var def = this.$q.defer();

            this.$http.get('ccg/gettables').then(response =>
            {
                def.resolve(response.data);
            }).catch(reason =>
            {
                def.reject(reason);
            });

            return def.promise;
        }

        getallTableFields(): ng.IPromise<Table[]>
        {
            var def = this.$q.defer();

            this.$http.get('ccg/getalltablefields').then(response =>
            {
                def.resolve(response.data);
            }).catch(reason =>
            {
                def.reject(reason);
            });

            return def.promise;
        }

        sendForm(data: any): ng.IPromise<string>
        {
            var def = this.$q.defer();

            this.$http.post('ccg', $.param(data)).then(response =>
            {
                def.resolve(response.data);
            }).catch(reason =>
            {
                def.reject(reason);
            });

            return def.promise;
        }
    }
}