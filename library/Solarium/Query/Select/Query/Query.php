<?php
/**
 * Copyright 2011 Bas de Nooijer. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this listof conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDER AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * The views and conclusions contained in the software and documentation are
 * those of the authors and should not be interpreted as representing official
 * policies, either expressed or implied, of the copyright holder.
 *
 * @copyright Copyright 2011 Bas de Nooijer <solarium@raspberry.nl>
 * @license http://github.com/basdenooijer/solarium/raw/master/COPYING
 * @link http://www.solarium-project.org/
 *
 * @package Solarium
 * @subpackage QueryType
 */

/**
 * @namespace
 */
namespace Solarium\Query\Select\Query;
use Solarium\Core\Exception;
use Solarium\Core\Client\Client;
use Solarium\Core\Query\Query as BaseQuery;
use Solarium\Query\Select\RequestBuilder\RequestBuilder;
use Solarium\Query\Select\ResponseParser\ResponseParser;

/**
 * Select Query
 *
 * Can be used to select documents and/or facets from Solr. This querytype has
 * lots of options and there are many Solarium subclasses for it.
 * See the Solr documentation and the relevant Solarium classes for more info.
 *
 * @package Solarium
 * @subpackage Query
 */
class Query extends BaseQuery
{

    /**
     * Solr sort mode descending
     */
    const SORT_DESC = 'desc';

    /**
     * Solr sort mode ascending
     */
    const SORT_ASC = 'asc';

    /**
     * Solr query operator AND
     */
    const QUERY_OPERATOR_AND = 'AND';

    /**
     * Solr query operator OR
     */
    const QUERY_OPERATOR_OR = 'OR';

    /**
     * Query component facetset
     */
    const COMPONENT_FACETSET = 'facetset';

    /**
     * Query component dismax
     */
    const COMPONENT_DISMAX = 'dismax';

    /**
     * Query component morelikethis
     */
    const COMPONENT_MORELIKETHIS = 'morelikethis';

    /**
     * Query component highlighting
     */
    const COMPONENT_HIGHLIGHTING = 'highlighting';

    /**
     * Query component spellcheck
     */
    const COMPONENT_SPELLCHECK = 'spellcheck';

    /**
     * Query component grouping
     */
    const COMPONENT_GROUPING = 'grouping';

    /**
     * Query component distributed search
     */
    const COMPONENT_DISTRIBUTEDSEARCH = 'distributedsearch';

    /**
     * Query component stats
     */
    const COMPONENT_STATS = 'stats';

    /**
     * Query component debug
     */
    const COMPONENT_DEBUG = 'debug';

    /**
     * Get type for this query
     *
     * @return string
     */
    public function getType()
    {
        return Client::QUERY_SELECT;
    }

    /**
     * Get a requestbuilder for this query
     *
     * @return RequestBuilder
     */
    public function getRequestBuilder()
    {
        return new RequestBuilder;
    }

    /**
     * Get a response parser for this query
     *
     * @return ResponseParser
     */
    public function getResponseParser()
    {
        return new ResponseParser;
    }

    /**
     * Default options
     *
     * @var array
     */
    protected $options = array(
        'handler'       => 'select',
        'resultclass'   => 'Solarium\Query\Select\Result\Result',
        'documentclass' => 'Solarium\Query\Select\Result\Document',
        'query'         => '*:*',
        'start'         => 0,
        'rows'          => 10,
        'fields'        => '*,score',
    );

