<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2017/3/20
 * Time: 上午1:39
 */

namespace app\Misc;


use Dotenv\Loader;

class EnvStringLoader extends Loader
{

    protected $config = [];

    protected $content = "";

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function load()
    {
        $lines = explode("\n", $this->content);
        foreach ($lines as $line) {
            if (!$this->isComment($line) && $this->looksLikeSetter($line)) {
                $this->parseLine($line);
            }
        }
        return $lines;
    }

    public function getEnvironmentVariable($name)
    {

        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }
        return null;

    }

    public function parseLine($name, $value = null)
    {
        list($name, $value) = $this->normaliseEnvironmentVariable($name, $value);

        // Don't overwrite existing environment variables if we're immutable
        // Ruby's dotenv does this with `ENV[key] ||= value`.
        if ($this->immutable && $this->getEnvironmentVariable($name) !== null) {
            return;
        }
        $this->config[$name] = $value;
    }

}