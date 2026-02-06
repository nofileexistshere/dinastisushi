<?php

namespace Tests\Feature;

use App\Services\MenuService;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuServiceTest extends TestCase
{
    use RefreshDatabase;

    private MenuService $menuService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->menuService = new MenuService();
    }

    /** @test */
    public function it_can_get_menu_items()
    {
        // Create test menu items
        MenuItem::factory()->create([
            'name' => 'Salmon Maki',
            'category' => 'Sushi Roll',
            'price' => 25000
        ]);

        MenuItem::factory()->create([
            'name' => 'Tuna Sashimi',
            'category' => 'Nigiri & Sashimi',
            'price' => 45000
        ]);

        $items = $this->menuService->getMenuItems();

        $this->assertCount(2, $items);
        $this->assertEquals('Salmon Maki', $items->first()->name);
    }

    /** @test */
    public function it_can_filter_menu_items_by_category()
    {
        MenuItem::factory()->create([
            'name' => 'Salmon Maki',
            'category' => 'Sushi Roll',
            'price' => 25000
        ]);

        MenuItem::factory()->create([
            'name' => 'Tuna Sashimi',
            'category' => 'Nigiri & Sashimi',
            'price' => 45000
        ]);

        $items = $this->menuService->getMenuItems('Sushi Roll');

        $this->assertCount(1, $items);
        $this->assertEquals('Salmon Maki', $items->first()->name);
    }

    /** @test */
    public function it_can_search_menu_items()
    {
        MenuItem::factory()->create([
            'name' => 'Salmon Maki',
            'description' => 'Fresh salmon roll',
            'category' => 'Sushi Roll'
        ]);

        MenuItem::factory()->create([
            'name' => 'Tuna Roll',
            'description' => 'Fresh tuna roll',
            'category' => 'Sushi Roll'
        ]);

        $items = $this->menuService->getMenuItems('Semua', 'salmon');

        $this->assertCount(1, $items);
        $this->assertEquals('Salmon Maki', $items->first()->name);
    }

    /** @test */
    public function it_can_get_global_recommendations()
    {
        // Create items in different categories
        MenuItem::factory()->create([
            'name' => 'Salmon Maki',
            'category' => 'Sushi Roll',
            'average_rating' => 4.5,
            'rating_count' => 10
        ]);

        MenuItem::factory()->create([
            'name' => 'Tuna Sashimi',
            'category' => 'Nigiri & Sashimi',
            'average_rating' => 4.0,
            'rating_count' => 5
        ]);

        $recommendations = $this->menuService->getRecommendations('Semua');

        $this->assertGreaterThan(0, $recommendations->count());
    }

    /** @test */
    public function it_can_get_category_recommendations()
    {
        MenuItem::factory()->create([
            'name' => 'Salmon Maki',
            'category' => 'Sushi Roll',
            'average_rating' => 4.5,
            'rating_count' => 10
        ]);

        MenuItem::factory()->create([
            'name' => 'California Roll',
            'category' => 'Sushi Roll',
            'average_rating' => 4.0,
            'rating_count' => 8
        ]);

        $recommendations = $this->menuService->getRecommendations('Sushi Roll');

        $this->assertLessThanOrEqual(3, $recommendations->count());
    }

    /** @test */
    public function it_can_get_menu_item_with_details()
    {
        $menuItem = MenuItem::factory()->create();

        $foundItem = $this->menuService->getMenuItem($menuItem->id);

        $this->assertEquals($menuItem->id, $foundItem->id);
        $this->assertEquals($menuItem->name, $foundItem->name);
    }

    /** @test */
    public function it_throws_exception_when_menu_item_not_found()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->menuService->getMenuItem(999);
    }

    /** @test */
    public function it_can_get_popular_menu_items()
    {
        // Create popular items
        MenuItem::factory()->create([
            'name' => 'Popular Item',
            'average_rating' => 4.8,
            'rating_count' => 20
        ]);

        MenuItem::factory()->create([
            'name' => 'Less Popular Item',
            'average_rating' => 3.5,
            'rating_count' => 2
        ]);

        $popularItems = $this->menuService->getPopularMenuItems(5);

        $this->assertCount(2, $popularItems);
        $this->assertEquals('Popular Item', $popularItems->first()->name);
    }

    /** @test */
    public function it_can_get_menu_statistics()
    {
        MenuItem::factory()->count(5)->create([
            'average_rating' => 4.0
        ]);

        $stats = $this->menuService->getMenuStatistics();

        $this->assertEquals(5, $stats['total_items']);
        $this->assertGreaterThan(0, $stats['total_categories']);
        $this->assertEquals(4.0, $stats['average_rating']);
    }
}