    /**
     * Default select query component types
     *
     * @var array
     */
    protected $componentTypes = array(
        self::COMPONENT_FACETSET => array(
            'component' => 'Solarium\Query\Select\Query\Component\FacetSet',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\FacetSet',
            'responseparser' => 'Solarium\Query\Select\ResponseParser\Component\FacetSet',
        ),
        self::COMPONENT_DISMAX => array(
            'component' => 'Solarium\Query\Select\Query\Component\DisMax',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\DisMax',
            'responseparser' => null,
        ),
        self::COMPONENT_MORELIKETHIS => array(
            'component' => 'Solarium\Query\Select\Query\Component\MoreLikeThis',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\MoreLikeThis',
            'responseparser' => 'Solarium\Query\Select\ResponseParser\Component\MoreLikeThis',
        ),
        self::COMPONENT_HIGHLIGHTING => array(
            'component' => 'Solarium\Query\Select\Query\Component\Highlighting\Highlighting',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\Highlighting',
            'responseparser' => 'Solarium\Query\Select\ResponseParser\Component\Highlighting',
        ),
        self::COMPONENT_GROUPING => array(
            'component' => 'Solarium\Query\Select\Query\Component\Grouping',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\Grouping',
            'responseparser' => 'Solarium\Query\Select\ResponseParser\Component\Grouping',
        ),
        self::COMPONENT_SPELLCHECK => array(
            'component' => 'Solarium\Query\Select\Query\Component\Spellcheck',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\Spellcheck',
            'responseparser' => 'Solarium\Query\Select\ResponseParser\Component\Spellcheck',
        ),
        self::COMPONENT_DISTRIBUTEDSEARCH => array(
            'component' => 'Solarium\Query\Select\Query\Component\DistributedSearch',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\DistributedSearch',
            'responseparser' => null,
        ),
        self::COMPONENT_STATS => array(
            'component' => 'Solarium\Query\Select\Query\Component\Stats\Stats',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\Stats',
            'responseparser' => 'Solarium\Query\Select\ResponseParser\Component\Stats',
        ),
        self::COMPONENT_DEBUG => array(
            'component' => 'Solarium\Query\Select\Query\Component\Debug',
            'requestbuilder' => 'Solarium\Query\Select\RequestBuilder\Component\Debug',
            'responseparser' => 'Solarium\Query\Select\ResponseParser\Component\Debug',
        ),
    );

    /**
     * Fields to fetch
     *
     * @var array
     */
    protected $fields = array();

    /**
     * Items to sort on
     *
     * @var array
     */
    protected $sorts = array();

    /**
     * Filterqueries
     *
     * @var array
     */
    protected $filterQueries = array();

    /**
     * Search components
     *
     * @var array
     */
    protected $components = array();

    /**
     * Initialize options
     *
     * Several options need some extra checks or setup work, for these options
     * the setters are called.
     *
     * @return void
     */
    protected function init()
    {
        foreach ($this->options AS $name => $value) {
            switch ($name) {
                case 'query':
                    $this->setQuery($value);
                    break;
                case 'filterquery':
                    $this->addFilterQueries($value);
                    break;
                case 'sort':
                    $this->addSorts($value);
                    break;
                case 'fields':
                    $this->addFields($value);
                    break;
                case 'rows':
                    $this->setRows((int)$value);
                    break;
                case 'start':
                    $this->setStart((int)$value);
                    break;
                case 'component':
                    $this->createComponents($value);
                    break;
            }
        }
    }

    /**
     * Set the query string
     *
     * Overwrites the current value. You are responsible for the correct
     * escaping of user input.
     *
     * @param string $query
     * @param array $bind Bind values for placeholders in the query string
     * @return self Provides fluent interface
     */
    public function setQuery($query, $bind = null)
    {
        if (!is_null($bind)) {
            $query = $this->getHelper()->assemble($query, $bind);
        }

        return $this->setOption('query', trim($query));
    }

    /**
     * Get the query string
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->getOption('query');
    }

    /**
     * Set default query operator
     *
     * Use one of the constants as value
     *
     * @param string $operator
     * @return self Provides fluent interface
     */
    public function setQueryDefaultOperator($operator)
    {
        return $this->setOption('querydefaultoperator', $operator);
    }

    /**
     * Get the default query operator
     *
     * @return null|string
     */
    public function getQueryDefaultOperator()
    {
        return $this->getOption('querydefaultoperator');
    }

    /**
     * Set default query field
     *
     * @param string $field
     * @return self Provides fluent interface
     */
    public function setQueryDefaultField($field)
    {
        return $this->setOption('querydefaultfield', $field);
    }

    /**
     * Get the default query field
     *
     * @return null|string
     */
    public function getQueryDefaultField()
    {
        return $this->getOption('querydefaultfield');
    }

