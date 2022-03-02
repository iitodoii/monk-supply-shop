const express = require('express');
const app = express();
const PORT = 8082;

app.use(express.json());

app.listen(PORT, () => console.log('listening on port '+PORT));

