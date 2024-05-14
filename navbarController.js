var app = angular.module('ecommerceApp', ['ngRoute']);

app.config(["$routeProvider", function ($routeProvider) {
    $routeProvider.
        when("/cart", {
            templateUrl: "cart.php",
        }).
        when("/home", {
            templateUrl: "home.php",
            controller: "BrandController"
        }).
        when("/display_all", {
            templateUrl: "display_all.php",
        }).
        when("/profile", {
            templateUrl: "./users_area/profile.php",
        }).
        when("/profile/edit_account", {
            templateUrl: "./users_area/edit_account.php",
            controller: "EditAccountController"
        }).
        when("/profile/my_orders", {
            templateUrl: "./users_area/user_orders.php",
            controller: "getOrder",
        }).
        when("/profile/delete_account", {
            templateUrl: "./users_area/delete_account.php",
        }).
        when("/users_area/checkout", {
            templateUrl: "./users_area/checkout.php",
        }).
        when("/users_area/user_registration", {
            templateUrl: "./users_area/user_registration.html",
        }).
        when("/users_area/user_login", {
            templateUrl: "./users_area/user_login.php",
        }).
        when("index", {
            templateUrl: "index.php",
        }).
        when("/admin_area/view_products", {
            templateUrl: "./admin_area/view_products.php",
            controller: "AdminController"
        }).
        when("/admin_area/insert_product", {
            templateUrl: "./admin_area/insert_product.php",
            controller: "AdminController"
        }).
        when("/admin_area/insert_categories", {
            templateUrl: "./admin_area/insert_categories.php",
            controller: "AdminController"
        }).
        when("/admin_area/view_categories", {
            templateUrl: "./admin_area/view_categories.php",
            controller: "AdminController"
        }).
        when("/admin_area/insert_brand", {
            templateUrl: "./admin_area/insert_brands.php",
            controller: "AdminController"
        }).
        when("/admin_area/view_brand", {
            templateUrl: "./admin_area/view_brands.php",
            controller: "AdminController"
        }).
        when("/admin_area/list_orders", {
            templateUrl: "./admin_area/list_orders.php",
            controller: "AdminController"

        }).
        when("/admin_area/list_payments", {
            templateUrl: "./admin_area/list_payments.php",
            controller: "AdminController"
        }).
        when("/admin_area/list_users", {
            templateUrl: "./admin_area/list_users.php",
            controller: "AdminController"
        }).
        when("/admin_logout", {
            templateUrl: "./admin_area/admin_logout.php",
            controller: "LogoutController"
        }).
        when("/edit_category/:categoryId", {
            templateUrl: "./admin_area/edit_category.php",
            controller: "editCategory"
        }).
        when("/edit_brands/:brandId", {
            templateUrl: "./admin_area/edit_brands.php",
            controller: "editBrands"
        }).
        when("/edit_products/:productId", {
            templateUrl: "./admin_area/edit_products.php",
            controller: "editProducts"
        }).
        when("/admin_area/admin_login", {
            templateUrl: "./admin_area/admin_login.php",
            controller: "AdminController"
        }).
        when("/admin_area/dashboard", {
            templateUrl: "./admin_area/dashboard.php",
            controller: "AdminController"
        }).
        when("/admin_area/admin_registration", {
            templateUrl: "./admin_area/admin_registration.php",
        }).
        when("/brands/:brandId", {
            templateUrl: "getUniqueBrand.php",
            controller: "BrandDetailsController"
        }).
        when("/category/:categoryId", {
            templateUrl: "getUniqueCat.php",
            controller: "CategoryController"
        }).
        when("/search", {
            templateUrl: "search_product.php",
            controller: "SearchPageController",
        })
}]);

app.controller('LogoutController', function ($http, $window) {
    // Make an HTTP request to logout.php
    $http.get('admin_area/admin_logout.php')
        .then(function (response) {
            $window.location.href = '.#!/admin_area/admin_login';
        })
        .catch(function (error) {
            console.error('Error logging out:', error);
            // Handle error if necessary
        });
});

