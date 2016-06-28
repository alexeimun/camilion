///<reference path="../app.ts"/>
var Camilion;
(function (Camilion) {
    var NavController = (function () {
        function NavController(tableService) {
            this.tableService = tableService;
            this.data = {
                TABLE_NAME: '',
                LAYOUT: 'main',
                PREFIX: 't_',
                SINGULAR: '',
                FIELDS: '',
                TABLE: ''
            };
        }
        NavController.prototype.sendForm = function () {
            this.tableService.sendForm(this.data).then(function (response) {
                // success function
            }, function (response) {
                console.log(response, 'error');
            });
        };
        NavController.$inject = [
            "TableService"
        ];
        return NavController;
    }());
    Camilion.NavController = NavController;
})(Camilion || (Camilion = {}));
