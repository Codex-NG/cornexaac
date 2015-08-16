<?php namespace Theme;

use Illuminate\Contracts\Pagination\Presenter;
use Illuminate\Pagination\BootstrapThreePresenter;

class CornexPresenter extends BootstrapThreePresenter {

    public function getActivePageWrapper($text)
    {
        return '<li class="active"><span>'.$text.'</span></li>';
    }

    public function getDisabledTextWrapper($text)
    {
        return '<li class="disabled"><a href="#">'.$text.'</a></li>';
    }

    public function getPageLinkWrapper($url, $page, $rel = null)
    {
        if ($page == $this->paginator->currentPage())
        {
            return $this->getActivePageWrapper($page);
        }

        return '<li><a href="'.url($url).'">'.$page.'</a></li>';
    }


    public function render()
    {
        if ($this->hasPages())
        {
            return sprintf(
                '<ul class="pagination">%s %s %s</a>',
                $this->getPreviousButton('Previous page'),
                $this->getLinks(),
                $this->getNextButton('Next page')
            );
        }

        return '';
    }

}