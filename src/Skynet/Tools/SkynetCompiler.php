<?php 

/**
 * Skynet/Tools/SkynetCompiler.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */
 
 namespace Skynet\Tools;

 /**
  * Standalone version compiler
  */   
class SkynetCompiler
{
  /** @var string Sources root dir */
  private $srcDir = 'src';
  
  /** @var string Output dir */
  private $compileDir = '_compiled';
  
  /** @var string Output file name */
  private $fileName = 'skynet';
  
  /** @var string Suffix for output file */
  private $suffix;
  
  /** @var string Output file extension */
  private $ext = 'php';
  
  /** @var string[] Sources list */
  private $sourcesList = [];
  
  /** @var string[] Sources content */
  private $sourcesFiles = [];
  
  /** @var string[] Sources paths */
  private $paths = [];
  
  /** @var string[] Elements to remove */
  private $replaceWith = [];
  
  /** @var bool Sets removing comments */
  private $removeComments = false;
  
  /** @var string New line in generated file */
  private $nl1 = "\r\n";
  
  /** @var string New line in status */
  private $nl2 = "<br>";

 /**
  * Constructor
  */  
  public function __construct()
  {
    $this->suffix = '_'.time();
  }

 /**
  * Resursively loads source files list
  *
  * @param string $folder Directory to get file list
  * @param string $pattern Pattern
  *
  * @return string[] Files list
  */  
  private function rsearch($folder, $pattern) 
  {
    $dir = new \RecursiveDirectoryIterator($folder);
    $ite = new \RecursiveIteratorIterator($dir);
    $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
    $fileList = array();
    foreach($files as $file) 
    {
        $fileList = array_merge($fileList, $file);
    }   
    return $fileList;
  }

 /**
  * Loads source files content
  */   
  private function loadClasses()
  {
    $path1 = $this->srcDir.'/SkynetUser/';
    $dir1 = $this->rsearch($path1, '/.*.php/');  
    
    $path2 = $this->srcDir.'/Skynet/';
    $dir2 = $this->rsearch($path2, '/.*.php/');   
    
    $dir = array_merge($dir1, $dir2);
    
    $srcClasses = [];
    $srcAbstract = [];
    $srcInterface = [];
    $srcTrait = [];   
    $srcConfig = [];
    
    $configClass = null;
    foreach($dir as $file)
    {
      $this->paths[] = $file;
      $className = str_replace(array($path1, $path2), '', $file);
      $this->sourcesList[] = $file;
      
      if(strpos($className, 'Abstract.php') !== false)
      {
        $srcAbstract[$className] = trim(file_get_contents($file));
      } elseif(strpos($className, 'Interface.php') !== false)
      {
        $srcInterface[$className] = trim(file_get_contents($file));
      } elseif(strpos($className, 'Trait.php') !== false)
      {
        $srcTraits[$className] = trim(file_get_contents($file));
      } elseif(strpos($className, 'Config.php') !== false)
      {
        $srcConfig[$className] = trim(file_get_contents($file));
      } else {
        $srcClasses[$className] = trim(file_get_contents($file));
      }      
    } 
    
    $this->sourcesFiles = array_merge($srcConfig, $srcAbstract, $srcInterface, $srcTraits, $srcClasses);
  } 
 
 /**
  * Generates array with directives to replace
  */   
  public function generateReplace()
  {
    $files = [];
    $files[] = 'Skynet';
    $files[] = 'SkynetUser';
    
    $replaceUse = [];
    $replaceNamespace = [];
    $replacePrefix = [];
    
    foreach($this->paths as $file)
    {
      $files[] = str_replace(array('src/', '.php', '/'), array('', '', '\\'), $file);      
    }
    
    foreach($files as $file)
    {
      $replaceUse[] = 'use '.$file.';';
      
      $namespace = 'namespace '.pathinfo($file, PATHINFO_DIRNAME).';';
      if(!in_array($namespace,  $replaceNamespace)) 
      {
        $replaceNamespace[] = $namespace;
      }
      $ns = pathinfo($file, PATHINFO_DIRNAME);
      if($ns != '.' && !in_array($ns.'\\', $replacePrefix))
      {
        $replacePrefix[] = '\\'.$ns.'\\';      
        $replacePrefix[] = $ns.'\\';         
      }
    }
    
    $this->replaceWith = array_merge($replaceUse, $replaceNamespace, $replacePrefix);
  }

