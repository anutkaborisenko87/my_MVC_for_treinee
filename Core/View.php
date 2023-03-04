<?php

namespace OptimMVC\Core;

class View
{
    private $root = ROOT;
    protected $layout = 'app';

    public function render($view, $data = [])
    {
        $layout = $this->getLayout();
        $content = $this->getContent($view, $data);
        $output = str_replace('{{ content }}', $content, $layout);

        echo $output;
    }

    public function getContent($view, $data = [])
    {
        extract($data);
        ob_start();
            if (file_exists(ROOT . '/resources/views/' . $view . '.php')) {
                require_once ROOT . '/resources/views/' . $view . '.php';
            }
        return ob_get_clean();
    }

    public function getLayout()
    {
        ob_start();

        require_once ROOT . '/resources/layouts/' . $this->layout . '.php';

        return ob_get_clean();
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}