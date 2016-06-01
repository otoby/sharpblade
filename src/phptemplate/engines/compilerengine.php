<?php

namespace phptemplate\engines;

use ErrorException;
use phptemplate\compilers\CompilerInterface;

class CompilerEngine implements EngineInterface {

    /**
     * The Blade compiler instance.
     *
     * @var \Xiaoler\Blade\Compilers\CompilerInterface
     */
    protected $compiler;

    /**
     * A stack of the last compiled templates.
     *
     * @var array
     */
    protected $lastCompiled = array();

    /**
     * Create a new Blade view engine instance.
     *
     * @param  \Xiaoler\Blade\Compilers\CompilerInterface  $compiler
     * @return void
     */
    public function __construct(CompilerInterface $compiler) {
        $this->compiler = $compiler;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = array()) {
        $this->lastCompiled[] = $path;

        // If this given view has expired, which means it has simply been edited since
        // it was last compiled, we will re-compile the views so we can evaluate a
        // fresh copy of the view. We'll pass the compiler the path of the view.
        if (!$this->compiler->options['COMPILE_CACHE'] || $this->compiler->isExpired($path)) {
            $this->compiler->compile($path);
        }

        $compiled = $this->compiler->getCompiledPath($path);

        // Once we have the path to the compiled file, we will evaluate the paths with
        // typical PHP just like any other templates. We also keep a stack of views
        // which have been rendered for right exception messages to be generated.
        $results = $this->evaluatePath($compiled, $data);

        array_pop($this->lastCompiled);

        return $results;
    }

    /**
     * Handle a view exception.
     *
     * @param  \Exception  $e
     * @param  int  $obLevel
     * @return void
     *
     * @throws $e
     */
    protected function handleViewException($e, $obLevel) {
        $exc = new ErrorException($this->getMessage($e), 0, 1, $e->getFile(), $e->getLine(), $e);

        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }

        throw $exc;
    }

    /**
     * Get the exception message for an exception.
     *
     * @param  \Exception  $exc
     * @return string
     */
    protected function getMessage($exc) {
        return $exc->getMessage() . ' (View: ' . realpath(last($this->lastCompiled)) . ')';
    }

    /**
     * Get the compiler implementation.
     *
     * @return \Xiaoler\Blade\Compilers\CompilerInterface
     */
    public function getCompiler() {
        return $this->compiler;
    }

    /**
     * Get the evaluated contents of the view at the given path.
     *
     * @param  string  $__path
     * @param  array   $__data
     * @return string
     */
    protected function evaluatePath($__path, $__data) {
        $obLevel = ob_get_level();

        ob_start();

        extract($__data);

        // We'll evaluate the contents of the view inside a try/catch block so we can
        // flush out any stray output that might get out before an error occurs or
        // an exception is thrown. This prevents any partial views from leaking.
        try {
            include $__path;
        } catch (Exception $e) {
            $this->handleViewException($e, $obLevel);
        }

        return ltrim(ob_get_clean());
    }

}