    /**
     * Set the start offset
     *
     * @param integer $start
     * @return self Provides fluent interface
     */
    public function setStart($start)
    {
        return $this->setOption('start', $start);
    }

    /**
     * Get the start offset
     *
     * @return integer
     */
    public function getStart()
    {
        return $this->getOption('start');
    }

    /**
     * Set a custom resultclass
     *
     * @param string $value classname
     * @return self Provides fluent interface
     */
    public function setResultClass($value)
    {
        return $this->setOption('resultclass', $value);
    }

    /**
     * Get the current resultclass option
     *
     * The value is a classname, not an instance
     *
     * @return string
     */
    public function getResultClass()
    {
        return $this->getOption('resultclass');
    }

    /**
     * Set a custom document class
     *
     * @param string $value classname
     * @return self Provides fluent interface
     */
    public function setDocumentClass($value)
    {
        return $this->setOption('documentclass', $value);
    }

    /**
     * Get the current documentclass option
     *
     * The value is a classname, not an instance
     *
     * @return string
     */
    public function getDocumentClass()
    {
        return $this->getOption('documentclass');
    }

    /**
     * Set the number of rows to fetch
     *
     * @param integer $rows
     * @return self Provides fluent interface
     */
    public function setRows($rows)
    {
        return $this->setOption('rows', $rows);
    }

    /**
     * Get the number of rows
     *
     * @return integer
     */
    public function getRows()
    {
        return $this->getOption('rows');
    }

    /**
     * Specify a field to return in the resultset
     *
     * @param string $field
     * @return self Provides fluent interface
     */
    public function addField($field)
    {
       $this->fields[$field] = true;
       return $this;
    }

