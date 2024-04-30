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
        when("/user_registration", {
            templateUrl: "./users_area/user_registration.html",
        }).
        when("/users_area/user_login", {
            templateUrl: "./users_area/user_login.php",
        }).
        when("index", {
            templateUrl: "index.php",
        }).
        otherwise({
            redirectTo: "/home"
        }).
        when("/view_products", {
            templateUrl: "view_products.php",
        }).
        when("/insert_product", {
            templateUrl: "insert_product.php",
        }).
        when("/insert_categories", {
            templateUrl: "insert_categories.php",
        }).
        when("/view_categories", {
            templateUrl: "view_categories.php",
        }).
        when("/insert_brand", {
            templateUrl: "insert_brands.php",
        }).
        when("/view_brand", {
            templateUrl: "view_brands.php",
        }).
        when("/list_orders", {
            templateUrl: "list_orders.php",
        }).
        when("/list_payments", {
            templateUrl: "list_payments.php",
        }).
        when("/list_users", {
            templateUrl: "list_users.php",
        }).
        when("/admin_logout", {
            templateUrl: "admin_logout.php",
        }).
        when("/edit_category/:categoryId", {
            templateUrl: "edit_category.php",
            controller: "editCategory"
        }).
        when("/edit_brands/:brandId", {
            templateUrl: "edit_brands.php",
            controller: "editBrands"
        }).
        when("/edit_products/:productId", {
            templateUrl: "edit_products.php",
            controller: "editProducts"
        }).
        when("/admin_login", {
            templateUrl: "admin_login.php",
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
            controller: "SearchController",
        })
}]);

