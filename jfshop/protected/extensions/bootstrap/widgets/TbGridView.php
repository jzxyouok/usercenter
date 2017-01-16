<?php
/**
 * TbGridView class file.
 * @author Antonio Ramirez <ramirez.cobos@gmail.com>
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Mod::import('zii.widgets.grid.CGridView');

/**
 * Bootstrap Zii grid view.
 */
class TbGridView extends CGridView
{
    /**
     * @var string|array the table style.
     * Valid values are TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED and/or
     * TbHtml::GRID_TYPE_HOVER.
     */
    public $type;
    /**
     * @var array the configuration for the pager.
     * Defaults to <code>array('class'=>'ext.bootstrap.widgets.TbPager')</code>.
     */
    public $pager = array('class' => 'bootstrap.widgets.TbPager');
    /**
     * @var string the URL of the CSS file used by this grid view.
     * Defaults to false, meaning that no CSS will be included.
     */
    public $cssFile = false;
    /**
     * @var string the template to be used to control the layout of various sections in the view.
     */
    public $template = "{items}\n<div class=\"row\"><div class=\"col-sm-6\">{summary}</div><div class=\"col-sm-6\">{pager}</div></div>";

    public $pagerCssClass = 'dataTables_paginate paging_bootstrap';
    /**
     * @var summary
     */
    public $summaryCssClass = 'dataTables_info';
    public $summaryCssId = 'sample-table-2_info';

    public $summaryText;
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $classes = array('table');
        if (isset($this->type) && !empty($this->type)) {
            if (is_string($this->type)) {
                $this->type = explode(' ', $this->type);
            }

            foreach ($this->type as $type) {
                $classes[] = 'table-' . $type;
            }
        }
        if (!empty($classes)) {
            $classes = implode(' ', $classes);
            if (isset($this->itemsCssClass)) {
                $this->itemsCssClass .= ' ' . $classes;
            } else {
                $this->itemsCssClass = $classes;
            }
        }

        $this->summaryText = Mod::t('zii','共{count}条记录,当前页:{start}-{end}条');
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        foreach ($this->columns as $i => $column) {
            if (is_array($column) && !isset($column['class'])) {
                $this->columns[$i]['class'] = 'bootstrap.widgets.TbDataColumn';
            }
        }
        parent::initColumns();
    }

    /**
     * Creates a column based on a shortcut column specification string.
     * @param mixed $text the column specification string
     * @return \TbDataColumn|\CDataColumn the column instance
     * @throws CException if the column format is incorrect
     */
    protected function createDataColumn($text)
    {
        if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            throw new CException(Mod::t(
                'zii',
                'The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'
            ));
        }
        $column = new TbDataColumn($this);
        $column->name = $matches[1];
        if (isset($matches[3]) && $matches[3] !== '') {
            $column->type = $matches[3];
        }
        if (isset($matches[5])) {
            $column->header = $matches[5];
        }
        return $column;
    }
}
