<?php

return [
    'json' => [
        'title'       => '商派B2B2C v4.0操作文档',
        'description' => '商派B2B2C v4.0操作文档',
        'author'      => 'Shopex',
        'generator'   => 'site',
        'language'    => 'zh-hans',
        'gitbook'     => '3.x.x',
        'styles'      => [
            'website' => 'styles/website.css',
        ],
//    "links" => [
//        "sidebar" => [
//            "<i class='fa fa-fw fa-file-pdf-o fa-lg'></i>下载pdf" => "/v4/book.pdf",
//        ]
//    ],
        'plugins' => [
            '-lunr',
            '-search',
            '-highlight',
            '-fontsettings',
            'prism',
            'prism-themes',
//         "edit-link",
            'anchors',
//         "github",
            'search-plus',
            'expand-active-chapter',
            'expandable-chapters-interactive',
//         "versions-select",
            'theme-comscore',
//         "add-js-css",
            'header',
            'footer',
            'anchor-navigation-ex',
        ],
        'pluginsConfig' => [
//        "edit-link" => [
//            "base" => "https://git.ishopex.cn/onex-doc/bbc-manual/blob/v4.0/",
//            "label" => "编辑本页面"
//        ],
//        "github" => [
//            "url" => "https://git.ishopex.cn/onex-doc/bbc-manual.git"
//        ],
//        "versions" => [
//            "gitbookConfigURL" => "https://git.ishopex.cn/onex-doc/bbc-manual/blob/v4.0/book.json",
//            "options" => [
//                 [
//                    "value" => "http://192.168.75.100:81/v4",
//                    "text" => "商派B2B2C v4.0操作文档",
//                ],
//                 [
//                    "value" => "http://192.168.75.100:81/v3",
//                    "text" => "商派B2B2C v3.0操作文档",
//                ]
//            ]
//        ],
            'prism' => [
                'css' => [
                    'prism-themes/themes/prism-vs.css',
                ],
            ],
            'layout' => [
                'headerPath' => 'styles/header.html',
                'footerPath' => 'styles/footer.html',
            ],
//        "add-js-css" => [
//            "css" => [
//                 "styles/viewer.min.css"
//            ]
//        ],
        ],
    ],
    'pdf' => [
        'title'       => '',
        'description' => '',
        'author'      => 'Shopex',
        'generator'   => 'site',
        'language'    => 'zh-hans',
        'gitbook'     => '3.x.x',
        'pdf'         => [
            'fontSize'       => 14,
            'footerTemplate' => null,
            'headerTemplate' => null,
            'pageNumbers'    => true,
            'paperSize'      => 'a4',
        ],
    ],
    'base_url' => env('GITBOOK_BASE_URL', 'http://192.168.75.251:81'),

    // 发布工具，可选项：docker,shell,需要搭建相应的环境；
    'engine' => env('GITBOOK_ENGINE', 'docker'),

    // 是否启用cache（开启cache会将git内容缓存到硬盘，再次更新将采用git pull的方式，会增加磁盘占用）；
    'cache' => env('GITBOOK_CACHE', true),

    // 是否启用中文图片名称转化（解决中文图片名无法生成pdf问题）；
    'change-zh' => env('GITBOOK_CHANGE_ZH', true),

    'storage_path' => storage_path('bookTmp'),

    //publisher info object
    'publish_info' => [
        'id'              => '',
        'title'           => '',
        'description'     => '',
        'github_url'      => '',
        'links'           => '',
        'versions_select' => '',
        'edit_link'       => '',
        'web_dir'         => '',
        'git_url'         => '',
        'git_branch'      => '',
        'git_path'        => '',
        'git_user'        => '',
        'git_password'    => '',
        'book_json'       => '',
    ],
];
