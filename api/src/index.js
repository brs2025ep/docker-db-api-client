const express = require('express');
const mysql = require('mysql2');

const app = express();

const connection = mysql.createConnection({
    host: 'mysql-container',
    user: 'root',
    password: 'root',
    database: 'store'
});

connection.connect();

app.get('/products', function(req, res) { 
    connection.query('SELECT * FROM products', function(error, results) {

        if (error) {
            console.log(error);
            return res.status(500).send({ error: 'Database query failed' });
        };
        
        res.send(results.map(item => ({ name: item.name, price: item.price })));
    });
});

app.listen(9001, '0.0.0.0', function() {
    console.log('Listening on port 9001');
})
