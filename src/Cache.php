<?php
namespace App; 

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Cache
{
    private static $instance = null;

    private $storage = null;

    private $filePath;
    private $filesystem;

    private function __construct() {
        $this->filePath = dirname(__DIR__) . '/data/cache.json';
        $this->filesystem = new Filesystem();
        $this->loadCache();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function set(string $key, mixed $value): void
    {
        self::getInstance()->storage[$key] = $value;
        self::getInstance()->saveCache();
    }

    public static function get(string $key): mixed
    {
        $instance = self::getInstance();
        $instance->loadCache();
        
        return $instance->storage[$key] ?? null;
    }

    private function loadCache(): void
    {
        if ($this->filesystem->exists($this->filePath)) {
            $this->storage = json_decode(file_get_contents($this->filePath), true);
            return;
        }

        $defaultValues = [
            'stepSize' => 10, 
            'outputFilePath' => dirname(realpath(__DIR__), 2) . '/output/' . Cache::get('targetFile') ?? 'output.png',
        ];
        dump('hi');
        $this->storage = $defaultValues;
        $this->saveCache();

    }

    private function saveCache(): void
    {
        try {
            $this->filesystem->dumpFile($this->filePath, json_encode($this->storage));
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while writing to the cache file at " . $exception->getPath();
        }
    }

    public static function dump(): void
    {
        $instance = self::getInstance();
        // $instance->loadCache();
        dump($instance);
    }
}