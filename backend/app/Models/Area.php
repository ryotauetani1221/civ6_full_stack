<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // エリアを新規制作
    public static function createArea($area_data)
    {
        $area = Area::create([
            'area' => $area_data['area'],
            'area_base' => $area_data['area_base'],
            'area_building' => $area_data['area_building'],
            'production_cost' => $area_data['production_cost'],
            'maintenance_cost' => $area_data['maintenance_cost'],
            'building_conditions' => $area_data['building_conditions'],
            'trade_bonus_domestic' => $area_data['trade_bonus_domestic'],
            'trade_bonus_overseas' => $area_data['trade_bonus_overseas'],
            'lifting_technology' => $area_data['lifting_technology'],
            'adjacent_bonus' => $area_data['adjacent_bonus'],
            'looting_bonus' => $area_data['looting_bonus'],
            'effect' => $area_data['effect'],
        ]);

        return $area;
    }

    // エリア達を新規制作
    public static function createAreas($area_datas)
    {
        foreach ($area_datas as $area_data) {
            Area::createArea($area_data);
        }
    }

    // エリアを編集
    public static function editArea($id, $area_data)
    {
        $area = Area::where('id', $id)->first();
        var_dump($area_data);
        foreach ($area_data as $key => $value) {
            $area->$key = $value;
        }

        $area->save();
        return $area;
    }
}
