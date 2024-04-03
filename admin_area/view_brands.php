<h3 class="text-center text-success">All Brands</h3>
<table class="table table-boardered mt-5">
    <thead class="bg-info">
        <tr class="text-center">
            <th>Slno</th>
            <th>Brand Title</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody class="bg-secondary">
        <?php
        $select_brand = "SELECT * FROM `brands`";
        $result = mysqli_query($con, $select_brand);
        $number = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $brand_id = $row['brand_id'];
            $brand_title = $row['brand_name'];
            $number++;

        ?>
            <tr class="text-center">
                <td><?php echo $number; ?></td>
                <td><?php echo $brand_title; ?></td>
                <td><a href='index.php?edit_brands=<?php echo $brand_id ?>'><i class='fa-solid fa-pen-to-square'></i></a></td>
                <td><a href='index.php?delete_brands=<?php echo $brand_id; ?>' onclick="return confirm('Are you sure you want to delete this Brand?');"><i class='fa-solid fa-trash'></i></a></td>
            </tr>
        <?php

        }
        ?>
    </tbody>

</table>