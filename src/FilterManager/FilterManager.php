<?php namespace Toplan\FilterManager;

/**
 * Class FilterManager
 * @package toplan\FilterManager
 */
class FilterManager{

    const ALL = 'FilterManager_All';

    /**
     * core data:current filters
     * exp:['gender'=>'male','city'=>'beijing',...]
     * @var array
     */
    protected  $filters = [];

    /**
     * blacklist for filter
     * @var array
     */
    protected  $blackList = [];

    /**
     * base url(without params)
     * exp:'www.xxx.com/goods'
     * @var string
     */
    protected  $baseUrl = "";


    public function __construct(Array $filters,$baseUrl,Array $blackList){
        $this->filters   = $filters;
        $this->$baseUrl   = $baseUrl;
        $this->blackList = $blackList;
    }

    /**create a instance of FilterManger
     * @param array  $filters
     * @param string $baseUrl
     * @param array  $blackList
     *
     * @return FilterManager
     */
    public static function create(Array $filters,$baseUrl = '/',Array $blackList = ['page','pageindex']){
        $fm = new FilterManager($filters,$baseUrl,$blackList);
        return $fm;
    }

    /**set base url
     * @param $baseUrl
     *
     * @return $this
     */
    public function setBootUrl($baseUrl){
        $this->baseUrl->$baseUrl;
        return $this;
    }

    /**set black list for filters
     * @param array $blackList
     *
     * @return $this
     */
    public function setBlackList(Array $blackList){
        $this->blackList = $blackList;
        return $this;
    }

    /**add filter
     * @param        $name
     * @param string $value
     *
     * @return $this
     */
    public function addFilter($name,$value = ''){
        if($name)
            array_push($this->filters,["$name"=>$value]);
        return $this;
    }

    /**remove filter
     * @param $name
     *
     * @return $this
     */
    public function removeFilter($name){
        if($name){
            foreach($this->filters as $filter_name => $filter_value){
                if($filter_name == $name)
                    unset($this->filters["$filter_name"]);
            }
        }
        return $this;
    }

    /**
     * is active
     *
     * @param string $name
     * filter name
     * @param string $value
     * filter value
     * @param mixed $trueReturn
     * @param mixed $falseReturn
     *
     * @return bool
     */
    public function isActive($name = '',$value = FilterManager::ALL,$trueReturn = true,$falseReturn = false){
        $current_filters = $this->filters;
        if(!$name || !$value)
            return false;
        if(!$current_filters || !isset($current_filters["$name"])){
            if($value == FilterManager::ALL)
                return $trueReturn;
            else
                return $falseReturn;
        }
        $arra = explode(',',$current_filters["$name"]);
        if(in_array($value,$arra)){
            return $trueReturn;
        }else{
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
     * @param array $LinkageRemoveFilters
     * Linkage to filter the filter
     * @param array $blackList
     *
     * @return string
     */
    public function url($name = '',$value = FilterManager::ALL,$multi = false ,Array $LinkageRemoveFilters = [],Array $blackList = null){
        $filters = [];
        $current_filters = $this->filters;

        if(!$name || !$value)
            return $this->baseUrl;

        if(!$current_filters || !count($current_filters))
            return  $value!=FilterManager::ALL ? "$this->baseUrl?$name=$value" : $this->baseUrl;

        if(!isset($current_filters["$name"]) && $value != FilterManager::ALL){
            if($this->isPass($name,$LinkageRemoveFilters,$blackList))
                $filters["$name"] = $value;
        }

        foreach($current_filters as $filter_name => $filter_value){
            if($this->isPass($filter_name,$LinkageRemoveFilters,$blackList)){
                if ($name == "$filter_name") {
                    if($value != FilterManager::ALL) {
                        if($multi){
                            $arra = explode(',', $filter_value);
                            if (in_array($value, $arra)) {
                                $new_arra                = array_diff($arra, [$value]);
                                $filters["$filter_name"] = implode(',', $new_arra);
                            } else {
                                array_push($arra, $value);
                                $filters["$filter_name"] = implode(',', $arra);
                            }
                        }else{
                            $filters["$filter_name"] = $value;
                        }
                    }
                } else {
                    $filters["$filter_name"] = $filter_value;
                }
            }
        }
        $params = [];
        foreach($filters as $key => $filter){
            if($filter) $params[] = "$key=$filter";
        }
        return "$this->baseUrl?" . implode('&',$params);
    }

    /**filter filters
     * @param       $filter_name
     * @param array $LinkageRemoveFilters
     * @param array $blackList
     *
     * @return bool
     */
    private function isPass($filter_name,Array $LinkageRemoveFilters = [],Array $blackList = null){
        if( count($LinkageRemoveFilters) > 0 ){
            if(in_array($filter_name,$LinkageRemoveFilters))
                return false;
        }
        if( ! $blackList || count($blackList) == 0 ){
            $blackList = $this->blackList;
        }
        if(in_array($filter_name,$blackList))
            return false;
        return true;
    }

}