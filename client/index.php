<html>
    <head>
        <meta title="Client PHP">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <h1>Client PHP</h1>
        <p>Consume a Node API hosted in Docked from a PHP client</p>

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