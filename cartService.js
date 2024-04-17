
angular.module('ecommerceApp').service('CartService', function ($http) {
    this.getTotalCartPrice = function () {
        return $http.get('/api/cart/total-price').then(function (response) {
            return response.data.totalPrice;
        });
    };
});
