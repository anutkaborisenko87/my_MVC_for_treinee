<?php

namespace OptimMVC\Core;

class View
{
    /**
     * @var string
     */
    protected $layout = 'app';

    /**
     * @param $view
     * @param $data
     * @return $this
     */
    public function render($view, $data = []): View
    {
        $layout = $this->getLayout($data);
        $content = $this->getContent($view, $data);
        $output = str_replace('{{ content }}', $content, $layout);
        echo $output;
        return $this;
    }

    /**
     * @param $view
     * @param array $data
     * @return false|string
     */
    public function getContent($view, array $data = [])
    {
        extract($data);
        ob_start();
        if (file_exists(ROOT . '/resources/views/' . $view . '.php')) {
            require_once ROOT . '/resources/views/' . $view . '.php';
        }
        return ob_get_clean();
    }

    /**
     * @param array $data
     * @return false|string
     */
    public function getLayout(array $data = [])
    {
        extract($data);
        ob_start();

        if (file_exists(ROOT . '/resources/layouts/' . $this->layout . '.php')) {
            require_once ROOT . '/resources/layouts/' . $this->layout . '.php';
        }

        return ob_get_clean();
    }

    /**
     * @param $layout
     * @return void
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}