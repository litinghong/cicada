<?php


namespace clazz;


class Foo
{
    /**
     * @rpc rpc method
     * @param $arg1
     * @param $arg2
     * @return Bar
     */
    public function bar($arg1, $arg2){
        return new Bar($arg1, $arg2);
    }
}