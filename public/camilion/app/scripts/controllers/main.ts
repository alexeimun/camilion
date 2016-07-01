///<reference path="../app.ts"/>

module Camilion {

    export interface IData {
        TABLE_NAME: string;
        LAYOUT: string;
        PREFIX: string;
        SINGULAR: string;
        FIELDS: Table[];
        TABLE: string;
    }
    export class MainController {

        public data: IData = {
            TABLE_NAME : '',
            LAYOUT : 'main',
            PREFIX : 't_',
            SINGULAR : '',
            FIELDS : [],
            TABLE : ''
        };
        public fields: Table[];
        public tables: string[];

        static $inject = [
            "TableService"
        ];

        constructor(private tableService: TableService)
        {
            //Definition block

            tableService.getTables().then((resp: string[]) =>
            {
                this.tables = resp;
                this.data.TABLE_NAME = resp[0];
                this.changeSingular();

            }).catch(reason =>
            {
                console.log("something went wrong!", reason);
            });

            tableService.getallTableFields().then((tables: Table[]) =>
            {
                tables[this.data.TABLE_NAME] = tables[this.data.TABLE_NAME].map((item)=>
                {
                    item.typeselect = this.tasteType(item.Type);
                    return item;
                });
                this.fields = tables;
            }).catch(reason =>
            {
                console.log("something went wrong!", reason);
            });

        }

        changeSingular(): void
        {
            this.data.SINGULAR = this.data.TABLE_NAME.substr(this.data.PREFIX.length, this.data.TABLE_NAME.length - this.data.PREFIX.length - 1).replace('_', '');
        }

        clearData(field: Table): void
        {
            delete field['textSelect'];
            delete field['linkTable'];
            delete field['valueSelect'];
        }

        sendForm(): void
        {
            this.data.TABLE = this.data.TABLE_NAME.substring(this.data.PREFIX.length);
            this.data.FIELDS = this.fields[this.data.TABLE_NAME];

            this.tableService.sendForm(this.data).then((response: string)=>
            {
                // success function
            }, (response: string)=>
            {
                console.log(response, 'error');
            });
        }

        tasteType(type): string
        {
            var t = 'Text';

            if(type.indexOf('(') > -1) {
                var variable = {
                    typo : type.split('(')[0],
                    length : type.split('(')[1].split(')')[0]
                };
                switch (variable.typo) {
                    case 'varchar':
                        if(variable.length <= 15) {
                            t = 'Price';
                        }
                        else if(variable.length < 150) {
                            t = 'Text';
                        }
                        else {
                            t = 'Textarea';
                        }
                        break;
                    case 'integer':
                    case 'int':
                    case 'tinyint':
                    case 'smallint':
                    case 'bigint':
                        if(variable.length < 2) {
                            t = 'Skip';
                        }
                        if(variable.length < 15) {
                            t = 'Text';
                        }
                        else {
                            //befero Select
                            t = 'Skip';
                        }
                        break;

                    case 'bit':
                    case 'binary':
                        t = 'Skip';
                        break;
                }
            }
            else {
                switch (type) {
                    case 'datetime':
                        t = 'Skip';
                        break;
                    case 'date':
                        t = 'Skip';
                        break;
                }
            }
            return t;
        }
    }
}