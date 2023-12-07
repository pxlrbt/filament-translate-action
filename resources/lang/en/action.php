<?php

return [
    'label' => 'Translate',

    'notifications' => [
        'success' => [
            'title' => 'Translations updated',
            'body' => ':records field(s) have been translated. Please review the translation and save the specification.',
        ],

        'error' => [
            'title' => 'Translation failed',
            'body' => 'Unknown error: :reason',
        ],

        'connection-error' => 'DeepL is taking too long to respond.',
        '429-error' => 'Too many requests. Please try again later.',
        '456-error' => 'Volume exhausted. New translations are only possible again on the 1st of the next month.',
    ]
];
