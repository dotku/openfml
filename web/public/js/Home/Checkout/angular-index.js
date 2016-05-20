var indexApp = angular.module('checkoutApp', [])
.controller('cartCtrl', ['$rootScope', '$scope','$http',function($rootScope, $scope, $http){
    $scope.total_price_item = 0;
    console.log('checkoutAPP is running');
    // console.log('goods_id', goods_id);
    // console.log('goods_quantity', goods_quantity);
    // $scope.goods = [];

    $http.get(__ROOT__ + '/index.php/Api2/Index/index/goods?goods_id=' + goods_id)
    .then(function(rsp){
        console.log(rsp);
        if (rsp.data && rsp.data.data) {
            $rootScope.goods = $scope.goods = rsp.data.data;
            
            for (var i = 0; i < $scope.goods[i]; i++) {
                if (goods_quantity > 0) {
                    goods_quantity_update(i, goods_quantity);
                } else {
                    goods_quantity_update(i, 1);
                }
            }
            
        }
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
        $scope.goods[index].quantity = num;
        $scope.total_price_item += $scope.goods[index].unit_price * num;
        /*
          <div>{{total_price_item}}</div>
          <div>{{tax_sale}}</div>
          <div>{{fee_shipping}}</div>
          <div>{{total_price_final}}(~12,345 人民币)</div>
        */
    }
    
    $scope.updateReport = function(index){
        console.log('trigger updateReport');
        $rootScope.total_price_item = 0;
        for(var i = 0; i < $scope.goods.length; i ++) {
            $rootScope.total_price_item += Math.round($scope.goods[i].unit_price * $scope.goods[i].quantity * 100)/100;
            console.log('$rootScope.total_price_item', $rootScope.total_price_item);
        }
    }
    
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

.controller('reportCtrl', ['$rootScope','$http',function($rootScope, $http){
    $scope.total_price_item = 0;
    
    /*
    
    */
    
}]);
