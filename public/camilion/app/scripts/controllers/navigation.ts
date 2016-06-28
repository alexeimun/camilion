///<reference path="../app.ts"/>

module Camilion {
    export class NavController {

        public data = {
            TABLE_NAME : '',
            LAYOUT : 'main',
            PREFIX : 't_',
            SINGULAR : '',
            FIELDS : '',
            TABLE : ''
        };
        public fields: Table[];
        public tables: string[];

        static $inject = [
            "TableService"
        ];

        constructor(private tableService: TableService)
        {

        }

        sendForm(): void
        {
            this.tableService.sendForm(this.data).then((response: string)=>
            {
                // success function
            }, (response: string)=>
            {
                console.log(response, 'error');
            });
        }
    }
}