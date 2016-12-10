<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2016/12/11
 * Time: 上午12:40
 */

namespace App\Misc;


use Dotenv\Loader;

class EnvHelper extends Loader
{

    protected $config = [];

    public function getConfig(){
        return $this->config;
    }
    public function load()
    {
        $this->ensureFileIsReadable();
        $filePath = $this->filePath;
        $lines = $this->readLinesFromFile($filePath);
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