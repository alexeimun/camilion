///<reference path="../app.ts"/>
var Camilion;
(function (Camilion) {
    var NavController = (function () {
        function NavController($scope) {
            this.$scope = $scope;
            $scope.visible = function (item) {
                var visible = true;
                if ($scope.query && $scope.query.length > 0) {
                    if (item.title.indexOf($scope.query) != -1) {
                        return true;
                    }
                    else {
                        visible = false;
                        angular.forEach(item.nodes, function (v, i) {
                            if (v.nodes.hasOwnProperty('title') && v.nodes.title.indexOf($scope.query) != -1) {
                                visible = true;
                            }
                        });
                    }
                }
                return visible;
            };
            $scope.findNodes = function () {
            };
            $scope.remove = function (scope) {
                scope.remove();
            };
            $scope.toggle = function (scope) {
                scope.toggle();
            };
            $scope.moveLastToTheBeginning = function () {
                var a = $scope.data.pop();
                $scope.data.splice(0, 0, a);
            };
            $scope.newSubItem = function (scope) {
                var nodeData = scope.$modelValue;
                nodeData.nodes.push({
                    id: nodeData.id * 10 + nodeData.nodes.length,
                    title: nodeData.title + '.' + (nodeData.nodes.length + 1),
                    nodes: []
                });
            };
            $scope.collapseAll = function () {
                $scope.$broadcast('angular-ui-tree:collapse-all');
            };
            $scope.expandAll = function () {
                $scope.$broadcast('angular-ui-tree:expand-all');
            };
            $scope.data = [{
                    'id': 1,
                    'title': 'node1',
                    'nodes': [
                        {
                            'id': 11,
                            'title': 'node1.1',
                            'nodes': [
                                {
                                    'id': 111,
                                    'title': 'node1.1.1',
                                    'nodes': []
                                }
                            ]
                        },
                        {
                            'id': 12,
                            'title': 'node1.2',
                            'nodes': []
                        }
                    ]
                }, {
                    'id': 2,
                    'title': 'node2',
                    'nodrop': true,
                    'nodes': [
                        {
                            'id': 21,
                            'title': 'node2.1',
                            'nodes': []
                        },
                        {
                            'id': 22,
                            'title': 'node2.2',
                            'nodes': []
                        }
                    ]
                }, {
                    'id': 3,
                    'title': 'node3',
                    'nodes': [
                        {
                            'id': 31,
                            'title': 'node3.1',
                            'nodes': []
                        }
                    ]
                }];
        }
        NavController.prototype.sendForm = function () {
        };
        NavController.$inject = ['$scope'];
        return NavController;
    }());
    Camilion.NavController = NavController;
})(Camilion || (Camilion = {}));
