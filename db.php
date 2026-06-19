<?php
$pdo = new PDO("mysql:host=127.0.0.1;port=3307;dbname=hotel_system;charset=utf8mb4", "root", "");
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);