///<reference path="../app.ts"/>

module Camilion {

    export class NavController {

        static $inject = ['$scope'];
        query: string;

        constructor(private $scope: any)
        {
            $scope.visible = (item): boolean =>
            {
                let visible = true;

                if($scope.query && $scope.query.length > 0)
                {
                    if(item.title.indexOf($scope.query) != -1) {
                        return true;
                    }
                    else {
                        visible = false;
                        angular.forEach(item.nodes, (v, i) =>
                        {
                            if(v.nodes.hasOwnProperty('title') && v.nodes.title.indexOf($scope.query) != -1) {
                                visible = true;
                            }
                        });
                    }
                }

                return visible;
            };
            $scope.findNodes = ()=>
            {

            };
            $scope.remove = (scope)=>
            {
                scope.remove();
            };

            $scope.toggle = (scope)=>
            {
                scope.toggle();
            };

            $scope.moveLastToTheBeginning = ()=>
            {
                var a = $scope.data.pop();
                $scope.data.splice(0, 0, a);
            };

            $scope.newSubItem = (scope)=>
            {
                var nodeData = scope.$modelValue;
                nodeData.nodes.push({
                    id : nodeData.id * 10 + nodeData.nodes.length,
                    title : nodeData.title + '.' + (nodeData.nodes.length + 1),
                    nodes : []
                });
            };

            $scope.collapseAll = ()=>
            {
                $scope.$broadcast('angular-ui-tree:collapse-all');
            };

            $scope.expandAll = ()=>
            {
                $scope.$broadcast('angular-ui-tree:expand-all');
            };

            $scope.data = [{
                'id' : 1,
                'title' : 'node1',
                'nodes' : [
                    {
                        'id' : 11,
                        'title' : 'node1.1',
                        'nodes' : [
                            {
                                'id' : 111,
                                'title' : 'node1.1.1',
                                'nodes' : []
                            }
                        ]
                    },
                    {
                        'id' : 12,
                        'title' : 'node1.2',
                        'nodes' : []
                    }
                ]
            }, {
                'id' : 2,
                'title' : 'node2',
                'nodrop' : true, // An arbitrary property to check in custom template for nodrop-enabled
                'nodes' : [
                    {
                        'id' : 21,
                        'title' : 'node2.1',
                        'nodes' : []
                    },
                    {
                        'id' : 22,
                        'title' : 'node2.2',
                        'nodes' : []
                    }
                ]
            }, {
                'id' : 3,
                'title' : 'node3',
                'nodes' : [
                    {
                        'id' : 31,
                        'title' : 'node3.1',
                        'nodes' : []
                    }
                ]
            }];
        }

        sendForm(): void
        {

        }
    }
}