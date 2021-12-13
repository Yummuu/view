<?php

require_once __DIR__ . '/vendor/autoload.php';
use Yummuu\View\Engine;

$engine = new Engine();
$body = <<<HTML
<h1>测试</h1>
HTML;
$js = <<<EOF
<script type="module" src="new_tab_page.js"></script>
EOF;
echo $engine->render('',['css'=>'test-ccss','menu'=>$body,'form'=>'form表单','js'=>$js,'title'=>'title-test']);