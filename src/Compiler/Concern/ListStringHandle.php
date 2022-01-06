<?php

declare(strict_types=1);

namespace Yummuu\View\Compiler\Concern;

use Yummuu\View\Compiler\StringHandleInterface;
use Exception;

class ListStringHandle implements StringHandleInterface
{
    protected $tableClass = '';
    protected $tableId = '';
    protected $body = 'div';
    protected $trS = '<tr>';
    protected $trE = '</tr>';
    protected $tdS = '<td>';
    protected $tdE = '</td>';
    protected $thS = '<th>';
    protected $thE = '</th>';

    /**
     * 格式化数据
     *
     * @param [type] $data
     * @return string
     */
    public function format($data): string
    {
        $config  = isset($data['config']) && is_array($data['config']) ? $data['config'] : array();
        $content = isset($data['content']) && is_array($data['content']) ? $data['content'] : array();
        $this->tableClass = isset($data['table_class']) ? $data['table_class'] : 'table table-hover table-bordered';
        $this->tableId    = isset($data['table_id']) ? $data['table_id'] : 'table-' . md5(json_encode($data));
        if (isset($data['not_table']) && $data['not_table'] && is_array($data['not_table'])) {
            //非table形式
            $htmlNodeArr = $data['not_table'];
            $this->trS = isset($htmlNodeArr['trS']) ? $htmlNodeArr['trS'] : $this->trS;
            $this->trE = isset($htmlNodeArr['trE']) ? $htmlNodeArr['trE'] : $this->trE;
            $this->tdS = isset($htmlNodeArr['tdS']) ? $htmlNodeArr['tdS'] : $this->tdS;
            $this->tdE = isset($htmlNodeArr['tdE']) ? $htmlNodeArr['tdE'] : $this->tdE;
            $this->thS = isset($htmlNodeArr['thS']) ? $htmlNodeArr['thS'] : $this->thS;
            $this->thE = isset($htmlNodeArr['thE']) ? $htmlNodeArr['thE'] : $this->thE;
            $result = $this->formatNotTable(
                $this->getTableHeader($content, $config),
                $this->getTBody($content, $config)
            );
        } else {
            $result = $this->formatTable(
                $this->getTableHeader($content, $config),
                $this->getTBody($content, $config)
            );
        }
        return $result;
    }

    protected function getTableHeader($content, $config = []): string
    {
        $result = '';
        if ($config) {
            foreach ($config as $value) {
                if (isset($value['name']) && $value['name']) {
                    $result .= $this->thS . $value['name'] . $this->thE;
                } else {
                    $result .= $this->thS . '未命名' . $this->thE;
                }
            }
        } elseif ($content) {
            $keys = array_keys($content);
            foreach ($keys as $key) {
                $result .= $this->thS . $key . $this->thE;
            }
        } else {
            throw new Exception('list类型未配置也没有数据');
        }
        return $result;
    }

    protected function getTBody($content, $config): string
    {
        $result = '';
        if ($config) {
            foreach ($content as $value) {
                $tr = '';
                foreach ($config as $item) {
                    if (isset($item['field'])) {
                        $v = isset($value[$item['field']]) ? $value[$item['field']] : "";
                    } else {
                        continue;
                    }
                    if (isset($item['render'])) {
                        $v = $this->renderFormat($item['render'], $v);
                    }
                    $tr .= $this->tdS . $v . $this->tdE;
                }
                $result .= $this->trS . $tr . $this->trE;
            }
        } else {
            foreach ($content as $value) {
                $tr = '';
                foreach ($value as $v) {
                    $tr .= $this->tdS . $v . $this->tdE;
                }
                $result .= $this->trS . $tr . $this->trE;
            }
        }
        return $result;
    }

    protected function renderFormat($render, $value): string
    {
        if (!is_array($render)) {
            return $value;
        }
        $result = '';
        foreach ($render as $renderItem) {
            if (isset($renderItem['value']) && $value == $renderItem['value']) {
                $v = isset($renderItem['name']) && $renderItem['name'] ? $renderItem['name'] : $value;
                $btnClass = isset($renderItem['class']) ? $renderItem['class'] : 'btn btn-primary';
                $result .= "<div class='$btnClass' data-value='$v'>$v</div>";
            }
        }
        return $result;
    }

    protected function formatTable($theader = '', $tbody = ''): string
    {
        return <<<TABLE_HTML
        <table id="$this->tableId" class="$this->tableClass">
              <thead><tr>$theader</tr></thead>
              <tbody>$tbody</tbody>
        </table>
TABLE_HTML;
    }

    protected function formatNotTable($theader = '', $tbody = ''): string
    {
        return <<<NOT_TABLE_HTML
        <$this->body id="$this->tableId" class="$this->tableClass">
            $theader
            $tbody
        </$this->body>
NOT_TABLE_HTML;
    }
}