app.controller('SearchController', function ($scope, $http) {
    $scope.searchData = '';
    $scope.products = [];
    $scope.noProductMessage = '';
    $scope.searchProduct = function () {
        $http.get('searchProduct.php', {
            params: { search_data_product: $scope.searchData }
        })
            .then(function (response) {
                console.log(response);
                $scope.products = response.data;
                console.log($scope.products);
                if ($scope.products.length === 0) {
                    $scope.noProductMessage = "No product found for this search!";
                } else {
                    $scope.noProductMessage = "";
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
        $http.get('fetchProductData.php?product_id=' + productId)
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

        $http.post('editProduct.php', formData, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
        }).then(function (response) {
            console.log(response.data);
            alert('Product updated successfully');
            window.location.href = 'index.php?view_products';
        }).catch(function (error) {
            console.error('Error updating product:', error);
            alert('An error occurred while updating the product.');
        });
    };
});


app.controller('editBrands', function ($scope, $http, $routeParams) {
    $scope.formData = {};

    var brandId = $routeParams.brandId;

    $http.get('fetchBrandData.php?edit_brands=' + brandId)
        .then(function (response) {
            $scope.formData = response.data;
        })
        .catch(function (error) {
            console.error('Error fetching brand data:', error);
        });

    $scope.editBrand = function () {
        $http.post('editBrand.php', { brand_id: brandId, brand_name: $scope.formData.brand_name })
            .then(function (response) {
                if (response.data.success) {
                    alert('Brand updated successfully');
                    window.location.href = './index.php?view_brands';
                } else {
                    alert('Error updating brand');
                }
            })
            .catch(function (error) {
                console.error('Error updating brand:', error);
                alert('An error occurred while updating the brand.');
            });
    };
});

app.controller('editCategory', function ($scope, $http, $routeParams) {
    $scope.formData = {};

    var categoryId = $routeParams.categoryId;


    $http.get('fetchCategoryData.php?edit_category=' + categoryId)
        .then(function (response) {
            console.log('fetch:', response.data);
            $scope.formData = response.data;
        })
        .catch(function (error) {
            console.error('Error fetching category data:', error);
        });
    $scope.editCategory = function () {
        console.log('edited title', $scope.formData.category_title);
        $http.post('editCategory.php', { category_id: categoryId, category_title: $scope.formData.category_title })
            .then(function (response) {
                console.log('response', response.data);
                if (response.data.success) {
                    alert('Category updated successfully');
                    window.location.href = './index.php?view_categories';
                } else {
                    alert('Error updating category');
                }
            })
            .catch(function (error) {
                console.error('Error updating category:', error);
                alert('An error occurred while updating the category.');
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
    $scope.updateSuccess = false; // Initialize updateSuccess variable

    // Fetch user details
    $scope.fetchUserDetails = function () {
        $http.get('users_area/getUserData.php')
            .then(function (response) {
                $scope.formData = response.data;
            })
            .catch(function (error) {
                console.error('Error fetching user details:', error);
            });
    };

    // Call fetchUserDetails function when the controller loads
    $scope.fetchUserDetails();

    // Update account function
    $scope.updateAccount = function () {
        var formData = new FormData();
        angular.forEach($scope.formData, function (value, key) {
            formData.append(key, value);
        });

        // Include user_id in the form data
        formData.append('user_id', $scope.formData.user_id);

        $http.post('users_area/updateAccount.php', formData, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        })
            .then(function (response) {
                // Check response from server
                if (response.data.success) {
                    $scope.updateSuccess = true; // Set updateSuccess to true if update is successful
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
    $scope.isLoginPage = function() {
        console.log($location.path())
        return $location.path() === '/users_area/user_login'; // Adjust the path as per your actual route
    };
    $scope.getPendingOrders = function () {
        $http.get('userProfile.php')
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

    var hideFunctionPaths = ['/profile', '/profile/edit_account', '/profile/my_orders', '/profile/delete_account', '/cart'];

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


    // $scope.searchData = '';
    // $scope.products = [];


    // $scope.searchProduct = function () {
    //     $http.get('searchProduct.php', {
    //         params: { search_data: $scope.searchData }
    //     })
    //         .then(function (response) {
    //             console.log($scope.searchData)
    //             $scope.searchproducts = response.data;
    //             if ($scope.searchproducts.length === 0) {
    //                 $scope.noProductMessage = "No product found for this search!";
    //             } else {
    //                 $scope.noProductMessage = "";
    //             }
    //             window.location.href = 'search_product.php?search_data=' + $scope.searchData;
    //         })
    //         .catch(function (error) {
    //             console.log('Error searching products:', error);
    //         });
    // };


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

        $http.post('register.php', formData, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
        })
            .then(function (response) {
                console.log(response.data);
                alert('Registered Successfully');
                window.location.href = './user_login.php';
            })
            .catch(function (error) {
                console.error('Error registering user:', error);
                alert('An error occurred while registering the user.');
            });
    };


    $scope.login = function () {
        var data = {
            user_username: $scope.user_username,
            user_password: $scope.user_password
        };
        console.log('Data sent:', data);

        $http.post('login.php', data)
            .then(function (response) {
                console.log('Response data:', response.data);
                if (response.data.success) {
                    alert('Login Successful');
                    if (response.data.hasItemsInCart) {
                        window.location.href = 'http://localhost/Ecommerce/#!/home';
                    } else {
                        window.location.href = 'http://localhost/Ecommerce/#!/home';
                    }
                } else {
                    alert('Invalid Credentials');
                }
            })
            .catch(function (error) {
                console.error('Error logging in:', error);
                alert('An error occurred while logging in.');
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

    $scope.fetchCategories2 = function () {
        $http.get('getAdCategories.php')
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

            $http.get('deleteCategory.php', {
                params: { delete_category: categoryId }
            })
                .then(function (response) {

                    alert('Category has been deleted successfully');

                    $scope.fetchCategories2();
                })
                .catch(function (error) {

                    console.log('Error deleting category:', error);
                    alert('An error occurred while deleting the category.');
                });
        }
    };
    $scope.fetchBrands2 = function () {
        $http.get('viewAdBrands.php')
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

            $http.get('deleteBrand.php', {
                params: { delete_brand: brandId }
            })
                .then(function (response) {

                    alert('Brand has been deleted successfully');

                    $scope.fetchBrands();
                })
                .catch(function (error) {

                    console.log('Error deleting brand:', error);
                    alert('An error occurred while deleting the brand.');
                });
        }
    };


    $scope.brandName = '';

    $scope.insertBrand = function () {
        var brandName = $scope.brandName;
        $http.post('insertBrand.php', { brand_name: brandName })
            .then(function (response) {
                alert('Brand has been inserted successfully');
                $scope.brandName = '';
            })
            .catch(function (error) {
                console.log('Error inserting brand:', error);
                alert('An error occurred while inserting the brand.');
            });
    };

    $scope.categoryName = '';

    $scope.insertCategory = function () {
        var categoryName = $scope.categoryName;
        console.log('dsfdsf', $scope.categoryName);
        $http.post('insertCategory.php', { category_name: categoryName })
            .then(function (response) {
                console.log('asdasdasd', response);
                alert('Category has been inserted successfully');
                $scope.categoryName = '';
            })
            .catch(function (error) {
                console.log('Error inserting category:', error);
                alert('An error occurred while inserting the category.');
            });
    };

    $scope.orders = [];
    $scope.fetchOrders = function () {
        $http.get('fetchOrders.php')
            .then(function (response) {
                $scope.orders = response.data;
            })
            .catch(function (error) {
                console.error('Error fetching orders:', error);
            });
    };

    $scope.confirmDelete = function (orderId) {
        if (confirm("Are you sure you want to delete this order?")) {
            $http.get('deleteOrder.php', { params: { order_id: orderId } })
                .then(function (response) {
                    alert('Order deleted successfully');
                    $scope.fetchOrders();
                })
                .catch(function (error) {
                    console.error('Error deleting order:', error);
                    alert('An error occurred while deleting the order.');
                });
        }
    };

    $scope.fetchOrders();

    $scope.fetchPayments = function () {
        $http.get('fetchPayment.php')
            .then(function (response) {
                $scope.payments = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching payments:', error);
            });
    };

    $scope.confirmDelete = function (paymentId) {
        if (confirm("Are you sure you want to delete this payment?")) {
            $http.get('deletePayment.php', { params: { payment_id: paymentId } })
                .then(function (response) {
                    alert('Payment has been deleted successfully');
                    $scope.fetchPayments();
                })
                .catch(function (error) {
                    console.log('Error deleting payment:', error);
                    alert('An error occurred while deleting the payment.');
                });
        }
    };
    $scope.fetchPayments();

    $scope.fetchUsers = function () {
        $http.get('fetchUser.php')
            .then(function (response) {
                $scope.users = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching users:', error);
            });
    };

    $scope.fetchUsers();

    $scope.confirmDelete = function (userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            $http.get('deleteUser.php', { params: { user_id: userId } })
                .then(function (response) {
                    alert('User has been deleted successfully');
                    $scope.fetchUsers();
                })
                .catch(function (error) {
                    console.log('Error deleting user:', error);
                    alert('An error occurred while deleting the user.');
                });
        }
    };

    $scope.fetchProducts = function () {
        $http.get('fetchProducts.php')
            .then(function (response) {
                $scope.products = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching products:', error);
            });
    };

    $scope.confirmDelete = function (productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            $http.get('deleteProducts.php', {
                params: { product_id: productId }
            })
                .then(function (response) {
                    alert('Product has been deleted successfully');
                    $scope.fetchProducts();
                })
                .catch(function (error) {
                    console.log('Error deleting product:', error);
                    alert('An error occurred while deleting the product.');
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


        $http.post('insertProduct.php', formData, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        })
            .then(function (response) {
                console.log('ResponseP:', response.data);
                alert('Product inserted successfully');
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
                alert('An error occurred while inserting the product.');
            });
    };


    // $scope.fetchBrandData = function () {
    //     $http.get('./admin_area/fetchBrandData.php')
    //         .then(function (response) {
    //             $scope.formData.brand_name = response.data.brand_name;
    //             console.log('Response', response.data);
    //         }, function (error) {
    //             console.error('Error fetching brand data:', error);
    //         });
    // };

    // $scope.fetchBrandData();


    $scope.adlogin = function () {
        var data = {
            admin_name: $scope.admin_name,
            admin_password: $scope.admin_password
        };

        $http.post('adlogin.php', data)
            .then(function (response) {
                console.log(response.data);
                if (response.data.success) {
                    alert('Login Successful');
                    setTimeout(function () {
                        window.location.href = 'index.php';
                    });
                } else {
                    alert('Invalid Credentials');
                }
            })
            .catch(function (error) {
                console.error('Error logging in:', error);
                alert('An error occurred while logging in.');
            });
    };

    // $scope.formData = {};

    // $scope.adregister = function () {
    //     $http.post('adRegistration.php', $scope.formData)
    //         .then(function (response) {
    //             if (response.data.success) {
    //                 alert('Registration Successful');
    //                 window.location.href = 'admin_login.php';
    //             } else {
    //                 alert(response.data.message);
    //             }
    //         })
    //         .catch(function (error) {
    //             console.error('Error:', error);
    //             alert('An error occurred while registering.');
    //         });
    // };


    $scope.admin = {};

    $scope.registeradmin = function () {
        var data = {
            admin_name: $scope.admin.admin_name,
            admin_email: $scope.admin.admin_email,
            admin_password: $scope.admin.admin_password,
            confirm_password: $scope.admin.confirm_password
        };

        $http.post('adregistration.php', data)
            .then(function (response) {
                console.log(response.data);
                if (response.data.success) {
                    alert('Registered Successfully');
                    window.location.href = './admin_login.php';
                } else {
                    alert('Registration Failed: ' + response.data.message);
                }
            })
            .catch(function (error) {
                console.error('Error registering admin:', error);
                alert('An error occurred while registering the admin.');
            });
    };
});





