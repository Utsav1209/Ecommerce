<?php include("../includes/connect.php"); ?>
<div class="row">
    <div class="col-md-2">
        <?php include("./navigation.php"); ?>
    </div>
    <div class="col-md-10 text-center">
        <div ng-if="orders.length > 0" ng-app="ecommerceApp" ng-controller="getOrder">
            <h3 class="text-center text-success mb-4">All My Orders</h3>
            <table class="table table-bordered mt-5">
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
                            <span ng-if=" order.order_status !='Complete'" class=" text-decoration-none" style="color: black;">Incomplete</span>
                            <span ng-if="order.order_status == 'Complete'">Complete</span>
                        </td>
                        <td>
                            <a ng-if="order.order_status != 'Complete'" href="users_area/confirm_payment.php?order_id={{ order.order_id }}">Confirm</a>
                            <span ng-if="order.order_status == 'Complete'">Paid</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div ng-if="orders.length === 0">
            <h1 class="text-center text-success mt-5">No orders till now.</h1>
        </div>
    </div>
</div>