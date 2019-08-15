<?php
/**
 * @package mj - PHP mini applciation for fast integration and implement
 * @version standalone version
 * @author Pham Minh
 * @website http://minh.ninja
 * @github
 * 
 */

namespace mj;

class config{

    private static $mjVersion = '0.2';
    private static $mjApp = 'mjApplication';

    // [ name_route, slug, params, task ]
    public static $endpoints = [
        // core system
        ['system' , 'system-message'],
        ['home' , '/'], 
        // test
        ['test-nice-slug' , 'test'],
        ['test-group-action' , 'admin'],
        ['test-url-var' , 'test2', array( 'id'=>'(.*)')],
        ['test-multi-level-path' , 'test3/test4/test5' ],
    ];

    // this relate to $endpoints
    public static $acceptUrlParams = [
        'app', 'task', 'alias', 'id', 'format'
    ];

    //  this relate to task in $endpoints 
    //  [
    //      task1 => [ 'act1', 'act2' ],
    //      task2 => [ 'act3', 'act2' ],
    //  ]
    public static $routers = [
        'system' => [ 'showDefault' ], 
        'home' => [ 'preparePostInWidget', 'showHome'],
        'test_nice_slug' => [
            'get' => ['preparePostInWidget', 'showPageData'],
            'post' => ['preparePostInWidget', 'beforeProcess', 'showPageData']
        ],
        'test_url_var' => [
            'get' => ['preparePostInWidget', 'showPageData'],
            'post' => ['preparePostInWidget', 'beforeProcess', 'showPageData']
        ],
        'test_group_action' => [
            'preparePostInWidget', 'admin\\testAdmin'
        ],
        'test_multi_level_path' => [
            'preparePostInWidget', 'showPageData'
        ],
    ];

    public static $notFoundTask = 'system';
    public static $notFoundAction = 'notFound';

    public static $defaultLanguage = 'english';

    public static $classUser = '';

    public static $siteName = 'Mj apllication - Demo';
    public static $siteDesc = 'Demo show how to implement MJ application';
    public static $siteUrl = 'http://localost/minhninja-mj/public';

    public static $template = [
        'script_path' => 'demo',
        'asset_path' => 'public'
    ];

    // 0: hide
    // 1: show inside html comment
    // 2: display as normal content
    public static $debug = 0;

    public static $queryLimit = 20;

    /* DB Connect
    public static $dbConnect = [
        'type' => 'mysql',
        'host' => 'localhost',
        'db' => 'demo',
        'user' => 'demo',
        'password' => 'demo',
    ];
    */
}