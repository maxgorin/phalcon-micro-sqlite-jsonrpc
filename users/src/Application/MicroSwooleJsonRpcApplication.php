<?php

namespace Users\Application;


use Phalcon\Mvc\Micro;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

class MicroSwooleJsonRpcApplication extends Micro {

    protected $server;

    protected $jsonRpcRequest;

    public function __construct($host, $port, $container) {

        $this->server = new Server($host, $port);

        $this->server->set([
            'open_http2_protocol' => true
        ]);

        $this->server->on('start', [$this, 'onStartServer']);
        $this->server->on('request', [$this, 'onRequest']);

        parent::__construct($container);

    }

    public function getServer(): Server {
        return $this->server;
    }

    public function onStartServer(Server $server) {

        echo 'Swoole http server is started' . PHP_EOL;

    }

    public function onRequest(Request $request, Response $response): bool {

        if (!isset($request->header['content-type']) || ($request->header['content-type'] !== 'application/json')) {
            return $this->jsonRpcError(415, 'Unsupported Media Type', $response);
        }

        $message = $request->rawContent();

        if (empty($message)) {
            return $this->jsonRpcError(400, 'Bad Request', $response);
        }

        // Convert Swoole HTTP request to regular PHP request
        foreach ($request->server as $key => $value) {
            $_SERVER[strtoupper($key)] = $value;
        }

        $jsonRpcServer = new \Datto\JsonRpc\Server(new MicroJsonRpcEvaluator($this));

        $reply = $jsonRpcServer->reply($message);

        if ($reply === null) {

            $response->status(204, 'No Content');
            $response->end();

        } else {

            $response->header('Content-type', 'application/json');
            $response->end($reply);

        }

        return true;
    }

    public function start() {

        $this->server->start();

    }

    public function setRequest(JsonRpcRequest $rpcRequest) {
        $this->jsonRpcRequest = $rpcRequest;
    }

    public function getRequest(): JsonRpcRequest {
        return $this->jsonRpcRequest;
    }

    protected function jsonRpcError($code, $title, Response $response) {

        $response->status($code, $title);

        $response->end();

        return false;
    }

}