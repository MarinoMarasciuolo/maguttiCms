<?php
return [
    'app' => [
        'name' => 'MaguttiCms',
        'legal' => 'MaguttiCms Framework',
        'address' => '8 maguttiCms Street',
        'locality' => 'Bergamo - Italy',
        'lat' => '45.612310',
        'lng' => '9.694187',
        'phone' => '+39 0363.123456',
        'fax' => '+39 035.123456',
        'vat' => 'XXXXXXXXX',
        'email' => 'hello@magutti.com',
        'email_order' => 'order@magutti.com',
    ],
    'email' => [
        'footer' => 'Questo messaggio è stato inviato da un indirizzo email utilizzato solo per le notifiche e non abilitato alla ricezione. Si prega di non rispondere a questo messaggio.'
    ],
    'pagination' => [
        'news_index' => 3,
    ],
    'images' => [
        'gallery' => '1',
        'slider' => '2',
        'bottom' => '3',
    ],
    'auth' => [
        'default_page' => 'login',
    ],
    // FontAwesome or MaterialIcons
    'icons' => 'fa',    // 'icons' => 'mi',
    'features' => [
        'reserved-area' => true
    ]
];
