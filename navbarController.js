var app = angular.module('ecommerceApp', []);

app.controller('BrandController', function ($scope, $http) {


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

    // Call the function when the controller loads
    $scope.getPendingOrders();


    $scope.fetchBrands = function () {
        $http.get('getBrands.php')
            .then(function (response) {
                // Extract the data from the response
                $scope.Bnames = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching brands:', error);
            });
    };


    $scope.fetchCategories = function () {
        $http.get('getCategory.php')
            .then(function (response) {
                // Extract the data from the response
                $scope.Cnames = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching categories:', error);
            });
    };

    $scope.products = [];

    // Function to fetch all products
    $scope.getAllProducts = function () {
        $http.get('getProducts.php')
            .then(function (response) {
                $scope.products = response.data;
            })
            .catch(function (error) {
                console.log('Error fetching products:', error);
            });
    };

    // Fetch all products when the controller loads
    $scope.getAllProducts();


    $scope.searchData = '';
    $scope.products = [];

    // // Function to search for products
    $scope.searchProduct = function () {
        $http.get('searchProduct.php', {
            params: { search_data: $scope.searchData }
        })
            .then(function (response) {
                console.log($scope.searchData)
                $scope.searchproducts = response.data;
                if ($scope.searchproducts.length === 0) {
                    $scope.noProductMessage = "No product found for this search!";
                } else {
                    $scope.noProductMessage = "";
                }
                window.location.href = 'search_product.php?search_data=' + $scope.searchData;
            })
            .catch(function (error) {
                console.log('Error searching products:', error);
            });
    };


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
                window.location.href = './user_login.html';
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
                        window.location.href = 'payment.php';
                    } else {
                        window.location.href = 'profile.php';
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


    $scope.updateAccount = function () {
        var formData = new FormData();
        angular.forEach($scope.formData, function (value, key) {
            formData.append(key, value);
        });

        $http.post('updateAccount.php', formData, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        })
            .then(function (response) {
                $scope.updateSuccess = true;
                console.log('Account updated successfully');
            })
            .catch(function (error) {
                console.error('Error updating account:', error);
            });
    };


    $scope.loading = true;
    $scope.error = '';

    $http.get('getOrders.php')
        .then(function (response) {
            $scope.loading = false;
            $scope.orders = response.data;
            console.log(orders.order_status)
        })
        .catch(function (error) {
            $scope.loading = false;
            $scope.error = 'Error fetching orders: ' + error.statusText;
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

                    $scope.fetchCategories();
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


    $scope.brandName = ''; // Initialize brandName variable

    $scope.insertBrand = function () {
        var brandName = $scope.brandName;
        $http.post('insertBrand.php', { brand_name: brandName })
            .then(function (response) {
                alert('Brand has been inserted successfully');
                $scope.brandName = ''; // Clear the input field
            })
            .catch(function (error) {
                console.log('Error inserting brand:', error);
                alert('An error occurred while inserting the brand.');
            });
    };

    $scope.categoryName = '';

    $scope.insertCategory = function () {
        var categoryName = $scope.categoryName;
        $http.post('insertCategory.php', { category_name: categoryName })
            .then(function (response) {
                alert('Category has been inserted successfully');
                $scope.categoryName = '';
            })
            .catch(function (error) {
                console.log('Error inserting category:', error);
                alert('An error occurred while inserting the category.');
            });
    };

    $scope.orders = [];
    // Function to fetch orders
    $scope.fetchOrders = function () {
        $http.get('fetchOrders.php')
            .then(function (response) {
                $scope.orders = response.data;
            })
            .catch(function (error) {
                console.error('Error fetching orders:', error);
            });
    };

    // Function to confirm and delete an order
    $scope.confirmDelete = function (orderId) {
        if (confirm("Are you sure you want to delete this order?")) {
            $http.get('deleteOrder.php', { params: { order_id: orderId } })
                .then(function (response) {
                    alert('Order deleted successfully');
                    $scope.fetchOrders(); // Refresh orders after deletion
                })
                .catch(function (error) {
                    console.error('Error deleting order:', error);
                    alert('An error occurred while deleting the order.');
                });
        }
    };

    // Fetch orders initially
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
                    $scope.fetchUsers(); // Refresh users after deletion
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
        var filename = document.getElementById('product_image1').files[0];
        var filename2 = document.getElementById('product_image2').files[0];
        var filename3 = document.getElementById('product_image3').files[0];

        formData.append('product_title', $scope.product_title);
        console.log('$scope.product_title:', $scope.product_title);
        formData.append('description', $scope.description);
        console.log('$scope.description:', $scope.description);
        formData.append('product_keywords', $scope.product_keywords);
        console.log('$scope.product_keywords:', $scope.product_keywords);
        formData.append('product_category', $scope.product_category);
        console.log('$scope.product_category:', $scope.product_category);
        formData.append('product_brands', $scope.product_brands);
        console.log('$scope.product_brands:', $scope.product_brands);
        // formData.append('product_image1', $scope.product_image1);
        formData.append('filename', filename);
        console.log('$scope.product_image1:', filename);
        // formData.append('product_image2', $scope.product_image2);
        formData.append('filename', filename2);
        console.log('$scope.product_image2:', filename2);
        // formData.append('product_image3', $scope.product_image3);
        formData.append('filename', filename3);
        console.log('$scope.product_image3:', filename3);
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
                console.log('ResponseP:', response);
                alert('Product inserted successfully');
                $scope.product_title = '';
                $scope.description = '';
                $scope.product_keywords = '';
                $scope.product_category = '';
                $scope.product_brands = '';
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

    $scope.formData = {};
    $scope.fetchProductData = function (productId) {
        $http.get('fetchProductData.php?product_id=' + productId)
            .then(function (response) {
                $scope.formData = response.data;
                $scope.formData.product_price = parseFloat($scope.formData.product_price);
                console.log("Fetched Product Data: ", $scope.formData);
            })
            .catch(function (error) {
                console.error('Error fetching product data:', error);
            });
    };

    var urlParams = new URLSearchParams(window.location.search);
    var productId = urlParams.get('edit_products');
    console.log('Product', productId);
    $scope.fetchProductData(productId);

    $scope.timestamp = new Date().getTime();

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

    $scope.formData = {};
    $scope.fetchCategoryData = function (categoryId) {
        $http.get('fetchCategoryData.php?edit_category=' + categoryId)
            .then(function (response) {
                $scope.formData = response.data;
            })
            .catch(function (error) {
                console.error('Error fetching category data:', error);
            });
    };

    var urlParams = new URLSearchParams(window.location.search);
    var categoryId = urlParams.get('edit_category');
    console.log('Category', categoryId);
    $scope.fetchCategoryData(categoryId);

    // Function to edit category
    $scope.editCategory = function () {
        $http.post('editCategory.php', { category_id: categoryId, category_title: $scope.formData.category_title })
            .then(function (response) {
                console.log(response);
                if (response.data.success) {
                    alert('Category updated successfully');
                } else {
                    alert('Error updating category');
                }
            })
            .catch(function (error) {
                console.error('Error updating category:', error);
                alert('An error occurred while updating the category.');
            });
    };


    $scope.formData = {};
    $scope.fetchBrandData = function (brandId) {
        $http.get('fetchBrandData.php?edit_brands=' + brandId)
            .then(function (response) {
                $scope.formData = response.data;
            })
            .catch(function (error) {
                console.error('Error fetching brand data:', error);
            });
    };

    var urlParams = new URLSearchParams(window.location.search);
    var brandId = urlParams.get('edit_brands');
    console.log('Brand', brandId);
    $scope.fetchBrandData(brandId);

    $scope.editBrand = function () {
        $http.post('editBrand.php', { brand_id: brandId, brand_name: $scope.formData.brand_name })
            .then(function (response) {
                console.log(response);
                if (response.data.success) {
                    alert('Brand updated successfully');
                } else {
                    alert('Error updating brand');
                }
            })
            .catch(function (error) {
                console.error('Error updating brand:', error);
                alert('An error occurred while updating the brand.');
            });
    };

    $scope.adlogin = function () {
        var data = {
            admin_username: $scope.username,
            admin_password: $scope.password
        };
        $http.post('adlogin.php', data)
            .then(function (response) {
                console.log(response);
                if (response.data.success) {
                    window.location.href = 'index.php';
                } else {
                    alert(response.data.message);
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
    };

});





