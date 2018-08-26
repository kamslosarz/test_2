<?php

return [
    'database'=>[
        'connection'=>'sqlite',
        'sqlite'=>[
            sprintf('sqlite:%s/data/database.db', dirname(__DIR__)),
            null,
            null,
            []
        ]
    ]
];