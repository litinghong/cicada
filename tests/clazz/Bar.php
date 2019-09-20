<?php


namespace clazz;


class Bar
{
    private $arg1;
    private $arg2;

    /**
     * Bar constructor.
     * @param $arg1
     * @param $arg2
     */
    public function __construct($arg1, $arg2)
    {
        $this->arg1 = $arg1;
        $this->arg2 = $arg2;
    }

    /**
     * @return mixed
     */
    public function getArg1()
    {
        return $this->arg1;
    }

    /**
     * @param mixed $arg1
     */
    public function setArg1($arg1)
    {
        $this->arg1 = $arg1;
    }

    /**
     * @return mixed
     */
    public function getArg2()
    {
        return $this->arg2;
    }

    /**
     * @param mixed $arg2
     */
    public function setArg2($arg2)
    {
        $this->arg2 = $arg2;
    }
}