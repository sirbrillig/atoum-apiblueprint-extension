<?php

declare(strict_types=1);

namespace atoum\apiblueprint;

use mageekguy\atoum;

class extension implements atoum\extension
{
    protected $_apibFinder = null;

    public function __construct(atoum\configurator $configurator = null)
    {
        if ($configurator) {
            $parser = $configurator->getScript()->getArgumentsParser();

            $handler = function ($script, $argument, $values) {
                $script->getRunner()->addTestsFromDirectory(dirname(__DIR__) . '/test/');
            };

            $parser
                ->addHandler($handler, ['--test-ext'])
                ->addHandler($handler, ['--test-it']);
        }

        $this->_apibFinder = new finder();
    }

    public function addToRunner(atoum\runner $runner)
    {
        $runner->addExtension($this);

        return $this;
    }

    public function setRunner(atoum\runner $runner)
    {
        return $this;
    }

    public function setTest(atoum\test $test)
    {
        return $this;
    }

    public function handleEvent($event, atoum\observable $observable)
    {
    }

    /**
     * Return the real finder instance.
     */
    public function getRawAPIBFinder(): finder
    {
        return $this->_apibFinder;
    }

    /**
     * Return the inner iterator of the iterator, which is a
     * `AppendIterator`. The user can simply add file system iterators to the
     * finder.
     */
    public function getAPIBFinder(): \AppendIterator
    {
        return $this->_apibFinder->getInnerIterator();
    }
}
