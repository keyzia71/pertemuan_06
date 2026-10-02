<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/functions.php';

$products = require __DIR__ . '/data/products.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

$id = filter_input(
    INPUT_POST,
    'id',
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 1
        ]
    ]
);

if (
    $action === 'add'
    && $id !== false
    && $id !== null
    && isset($products[$id])
) {

    $_SESSION['cart'][$id] =
        ($_SESSION['cart'][$id] ?? 0) + 1;

    setFlash('Produk berhasil dihapus dari keranjang.');

} elseif (
    $action === 'remove'
    && $id !== false
    && $id !== null
    && isset($_SESSION['cart'][$id])
) {

    unset($_SESSION['cart'][$id]);

    setFlash('Produk dihapus dari keranjang.');

} elseif ($action === 'clear') {

    $_SESSION['cart'] = [];

    setFlash('semua produk berhasil dihapus dari keranjang.');

} else {

    setFlash('Permintaan tidak valid.');
}

$target = $action === 'add'
    ? 'index.php'
    : 'cart.php';

header('Location: ' . $target);
exit;
