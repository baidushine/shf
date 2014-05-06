<?php
/**
 * Created by PhpStorm.
 * User: shine
 * Date: 14-5-6
 * Time: 上午11:34
 */

namespace shf\base;


/**
 * Class Object
 * @package shf\base
 *
 * 1. 属性的访问：依靠
 *
 *
 * 2. 构造的生命周期
 *    1) 调用构造函数
 *    2) 初始化config
 *    3) 调用init方法, 方便子类们自定义初始化的方法
 *
 * 注：上述顺序保证了，在调用init的时候, 类的配置文件已经加载完成
 *
 */
class Object
{

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!empty($config)) {
            //根据类的配置文件进行初始化, 保证在init之前, 类的配置已经加载完成

        }
        $this->init();
    }

    public function init()
    {
    }

    /**
     *
     * 调用方式：$this->property
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        $getter = "get" . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter;
        } // 异常处理, 后续再进行相应的补充
        else {

        }
    }


    /**
     *
     * 调用方式：$this->property = $value
     *
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        $setter = "set" . $name;
        if (method_exists($this, $setter)) {
            return $this->$setter($name, $vlaue);
        } // 异常处理，后续进行相应补充
        else {

        }
    }

    /**
     *
     * Checks if the named property is set (not null).
     *
     * 调用方式：isset($this->property)
     *
     * @param $name
     * @return mixed
     */
    public function __isset($name)
    {
        $getter = "get" . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter !== NULL;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * set property to null
     *
     * 调用方式：unset($this->property)
     *
     * @param $name
     * @return mixed
     */
    public function __unset($name)
    {
        $setter = "set" . $name;
        if (method_exists($this, $setter)) {
            $this->setter(null);
        }

        //异常处理： 1. 针对read only的属性进行unset; 2. 对于不存在的属性进行unset，对于结果等没有什么影响，因此不做任何处理
    }

    /**
     *
     * 针对不存在的方法调用的异常处理
     *
     * @param $method_name
     * @param $params
     * @return mixed
     */
    public function __call($method_name, $params)
    {
        // 异常处理，当然也是个魔术方法
    }


    /**
     *
     * 判断某个方法类中是否存在
     *
     * @param $method
     * @return bool
     */
    public function hasMethod($method)
    {
        return method_exists($this, $method);
    }


    /**
     *
     * 判断某个属性是否存在：是否存在getter或者setter方法
     *
     * yii框架里面还有个$checkVars参数，主要是表明是否允许直接访问属性，这个在set方法里面尤其有用
     *
     * 注：感觉一个property可以写，却不可以读的情况比较少，所以后面再说
     *
     * @param $name
     * @return bool
     */
    public function hasProperty($name)
    {
        return $this->canGetProperty($name) || $this->canSetProperty($name);
    }

    public function canSetProperty($name)
    {
        return method_exists($this, 'set' . $name) || property_exists($this, $name);
    }

    public function canGetProperty($name)
    {
        return method_exists($this, 'get' . $name) || property_exists($this, $name);
    }


} 