app.controller('SearchPageController', function ($scope, $rootScope) {
    $scope.products = $rootScope.products;
});


app.controller('SearchController', function ($scope, $rootScope, $http, $location) {
    $scope.searchData = '';
    $rootScope.products = [];

    $scope.noProductMessage = '';
    $scope.searchProduct = function () {
        $http.get('searchProduct.php', {
            params: { search_data_product: $scope.searchData }
        })
            .then(function (response) {
                console.log(response);
                $rootScope.products = response.data;
                console.log('Products', $rootScope.products);
                if ($rootScope.products.length === 0) {
                    $scope.noProductMessage = "No product found for this search!";
                } else {
                    // $scope.noProductMessage = "";
                    $location.path('/search');
                }
            })
            .catch(function (error) {
                console.log('Error searching products:', error);
            });
    };
});


app.controller('BrandDetailsController', function ($scope, $http, $routeParams) {
    $http.get('get_products_by_brand.php', {
        params: { brand: $routeParams.brandId }
    })
        .then(function (response) {
            $scope.products = response.data;
        })
        .catch(function (error) {
            console.log('Error fetching products by brand:', error);
        });
});


app.controller('CategoryController', function ($scope, $http, $routeParams) {
    // Fetch products based on category ID
    $http.get('get_products_by_category.php', {
        params: { category: $routeParams.categoryId }
    })
        .then(function (response) {
            // Assign fetched products to scope variable
            $scope.products = response.data;
        })
        .catch(function (error) {
            console.log('Error fetching products by category:', error);
        });
});

app.controller('editProducts', function ($scope, $http, $routeParams) {
    $scope.formData = {};
    var productId = $routeParams.productId;
    $scope.fetchProductData = function (productId) {
        $http.get('admin_area/fetchProductData.php?product_id=' + productId)
            .then(function (response) {
                $scope.formData = response.data;
                $scope.formData.product_price = parseFloat($scope.formData.product_price);
            })
            .catch(function (error) {
                console.error('Error fetching product data:', error);
            });
    };

    $scope.fetchProductData(productId);

    $scope.editProduct = function () {
        var formData = new FormData();
        formData.append('product_title', $scope.formData.product_title);
        formData.append('product_description', $scope.formData.product_description);
        formData.append('product_keywords', $scope.formData.product_keywords);
        formData.append('category_id', $scope.formData.category_id);
        formData.append('brand_id', $scope.formData.brand_id);
        formData.append('product_price', $scope.formData.product_price.toString());
        formData.append('product_image1', $scope.formData.product_image1);
        formData.append('product_id', $scope.formData.product_id);

        $http.post('admin_area/editProduct.php', formData, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
        }).then(function (response) {
            console.log(response.data);
            swal({
                title: "Success",
                text: "Product Updated successfully!",
                icon: "success",
                timer: 2000,
                buttons: false,
            }).then(function () {
                window.location.href = '.#!/admin_area/view_products';
            });
        }).catch(function (error) {
            console.error('Error updating product:', error);
            swal('Error', 'An error occurred while updating the product', 'error');
        });
    };
});


app.controller('editBrands', function ($scope, $http, $routeParams) {
    $scope.formData = {};

    var brandId = $routeParams.brandId;

    $http.get('admin_area/fetchBrandData.php?edit_brands=' + brandId)
        .then(function (response) {
            $scope.formData = response.data;
        })
        .catch(function (error) {
            console.error('Error fetching brand data:', error);
        });

    $scope.editBrand = function () {
        $http.post('admin_area/editBrand.php', { brand_id: brandId, brand_name: $scope.formData.brand_name })
            .then(function (response) {
                if (response.data.success) {
                    swal({
                        title: "Success",
                        text: "Brand Updated Successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '.#!/admin_area/view_brand';
                    });
                } else {
                    swal('Error', 'Error Updating Brand', 'error');
                }
            })
            .catch(function (error) {
                console.error('Error updating brand:', error);
                swal('Error', 'An error occurred while updating the brand', 'error');
            });
    };
});

