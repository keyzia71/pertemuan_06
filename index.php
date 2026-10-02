```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/functions.php';

$products = require __DIR__ . '/data/products.php';

/*
|--------------------------------------------------------------------------
| Tema
|--------------------------------------------------------------------------
*/

$theme = $_COOKIE['theme'] ?? 'light';

$allowedThemes = ['light', 'dark'];

/*
|--------------------------------------------------------------------------
| Simpan Tema ke Cookie
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['theme'])
) {
    $candidate = $_POST['theme'];

    if (in_array($candidate, $allowedThemes, true)) {
        setcookie('theme', $candidate, [
            'expires' => time() + (60 * 60 * 24 * 30),
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        header('Location: index.php');
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Flash Message
|--------------------------------------------------------------------------
*/

$flash = pullFlash();

/*
|--------------------------------------------------------------------------
| Jumlah Produk di Keranjang
|--------------------------------------------------------------------------
*/

$cartCount = cartCount($_SESSION['cart'] ?? []);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Katalog Produk</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;

            background:
                <?= $theme === 'dark'
                    ? '#1e1e1e'
                    : '#f5f5f5' ?>;

            color:
                <?= $theme === 'dark'
                    ? '#ffffff'
                    : '#222222' ?>;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        h1 {
            margin: 0;
        }

        .cart-link {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            background: #007bff;
            color: white;
        }

        .theme-form {
            margin-bottom: 25px;
        }

        .theme-form select {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #aaa;
        }

        .theme-form button {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .flash {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background: #dff0d8;
            color: #2d662d;
        }

        .products {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .product {
            padding: 20px;
            border-radius: 10px;

            background:
                <?= $theme === 'dark'
                    ? '#2b2b2b'
                    : '#ffffff' ?>;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .product h2 {
            margin-top: 0;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
        }

        .product button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 7px;
            background: #007bff;
            color: white;
            cursor: pointer;
        }

        .product button:hover {
            background: #0056b3;
        }

    </style>

</head>

<body>

<div class="container">

    <header>

        <h1>Katalog Produk</h1>

        <a
            href="cart.php"
            class="cart-link"
        >
            Keranjang (<?= $cartCount ?>)
        </a>

    </header>


    <?php if ($flash !== null): ?>

        <div class="flash">
            <?= e($flash) ?>
        </div>

    <?php endif; ?>


    <!-- Pilihan Tema -->

    <form
        method="POST"
        class="theme-form"
    >

        <label for="theme">
            Pilih Tema:
        </label>

        <select
            name="theme"
            id="theme"
        >

            <option
                value="light"
                <?= $theme === 'light' ? 'selected' : '' ?>
            >
                Light
            </option>

            <option
                value="dark"
                <?= $theme === 'dark' ? 'selected' : '' ?>
            >
                Dark
            </option>

        </select>

        <button type="submit">
            Simpan Tema
        </button>

    </form>


    <!-- Daftar Produk -->

    <div class="products">

        <?php foreach ($products as $id => $product): ?>

            <div class="product">

                <h2>
                    <?= e($product['nama']) ?>
                </h2>

                <div class="price">

                    Rp
                    <?= number_format(
                        $product['harga'],
                        0,
                        ',',
                        '.'
                    ) ?>

                </div>

                <form
                    action="actions.php"
                    method="POST"
                >

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

</div>

</body>

</html>
```
