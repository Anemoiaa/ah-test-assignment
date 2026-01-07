<?php

require_once __DIR__ . '/../bootstrap/app.php';

use Anemoiaa\AhTestAssignment\core\Database;

$db = Database::connection();

$db->prepare("
    CREATE TABLE IF NOT EXISTS categories (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,        
        
        INDEX idx_created_at (created_at)
    )
")->execute();


$db->prepare("
    CREATE TABLE IF NOT EXISTS posts (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        text TEXT NOT NULL,
        image VARCHAR(255),
        views INT UNSIGNED DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                
        INDEX idx_created_at (created_at)
    )
")->execute();

$db->prepare("
   CREATE TABLE IF NOT EXISTS post_category (
        post_id INT UNSIGNED NOT NULL,
        category_id INT UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                
        PRIMARY KEY (post_id, category_id),
        INDEX idx_category_post (category_id, post_id),
                
        CONSTRAINT fk_post_categories_post_id 
            FOREIGN KEY (post_id) 
            REFERENCES posts(id) 
            ON DELETE CASCADE 
            ON UPDATE CASCADE,
                    
        CONSTRAINT fk_post_categories_category_id 
            FOREIGN KEY (category_id) 
            REFERENCES categories(id) 
            ON DELETE CASCADE 
            ON UPDATE CASCADE
    )
")->execute();