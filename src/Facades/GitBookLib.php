<?php
/**
 * Created by PhpStorm.
 * User: qihao
 * Date: 2018/7/20
 * Time: 10:13.
 */

namespace Summergeorge\GitBookLib\Facades;

use Illuminate\Support\Facades\Facade;

class GitBookLib extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'gitbooklib';
    }
}
