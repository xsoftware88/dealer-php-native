<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script type='text/javascript'>
            window.location = '" .homeUrl. "dealer/'
        </script>";
}
