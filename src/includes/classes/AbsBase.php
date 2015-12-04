<?php
namespace WebSharks\WpSuperSnow;

class AbsBase
{
    protected $Plugin;

    const VERSION = '151204'; //v//
    const GLOBAL_NS = 'wp_super_snow';

    public function __construct(Plugin $Plugin = null)
    {
        $this->Plugin = $Plugin;
    }
}
