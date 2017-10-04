<?php

namespace FS\Web\Controller;

class PageController
{
    private $viewRoot  = __DIR__ . '/../../../web/view/';
    private $assetRoot = '/asset/';

    public function __construct()
    {
        if (defined('ENV') && ENV == 'live') {
            $this->assetRoot = '/build/';
        }
    }

    #region Methods
    public function render($view = 'home')
    {
        $this->_display($view, $this->assetRoot);
        return '';
    }
    #endregion

    #region Utils
    private function _display($view, $asset)
    {
        require_once($this->viewRoot . strtolower($view) . '.view.php');
    }
    #endregion
}
