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
        console.log('brandApp request failed');
        console.log(rsp);
    });
}]).controller('featuredCtrl',['$scope','$http',function($scope,$http){
    $http.get(__ROOT__ + '/index.php/Api2/goods').success(function(data){
        $scope.goods = data.data;
    });
}]).controller('cateCtrl',['$scope','$http',function($scope,$http){
    $http.get(__ROOT__ + '/index.php/Api2/goods_cate').success(function(data){
        $scope.cate = data.data;
    });
}]);