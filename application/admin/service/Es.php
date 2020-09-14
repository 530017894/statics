<?php


namespace app\admin\service;


use Elasticsearch\ClientBuilder;

class Es
{
    private static $instance = null;
    private static $client = null;

    public function __construct()
    {
        self::$client = ClientBuilder::create()->setHosts(config('es.'))->build();
    }

    public function create($data = [])
    {
        $params = [];
        $params['index'] = 'test';
        $params['type'] = 'cat';
        $params['body'] = array('name' => '小川编程');
        self::$client->index($params);
    }

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}