<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuBrowsingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_menu_list(): void
    {
        Product::factory()->count(3)->create();

        $res = $this->get('/menu');
        $res->assertStatus(200);
    }

    public function test_user_can_filter_by_category_slug(): void
    {
        $catA = Category::factory()->create(['name' => 'Nasi', 'slug' => 'nasi']);
        $catB = Category::factory()->create(['name' => 'Minuman', 'slug' => 'minuman']);

        Product::factory()->create(['category_id' => $catA->id, 'name' => 'Nasi Goreng']);
        Product::factory()->create(['category_id' => $catB->id, 'name' => 'Es Teh']);

        $res = $this->get('/menu?category=nasi');
        $res->assertStatus(200);
    }

    public function test_user_can_search_menu(): void
    {
        Product::factory()->create(['name' => 'Nasi Goreng Spesial', 'slug' => 'nasi-goreng-spesial-1']);
        Product::factory()->create(['name' => 'Es Jeruk', 'slug' => 'es-jeruk-1']);

        $res = $this->get('/menu?q=nasi');
        $res->assertStatus(200);
    }
}
