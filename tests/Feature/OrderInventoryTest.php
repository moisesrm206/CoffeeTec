<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderInventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_an_order_does_not_reduce_stock(): void
    {
        $product = $this->makeProduct(stock: 10);

        $this->post('/pedidos', [
            'customer' => 'María López',
            'items' => json_encode([
                ['id' => $product->id_product, 'quantity' => 3],
            ]),
        ])->assertRedirect();

        $this->assertDatabaseHas('products', [
            'id_product' => $product->id_product,
            'stock' => 10,
        ]);
    }

    public function test_orders_exceeding_stock_are_rejected_on_creation(): void
    {
        $product = $this->makeProduct(stock: 2);

        $this->post('/pedidos', [
            'customer' => 'María López',
            'items' => json_encode([
                ['id' => $product->id_product, 'quantity' => 3],
            ]),
        ])->assertSessionHas('error');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_products', 0);
        $this->assertDatabaseHas('products', [
            'id_product' => $product->id_product,
            'stock' => 2,
        ]);
    }

    public function test_orders_with_exactly_the_available_stock_are_accepted(): void
    {
        $product = $this->makeProduct(stock: 3);

        $this->post('/pedidos', [
            'customer' => 'María López',
            'items' => json_encode([
                ['id' => $product->id_product, 'quantity' => 3],
            ]),
        ])->assertSessionHas('success');

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('products', [
            'id_product' => $product->id_product,
            'stock' => 3,
        ]);
    }

    public function test_starting_preparation_reduces_stock(): void
    {
        $product = $this->makeProduct(stock: 10);
        $order = $this->makeOrder($product, quantity: 3);

        $this->actingAs(User::factory()->create())
            ->post(route('orders.status', $order), ['status' => 'making'])
            ->assertSessionHas('success');

        $this->assertSame('making', $order->refresh()->status);
        $this->assertDatabaseHas('products', [
            'id_product' => $product->id_product,
            'stock' => 7,
        ]);
    }

    public function test_cancelling_an_order_in_preparation_restores_stock(): void
    {
        $product = $this->makeProduct(stock: 10);
        $order = $this->makeOrder($product, quantity: 3);
        $cook = User::factory()->create();

        $this->actingAs($cook)->post(route('orders.status', $order), ['status' => 'making']);
        $this->actingAs($cook)->post(route('orders.status', $order), ['status' => 'cancelled'])
            ->assertSessionHas('success');

        $this->assertSame('cancelled', $order->refresh()->status);
        $this->assertDatabaseHas('products', [
            'id_product' => $product->id_product,
            'stock' => 10,
        ]);
    }

    public function test_cancelling_a_pending_order_does_not_change_stock(): void
    {
        $product = $this->makeProduct(stock: 10);
        $order = $this->makeOrder($product, quantity: 3);

        $this->actingAs(User::factory()->create())
            ->post(route('orders.status', $order), ['status' => 'cancelled'])
            ->assertSessionHas('success');

        $this->assertSame('cancelled', $order->refresh()->status);
        $this->assertDatabaseHas('products', [
            'id_product' => $product->id_product,
            'stock' => 10,
        ]);
    }

    public function test_completed_orders_cannot_be_cancelled(): void
    {
        $product = $this->makeProduct(stock: 7);
        $order = $this->makeOrder($product, quantity: 3, status: 'completed');

        $this->actingAs(User::factory()->create())
            ->post(route('orders.status', $order), ['status' => 'cancelled'])
            ->assertSessionHas('error');

        $this->assertSame('completed', $order->refresh()->status);
        $this->assertDatabaseHas('products', [
            'id_product' => $product->id_product,
            'stock' => 7,
        ]);
    }

    public function test_preparation_is_rejected_when_there_is_not_enough_stock(): void
    {
        $product = $this->makeProduct(stock: 2);
        $order = $this->makeOrder($product, quantity: 3);

        $this->actingAs(User::factory()->create())
            ->post(route('orders.status', $order), ['status' => 'making'])
            ->assertSessionHas('error');

        $this->assertSame('pending', $order->refresh()->status);
        $this->assertDatabaseHas('products', [
            'id_product' => $product->id_product,
            'stock' => 2,
        ]);
    }

    private function makeProduct(int $stock): Product
    {
        $category = Category::query()->create([
            'name' => 'Bebidas',
            'description' => 'Bebidas calientes',
        ]);

        return Product::query()->create([
            'id_category' => $category->id_category,
            'name' => 'Café americano',
            'description' => 'Café de grano recién preparado',
            'price' => 25,
            'stock' => $stock,
        ]);
    }

    private function makeOrder(Product $product, int $quantity, string $status = 'pending'): Order
    {
        $order = Order::query()->create([
            'customer' => 'María López',
            'status' => $status,
            'total' => (float) $product->price * $quantity,
        ]);

        $order->orderProducts()->create([
            'id_product' => $product->id_product,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);

        return $order;
    }
}
