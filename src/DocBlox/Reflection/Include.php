<?php
/**
 * DocBlox
 *
 * @category   DocBlox
 * @package    Static_Reflection
 * @copyright  Copyright (c) 2010-2011 Mike van Riel / Naenius. (http://www.naenius.com)
 */

/**
 * Provides the basic functionality for every static reflection class.
 *
 * @category   DocBlox
 * @package    Static_Reflection
 * @author     Mike van Riel <mike.vanriel@naenius.com>
 */
class DocBlox_Reflection_Include extends DocBlox_Reflection_Abstract
{
  /** @var string Which type of include is this? Include, Include Once, Require or Require Once? */
  protected $type = '';

  /**
   * Get the type and name for this include.
   *
   * @param DocBlox_Token_Iterator $tokens
   *
   * @return void
   */
  protected function processGenericInformation(DocBlox_Token_Iterator $tokens)
  {
    $this->type = ucwords(strtolower(str_replace('_', ' ', substr($tokens->current()->getName(), 2))));

    if ($token = $tokens->gotoNextByType(T_CONSTANT_ENCAPSED_STRING, 10, array(';')))
    {
      $this->setName(trim($token->getContent(), '\'"'));
    }
    elseif ($token = $tokens->gotoNextByType(T_VARIABLE, 10, array(';')))
    {
      $this->setName(trim($token->getContent(), '\'"'));
    }
  }

  /**
   * Returns the type of this include.
   *
   * Valid types are:
   * - Include
   * - Include Once
   * - Require
   * - Require Once
   *
   * @return string
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * Generates a DocBlox compatible XML output for this object.
   *
   * @return string
   */
  public function __toXml()
  {
    $xml = new SimpleXMLElement('<include></include>');
    $xml->name         = $this->getName();
    $xml['type']       = $this->getType();
    $xml['line']       = $this->getLineNumber();

    return $xml->asXML();
  }

  /**
   * Returns the name for this object.
   *
   * @return string
   */
  public function __toString()
  {
    return $this->getName();
  }
}