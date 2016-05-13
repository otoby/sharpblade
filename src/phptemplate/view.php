<?php

namespace phptemplate;

use ArrayAccess;
use BadMethodCallException;

class View implements ArrayAccess {

    /**
     * The view factory instance.
     *
     * @var \Xiaoler\Blade\Factory
     */
    protected $factory;

    /**
     * The name of the view.
     *
     * @var string
     */
    public $view;

    /**
     * The array of view data.
     *
     * @var array
     */
    public $data;

    /**
     * The path to the view file.
     *
     * @var string
     */
    public $path;
    public $_rawContent = '';

    public function __construct(Factory $factory, $name, $path, array $data = array()) {
        $this->view = $name;
        $this->path = $path;
        $this->factory = $factory;

        $this->data = $data;
    }

    /**
     * Get the string contents of the view.
     *
     * @param  callable|null  $callback
     * @return string
     */
    public function render(callable $callback = null) {

        $this->factory->renderContents($this);

        $response = isset($callback) ? call_user_func($callback, $this, $this->_rawContent) : null;

        // Once we have the contents of the view, we will flush the sections if we are
        // done rendering all views so that there is nothing left hanging over when
        // another view gets rendered in the future by the application developer.
        $this->factory->flushSectionsIfDoneRendering();

        return !is_null($response) ? $response : $this->_rawContent;
    }

    /**
     * Get the sections of the rendered view.
     *
     * @return array
     */
    public function renderSections() {
        return $this->render(function () {
                    return $this->factory->getSections();
                });
    }

    /**
     * Add a piece of data to the view.
     *
     * @param  string|array  $key
     * @param  mixed   $value
     * @return $this
     */
    public function with($key, $value = null) {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Add a view instance to the view data.
     *
     * @param  string  $key
     * @param  string  $view
     * @param  array   $data
     * @return $this
     */
    public function nest($key, $view, array $data = array()) {
        return $this->with($key, $this->factory->make($view, $data));
    }

    /**
     * Get the view factory instance.
     *
     * @return \Xiaoler\Blade\Factory
     */
    public function getFactory() {
        return $this->factory;
    }

    /**
     * Get the name of the view.
     *
     * @return string
     */
    public function name() {
        return $this->getName();
    }

    /**
     * Get the name of the view.
     *
     * @return string
     */
    public function getName() {
        return $this->view;
    }

    /**
     * Get the array of view data.
     *
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Get the path to the view file.
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set the path to the view.
     *
     * @param  string  $path
     * @return void
     */
    public function setPath($path) {
        $this->path = $path;
    }

    /**
     * Determine if a piece of data is bound.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key) {
        return array_key_exists($key, $this->data);
    }

    /**
     * Get a piece of bound data to the view.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key) {
        return $this->data[$key];
    }

    /**
     * Set a piece of data on the view.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function offsetSet($key, $value) {
        $this->with($key, $value);
    }

    /**
     * Unset a piece of data from the view.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key) {
        unset($this->data[$key]);
    }

    /**
     * Get a piece of data from the view.
     *
     * @param  string  $key
     * @return mixed
     */
    public function &__get($key) {
        return $this->data[$key];
    }

    /**
     * Set a piece of data on the view.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value) {
        $this->with($key, $value);
    }

    /**
     * Check if a piece of data is bound to the view.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key) {
        return isset($this->data[$key]);
    }

    /**
     * Remove a piece of bound data from the view.
     *
     * @param  string  $key
     * @return bool
     */
    public function __unset($key) {
        unset($this->data[$key]);
    }

    /**
     * Dynamically bind parameters to the view.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Xiaoler\Blade\View
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters) {
        if (strpos($method, 'with') === 0) {
            $value = substr($method, 4);

            if (!ctype_lower($value)) {
                $value = preg_replace('/\s+/', '', $value);
                $value = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1' . '_', $value));
            }

            return $this->with($value, $parameters[0]);
        }

        throw new BadMethodCallException("Method [$method] does not exist on view.");
    }

    /**
     * Get the string contents of the view.
     *
     * @return string
     */
    public function __toString() {
        return $this->render();
    }

}
