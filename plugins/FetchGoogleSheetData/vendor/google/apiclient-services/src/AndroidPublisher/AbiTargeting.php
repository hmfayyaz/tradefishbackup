<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\AndroidPublisher;

class AbiTargeting extends \Google\Collection
{
  protected $collection_key = 'value';
  /**
   * @var Abi[]
   */
  public $alternatives;
  protected $alternativesType = Abi::class;
  protected $alternativesDataType = 'array';
  /**
   * @var Abi[]
   */
  public $value;
  protected $valueType = Abi::class;
  protected $valueDataType = 'array';

  /**
   * @param Abi[]
   */
  public function setAlternatives($alternatives)
  {
    $this->alternatives = $alternatives;
  }
  /**
   * @return Abi[]
   */
  public function getAlternatives()
  {
    return $this->alternatives;
  }
  /**
   * @param Abi[]
   */
  public function setValue($value)
  {
    $this->value = $value;
  }
  /**
   * @return Abi[]
   */
  public function getValue()
  {
    return $this->value;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AbiTargeting::class, 'Google_Service_AndroidPublisher_AbiTargeting');
