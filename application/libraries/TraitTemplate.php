<?php
/**
 * Trait For Template Engine
 */



trait TraitTemplate
{
    protected $template = '';
    function init($dir)
    {
        $this->template = new League\Plates\Engine($dir);
    }
}

 ?>