app.controller('editCategory', function ($scope, $http, $routeParams) {
    $scope.formData = {};

    var categoryId = $routeParams.categoryId;


    $http.get('admin_area/fetchCategoryData.php?edit_category=' + categoryId)
        .then(function (response) {
            console.log('fetch:', response.data);
            $scope.formData = response.data;
        })
        .catch(function (error) {
            console.error('Error fetching category data:', error);
        });
    $scope.editCategory = function () {
        console.log('edited title', $scope.formData.category_title);
        $http.post('admin_area/editCategory.php', { category_id: categoryId, category_title: $scope.formData.category_title })
            .then(function (response) {
                console.log('response', response.data);
                if (response.data.success) {
                    swal({
                        title: "Success",
                        text: "Category Updated Successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '.#!/admin_area/view_categories';
                    });
                } else {
                    swal('Error', 'Error Updating Category', 'error');
                }
            })
            .catch(function (error) {
                console.error('Error updating category:', error);
                swal('Error', 'An error occurred while updating the category', 'error');
            });
    };
});

app.controller('getOrder', function ($scope, $http) {
    $scope.fetchUserOrders = function () {
        $http.get('users_area/getOrders.php')
            .then(function (response) {
                $scope.loading = false;
                $scope.orders = response.data;
            })
            .catch(function (error) {
                $scope.loading = false;
                $scope.error = 'Error fetching orders: ' + error.statusText;
            });
    };

    $scope.fetchUserOrders();
});

app.controller('EditAccountController', function ($scope, $http) {
    $scope.formData = {};
    $scope.updateSuccess = false;
    $scope.fetchUserDetails = function () {
        $http.get('users_area/getUserData.php')
            .then(function (response) {
                $scope.formData = response.data;
            })
            .catch(function (error) {
                console.error('Error fetching user details:', error);
            });
    };

    $scope.fetchUserDetails();

    $scope.updateAccount = function () {
        var formData = new FormData();
        angular.forEach($scope.formData, function (value, key) {
            formData.append(key, value);
        });

        formData.append('user_id', $scope.formData.user_id);

        $http.post('users_area/updateAccount.php', formData, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        })
            .then(function (response) {
                if (response.data.success) {
                    $scope.updateSuccess = true;
                    console.log('Account updated successfully');
                } else {
                    console.error('Error updating account:', response.data.error);
                }
            })
            .catch(function (error) {
                console.error('Error updating account:', error);
            });
    };
});


