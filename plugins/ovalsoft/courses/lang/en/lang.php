<?php

return [
    'common' => [
        'create' => 'Create',
        'create_and_close' => 'Create and Close',
        'save' => 'Save',
        'save_and_close' => 'Save and Close',
        'cancel' => 'Cancel',
        'created_at' => 'Created',
        'updated_at' => 'Last modification'
    ],
    'plugin' => [
        'navigation' => [
            'label' => 'YT Gallery',
            'sidemenu' => [
                'videos' => [
                    'label' => 'Videos'
                ],
                'playlists' => [
                    'label' => 'Playlists'
                ]
            ],
        ],
        'controllers' => [
            'videos' => [
                'name' => 'Video',
                'breadcrumbs' => 'Videos',
                'relation' => [
                    'label' => 'video'
                ],
                'list_toolbar' => [
                    'new' => 'New Video'
                ],
                'create' => [
                    'title' => 'Create Video',
                    'return' => 'Return to videos list'
                ],
                'update' => [
                    'title' => 'Edit Video'
                ]
            ],
            'playlists' => [
                'name' => 'Playlist',
                'breadcrumbs' => 'Playlists',
                'relation' => [
                    'label' => 'playlist'
                ],
                'list_toolbar' => [
                    'new' => 'New Playlist'
                ],
                'create' => [
                    'title' => 'Create Playlist',
                    'return' => 'Return to playlists'
                ],
                'update' => [
                    'title' => 'Edit Playlist'
                ]
            ]
        ],
        'models' => [
            'course' => [
                'columns' => [
                    'title' => 'Title',
                    'slug' => 'Slug',
                    'description' => 'Course description',
                ],
                'fields' => [
                    'title' => 'Video title',
                    'slug' => 'Slug',
                    'description' => 'Course description',
                    'on' => 'Yes',
                    'off' => 'No',
                ],
            ],
            'video' => [
                'columns' => [
                    'title' => 'Title',
                    'slug' => 'Slug',
                    'youtube_video_id' => 'YouTube video ID',
                    'published' => 'Published',
                    'order' => 'Order'
                ],
                'fields' => [
                    'source' => 'Video Source',
                    'title' => 'Video title',
                    'slug' => 'Slug',
                    'youtube_video_id' => 'YouTube Video ID',
                    'published' => 'Published',
                    'order' => 'Video display priority in playlists',
                    'description' => 'Video description',
                    'categories' => 'Video categories',
                ],
                'attributes' => [
                    'title' => 'title',
                    'youtube_video_id' => 'YouTube video ID'
                ]
            ],
            'playlist' => [
                'columns' => [
                    'name' => 'Name',
                    'slug' => 'Slug',
                    'video_count' => 'Number of videos'
                ],
                'fields' => [
                    'name' => 'Name',
                    'slug' => 'Slug',
                    'description' => 'Playlist description',
                ],
                'attributes' => [
                    'name' => 'name'
                ]
            ]
        ]
    ]
];