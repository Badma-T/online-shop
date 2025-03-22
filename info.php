<?php
$conn = pg_connect("host=postgres_db dbname=mydb user=user password=pass");
if ($conn) {
    echo "Connected to PostgreSQL successfully!";
} else {
    echo "Connection failed.";
}

echo "\n";
echo "Hello World!";