<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    // 商品一级分类模型
    protected $table='main_class';
    protected $primaryKey='class_id';
}
