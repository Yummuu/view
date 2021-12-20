<?php

require_once __DIR__ . '/vendor/autoload.php';

use Yummuu\View\Engine;

$engine = new Engine();
$content = '{"css":{"type":"css","value":"h1{color:red;background-color:#00000}","list":["https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"]},"js":{"type":"js","value":"","list":["https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"]},"body":{"type":"form","form":{"formKey":"表单测试","candidateUsers":"Yummuu","candidateGroups":"CQGG","dueDate":"2021-01-01","formField":[{"id":"姓名","label":"姓名","type":"string","defaultValue":"Lee","validation":[{"config":null,"name":null}]},{"id":"性别","label":"标签","type":"enum","defaultValue":"男","values":[{"id":"Value_0rbp76t","name":"男"},{"id":"Value_2ecjui1","name":"女"},{"id":"Value_10eq5u5","name":"未知"}],"validation":[{"config":"1","name":"男"}]},{"id":"生日","label":"生日","type":"date","defaultValue":"2021-01-01","properties":[{"id":"Property_1gg14dr","value":null}]},{"id":"测试字段","label":null,"type":"checkbox","defaultValue":null,"properties":[{"id":"name","value":null}]}]},"content":""},"list":{"type":"list","content":""},"title":"这个是测试标题"}';

$arr = json_decode($content, true);
echo $engine->getContens('', $arr);
