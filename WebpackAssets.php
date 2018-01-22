<?php
  // namespace CIC\WebpackAssets\Plugin;

  /**
    * Class WebpackAssets
    * @package CIC\WebpackAssets\Plugin
  */

  class WebpackAssets {
    // Class defaults
    protected $assetDir = '/build/';
    protected $fileName = 'assets-manifest';
    protected $phpClassName = 'WebpackBuiltFiles';

    public function __construct($options) {
      $this->assetDir = get_template_directory().$this->assetDir;
      $this->assetDir = array_key_exists('dir', $options) ?
        $options['dir'] : $this->assetDir;
      $this->fileName = array_key_exists('fileName', $options) ?
        $options['fileName'] : $this->fileName;
      $this->phpClassName = array_key_exists('phpClassName', $options) ?
        $options['phpClassName'] : $this->phpClassName;
    }

    protected function assetManifestPath() {
      // Append subdir, even if it's a blank string
      // This is deprecated.
      // $path = $this->assetDir.$this->subDir;
      // Conditionally append a slash if the user didn't provide one in their subdir
      // $path = (substr($path, -1) == '/') ? $path : $path.'/';

      return $this->assetDir.$this->fileName.'.php';
    }

    protected function loadAssetsManifest() {
      require_once($this->assetManifestPath());
    }

    protected function getAssets($type) {
      $manifestClass = $this->phpClassName;

      // Require assets manifest once before outputting assets
      $this->loadAssetsManifest();
      // Check for php classname in document and return the stuff!
      if(!class_exists($manifestClass)) {
        throw new Exception('Could not load class ' . $manifestClass . ' from asset manifest file ' .
          $this->assetManifestPath());
      }

      $assetListVar = $type.'Files';
      return $manifestClass::$$assetListVar;
    }

    protected function css($files) {
      return implode("\n", array_map(function ($file) {
        return '<link rel="stylesheet" href="'.$file.'">';
      }, $files));
    }

    protected function js($files) {
      return implode("\n", array_map(function ($file) {
        return '<script src="'.$file.'"></script>';
      }, $files));
    }

    public function outputAssets($type) {
      $files = $this->getAssets($type);
      return $this->$type($files);
    }
  }
