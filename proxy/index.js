const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');
require('dotenv').config();

const app = express();
const port = 3000;

app.use(bodyParser.json());

const mysqlDatabase = process.env.DB_DATABASE;
const mysqlHost = process.env.DB_HOST;
const mysqlUser = process.env.DB_USERNAME;
const mysqlPassword = process.env.DB_PASSWORD;

const db = mysql.createConnection({
    host: mysqlHost,
    user: mysqlUser,
    password: mysqlPassword,
    database: mysqlDatabase
});

app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    next();
});

app.post('/query', (req, res) => {
    const sqlCommands = req.body.query.split(';').filter(command => command.trim() !== '');

    const results = [];

    sqlCommands.forEach(command => {
        db.query(command, (err, result) => {
            if (err) {
                console.error('Error during query:', err);
                res.status(500).json({ error: 'Error during query' });
                return;
            }

            results.push(result);
        });
    });

    res.json({ results });
});

app.listen(port, () => {
    console.log(`http://localhost:${port}`);
});


