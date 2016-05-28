var indexApp = angular.module('indexApp', [])
.controller('headerCtrl', ['$rootScope', '$scope','$http',function($rootScope, $scope, $http){
    
    
    
    $rootScope.updateCartNum = function(){
        $http.get(__ROOT__ + '/index.php/api/cart')
        .then(function(rsp){
            console.log('headerCtrl rsp', rsp);
            $scope.cart = rsp.data.value;
            $rootScope.totalNum = 0;
            for (var i = 0; i < $scope.cart.length; i ++){
                console.log('$scope.cart[i].quantity', $scope.cart[i].quantity);
                $rootScope.totalNum += parseInt($scope.cart[i].quantity);
            }
            $scope.totalNum = $rootScope.totalNum;
            console.log('$scope.totalNum', $rootScope.totalNum);

        });
    }
    $rootScope.updateCartNum();
}])
.controller('brandCtrl', ['$scope','$http',function($scope, $http){
   // console.log('brandAPP is running');
    $http.get(__ROOT__ + '/index.php/Api/Brand/index')
    .then(function(rsp){
        if (rsp.data && rsp.data.list){
            $scope.brand = rsp.data.list;
        }
        // console.log($scope.brand);
    }, function(rsp){
        // console.log('brandApp request failed');
        // console.log(rsp);
    });

}]).controller('featuredCtrl',['$rootScope', '$scope','$http',function($rootScope, $scope,$http){
    $http.get(__ROOT__ + '/index.php/Api2/Index/index/goods').success(function(data){
        $scope.goods = data.data;
        // console.log('featureCtrl goods', $scope.goods);
    });
    $http.get(__ROOT__ + '/index.php/Api2/Index/index/goods_cate?has_goods=1').success(function(data){
        $scope.goods_cate = data;
        // console.log('featureCtrl goods_cate', $scope.goods_cate);
    });
    $scope.cartAdd = function(obj){
        console.log('cartAdd index', obj);
        console.log('cartAdd scope', obj.target.getAttribute('data-id'));
        inputData = {'goods_id': obj.target.getAttribute('data-id')}
        $http.post(__ROOT__ + '/index.php/api/cart', inputData)
        .success(function(data){
            console.log(__ROOT__ + '/index.php/api/cart');
            console.log('addToCart', inputData);
            console.log('addToCart return', data);
            $rootScope.updateCartNum();
        })
    }
}]).controller('cateCtrl',['$scope','$http',function($scope,$http){
    $http.get(__ROOT__ + '/index.php/Api2/Index/index/goods_cate').success(function(data){
        if (data.status_code > 0){
            $scope.cate = data.data;
        } else {
            $scope.cate = [];
            console.log(data);
        }
        
    });
}]).filter('filterByCate', function(){
    return function(goods, gc_id){
        console.log('filter', gc_id);
        console.log('filterByCate goods', goods);
        for (var i = 0; i < goods.length; i++){
            if (goods[i].cate_id != gc_id){
                goods.splice(i, 1);
            }
        }
        console.log('filterByCate goods', goods);
        return goods;
    }
});