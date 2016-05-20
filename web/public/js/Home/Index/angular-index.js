var indexApp = angular.module('indexApp', [])
.controller('brandCtrl', ['$scope','$http',function($scope, $http){
   // console.log('brandAPP is running');
    $http.get(__ROOT__ + '/index.php/Api/brand')
    .then(function(rsp){
        if (rsp.data && rsp.data.list){
            $scope.brand = rsp.data.list;
        }
        console.log($scope.brand);
    }, function(rsp){
        // console.log('brandApp request failed');
        // console.log(rsp);
    });

}]).controller('featuredCtrl',['$scope','$http',function($scope,$http){
    $http.get(__ROOT__ + '/index.php/Api2/Index/index/goods').success(function(data){
        $scope.goods = data.data;
        // console.log('featureCtrl goods', $scope.goods);
    });
    $http.get(__ROOT__ + '/index.php/Api2/Index/index/goods_cate?has_goods=1').success(function(data){
        $scope.goods_cate = data;
        // console.log('featureCtrl goods_cate', $scope.goods_cate);
    });
}]).controller('cateCtrl',['$scope','$http',function($scope,$http){
    $http.get(__ROOT__ + '/index.php/Api2/Index/index/goods_cate').success(function(data){
        $scope.cate = data.data;
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