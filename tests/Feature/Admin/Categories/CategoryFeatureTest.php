<?php

namespace Tests\Feature\Admin\Categories;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_categories()
    {
        $category = Category::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.categories.index'))
            ->assertStatus(200)
            ->assertSee($category->name);
    }

    /** @test */
    public function it_can_remove_the_cover_image()
    {
        $category = Category::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.category.remove.image', ['category' => $category->id]))
            ->assertStatus(302)
            ->assertRedirect(route('admin.categories.edit', $category->id))
            ->assertSessionHas('message', 'Image delete successful');
    }

    /** @test */
    public function it_can_remove_a_category()
    {
        $category = Category::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->delete(route('admin.categories.destroy', $category->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('message', 'Delete successful');
    }

    /** @test */
    public function it_can_update_the_category()
    {
        $data = [
            'name' => $this->faker->name
        ];

        $category = Category::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.categories.update', $category->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.categories.edit', $category->id))
            ->assertSessionHas('message', 'Update successful');
    }
    
    /** @test */
    public function it_can_show_the_category_edit_page()
    {
        $category = Category::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.categories.edit', $category->id))
            ->assertStatus(200)
            ->assertSee($category->name)
            ->assertSee($category->description);
    }
    
    /** @test */
    public function it_can_show_the_category_page()
    {
        $category = Category::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.categories.show', $category->id))
            ->assertStatus(200)
            ->assertSee($category->name)
            ->assertSee($category->description);
    }

    /** @test */
    public function it_can_show_the_create_category_page()
    {
        $category = Category::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.categories.create'))
            ->assertStatus(200)
            ->assertSee($category->name);
    }

    
    /** @test */
    public function it_can_create_category()
    {
        $cover = UploadedFile::fake()->image('file.png', 600, 600);
        $parent = Category::factory()->create();

        $params = [
            'name' => 'Boys',
            'slug' => 'boys',
            'cover' => $cover,
            'description' => $this->faker->paragraph,
            'status' => 1,
            'parent' => $parent->id
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.categories.store'), $params)
            ->assertStatus(302)
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('message', 'Category created');
    }
}
