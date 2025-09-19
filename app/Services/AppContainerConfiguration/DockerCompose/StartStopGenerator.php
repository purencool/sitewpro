<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use App\Services\AppDirectoryStructure\HostingEnvironment;

/**
 * Class StartGenerator
 *
 * This class generates proxy configuration for multiple server names.
 *
 * @package App\Services\StartGenerator
 */
class StartStopGenerator
{
    /**
     * array $pathAndFileNames 
     */
    private $pathAndFileNames = [];

    /**
     * Creat start configuration body.
     * 
     * @return string
     */
    private function pathAndFiles()
    {
        $lines = array_map(function($x) {
            return ' -f "$1/' . $x . '" \\';
        }, $this->pathAndFileNames);

        return implode(PHP_EOL, $lines);
    }

    /**
     * Generates the Start configuration array for each server name in the array.
     *
     * @return array
     */
    private function startConfiguration()
    {
        $generated = $this->pathAndFiles();

$config = <<<EOT
#!/bin/bash
docker compose \
$generated
 up -d
EOT;
        $filePath = (new HostingEnvironment())->getContainersDirectoryPath(); 
        (new HostingEnvironment())->updateContainerFiles('','start.sh', $config);
    }

     /**
     * Generates the Stop configuration array for each server name in the array.
     *
     * @return array
     */
    private function stopConfiguration()
    {
        $generated = $this->pathAndFiles();
$config = <<<EOT
#!/bin/bash
docker compose \
$generated
down
EOT;
        $filePath = (new HostingEnvironment())->getContainersDirectoryPath(); 
        (new HostingEnvironment())->updateContainerFiles('','stop.sh', $config);
    }

    /**
     * Generates the Start configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateStartStopConfiguration(): array
    {
        $this->startConfiguration();
        $this->stopConfiguration();
        return ["Built start and stop scripts."];
    }

    /**
     * 
     */
    public function setPathAndFileNames(string $pathAndFileName)
    {
       $this->pathAndFileNames[] = $pathAndFileName; 
    }

    /**
     * 
     */
    public function getPathAndFileNames() : array 
    {
       return $this->pathAndFileNames;
    }
}
