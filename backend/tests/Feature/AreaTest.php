<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Area;

class AreaTest extends TestCase
{

    public function test_api_areas()
    {
        $response = $this->get('/api/areas');
        // $response = json_decode($response);
        // var_dump(($response->assertJsonCount()));
        // レスポンスの検証
        $response->assertOk()  # ステータスコードが 200
            ->assertJsonCount(Area::all()->count()); # レスポンスの配列の件数が1件
    }

    public function test_api_area()
    {
        $response = $this->get('/api/area/1');
        $response->assertOk()  # ステータスコードが 200
            ->assertJsonCount(Area::where('id', 1)->first()->id); # レスポンスの配列の件数が1件
    }

    public function test_api_edit_area()
    {
        $id = 1;
        $rand = rand(0, 100);
        $area = Area::where('id', $id)->first();
        $area->star = $rand;
        $area = $area->toArray();
        // var_dump($area);
        $response = $this->post('/api/area/' . $id, [
            $area
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $id,
                'star' => $rand,
            ]);
    }
}