app.controller('BrandController', function ($scope, $http, $location) {
    // $scope.isLoginPage = function () {
    //     console.log($location.path())
    //     return $location.path() === '/users_area/user_login';
    // };
    // $scope.adlogin = function () {
    //     console.log($location.path())
    //     return $location.path() == '/admin_area/admin_login';
    // };
    // $scope.isUserDashboard = function () {
    //     console.log('user ng', $location.path())
    //     var userAreaPaths = ['/user_login', '/home', '/display_all', '/profile', '/cart', '/brands', '/category', '/search'];
    //     return userAreaPaths.some(function (path) {
    //         return $location.path().includes(path);
    //     });
    // };
    // $scope.isAdminDashboard = function () {
    //     console.log('admin ng', $location.path())
    //     var adminAreaPaths = ['/dashboard', '/admin_login'];
    //     return adminAreaPaths.some(function (path) {
    //         return $location.path().includes(path);
    //     });
    // };

    // $scope.fetchCartItems = function () {
    //     $http.get('cart_func.php').then(function (response) {
    //         $scope.cart = response.data;
    //     });
    // };



    $scope.cart = {
        cart_items: [],
        total_price: 0
    };
    $http.get('cart_func.php')
        .then(function (response) {
            $scope.cart.cart_items = response.data.cart_items;
            $scope.cart.total_price = response.data.total_price;
        }, function (error) {
            console.error('Error fetching cart items:', error);
        });

    $scope.checkItemUpdated = function () {
        $scope.isAnyItemUpdated();
    };

    $scope.isAnyItemUpdated = function () {
        $scope.cart.isUpdated = $scope.cart.cart_items.some(function (item) {
            return item.quantity !== item.originalQuantity;
        });
    };

    $scope.updateCart = function () {
        if (!$scope.cart.isUpdated) {
            swal('Update Quantity', "Please update at least one item's quantity before updating the cart.", 'warning');
            return;
        }
        $http.post('update_cart.php', { cart_items: $scope.cart.cart_items })
            .then(function (response) {
                $scope.cart.total_price = response.data.total_price;
                location.reload();
            }, function (error) {
                console.error('Error updating cart:', error);
            });
    };

    $scope.isAnyItemChecked = function () {
        return $scope.cart.cart_items.some(function (item) {
            return item.remove;
        });
    };

    $scope.removeItem = function () {
        if (!$scope.isAnyItemChecked()) {
            swal('Select atleast one item', "Please check at least one item to remove.", 'warning');
            return;
        }
        var removedItems = $scope.cart.cart_items.filter(function (item) {
            return item.remove;
        });
        $http.post('remove_cart_items.php', { removed_items: removedItems })
            .then(function (response) {
                $scope.cart.cart_items = $scope.cart.cart_items.filter(function (item) {
                    return !item.remove;
                });
                $scope.cart.total_price = response.data.total_price;
                location.reload();
            }, function (error) {
                console.error('Error removing cart items:', error);
            });
    };
    $scope.continueShopping = function () {
        window.location.href = '#!/home';
    };


    $scope.getPendingOrders = function () {
        $http.get('users_area/userProfile.php')
            .then(function (response) {
                if (response.data.hasOwnProperty('pendingOrders')) {
                    $scope.pendingOrders = parseInt(response.data.pendingOrders);
                } else {
                    console.error('Error: pendingOrders not found in response');
                }
            })
            .catch(function (error) {
                console.error('Error fetching pending orders:', error);
            });
    };

    var hideFunctionPaths = ['/users_area/user_registration', '/users_area/user_login', '/admin_area/admin_registration', '/admin_area/admin_login', '/admin_area/dashboard', '/admin_area/insert_product', '/admin_area/view_products', '/admin_area/insert_categories', '/admin_area/insert_brand', '/admin_area/view_brand', '/admin_area/list_orders', '/admin_area/list_payments', '/admin_area/list_users', '/admin_area/view_categories'];
    $scope.shouldHideFunctions = function () {
        var currentPath = $location.path();
        return hideFunctionPaths.includes(currentPath);
    };

    $scope.getPendingOrders();


    $scope.fetchBrands = function () {
        $http.get('getBrands.php')
            .then(function (response) {

                $scope.Bnames = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching brands:', error);
            });
    };


    $scope.fetchCategories = function () {
        $http.get('getCategory.php')
            .then(function (response) {

                $scope.Cnames = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching categories:', error);
            });
    };

    $scope.products = [];


    $scope.getAllProducts = function () {
        $http.get('getProducts.php')
            .then(function (response) {
                $scope.products = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching products:', error);
            });
    };


    $scope.getAllProducts();

    $scope.user = {};

    $scope.registerUser = function () {
        var formData = new FormData();
        formData.append('user_username', $scope.user.username);
        formData.append('user_email', $scope.user.email);
        formData.append('user_password', $scope.user.password);
        formData.append('conf_user_password', $scope.user.confirmPassword);
        formData.append('user_address', $scope.user.address);
        formData.append('user_contact', $scope.user.contact);
        formData.append('user_image', $scope.user.image);

        $http.post('users_area/register.php', formData, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
        })
            .then(function (response) {
                console.log(response.data);
                swal({
                    title: "Success",
                    text: "Registration successful!",
                    icon: "success",
                    timer: 2000,
                    buttons: false,
                }).then(function () {
                    window.location.href = '.#!/users_area/user_login';
                });
            })
            .catch(function (error) {
                console.error('Error registering user:', error);
                swal('Error', 'An error occurred while registering the user.', 'error');
            });
    };

    $scope.userData = {
        user_username: '',
        user_password: ''
    };

    $scope.login = function () {
        var data = {
            user_username: $scope.userData.user_username,
            user_password: $scope.userData.user_password
        };

        $http.post('users_area/login.php', data)
            .then(function (response) {
                console.log('Login response:', response.data);
                if (response.data.success) {
                    console.log('sdfdfsdfdsf', response.data)
                    swal({
                        title: "Success",
                        text: "Login successful!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    })
                        .then(function () {
                            if (response.data.hasItemsInCart) {
                                window.location.href = 'http://localhost/Ecommerce%20Website%20-%20Angularjs/#!/home';
                            } else {
                                window.location.href = 'http://localhost/Ecommerce%20Website%20-%20Angularjs/#!/home';
                            }
                        });
                } else {
                    swal('Error', 'Invalid username or password', 'error');
                }
            })
            .catch(function (error) {
                console.error('Error logging in:', error);
                swal('Error', 'An error occurred while logging in', 'error');
            });
    };


    $scope.isCollapsed = true;

    $scope.toggleCollapse = function () {
        $scope.isCollapsed = !$scope.isCollapsed;
    };

    $scope.cartItemCount = 0;
    $scope.totalCartPrice = 0;

    $scope.formData = {};
    $scope.imageSrc = '';


    $http.get('getUserData.php')
        .then(function (response) {
            console.log(response.data);
            $scope.formData = response.data;
            $scope.imageSrc = './user_images/' + $scope.formData.user_image;
        })
        .catch(function (error) {
            console.error('Error fetching user data:', error);
        });


});



app.controller('AdminController', function ($scope, $http, $location) {

    $scope.admin = {};

    $scope.registeradmin = function () {
        var data = {
            admin_name: $scope.admin.admin_name,
            admin_email: $scope.admin.admin_email,
            admin_password: $scope.admin.admin_password,
            confirm_password: $scope.admin.confirm_password
        };
        console.log(data);
        $http.post('admin_area/adregistration.php', data)
            .then(function (response) {
                console.log(response.data);
                if (response.data.success) {
                    swal({
                        title: "Success",
                        text: "Admin Registered Successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '#!/admin_area/admin_login';
                    });
                } else {
                    swal('Error', 'Registration Failed: ' + response.data.message, 'error');
                }
            })
            .catch(function (error) {
                console.error('Error registering admin:', error);
                swal('Error', 'An error occurred while registering the admin', 'error');
            });
    };

    $scope.userData = {
        admin_name: '',
        admin_password: ''
    };

    $scope.adlogin = function () {
        var data = {
            admin_name: $scope.userData.admin_name,
            admin_password: $scope.userData.admin_password
        };
        console.log(data);
        $http.post('admin_area/adlogin.php', data)
            .then(function (response) {
                console.log(response.data);
                if (response.data.success) {
                    swal({
                        title: "Success",
                        text: "Login successful!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    })
                        .then(function () {
                            window.location.href = '#!/admin_area/dashboard';
                        });
                } else {
                    swal('Error', 'Invalid username or password', 'error');
                }
            })
            .catch(function (error) {
                console.error('Error logging in:', error);
                swal('Error', 'An error occurred while logging in', 'error');
            });
    };

    $scope.fetchCategories2 = function () {
        $http.get('admin_area/getAdCategories.php')
            .then(function (response) {
                $scope.categories = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching categories:', error);
            });
    };

    $scope.fetchCategories2();

    $scope.deleteCategory = function (categoryId) {

        if (confirm('Are you sure you want to delete this category?')) {

            $http.get('admin_area/deleteCategory.php', {
                params: { delete_category: categoryId }
            })
                .then(function (response) {
                    swal({
                        title: "Success",
                        text: "Category has been deleted Successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '.#!/admin_area/view_categories';
                    });

                    $scope.fetchCategories2();
                })
                .catch(function (error) {

                    console.log('Error deleting category:', error);
                    swal('Error', 'An error occurred while deleting the category', 'error');
                });
        }
    };
    $scope.fetchBrands2 = function () {
        $http.get('admin_area/viewAdBrands.php')
            .then(function (response) {
                $scope.brands = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching brands:', error);
            });
    };

    $scope.fetchBrands2();

    $scope.deleteBrand = function (brandId) {

        if (confirm('Are you sure you want to delete this brand?')) {

            $http.get('admin_area/deleteBrand.php', {
                params: { delete_brand: brandId }
            })
                .then(function (response) {
                    swal({
                        title: "Success",
                        text: "Brand has been deleted successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '.#!/admin_area/view_brand';
                    });

                    $scope.fetchBrands();
                })
                .catch(function (error) {

                    console.log('Error deleting brand:', error);
                    swal('Error', 'An error occurred while deleting the brand', 'error');
                });
        }
    };


    $scope.brandName = '';

    $scope.insertBrand = function () {
        var brandName = $scope.brandName;
        $http.post('admin_area/insertBrand.php', { brand_name: brandName })
            .then(function (response) {
                swal({
                    title: "Success",
                    text: "Brand has been inserted successfully!",
                    icon: "success",
                    timer: 2000,
                    buttons: false,
                }).then(function () {
                    window.location.href = '.#!/admin_area/view_brand';
                });
                $scope.brandName = '';
            })
            .catch(function (error) {
                console.log('Error inserting brand:', error);
                swal('Error', 'An error occurred while inserting the brand', 'error');
            });
    };

    $scope.categoryName = '';

    $scope.insertCategory = function () {
        var categoryName = $scope.categoryName;
        console.log('dsfdsf', $scope.categoryName);
        $http.post('admin_area/insertCategory.php', { category_name: categoryName })
            .then(function (response) {
                console.log('asdasdasd', response);
                swal({
                    title: "Success",
                    text: "Category has been inserted successfully!",
                    icon: "success",
                    timer: 2000,
                    buttons: false,
                }).then(function () {
                    window.location.href = '.#!/admin_area/view_categories';
                });
                $scope.categoryName = '';
            })
            .catch(function (error) {
                console.log('Error inserting category:', error);
                swal('Error', 'AAn error occurred while inserting the category', 'error');
            });
    };

    $scope.orders = [];
    $scope.fetchOrders = function () {
        $http.get('admin_area/fetchOrders.php')
            .then(function (response) {
                $scope.orders = response.data;
            })
            .catch(function (error) {
                console.error('Error fetching orders:', error);
            });
    };

    $scope.orderDelete = function (orderId) {
        if (confirm("Are you sure you want to delete this order?")) {
            $http.get('admin_area/deleteOrder.php', { params: { order_id: orderId } })
                .then(function (response) {
                    swal({
                        title: "Success",
                        text: "Order deleted successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '.#!/admin_area/list_orders';
                    });
                    $scope.fetchOrders();
                })
                .catch(function (error) {
                    console.error('Error deleting order:', error);
                    swal('Error', 'An error occurred while deleting the order', 'error');
                });
        }
    };

    $scope.fetchOrders();

    $scope.fetchPayments = function () {
        $http.get('admin_area/fetchPayment.php')
            .then(function (response) {
                $scope.payments = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching payments:', error);
            });
    };

    $scope.paymentDelete = function (paymentId) {
        if (confirm("Are you sure you want to delete this payment?")) {
            $http.get('admin_area/deletePayment.php', { params: { payment_id: paymentId } })
                .then(function (response) {
                    swal({
                        title: "Success",
                        text: "Payment has been deleted successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '.#!/admin_area/list_payments';
                    });
                    $scope.fetchPayments();
                })
                .catch(function (error) {
                    console.log('Error deleting payment:', error);
                    swal('Error', 'An error occurred while deleting the payment', 'error');
                });
        }
    };
    $scope.fetchPayments();

    $scope.fetchUsers = function () {
        $http.get('admin_area/fetchUser.php')
            .then(function (response) {
                $scope.users = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching users:', error);
            });
    };

    $scope.fetchUsers();

    $scope.userDelete = function (userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            $http.get('admin_area/deleteUser.php', { params: { user_id: userId } })
                .then(function (response) {
                    swal({
                        title: "Success",
                        text: "User has been deleted successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '.#!/admin_area/list_users';
                    });
                    $scope.fetchUsers();
                })
                .catch(function (error) {
                    console.log('Error deleting user:', error);
                    swal('Error', 'An error occurred while deleting the user', 'error');
                });
        }
    };

    $scope.fetchProducts = function () {
        $http.get('admin_area/fetchProducts.php')
            .then(function (response) {
                $scope.products = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching products:', error);
            });
    };

    $scope.productDelete = function (productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            $http.get('admin_area/deleteProducts.php', {
                params: { product_id: productId }
            })
                .then(function (response) {
                    swal({
                        title: "Success",
                        text: "Product has been deleted successfully!",
                        icon: "success",
                        timer: 2000,
                        buttons: false,
                    }).then(function () {
                        window.location.href = '.#!/admin_area/view_products';
                    });
                    $scope.fetchProducts();
                })
                .catch(function (error) {
                    console.log('Error deleting product:', error);
                    swal('Error', 'An error occurred while deleting the product', 'error');
                });
        }
    };

    $scope.fetchProducts();

    $scope.insertProduct = function () {
        var formData = new FormData();
        formData.append('product_title', $scope.product_title);
        console.log('$scope.product_title:', $scope.product_title);
        formData.append('product_description', $scope.product_description);
        console.log('$scope.product_description:', $scope.product_description);
        formData.append('product_keywords', $scope.product_keywords);
        console.log('$scope.product_keywords:', $scope.product_keywords);
        formData.append('category_id', $scope.category_id);
        console.log('$scope.category_id:', $scope.category_id);
        formData.append('brand_id', $scope.brand_id);
        console.log('$scope.brand_id:', $scope.brand_id);

        var filename = document.getElementById('product_image1').files[0];
        var filename2 = document.getElementById('product_image2').files[0];
        var filename3 = document.getElementById('product_image3').files[0];

        formData.append('product_image1', filename);
        formData.append('product_image2', filename2);
        formData.append('product_image3', filename3);

        formData.append('product_price', $scope.product_price);
        console.log('$scope.product_price:', $scope.product_price);

        console.log('FormData:', formData);


        $http.post('admin_area/insertProduct.php', formData, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        })
            .then(function (response) {
                console.log('ResponseP:', response.data);
                swal({
                    title: "Success",
                    text: "Product Inserted successfully!",
                    icon: "success",
                    timer: 2000,
                    buttons: false,
                })
                $scope.product_title = '';
                $scope.product_description = '';
                $scope.product_keywords = '';
                $scope.categoru_id = '';
                $scope.brand_id = '';
                document.getElementById('product_image1').value = '';
                document.getElementById('product_image2').value = '';
                document.getElementById('product_image3').value = '';
                $scope.product_price = '';
            })
            .catch(function (error) {
                console.error('Error inserting product:', error);
                swal('Error', 'An error occurred while inserting the product', 'error');
            });
    };
});