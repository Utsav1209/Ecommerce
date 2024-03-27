<?php

$con = mysqli_connect("localhost", "root", "Utsav!@#456", "mystore");
if (!$con) {
    die(mysqli_error($con));
}
