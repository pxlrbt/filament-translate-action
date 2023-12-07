<?php

return [
    'label' => 'Übersetzen',

    'notifications' => [
        'success' => [
            'title' => 'Übersetzungen aktualisiert',
            'body' => ':fields Feld(er) wurden übersetzt. Bitte überprüfen Sie die Übersetzung und speichern Sie die Spezifikation.',
        ],

        'error' => [
            'title' => 'Übersetzung fehlgeschlagen',
            'body' => 'Unbekannter Fehler: :reason',
        ],

        'connection-error' => 'DeepL braucht zu lange zum Antworten.',
        '429-error' => 'Zu viele Anfragen. Bitte versuchen Sie es später nochmal.',
        '456-error' => 'Volumen aufgebraucht. Neue Übersetzungen sind erst wieder am 1. des nächsten Monats möglich.',
    ]
];
