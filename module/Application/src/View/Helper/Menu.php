<?php
/**
 * Created by PhpStorm.
 * User: ruslan
 * Date: 01/07/17
 * Time: 13:44
 */

namespace Application\View\Helper;


use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;

class Menu extends AbstractHelper
{
    // Массив пунктов меню.
    protected $items = [];

    protected $activeItemId = '';

    protected $menuRenderer;


    public function __construct($items = [], RendererInterface $menuRenderer)
    {
        $this->items = $items;
        $this->menuRenderer = $menuRenderer;
    }


    public function setItems($items)
    {
        $this->items = $items;
    }

    public function setActiveItemId($activeItemId)
    {
        $this->activeItemId = $activeItemId;
    }


    public function renderNew()
    {
        $viewContent = new ViewModel();
        $viewContent->setTemplate('menuMain');
        $menuContent = $this->menuRenderer->render($viewContent);

        return $menuContent;
    }


    public function render()
    {
        if (count($this->items)==0)
            return ''; // Do nothing if there are no items.

        $result = '<nav class="navbar navbar-default" role="navigation">';
        $result .= '<div class="navbar-header">';
        $result .= '<button type="button" class="navbar-toggle" data-toggle="collapse"';
        $result .= 'data-target=".navbar-ex1-collapse">';
        $result .= '<span class="sr-only">Toggle navigation</span>';
        $result .= '<span class="icon-bar"></span>';
        $result .= '<span class="icon-bar"></span>';
        $result .= '<span class="icon-bar"></span>';
        $result .= '</button>';
        $result .= '</div>';

        $result .= '<div class="collapse navbar-collapse navbar-ex1-collapse">';
        $result .= '<ul class="nav navbar-nav">';

        // Render items
        foreach ($this->items as $item) {
            if(!isset($item['float']) || $item['float']=='left')
                $result .= $this->renderItem($item);
        }

        $result .= '</ul>';
        $result .= '<ul class="nav navbar-nav navbar-right">';

        // Render items
        foreach ($this->items as $item) {
            if(isset($item['float']) && $item['float']=='right')
                $result .= $this->renderItem($item);
        }

        $result .= '</ul>';
        $result .= '</div>';
        $result .= '</nav>';

        return $result;
    }


    public function renderItem($item)
    {
        $id = isset($item['id']) ? $item['id'] : '';
        $isActive = ($id==$this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';

        $result = '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        if (isset($item['dropdown'])) {

            $dropdownItems = $item['dropdown'];

            $result .= '<li class="dropdown ' . ($isActive?'active':'') . '">';
            $result .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
            $result .= $escapeHtml($label) . ' <b class="caret"></b>';
            $result .= '</a>';

            $result .= '<ul class="dropdown-menu">';
            foreach ($dropdownItems as $item) {
                $link = isset($item['link']) ? $item['link'] : '#';
                $label = isset($item['label']) ? $item['label'] : '';

                $result .= '<li>';
                $result .= '<a href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
                $result .= '</li>';
            }
            $result .= '</ul>';
            $result .= '</li>';

        } else {
            $link = isset($item['link']) ? $item['link'] : '#';

            $result .= $isActive?'<li class="active">':'<li>';
            $result .= '<a href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
            $result .= '</li>';
        }

        return $result;
    }


}