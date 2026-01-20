<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_product_pages(): void
    {
        $this->get('/admin/products')->assertRedirect('/login');
        $this->get('/admin/products/create')->assertRedirect('/login');

        $category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'slug' => 'nasi-goreng',
            'description' => 'enak',
            'price' => 15000,
            'stock' => 10,
            'photo_path' => null,
            'is_active' => true,
        ]);

        $this->get("/admin/products/{$product->id}/edit")->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_product_with_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);

        $resp = $this->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Ayam Geprek',
            'description' => 'Pedas',
            'price' => 20000,
            'stock' => 5,
            'is_active' => 1,
            'photo' => UploadedFile::fake()->create('ayam.jpg', 100, 'image/jpeg'),
        ]);

        $resp->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Ayam Geprek',
            'slug' => 'ayam-geprek',
            'price' => 20000,
            'stock' => 5,
            'is_active' => 1,
        ]);

        $product = Product::where('name', 'Ayam Geprek')->firstOrFail();
        $this->assertNotNull($product->photo_path);
        $this->assertTrue(Storage::disk('public')->exists($product->photo_path));
    }

    public function test_authenticated_user_can_update_product_and_replace_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);

        $oldPhotoPath = UploadedFile::fake()
            ->create('old.jpg', 100, 'image/jpeg')
            ->store('products', 'public');

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Burger',
            'slug' => 'burger',
            'description' => null,
            'price' => 30000,
            'stock' => 7,
            'photo_path' => $oldPhotoPath,
            'is_active' => true,
        ]);

        $resp = $this->put(route('admin.products.update', $product), [
            'category_id' => $category->id,
            'name' => 'Burger Spesial',
            'description' => 'Tambah keju',
            'price' => 35000,
            'stock' => 9,
            'is_active' => 1,
            'photo' => UploadedFile::fake()->create('new.jpg', 100, 'image/jpeg'),
        ]);

        $resp->assertRedirect(route('admin.products.index'));

        $product->refresh();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Burger Spesial',
            'slug' => 'burger-spesial',
            'price' => 35000,
            'stock' => 9,
            'is_active' => 1,
        ]);

        $this->assertFalse(Storage::disk('public')->exists($oldPhotoPath));
        $this->assertTrue(Storage::disk('public')->exists($product->photo_path));
    }

    public function test_authenticated_user_can_delete_product_and_photo_is_deleted(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);

        $photoPath = UploadedFile::fake()
            ->create('hapus.jpg', 100, 'image/jpeg')
            ->store('products', 'public');

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Sate',
            'slug' => 'sate',
            'description' => null,
            'price' => 25000,
            'stock' => 3,
            'photo_path' => $photoPath,
            'is_active' => true,
        ]);

        $resp = $this->delete(route('admin.products.destroy', $product));

        $resp->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        $this->assertFalse(Storage::disk('public')->exists($photoPath));
    }
}
