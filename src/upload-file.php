<?php

return [

    // 是否开启缓存
    'tmp' => true,

    'middleware' => ['api'],

    'img' => [
        // 支持格式
        'supported_formats' => ['jpg', 'png', 'bmp', 'jpeg', 'gif'],
    ],

    'file' => [
        // 支持格式
        'supported_formats' => ['doc', 'exe', 'pdf'],
    ],

];