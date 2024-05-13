<?php
session_start();
session_unset();
session_destroy();
echo "<script>window.open('.#!/admin_area/admin_login','_self')</script>";
