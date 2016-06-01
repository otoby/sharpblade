<?php

namespace phptemplate\compilers;

abstract class Compiler extends CompilerConfiguration {

    public function __construct(array $configuration = null) {

        if (isset($configuration)) {
            $this->configuration = $configuration + $this->configuration;
        }

        if (!$this->configuration['COMPILE_CACHE']) {
            $tempnam = tempnam(sys_get_temp_dir(), 'TEM');
            $this->configuration['CACHE_PATH'] = $tempnam;

            register_shutdown_function(function() use ($tempnam) {
                unlink($tempnam);
            });
        } elseif ($this->configuration['CACHE_PATH'] == '') {
            $this->configuration['CACHE_PATH'] = dirname(__FILE__);
        }
    }

    /**
     * Get the path to the compiled version of a view.
     *
     * @param  string  $path
     * @return string
     */
    public function getCompiledPath($path) {
        if ($this->configuration['COMPILE_CACHE']) {
            return $this->configuration['CACHE_PATH'] . '/' . md5($path);
        }

        return $this->configuration['CACHE_PATH'];
    }

    /**
     * Determine if the view at the given path is expired.
     *
     * @param  string  $path
     * @return bool
     */
    public function isExpired($path) {
        $compiled = $this->getCompiledPath($path);

        // If the compiled file doesn't exist we will indicate that the view is expired
        // so that it can be re-compiled. Else, we will verify the last modification
        // of the views is less than the modification times of the compiled views.
        if (!file_exists($compiled)) {
            return true;
        }

        return filemtime($path) >= filemtime($compiled);
    }

}
