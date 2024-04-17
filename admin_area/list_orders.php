<div ng-app="ecommerceApp" ng-controller="BrandController">
    <h3 class="text-center text-success">All Orders</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-info text-center">
            <tr>
                <th>Sl no</th>
                <th>Due Amount</th>
                <th>Invoice Number</th>
                <th>Total Products</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class='bg-secondary text-center'>
            <tr ng-repeat="order in orders">
                <td>{{$index + 1}}</td>
                <td>{{order.amount_due}}</td>
                <td>{{order.invoice_number}}</td>
                <td>{{order.total_products}}</td>
                <td>{{order.order_date}}</td>
                <td>{{order.order_status}}</td>
                <td><a href="#" ng-click="confirmDelete(order.order_id)"><i class='fa-solid fa-trash'></i></a></td>
            </tr>
        </tbody>
    </table>
</div>