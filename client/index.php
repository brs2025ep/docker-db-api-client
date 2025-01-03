<html>
    <head>
        <meta title="Client PHP">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    </head>
    <body class="bg-light">
        <div class="container py-5">
            <h1 class="text-primary mb-3">Client PHP</h1>
            <p class="text-muted lead">Consume a Node API hosted in Docker from a PHP client</p>
        </div>

        <?php
            $result = file_get_contents('http://node-container:9001/products');
            $products = json_decode($result);
        ?>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                        <tr>
                            <td><?php echo $product -> name; ?></td>
                            <td><?php echo $product -> price; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>