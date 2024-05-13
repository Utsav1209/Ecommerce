<?php include("./dashboard.php"); ?>
<div ng-app="ecommerceApp" ng-controller="AdminController">
    <h3 class="text-center text-success">All Payments</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-info text-center">
            <tr>
                <th>Sl no</th>
                <th>Invoice Number</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Order Date</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-center">
            <tr ng-repeat="payment in payments">
                <td>{{$index + 1}}</td>
                <td>{{payment.invoice_number}}</td>
                <td>{{payment.amount}}</td>
                <td>{{payment.payment_mode}}</td>
                <td>{{payment.date}}</td>
                <td><a href="#" ng-click="paymentDelete(payment.payment_id)"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
        </tbody>
    </table>
</div>