<?php

namespace Toplan\FilterManager;

/**
 * Class FilterManager
 */
class FilterManager
{
    const ALL = 'FilterManager_SelectAll';

    /**
     * core data:current filters
     * exp:['gender'=>'male','city'=>'beijing',...]
     *
     * @var array
     */
    protected $filters = [];

    /**
     * blacklist for filter
     *
     * @var array
     */
    protected $blackList = [];

    /**
     * base url(without params)
     * exp:'www.xxx.com/goods'
     *
     * @var string
     */
    protected $baseUrl = '';

    /**
     * @param array $filters
     * @param       $baseUrl
     * @param array $blackList
     */
    public function __construct(array $filters, $baseUrl = '', array $blackList = array())
    {
        define('FM_SELECT_ALL', self::ALL);
        $this->filters = $filters;
        $this->baseUrl = str_replace('?', '', $baseUrl);
        $this->blackList = $blackList;
    }

    /**create a instance of FilterManger
     * @param array  $filters
     * @param string $baseUrl
     * @param array  $blackList
     *
     * @return FilterManager
     */

    public static function create(array $filters, $baseUrl = '', array $blackList = [])
    {
        $fm = new self($filters, $baseUrl, $blackList);

        return $fm;
    }

    /**set base url
     * @param $baseUrl
     *
     * @return $this
     */

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl->$baseUrl;

        return $this;
    }

    /**set black list for filters
     * @param array $blackList
     *
     * @return $this
     */

    public function setBlackList(array $blackList)
    {
        $this->blackList = $blackList;

        return $this;
    }

    /**add filter
     * @param        $name
     * @param string $value
     *
     * @return $this
     */

    public function addFilter($name, $value = '')
    {
        if ($name) {
            array_push($this->filters, ["$name" => $value]);
        }

        return $this;
    }

    /**remove filter
     * @param $name
     *
     * @return $this
     */

    public function removeFilter($name)
    {
        if ($name && isset($this->filters["$name"])) {
            unset($this->filters["$name"]);
        }

        return $this;
    }

    /**has filter?
     * @param $name
     *
     * @return bool
     */

    public function has($name)
    {
        if ($name && isset($this->filters["$name"])) {
            return $this->filters["$name"];
        }

        return false;
    }

    /**
     * is active
     *
     * @param string $name
     *                            filter name
     * @param string $value
     *                            filter value
     * @param mixed  $trueReturn
     * @param mixed  $falseReturn
     *
     * @return bool
     */
    public function isActive($name = '', $value = self::ALL, $trueReturn = true, $falseReturn = false)
    {
        $currentFilters = $this->filters;
        if (!$name) {
            return false;
        }
        if (!$currentFilters || !isset($currentFilters["$name"])) {
            if ($value === self::ALL) {
                return $trueReturn;
            } else {
                return $falseReturn;
            }
        }
        $valueArray = explode(',', $currentFilters["$name"]);
        if (in_array($value, $valueArray)) {
            return $trueReturn;
        } else {
            return $falseReturn;
        }
    }

    /**get full url(with params)
     *
     * @param string $name
     * filter name
     * @param string $value
     * filter value
     * @param bool $multi
     * Whether to support more value filtering,
     * if $value == FilterManager::ALL, this parameter does`t work
     * @param array $linkageRemoveFilters
     * Linkage to filter the filter
     * @param array $blackList
     *
     * @return string
     */

    public function url($name = '', $value = self::ALL, $multi = false, array $linkageRemoveFilters = [], array $blackList = [])
    {
        $filters = [];
        $currentFilters = $this->filters;

        if (!$name) {
            return $this->baseUrl;
        }

        if (!$currentFilters || !count($currentFilters)) {
            return  $value !== self::ALL ? "$this->baseUrl?$name=$value" : $this->baseUrl;
        }

        if (!isset($currentFilters["$name"]) && $value !== self::ALL) {
            if ($this->isPass($name, $linkageRemoveFilters, $blackList)) {
                $filters["$name"] = $value;
            }
        }

        foreach ($currentFilters as $filterName => $filterValue) {
            if ($this->isPass($filterName, $linkageRemoveFilters, $blackList)) {
                if ($name === "$filterName") {
                    if ($value !== self::ALL) {
                        if ($multi) {
                            $valueArray = explode(',', $filterValue);
                            if (in_array($value, $valueArray)) {
                                $newValueArray = array_diff($valueArray, [$value]);
                                $filters["$filterName"] = implode(',', $newValueArray);
                            } else {
                                array_push($valueArray, $value);
                                $filters["$filterName"] = implode(',', $valueArray);
                            }
                        } else {
                            $filters["$filterName"] = $value;
                        }
                    }
                } else {
                    $filters["$filterName"] = $filterValue;
                }
            }
        }
        $params = [];
        foreach ($filters as $key => $filter) {
            if ($filter = urlencode(trim($filter))) {
                $params[] = "$key=$filter";
            }
        }

        return "$this->baseUrl?" . implode('&', $params);
    }

    /**filter filters
     * @param       $filterName
     * @param array $linkageRemoveFilters
     * @param array $blackList
     *
     * @return bool
     */

    protected function isPass($filterName, array $linkageRemoveFilters = [], array $blackList = [])
    {
        if (count($linkageRemoveFilters) > 0) {
            if (in_array($filterName, $linkageRemoveFilters)) {
                return false;
            }
        }
        if (count($blackList) === 0) {
            $blackList = $this->blackList;
        }
        if (in_array($filterName, $blackList)) {
            return false;
        }

        return true;
    }
}
