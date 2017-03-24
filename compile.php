<?php 
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
class SkynetCompiler
{
  private $srcDir;
  private $compileDir;
  private $fileName;
  private $suffix;
  private $ext;
  private $filesList;
  private $filesSrc;
  
  public function __construct()
  {
    $this->srcDir = 'src';
    $this->fileName = 'skynet';
    $this->suffix = '_'.time();
    $this->ext = 'php';  
    $this->compileDir = 'compiled';
  }
  
  public function loadClasses()
  {
    $path = $this->srcDir.'/Skynet/';
    $dir = glob($path.'Skynet*.php');
    
    foreach($dir as $file)
    {
      $className = str_replace(array($path, ''), '', $file);
      $this->filesList[] = $file;
      $this->filesSrc[$className] = trim(file_get_contents($file));
    }   
  } 
  
  public function setSrcDir($srcDir)
  {
    $this->srcDir = $srcDir;
  }
  
  public function setFileName($fileName)
  {
    $this->fileName = $fileName;
  }
  
  public function setSuffix($suffix)
  {
    $this->suffix = $suffix;
  }
  
  public function setExt($ext)
  {
    $this->ext = $ext;
  }
  
  public function setCompileDir($compileDir)
  {
    $this->compileDir = $compileDir;
  }
  
  private function stripDocBlock($src)
  {
    //$src = preg_replace('!^[ \t]*/\*.*?\*/[ \t]*[\r\n]!s', '', $src);
    $src = preg_replace('#/\*[^*]*\*+([^/][^*]*\*+)*/#', '', $src); 
    $src = str_replace("\r\n", "\n", $src);    
    $src = str_replace("\n\n", "\n", $src);    
    //$src = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", '', $src);  
    
    return $src;
  }
  
  private function parseSrc($name, $src)
  {
    $eraseArray = ['<?php', '?>', 'namespace Skynet;'];
    $src = str_replace($eraseArray, '', $src); 
    $src = $this->stripDocBlock($src);
    $src = "\n\n/* ".$name." */".$src;
    return $src;
  }
  
  private function generateStandalone($src)
  {     
    $src = "<?php \n// Skynet standalone | compiled: ".date('Y.m.d H:i:s')." (".time().")\nnamespace Skynet;\n".$src."\n\$skynet = new Skynet();\n\$skynetCluster = new SkynetCluster();\n\$skynetCluster->launch();";
    return $src;
  }
  
  public function compile()
  {
    $this->loadClasses();
    $newSrc = '';
    
    foreach($this->filesSrc as $className => $classCode)
    {
      $newSrc.= $this->parseSrc($className, $classCode);       
    } 
    
    if(!empty($newSrc))
    {
      $dir = '';
      if(!empty($this->compileDir)) $dir = $this->compileDir.'/';
      $newFileName = $dir.$this->fileName.$this->suffix. '.' .$this->ext;
      if(file_put_contents($newFileName, $this->generateStandalone($newSrc))) echo 'Compiled '.count($this->filesList).' classes.<br/>Standalone Skynet is ready: '.$newFileName;      
    }
  }
}

$skynetCompiler = new SkynetCompiler;
$skynetCompiler->compile();