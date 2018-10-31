<?php
/*
 * 基础模型
 */

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Qmai\DataCache;

class Base extends Model {

    protected $connection = 'mysql';

    protected $dateFormat = 'U';                        //日期字段保存格式

    public static $status = ['禁用', '启用'];           //状态类型

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        /*
         * 注册数据库操作事件，对设定清除API前端结果缓存的数据进行处理
         */
    }


    /**
     * @param string $key
     * @return mixed|string
     */
    public function getAttribute($key) {
        if (!array_key_exists($key, $this->attributes) && preg_match('/([\w]+)_text$/', $key, $match)) {
            $attribute = $match[1];
            $value = static::getAttribute($attribute);
            $plural = Str::plural($match[1]);
            $statuses = static::$$plural;
            return isset($statuses[$value]) ? $statuses[$value] : '未知';
        }
        return parent::getAttribute($key);
    }

    /**
     * @param $query
     * @param $column
     * @param null $key
     * @return Collection
     */
    public function scopeLists($query, $column, $key = null) {
        if (is_array($column)) {
            if (!empty($key)) {
                $column[] = $key;
            }
            $items = new Collection();
            foreach ($query->get($column) as $item) {
                $items[$item->$key] = $item;
            }
            return $items;
        } else {
            return $query->pluck($column, $key);
        }
    }
}
