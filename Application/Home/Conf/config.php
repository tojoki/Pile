<?php
/* 前台配置 */
    return array(
    'WEB_NAME'=>'Pile',
    'DEFAULT_PAGE_SIZE'=>12,
    'DEFAULT_AVATOR_PATH'=>'/Uploads/avator.png',
    //'配置项'=>'配置值'
	'TMPL_PARSE_STRING' => array(
			'__CSS__' => __ROOT__.'/Public/Home/css',
			'__JS__'  => __ROOT__.'/Public/Home/js',
			'__IMG__' => __ROOT__.'/Public/Home/images',
			'__UPLOAD__'=>__ROOT__.'//',
            '__LAYER__'=>__ROOT__.'/Public/Home/layer',
		)
);