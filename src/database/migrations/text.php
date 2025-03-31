<?php

return [
    'up' => '
            CREATE TABLE IF NOT EXISTS texts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `key` VARCHAR(255) NOT NULL,
                `text` TEXT NOT NULL,
                `language` VARCHAR(2) NOT NULL,       
                INDEX `idx_key_language` (`key`, `language`)
            );
',
    'down' => '
    DROP TABLE IF EXISTS texts;
'
];
