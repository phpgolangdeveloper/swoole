<?php


class Ws{

    const HOST = '0.0.0.0';
    const PORT = 8812;
    public $ws = null;
    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server("0.0.0.0", 8812);
        $this->ws->on('open',[$this,'onOpen']);
        $this->ws->on('message',[$this,'onMessage']);
        $this->ws->on('close',[$this,'onClose']);
        $this->ws->start();
    }
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);
    }
    public function onMessage($ws, $frame)
    {
        echo 'ser-push-message:'. $frame->data;
        $ws->push($frame->fd,'server-push:'.date('Y-M-D H:i:s'));
    }
    public function onClose($ws, $fd) {
        echo 'clientid:'. $fd.'\n';
    }
}

$obj = new Ws();