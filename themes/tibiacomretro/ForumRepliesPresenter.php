<?php namespace themes\tibiacomretro;

use Illuminate\Contracts\Pagination\Presenter;
use Illuminate\Pagination\BootstrapThreePresenter;

class ForumRepliesPresenter extends BootstrapThreePresenter {

    public function getActivePageWrapper($text)
    {
        return $text;
    }

    public function getDisabledTextWrapper($text)
    {
        return '';
    }

    public function getPageLinkWrapper($url, $page, $rel = null)
    {
        if ($page == $this->paginator->currentPage())
        {
            return $this->getActivePageWrapper($page);
        }

        return '<a href="'.url($url).'">'.$page.'</a>';
    }


    public function render()
    {
        if ($this->hasPages())
        {
            return sprintf(
                '<table><tr class="transparent noborderpadding"><td align="right">%s %s</td></tr></table>',
                $this->getPreviousButton('Previous page'),
                $this->getNextButton('Next page')
            );
        }

        return '';
    }

}