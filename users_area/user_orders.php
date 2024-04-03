<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php
    $username = $_SESSION['username'];
    $get_user = "SELECT * FROM `user_table` WHERE username='$username'";
    $result = mysqli_query($con, $get_user);
    $row_fetch = mysqli_fetch_assoc($result);
    $user_id = $row_fetch['user_id'];

    $get_order_details = "SELECT * FROM `user_orders` WHERE user_id='$user_id'";
    $result_orders = mysqli_query($con, $get_order_details);

    // Check if the query executed successfully
    if ($result_orders) {
        if (mysqli_num_rows($result_orders) > 0) {
    ?>
            <h3 class="text-success">All my Orders</h3>
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
                    <?php
                    $number = 1;
                    while ($row_orders = mysqli_fetch_assoc($result_orders)) {
                        $order_id = $row_orders['order_id'];
                        $amount_due = $row_orders['amount_due'];
                        $total_products = $row_orders['total_products'];
                        $invoice_number = $row_orders['invoice_number'];
                        $order_status = $row_orders['order_status'];
                        if ($order_status == 'pending') {
                            $order_status = 'Incomplete';
                        } else {
                            $order_status = 'Complete';
                        }
                        $order_date = $row_orders['order_date'];

                        echo "<tr>
            <td>$number</td>
            <td>$amount_due</td>
            <td>$total_products</td>
            <td>$invoice_number</td>
            <td>$order_date</td>
            <td>$order_status</td>";

                        if ($order_status == 'Complete') {
                            echo "<td>Paid</td>";
                        } else {
                            echo  "<td><a href='confirm_payment.php?order_id=$order_id'>Confirm</a></td>
                </tr>";
                        }
                        $number++;
                    }
                    ?>
                </tbody>
            </table>
    <?php
        } else {
            echo "<h1 class='text-success mt-5'>No orders till now.</h1>";
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>