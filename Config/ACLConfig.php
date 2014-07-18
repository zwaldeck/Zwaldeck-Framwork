<?php
return array(
    'roles' => array(
        'anonymous',
        'user',
        'admin'
    ),
    'routes' => array(
        'user_panel' => array(
            'uri' => 'users/*',
            'role' => 'user'
        ),
        'admin_panel' => array(
            'uri' => 'admin/*',
            'role' => 'admin'
        )
    )
);