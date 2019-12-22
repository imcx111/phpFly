<?php

/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Document
 * @author     James.Huang <shagoo@gmail.com>
 * @version    $Id$
 */

namespace utils;

use utils\Document\DocumentParser;

/** root directory */
//if (!defined('PHPEXCEL_ROOT')) {
//    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/');
//    require_once(PHPEXCEL_ROOT . 'Document/Parser.php');
//}

/**
 * @package Hush_Document
 */
class Document {

    /**
     * @var Hush_Document_Parser 
     */
    protected $_parser = null;

    /**
     * Construct
     * @param Hush_Debug_Writer $writer
     */
    public function __construct($classFile, $parser = 'PhpDoc') {
        if (!file_exists($classFile)) {
            exit("Non-exists class file '$classFile'.");
        }

        $this->_parser = DocumentParser::factory($parser);
        $this->_parser->parseCode($classFile);
    }

    /**
     * Get annotations
     * @param $classFile ClassName you want
     * @param $methodName MethodName you want
     * @return array
     */
    public function getAnnotation($className = '', $methodName = '') {
        return $this->_parser->getAnnotation($className, $methodName);
    }

}
