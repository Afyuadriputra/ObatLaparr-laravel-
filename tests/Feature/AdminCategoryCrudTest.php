<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_category_pages(): void
    {
        $this->get('/admin/categories')->assertRedirect('/login');
        $this->get('/admin/categories/create')->assertRedirect('/login');

        $category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);
        $this->get("/admin/categories/{$category->id}/edit")->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_category(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $resp = $this->post(route('admin.categories.store'), [
            'name' => 'Minuman',
        ]);

        $resp->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Minuman',
            // slug otomatis dari controller
            'slug' => 'minuman',
        ]);
    }

    public function test_authenticated_user_can_update_category(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::create(['name' => 'Snack', 'slug' => 'snack']);

        $resp = $this->put(route('admin.categories.update', $category), [
            'name' => 'Snack Baru',
        ]);

        $resp->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Snack Baru',
            'slug' => 'snack-baru',
        ]);
    }

    public function test_authenticated_user_can_delete_category(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::create(['name' => 'Dessert', 'slug' => 'dessert']);

        $resp = $this->delete(route('admin.categories.destroy', $category));

        $resp->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
