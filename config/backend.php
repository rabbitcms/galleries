<?php
declare(strict_types = 1);
use RabbitCMS\Backend\Support\Backend;

return [
    'boot' => function (Backend $backend) {
        $backend->addAclResolver(
            function (Backend $acl) {
                $acl->addAclGroup('galleries', trans('galleries::acl.galleries.title'));
                $acl->addAcl('galleries', 'galleries.read', trans('galleries::acl.galleries.read'));
                $acl->addAcl('galleries', 'galleries.write', trans('galleries::acl.galleries.write'));
            }
        );

        $backend->addMenuResolver(function (Backend $menu) {
            $parent = config('module.galleries.backend_menu');

            $menu->addMenu(
                $parent,
                'galleries',
                trans('galleries::menu.galleries'),
                relative_route('backend.galleries.galleries.index'),
                $parent === null ? 'fa-picture-o' : 'fa-angle-double-right',
                ['galleries.galleries.read'],
                900
            );
        });
    },
    'requirejs' => [
        'rabbitcms.galleries' => [
            'path' => 'js/rabbitcms.galleries',
            'deps' => 'rabbitcms.backend'
        ]
    ]
];
