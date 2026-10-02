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

$cart = $_SESSION['cart'];

$total = 0;
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
            background: <?= $theme === 'dark'
                ? '#1e1e1e'
                : '#f5f5f5' ?>;
            color: <?= $theme === 'dark'
                ? '#ffffff'
                : '#222222' ?>;
        }

        header {
            background: <?= $theme === 'dark'
                ? '#111827'
                : '#2563eb' ?>;
            color: white;
            padding: 20px;
        }

        main {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }

        .card {
            background: <?= $theme === 'dark'
                ? '#2d2d2d'
                : '#ffffff' ?>;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .flash {
            background: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        button,
        a {
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
        }

        .danger {
            background: #dc2626;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

    </style>

</head>

<body>

<header>

    <h1>Keranjang Belanja</h1>

</header>

<main>

    <a href="index.php">
        ← Kembali ke Produk
    </a>

    <?php if ($flash !== null): ?>

        <div class="flash">
            <?= e($flash) ?>
        </div>

    <?php endif; ?>

    <h2>Isi Keranjang</h2>

    <?php if (empty($cart)): ?>

        <div class="card">
            <p>Keranjang masih kosong.</p>
        </div>

    <?php else: ?>

        <?php foreach ($cart as $id => $quantity): ?>

            <?php

            if (!isset($products[$id])) {
                continue;
            }

            $product = $products[$id];

            $subtotal =
                $product['harga'] * $quantity;

            $total += $subtotal;

            ?>

            <div class="card">

                <h3>
                    <?= e($product['nama']) ?>
                </h3>

                <p>
                    Harga:
                    Rp <?= number_format(
                        $product['harga'],
                        0,
                        ',',
                        '.'
                    ) ?>
                </p>

                <p>
                    Jumlah:
                    <?= $quantity ?>
                </p>

                <p>
                    Subtotal:
                    Rp <?= number_format(
                        $subtotal,
                        0,
                        ',',
                        '.'
                    ) ?>
                </p>

                <form
                    action="actions.php"
                    method="post"
                >

                    <input
                        type="hidden"
                        name="action"
                        value="remove"
                    >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $id ?>"
                    >

                    <button
                        class="danger"
                        type="submit"
                    >
                        Hapus
                    </button>

                </form>

            </div>

        <?php endforeach; ?>

        <div class="total">

            Total:
            Rp <?= number_format(
                $total,
                0,
                ',',
                '.'
            ) ?>

        </div>

        <br>

        <form
            action="actions.php"
            method="post"
        >

            <input
                type="hidden"
                name="action"
                value="clear"
            >

            <button
                class="danger"
                type="submit"
            >
                Kosongkan Keranjang
            </button>

        </form>

    <?php endif; ?>

</main>

</body>

</html>