<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/functions.php';

$products = require __DIR__ . '/data/products.php';

$theme = $_COOKIE['theme'] ?? 'light';

if (!in_array($theme, ['light', 'dark'], true)) {
    $theme = 'light';
}

$flash = pullFlash();

$cartCount = cartCount($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Keranjang Belanja</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: <?= $theme === 'dark' ? '#1e1e1e' : '#f5f5f5' ?>;
            color: <?= $theme === 'dark' ? '#ffffff' : '#222222' ?>;
        }

        header {
            background: <?= $theme === 'dark' ? '#111827' : '#2563eb' ?>;
            color: white;
            padding: 20px;
        }

        header .container {
            max-width: 1000px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        main {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .flash {
            background: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(220px, 1fr)
            );
            gap: 20px;
        }

        .card {
            background: <?= $theme === 'dark' ? '#2d2d2d' : '#ffffff' ?>;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .price {
            font-weight: bold;
            font-size: 18px;
            margin: 15px 0;
        }

        button,
        .cart-link {
            border: none;
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            border-radius: 7px;
            cursor: pointer;
            text-decoration: none;
        }

        button:hover,
        .cart-link:hover {
            opacity: 0.85;
        }

    </style>

</head>

<body>

<header>

    <div class="container">

        <h1>Keranjang Belanja</h1>

        <a class="cart-link" href="cart.php">
            🛒 Keranjang (<?= $cartCount ?>)
        </a>

    </div>

</header>

<main>

    <?php if ($flash !== null): ?>

        <div class="flash">
            <?= e($flash) ?>
        </div>

    <?php endif; ?>

    <h2>Daftar Produk</h2>

    <div class="products">

        <?php foreach ($products as $id => $product): ?>

            <div class="card">

                <h3>
                    <?= e($product['nama']) ?>
                </h3>

                <div class="price">
                    Rp <?= number_format(
                        $product['harga'],
                        0,
                        ',',
                        '.'
                    ) ?>
                </div>

                <form action="actions.php" method="post">

                    <input
                        type="hidden"
                        name="action"
                        value="add"
                    >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $id ?>"
                    >

                    <button type="submit">
                        Tambah ke Keranjang
                    </button>

                </form>

            </div>

        <?php endforeach; ?>

    </div>

</main>

</body>

</html>