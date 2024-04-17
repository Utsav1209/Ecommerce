<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="../navbarController.js"></script>
</head>

<body ng-app="ecommerceApp" ng-controller="BrandController">
    <h3 class="text-center text-success mb-4">All My Orders</h3>


    <table class="table table-bordered mt-5" ng-if="orders.length > 0">
        <thead class="bg-info">
            <tr>
                <th>Sl no</th>
                <th>Amount Due</th>
                <th>Total Products</th>
                <th>Invoice Number</th>
                <th>Date</th>
                <th>Complete/Incomplete</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-light">
            <tr ng-repeat="order in orders">
                <td>{{ $index + 1 }}</td>
                <td>{{ order.amount_due }}</td>
                <td>{{ order.total_products }}</td>
                <td>{{ order.invoice_number }}</td>
                <td>{{ order.order_date }}</td>
                <td>
                    <span ng-if="order.order_status != 'Complete'" class="text-decoration-none" style="color: black;">Incomplete</span>

                    <span ng-if="order.order_status == 'Complete'">Compelete</span>

                </td>
                <!-- {{ order.order_status == 'pending' ? 'Incomplete' : 'Complete' }} -->
                <td>
                    <a ng-if="order.order_status != 'Complete'" href="confirm_payment.php?order_id={{ order.order_id }}">Confirm</a>
                    <span ng-if="order.order_status == 'Complete'">Paid</span>
                </td>


            </tr>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>