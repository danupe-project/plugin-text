<?php
return [
    'up' => '
        INSERT INTO texts (`key`,`text`,`language`) VALUES ("test","test","de");
    ',
    'down' => '
        DELETE FROM texts WHERE id = 1;
    '
];
