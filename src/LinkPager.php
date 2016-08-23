<?php
/**
 * @author: Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\yii2\linkpager;


use yii\bootstrap\Html;

class LinkPager extends \yii\widgets\LinkPager
{
    public $go = false;

    public function renderPageButtons()
    {
        $renderedButtons = parent::renderPageButtons();
        $page = $this->pagination->getPage() + 1;
        $url = $this->pagination->createUrl($page);
        $pageGo = Html::textInput($this->pagination->pageParam, $page, [
            'class' => 'form-control',
            'style' => 'display: inline-block; margin-top:0; width: ' . (strlen($page) / 2 + 2) . 'em;',
        ]);
        $jsGo = <<<JSGO
$('ul.pagination li input').keyup(function(event){
    if(event.which != 13) return;
    var page = "{$url}";
    location.href = page.replace(/page=\\d+/, "page=" + this.value);
});
JSGO;

        $this->view->registerJs($jsGo);
        $renderedButtons = preg_replace('/<\/ul>/', "<li>{$pageGo}</li></ul>", $renderedButtons);
        return $renderedButtons;
    }
}