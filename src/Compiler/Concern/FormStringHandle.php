<?php

declare(strict_types=1);

namespace Yummuu\View\Compiler\Concern;

use Yummuu\View\Compiler\StringHandleInterface;

class FormStringHandle implements StringHandleInterface
{
    /**
     * 格式化数据
     *
     * @param [type] $data
     * @return string
     */
    public function format($data): string
    {
        $result    = '';
        $formFeild = '';
        $form      = $data['form'];
        if (!is_array($form)) {
            return $result;
        }
        if (isset($form['formField'])) {
            $arr = [];
            foreach ($form['formField'] as $fieldItem) {
                if (!isset($fieldItem['type'])) {
                    continue;
                }
                $id      = $this->createFieldId($fieldItem);
                $name    = $this->createFieldName($fieldItem);
                $label   = $this->createLabel($fieldItem, $id);
                $str     = '';
                switch ($fieldItem['type']) {
                    case 'select':
                        $str = $this->formFieldForSelect($fieldItem, $name);
                        break;
                    case 'radio':
                        $str = $this->formFieldForRadio($fieldItem, $name);
                        break;
                    case 'checkbox':
                        $str = $this->formFieldForCheckbox($fieldItem, $name);
                        break;
                    case 'number':
                        $str = $this->formFieldForNum($fieldItem, $name);
                        break;
                    case 'textarea':
                        $str = $this->formFieldForTextarea($fieldItem, $id);
                        break;
                    case 'text':
                    case 'string':
                    default:
                        $str = $this->formFieldForString($fieldItem, $id);
                        break;
                }
                array_push($arr, $this->createFormItem($label, $str));
            }
            $formFeild = implode(" ", $arr);
        }
        if (isset($form['formKey'])) {
            $key    = $form['formKey'];
            $class  = isset($form['class']) ? $form['class'] : "";
            $method  = isset($form['method']) ? $form['method'] : "POST";
            $result = <<<EOF
            <form class='$class' id='$key' method='$method'>
                $formFeild
            </form>
EOF;
        }
        return $result;
    }

    protected function createFieldId($data)
    {
        return "form-" . (isset($data['id']) ? $data['id'] : md5($data));
    }

    protected function createFieldName($data)
    {
        return isset($data['name']) ? $data['name'] : ((isset($data['id']) ? $data['id'] : md5($data)));
    }

    protected function createLabel($fieldItem, $id)
    {
        $label = isset($fieldItem['label']) ? $fieldItem['label'] : '';
        $tips  = isset($fieldItem['tips']) ? $fieldItem['tips'] : '';
        $must  = isset($fieldItem['must']) ? $fieldItem['must'] : '';
        $other = '';
        if ($must) {
            $other .= "<i class='form-must'>$must</i>";
        }
        if ($tips) {
            $other .= "<i class='form-tips'>$tips</i>";
        }
        return "<label for='$id'>$label $other</label>";
    }

    protected function createFormItem($label, $content): string
    {
        return <<<FORM
        <div class='form-group'>
            $label
            $content
        </div>
FORM;
    }

    protected function formFieldForString($data, $id, $value = ''): string
    {
        $tips  = isset($data['placeholder']) ? $data['placeholder'] : '';                           //提示语
        $value = $value ? $value : (isset($data['defaultValue']) ? $data['defaultValue'] : '');     //默认值
        return <<<INPUT
            <input type='text' class='form-control' id='$id' placeholder='$tips' value='$value' />
INPUT;
    }

    protected function formFieldForNum($data, $name, $num = 0): string
    {
        $tips  = isset($data['placeholder']) ? $data['placeholder'] : '';                           //提示语
        $value = $num ? $num : (isset($data['defaultValue']) ? $data['defaultValue'] : 0);          //默认值
        return <<<INPUT
            <input type='number' class='form-control' name='$name' placeholder='$tips' value='$value' />
INPUT;
    }

    protected function formFieldForPassword($data, $id, $value = ''): string
    {
        $tips  = isset($data['placeholder']) ? $data['placeholder'] : '';                           //提示语
        $value = $value ? $value : (isset($data['defaultValue']) ? $data['defaultValue'] : '');     //默认值
        return <<<INPUT
            <input type='password' class='form-control' id='$id' placeholder='$tips' value='$value' />
INPUT;
    }

    protected function formFieldForTextarea($data, $id, $value = ''): string
    {
        $tips  = isset($data['placeholder']) ? $data['placeholder'] : '';                           //提示语
        $value = $value ? $value : (isset($data['defaultValue']) ? $data['defaultValue'] : '');     //默认值
        return <<<TEXTAREA
            <textarea row='10' cols='30' id='$id' placeholder='$tips'>$value</textarea>
TEXTAREA;
    }

    protected function formFieldForCheckbox($data, $name, $checked = []): string
    {
        $lists = isset($data['properties']) ? $data['properties'] : [];
        $result = '';
        foreach ($lists as $item) {
            $v = $item['value'];
            $n = $item['id'];
            $c = in_array($v, $checked) ? 'true' : 'false';
            $result .= "<input type='checkbox' value='$v' id='$v' name='$name' checked='$c' /><label for='$v'>$n</label>";
        }
        return $result;
    }

    protected function formFieldForRadio($data, $name, $checked = ''): string
    {
        $lists = isset($data['properties']) ? $data['properties'] : [];
        $result = '';
        foreach ($lists as $item) {
            $v = $item['value'];
            $n = $item['id'];
            $c = $v == $checked ? 'true' : 'false';
            $result .= "<input type='radio' value='$v' id='$v' name='$name' checked='$c' /><label for='$v'>$n</label>";
        }
        return $result;
    }

    protected function formFieldForSelect($data, $name, $selected = []): string
    {
        $lists = isset($data['properties']) ? $data['properties'] : [];
        $result = '';
        foreach ($lists as $item) {
            $v = $item['value'];
            $n = $item['id'];
            $c = in_array($v, $selected) ? 'true' : 'false';
            $result .= "<option value='$v' selected='$c'>$n</option>";
        }
        return <<<SELECT
        <select name="$name">
            $result
        </select>
SELECT;
    }
}
