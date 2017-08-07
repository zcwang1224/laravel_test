<?php

namespace app\Handlers;

class LfmConfigHandler extends \Unisharp\Laravelfilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
        return parent::userField();
        // return 123;
    }
}
