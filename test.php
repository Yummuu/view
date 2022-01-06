<?php

require_once __DIR__ . '/vendor/autoload.php';

use Yummuu\View\Engine;

$engine = new Engine();
$content = '{"css":{"type":"css","value":"h1{color:red;background-color:#00000}","list":["https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"]},"js":{"type":"js","value":"","list":["https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"]},"body":{"type":"form","form":{"formKey":"表单测试","candidateUsers":"Yummuu","candidateGroups":"CQGG","dueDate":"2021-01-01","formField":[{"id":"姓名","label":"姓名","type":"string","defaultValue":"Lee","validation":[{"config":null,"name":null}]},{"id":"性别","label":"标签","type":"enum","defaultValue":"男","values":[{"id":"Value_0rbp76t","name":"男"},{"id":"Value_2ecjui1","name":"女"},{"id":"Value_10eq5u5","name":"未知"}],"validation":[{"config":"1","name":"男"}]},{"id":"生日","label":"生日","type":"date","defaultValue":"2021-01-01","properties":[{"id":"Property_1gg14dr","value":null}]},{"id":"测试字段","label":null,"type":"checkbox","defaultValue":null,"properties":[{"id":"name","value":null}]}]},"content":""},"list":{"type":"list","content":[{"title":"测试","id":1,"start_at":null,"status":1},{"title":"测试2","id":2,"start_at":null,"status":1},{"title":"测试3","id":3,"start_at":"2021-01-05 00:00:00","status":0},{"title":"测试4","id":4,"start_at":null,"status":1},{"title":"测试5","id":5,"start_at":null,"status":1},{"title":"测试6","id":6,"start_at":null,"status":1},{"title":"测试7","id":7,"start_at":null,"status":1},{"title":"admin","id":8,"start_at":null,"status":1}],"total":8,"size":15,"page":0,"config":[{"name":"序号","field":"id"},{"name":"标题","field":"title"},{"name":"生效时间","field":"start_at"},{"name":"状态","field":"status","render":[{"value":1,"name":"正常","class":"btn btn-info"},{"value":0,"name":"删除","class":"btn btn-danger"}]},{"name":"操作","field":"","render":[{"value":"","name":"详情","class":"btn btn-info"},{"value":"","name":"其它","class":"btn btn-danger"}]}]},"title":"这个是测试标题"}';

$arr = json_decode($content, true);
echo $engine->getContents('', $arr);
