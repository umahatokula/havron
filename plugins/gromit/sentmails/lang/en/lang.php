<?php

return [
    'menu_label'  => 'Sent mails',
    'mails'       => [
        'from'      => 'From',
        'to'        => 'To',
        'cc'        => 'Copy',
        'bcc'       => 'Hidden copy',
        'sent_at'   => 'Sent at',
        'opened_at' => 'Opened at',
    ],
    'errors'      => [
        'mail_not_found' => 'Mail not found',
        'file_deleted'   => 'File deleted',
    ],
    'controllers' => [
        'mails' => [
            'index' => [
                'page_title'      => 'View sent mails',
                'delete_selected' => [
                    'label'   => 'Delete selected',
                    'confirm' => 'Are you really want to delete selected mails?',
                ]
            ],
            'view'  => [
                'page_title'     => 'View mail',
                'back'           => 'Back',
                'return_to_list' => 'Return to mails list',
            ],
        ],
    ],
    'plugin' => [
        'description' => 'Saves sent mails to storage'
    ],
];
