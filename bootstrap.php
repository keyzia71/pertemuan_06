<?php

declare(strict_types=1);

session_start();

$_SESSION['cart'] ??= [];

$_SESSION['flash'] ??= null;