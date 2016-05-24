var indexApp = angular.module('checkoutApp', [])
.controller('cartCtrl', ['$rootScope', '$scope','$http',function($rootScope, $scope, $http){
    // $scope.total_price_item = 0;
    console.log('checkoutAPP is running');
    console.log('goods_id', goods_id);
    // console.log('goods_quantity', goods_quantity);
    // $scope.goods = [];

    if (goods_id){
        httpRequst = $http.get(__ROOT__ + '/index.php/Api2/Index/index/goods?goods_id=' + goods_id);
    } else {
        httpRequst = $http.get(__ROOT__ + '/index.php/Api/cart');
    }

    httpRequst.then(function(rsp){
        console.log(rsp);
        if (rsp.data && rsp.data.data) {
            $rootScope.goods = $scope.goods = rsp.data.data;
            
            for (var i = 0; i < $scope.goods.length; i++) {
                if ($scope.goods[i].quantity > 0) {
                    $scope.goods_quantity_update(i, $scope.goods[i].quantity);
                } else {
                    $scope.goods_quantity_update(i, 1);
                }
            }
            
        }
        $scope.updateReport();
        console.log('$scope.goods', $scope.goods);
    }, function(rsp){
        // console.log('brandApp request failed');
        // console.log(rsp);
    });

    $scope.item_remove = function(index) {
        if (confirm('删除购物车物品')){
            $scope.goods.splice(index, 1);
            console.log('cartCtrl', $scope.goods);
        }
        
    }

    $scope.goods_quantity_update = function(index, num) {
        $rootScope.goods[index].quantity = num;
        $rootScope.total_price_item += $rootScope.goods[index].unit_price * num;
        // $scope.goods = $rootScope.goods;
    }
    
    $scope.updateReport = function(index){
        console.log('trigger updateReport');
        $rootScope.total_price_item = 0;
        $rootScope.total_tax_value = 0;
        for (var i = 0; i < $scope.goods.length; i ++) {
            $rootScope.total_price_item += $scope.goods[i].unit_price * $scope.goods[i].quantity;
            if ($scope.goods[i].tax_rate > 0) {
                $rootScope.total_tax_value += Math.round($scope.goods[i].unit_price * $scope.goods[i].tax_rate)/100;
            }
            console.log('$rootScope.total_price_item', $rootScope.total_price_item);
        }
        $rootScope.total_price_item = Math.round($rootScope.total_price_item * 100)/100;
        $rootScope.total_final = $rootScope.total_price_item 
            + $rootScope.total_shipping_fee
            + $rootScope.total_tax_value;
        $rootScope.total_final = Math.round($rootScope.total_final * 100)/100;
        $http.get(__ROOT__ + '/index.php/api/openexchangerates')
        .then(function(rsp){
            $rootScope.total_final_RMB = Math.round($rootScope.total_final * rsp.data.CNY * 100)/100;
            console.log('getReate', rsp.data.CNY);
        });
    }
    
}])
.controller('receiverCtrl', ['$scope', '$http', function($scope, $http){
    /*
    $scope.level1 = [{fullname: "北京市"}];
    $scope.level2 = [{fullname: "北京市"}];
    $scope.level3 = [{fullname: "东城区"}];
    $scope.selectedLevel1 = $scope.level1[0];
    $scope.selectedLevel2 = $scope.level2[0];
    $scope.selectedLevel3 = $scope.level3[0];
    */
    $http.get(__ROOT__ + '/index.php/api/qqmap_ws_district')
    .then(function(rsp){

        console.log('addressCtrl', rsp.data);
        $scope.level1 = rsp.data.result[0];
        $scope.level2 = rsp.data.result[1];
        $scope.level3 = rsp.data.result[2];

        console.log('$scope.level1', $scope.level1);
        console.log('$scope.level2', $scope.level2);
        console.log('$scope.level3', $scope.level3);

        $scope.selectedLevel1 = $scope.level1[0];
    });
}])
.controller('shippingCtrl', ['$scope','$http',function($scope, $http){
    $http.get(__ROOT__ + '/index.php/Api2/Index/index/shipping_plan')
    .then(function(rsp){
        $scope.item = rsp.data.data[1];
        $scope.plan_detail = rsp.data.data[1].plan_detail;
        $scope.shipping_plan = rsp.data.data;
    });

    $scope.shipping_update = function(target){
        console.log('shipping_update id', target);
        $scope.plan_detail = target.plan_detail;
    }
}])

.controller('reportCtrl', ['$rootScope','$http',function($rootScope, $scope, $http){
    $rootScope.total_price_item = 0;
    $rootScope.total_tax_value = 0;
    $rootScope.total_shipping_fee = 0;
    $rootScope.total_final = 0;
    $rootScope.total_final_RMB = 0;
    console.log('$rootScope.total_price_item', $rootScope.total_price_item);
    /*
    
    */
}]);
