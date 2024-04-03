<h3 class="text-center text-success">All Payments</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-info text-center">
        <?php
        $get_payments = "SELECT * FROM `user_payments`";
        $result = mysqli_query($con, $get_payments);
        $row_count = mysqli_num_rows($result);


        if ($row_count == 0) {
            echo "<h2 class='text-danger text-center mt-5'>No payments received yet</h2>";
        } else {
            echo " <tr>
            <th>Sl no</th>
            <th>Invoice Number</th>
            <th>Amount</th>
            <th>Payment Mode</th>
            <th>Order Date</th>
            <th>Delete</th>
        </tr>
    
    </thead>
    <tbody class='bg-secondary text-center'>";
            $number = 0;
            while ($row_data = mysqli_fetch_assoc($result)) {
                $order_id = $row_data['order_id'];
                $payment_id = $row_data['payment_id'];
                $amount = $row_data['amount'];
                $invoice_number = $row_data['invoice_number'];
                $date = $row_data['date'];
                $payment_mode = $row_data['payment_mode'];
                $number++;
                echo "  <tr>
                <td>$number</td>
                <td>$invoice_number</td>
                <td>$amount</td>
                <td>$payment_mode</td>
                <td>$date</td>

                <td><a href='#' onclick='confirmDelete($payment_id)'><i class='fa-solid fa-trash'></i></a></td>
                </tr>";
            }
        ?>

        <?php
        }

        ?>


        </tbody>
</table>

<script>
    function confirmDelete(paymentId) {
        if (confirm("Are you sure you want to delete this payment?")) {
            window.location.href = 'index.php?delete_payment=' + paymentId;
        }
    }
</script>