 /**
  * Sets sources dir
  *
  * @param string $srcDir Sources root dir
  */    
  public function setSrcDir($srcDir)
  {
    $this->srcDir = $srcDir;
  }

 /**
  * Sets new line char in compiled file
  *
  * @param string $char New line
  */    
  public function setNl1($char)
  {
    $this->nl1 = $char;
  }  
 
 /**
  * Sets new line char in status output
  *
  * @param string $char New line
  */    
  public function setNl2($char)
  {
    $this->nl2 = $char;
  }
  
 /**
  * Sets output file name
  *
  * @param string $fileName Output compiled file name
  */    
  public function setFileName($fileName = 'skynet')
  {
    $this->fileName = $fileName;
  }
 
 /**
  * Sets suffix for output file
  *
  * @param string $suffix Suffix
  */   
  public function setSuffix($suffix)
  {
    $this->suffix = $suffix;
  }

 /**
  * Sets extension for output file
  *
  * @param string $ext Extension for file
  */    
  public function setExt($ext = 'php')
  {
    $this->ext = $ext;
  }
 
 /**
  * Sets destination dir for compile
  *
  * @param string $compileDir Output dir
  */   
  public function setCompileDir($compileDir = '_compiled')
  {
    $this->compileDir = $compileDir;
  }

 /**
  * Strips new lines
  *
  * @param string $src Source string
  *
  * @return string Parsed string
  */    
  private function stripNewLines($src)
  {
    $src = str_replace("\r\n", "\n", $src);
    $src = str_replace("\n\n\n", "\n", $src);    
    $src = str_replace("\n\n", "\n", $src);      
    return $src;
  }
  
 /**
  * Strips DOCBLOCK comments
  *
  * @param string $src Source string
  *
  * @return string Parsed string
  */   
  private function stripDocBlock($src)
  {   
    $src = preg_replace('#/\*[^*]*\*+([^/][^*]*\*+)*/#', '', $src);     
    return $src;
  }

 /**
  * Parse and replace code
  *
  * @param string $name Class name
  * @param string $src Source 
  *
  * @return string Parsed string
  */    
  private function parseSrc($name, $src)
  {
    $eraseArray = ['<?php', '?>'];
    $src = str_replace($this->replaceWith, '', $src);
    $src = str_replace($eraseArray, '', $src); 
    $src = str_replace('\\SkynetUser\\', '', $src);
    $src = str_replace('\\Skynet\\', '', $src);
    
    $src = preg_replace('/(\r?\n){2,}/', "\n\n", $src);
    
    if($this->removeComments) 
    {
      $src = $this->stripDocBlock($src);
      $src = $this->stripNewLines($src);
      $src = $this->nl1."/* ".$name." */".$src;
    }
    return $src;
  }
 
 /**
  * Generates compiled file body
  *
  * @param string $src Source string
  *
  * @return string Parsed string
  */   
  private function generateStandalone($src)
  {     
    $header = "<?php ".$this->nl1.$this->nl1."/* Skynet Standalone | version compiled: ".date('Y.m.d H:i:s')." (".time().") */".$this->nl1.$this->nl1."namespace Skynet;".$this->nl1;
    $code = $this->nl1."\$skynet = new SkynetLauncher(true, true);".$this->nl1."echo \$skynet;";
    $src = $header.$src.$code;
    return $src;
  }

 /**
  * Compiles standalone
  *
  * @param string $mode HTML or CLI
  *
  * @return string Status
  */    
  public function compile($mode = 'html')
  {
    if($mode == 'cli')
    {
      $this->setNl2("\n");
    }
    
    $this->loadClasses();    
    $this->generateReplace();
    
    $compiledSource = '';    
    $i = 1;         
    
    foreach($this->sourcesFiles as $className => $classCode)
    {
      $compiledSource.= $this->parseSrc($className, $classCode);    
      echo $i.') Compiling: '.$className.$this->nl2;
      $i++;
    } 
    
    if(!empty($compiledSource))
    {
      $dir = '';
      if(!empty($this->compileDir)) 
      {
        $dir = $this->compileDir.'/';
      }
      
      if(!is_dir($dir))
      {
        if(!mkdir($dir))
        {
          return false;
        }
      }
      
      $newFileName = $dir.$this->fileName.$this->suffix. '.' .$this->ext;
      if(file_put_contents($newFileName, $this->generateStandalone($compiledSource))) 
      {
        return 'Compiled '.count($this->sourcesList).' classes.'.$this->nl2.'Standalone Skynet is ready: '.$newFileName;          
      }        
    }
  }
}