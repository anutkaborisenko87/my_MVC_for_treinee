<?php

namespace OptimMVC\Core;

class Response {

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var int|mixed
     */
    protected $status;

    /**
     * @var array|mixed
     */
    protected $headers;

    public function __construct(string $content, $status = 200, $headers = array()) {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * @param $content
     * @return void
     */
    public function set_content($content) {
        $this->content = $content;
    }

    /**
     * @param $status
     * @return void
     */
    public function set_status($status) {
        $this->status = $status;
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function set_header($name, $value) {
        $this->headers[$name] = $value;
    }

    /**
     * @return void
     */
    public function send()
    {
        http_response_code($this->status);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        echo $this->content;
    }

    /**
     * @param array $data
     * @param int $status
     * @return Response
     */
    public function json(array $data, int $status = 200): Response
    {
        $this->status = $status;
        $this->content = json_encode($data);
        $this->send();
        return $this;
    }
}
