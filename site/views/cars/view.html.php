<?php
defined('_JEXEC') or die;

class SheringViewCars extends JViewLegacy {
    protected $items;
    protected $pagination;
    protected $state;
    protected $token;

    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        foreach ($this->items as $item) {
            $item->images = json_decode($item->images);
        }

        return parent::display($tpl);
    }
}
?>