    /**
     * Specify multiple fields to return in the resultset
     *
     * @param string|array $fields can be an array or string with comma
     * separated fieldnames
     *
     * @return self Provides fluent interface
     */
    public function addFields($fields)
    {
        if (is_string($fields)) {
            $fields = explode(',', $fields);
            $fields = array_map('trim', $fields);
        }

        foreach ($fields AS $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * Remove a field from the field list
     *
     * @param string $field
     * @return self Provides fluent interface
     */
    public function removeField($field)
    {
        if (isset($this->fields[$field])) {
           unset($this->fields[$field]);
        }

        return $this;
    }

    /**
     * Remove all fields from the field list.
     *
     * @return self Provides fluent interface
     */
    public function clearFields()
    {
        $this->fields = array();
        return $this;
    }

    /**
     * Get the list of fields
     *
     * @return array
     */
    public function getFields()
    {
        return array_keys($this->fields);
    }

    /**
     * Set multiple fields
     *
     * This overwrites any existing fields
     *
     * @param array $fields
     * @return self Provides fluent interface
     */
    public function setFields($fields)
    {
        $this->clearFields();
        $this->addFields($fields);

        return $this;
    }

    /**
     * Add a sort
     *
     * @param string $sort
     * @param string $order
     * @return self Provides fluent interface
     */
    public function addSort($sort, $order)
    {
        $this->sorts[$sort] = $order;

        return $this;
    }

    /**
     * Add multiple sorts
     *
     * The input array must contain sort items as keys and the order as values.
     *
     * @param array $sorts
     * @return self Provides fluent interface
     */
    public function addSorts(array $sorts)
    {
        foreach ($sorts AS $sort => $order) {
            $this->addSort($sort, $order);
        }

        return $this;
    }

    /**
     * Remove a sort
     *
     * @param string $sort
     * @return self Provides fluent interface
     */
    public function removeSort($sort)
    {
        if (isset($this->sorts[$sort])) {
            unset($this->sorts[$sort]);
        }

        return $this;
    }

    /**
     * Remove all sorts
     *
     * @return self Provides fluent interface
     */
    public function clearSorts()
    {
        $this->sorts = array();
        return $this;
    }

    /**
     * Get a list of the sorts
     *
     * @return array
     */
    public function getSorts()
    {
        return $this->sorts;
    }

    /**
     * Set multiple sorts
     *
     * This overwrites any existing sorts
     *
     * @param array $sorts
     * @return self Provides fluent interface
     */
    public function setSorts($sorts)
    {
        $this->clearSorts();
        $this->addSorts($sorts);

        return $this;
    }

    /**
     * Create a filterquery instance
     *
     * If you supply a string as the first arguments ($options) it will be used as the key for the filterquery
     * and it will be added to this query.
     * If you supply an options array/object that contains a key the filterquery will also be added to the query.
     *
     * When no key is supplied the filterquery cannot be added, in that case you will need to add it manually
     * after setting the key, by using the addFilterQuery method.
     *
     * @param mixed $options
     * @return FilterQuery
     */
    public function createFilterQuery($options = null)
    {
        if (is_string($options)) {
            $fq = new FilterQuery;
            $fq->setKey($options);
        } else {
            $fq = new FilterQuery($options);
        }

        if ($fq->getKey() !== null) {
            $this->addFilterQuery($fq);
        }

        return $fq;
    }

    /**
     * Add a filter query
     *
     * Supports a filterquery instance or a config array, in that case a new
     * filterquery instance wil be created based on the options.
     *
     * @param FilterQuery|array $filterQuery
     * @return self Provides fluent interface
     */
    public function addFilterQuery($filterQuery)
    {
        if (is_array($filterQuery)) {
            $filterQuery = new FilterQuery($filterQuery);
        }

        $key = $filterQuery->getKey();

        if (0 === strlen($key)) {
            throw new Exception('A filterquery must have a key value');
        }

        //double add calls for the same FQ are ignored, but non-unique keys cause an exception
        //@todo add trigger_error with a notice for double add calls?
        if (array_key_exists($key, $this->filterQueries) && $this->filterQueries[$key] !== $filterQuery) {
            throw new Exception('A filterquery must have a unique key value within a query');
        } else {
            $this->filterQueries[$key] = $filterQuery;
        }

        return $this;
    }

    /**
     * Add multiple filterqueries
     *
     * @param array $filterQueries
     * @return self Provides fluent interface
     */
    public function addFilterQueries(array $filterQueries)
    {
        foreach ($filterQueries AS $key => $filterQuery) {

            // in case of a config array: add key to config
            if (is_array($filterQuery) && !isset($filterQuery['key'])) {
                $filterQuery['key'] = $key;
            }

            $this->addFilterQuery($filterQuery);
        }

        return $this;
    }

    /**
     * Get a filterquery
     *
     * @param string $key
     * @return string
     */
    public function getFilterQuery($key)
    {
        if (isset($this->filterQueries[$key])) {
            return $this->filterQueries[$key];
        } else {
            return null;
        }
    }

    /**
     * Get all filterqueries
     *
     * @return array
     */
    public function getFilterQueries()
    {
        return $this->filterQueries;
    }

    /**
     * Remove a single filterquery
     *
     * You can remove a filterquery by passing it's key, or by passing the filterquery instance
     *
     * @param string|FilterQuery $filterQuery
     * @return self Provides fluent interface
     */
    public function removeFilterQuery($filterQuery)
    {
        if (is_object($filterQuery)) {
            $filterQuery = $filterQuery->getKey();
        }

        if (isset($this->filterQueries[$filterQuery])) {
            unset($this->filterQueries[$filterQuery]);
        }

        return $this;
    }

    /**
     * Remove all filterqueries
     *
     * @return self Provides fluent interface
     */
    public function clearFilterQueries()
    {
        $this->filterQueries = array();
        return $this;
    }

    /**
     * Set multiple filterqueries
     *
     * This overwrites any existing filterqueries
     *
     * @param array $filterQueries
     */
    public function setFilterQueries($filterQueries)
    {
        $this->clearFilterQueries();
        $this->addFilterQueries($filterQueries);
    }

    /**
     * Get all registered component types
     *
     * @return array
     */
    public function getComponentTypes()
    {
        return $this->componentTypes;
    }

    /**
     * Register a component type
     *
     * @param string $key
     * @param string $component
     * @param string $requestBuilder
     * @param string $responseParser
     * @return self Provides fluent interface
     */
    public function registerComponentType($key, $component, $requestBuilder=null, $responseParser=null)
    {
        $this->componentTypes[$key] = array(
            'component' => $component,
            'requestbuilder' => $requestBuilder,
            'responseparser' => $responseParser,
        );

        return $this;
    }

    /**
     * Get all registered components
     *
     * @return array
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Get a component instance by key
     *
     * You can optionally supply an autoload class to create a new component
     * instance if there is no registered component for the given key yet.
     *
     * @param string $key Use one of the constants
     * @param string $autoload Class to autoload if component needs to be created
     * @param array $config Configuration to use for autoload
     * @return object|null
     */
    public function getComponent($key, $autoload = false, $config = null)
    {
        if (isset($this->components[$key])) {
            return $this->components[$key];
        } else {
            if ($autoload == true) {

                if (!isset($this->componentTypes[$key])) {
                    throw new Exception('Cannot autoload unknown component: ' . $key);
                }

                $className = $this->componentTypes[$key]['component'];
                $className = class_exists($className) ? $className : $className.strrchr($className, '\\');
                $component = new $className($config);
                $this->setComponent($key, $component);
                return $component;
            }
            return null;
        }
    }

    /**
     * Set a component instance
     *
     * This overwrites any existing component registered with the same key.
     *
     * @param string $key
     * @param object|null $value
     * @return self Provides fluent interface
     */
    public function setComponent($key, $value)
    {
        $this->components[$key] = $value;
        return $this;
    }

    /**
     * Remove a component instance
     *
     * You can remove a component by passing it's key or the component instance
     *
     * @param string|Component\Component $component
     * @return self Provides fluent interface
     */
    public function removeComponent($component)
    {
        if (is_object($component)) {
            foreach ($this->components as $key => $instance) {
                if ($instance === $component) {
                    unset($this->components[$key]);
                    break;
                }
            }
        } else {
            if (isset($this->components[$component])) {
                unset($this->components[$component]);
            }
        }
        return $this;
    }


    /**
     * Build component instances based on config
     *
     * @param array $configs
     * @return void
     */
    protected function createComponents($configs)
    {
        foreach ($configs AS $type => $config) {
            $this->getComponent($type, true, $config);
        }
    }

    /**
     * Get a MoreLikeThis component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\MoreLikeThis
     */
    public function getMoreLikeThis()
    {
        return $this->getComponent(self::COMPONENT_MORELIKETHIS, true);
    }

    /**
     * Get a FacetSet component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\FacetSet
     */
    public function getFacetSet()
    {
        return $this->getComponent(self::COMPONENT_FACETSET, true);
    }

    /**
     * Get a DisMax component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\DisMax
     */
    public function getDisMax()
    {
        return $this->getComponent(self::COMPONENT_DISMAX, true);
    }

    /**
     * Get a highlighting component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\Highlighting\Highlighting
     */
    public function getHighlighting()
    {
        return $this->getComponent(self::COMPONENT_HIGHLIGHTING, true);
    }

    /**
     * Get a grouping component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\Grouping
     */
    public function getGrouping()
    {
        return $this->getComponent(self::COMPONENT_GROUPING, true);
    }

    /**
     * Get a spellcheck component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\Spellcheck
     */
    public function getSpellcheck()
    {
        return $this->getComponent(self::COMPONENT_SPELLCHECK, true);
    }

    /**
     * Get a DistributedSearch component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\DistributedSearch
     */
    public function getDistributedSearch()
    {
        return $this->getComponent(self::COMPONENT_DISTRIBUTEDSEARCH, true);
    }

    /**
     * Get a Stats component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\Stats\Stats
     */
    public function getStats()
    {
        return $this->getComponent(self::COMPONENT_STATS, true);
    }

    /**
     * Get a Debug component instance
     *
     * This is a convenience method that maps presets to getComponent
     *
     * @return Component\Debug
     */
    public function getDebug()
    {
        return $this->getComponent(self::COMPONENT_DEBUG, true);
    }

}
