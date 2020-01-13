<?php

namespace Users\Application;

use Datto\JsonRpc\Evaluator;
use Datto\JsonRpc\Exceptions\ApplicationException;
use Datto\JsonRpc\Exceptions\ArgumentException;
use Datto\JsonRpc\Exceptions\MethodException;
use Phalcon\Di\Injectable;

class MicroJsonRpcEvaluator extends Injectable implements Evaluator {

    protected $application;

    public function __construct(MicroSwooleJsonRpcApplication $application) {

        $this->application = $application;

    }


    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws ArgumentException
     * @throws ApplicationException
     * @throws MethodException
     * @throws \Datto\JsonRpc\Exceptions\Exception
     */
    public function evaluate($method, $arguments) {

        try {

            $this->application->setRequest(new JsonRpcRequest($method, $arguments));

            return $this->application->handle($method);

        } catch (\TypeError $exception) {

            throw new ArgumentException();

        } catch (\Exception $exception) {

            if (!($exception instanceof \Datto\JsonRpc\Exceptions\Exception)) {

                switch ($exception->getMessage()) {
                    case 'Not-Found handler is not callable or is not defined':
                        throw new MethodException();
                    default:
                        throw new ApplicationException($exception->getMessage(), $exception->getCode());
                }
            }

            throw $exception;
        }
    }
}