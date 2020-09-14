<?php
return [
    "nsq" => [
        "nsqd_addrs" => [
            "192.168.1.128:4150",
        ],
        "lookupd_addrs" => [
            "192.168.1.128:4161",
        ],
        "lookupd_switch" => true,
        "logdir" => "/tmp",
        "auth_secret" => "secret",
        "auth_switch" => false,
    ],
    'topic' => "test"
];