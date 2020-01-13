<?php

namespace Site\Application;


use Phalcon\Mvc\Micro;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

class MicroSwooleApplication extends Micro {

    protected $allowedFiles = [
        'css' => 'text/css',
        'js' => 'text/javascript',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpg',
        'mp4' => 'video/mp4'
    ];

    protected $server;

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

        $uri = $request->server['request_uri'];

        // Check static files

        if (is_file(PUBLIC_PATH . $uri)) {
            $type = pathinfo(PUBLIC_PATH . $uri, PATHINFO_EXTENSION);

            if (!isset($this->allowedFiles[$type])) {
                return false;
            }

            $response->header('Content-Type', $this->allowedFiles[$type]);
            $response->sendfile(PUBLIC_PATH . $uri);

            return true;
        }

        $this->response = new \Phalcon\Http\Response();

        $this->header = $request->header;

        // Convert Swoole HTTP request to regular PHP request
        foreach ($request->server as $key => $value) {
            $_SERVER[strtoupper($key)] = $value;
        }
        $_GET = $request->get;
        $_POST = $request->post;
        $_COOKIE = $request->cookie;
        $_FILES = $request->files;
        $_REQUEST = array_merge(
            (array)$request->get,
            (array)$request->post,
            (array)$request->cookie
        );

        $result = $this->handle($uri);

        $response->status($this->response->getStatusCode(), $this->response->getReasonPhrase());

        $response->end($result);

        return true;
    }

    public function start() {

        $this->server->start();

    }

}