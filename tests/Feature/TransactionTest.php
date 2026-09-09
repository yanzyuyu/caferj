<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_transaction_history_and_detail(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::create(['nama_kategori' => 'Kopi']);
        $product = Product::create([
            'category_id' => $category->id,
            'nama_menu' => 'Espresso',
            'harga' => 18000,
            'stok' => 10,
        ]);

        $trx = Transaction::create([
            'no_invoice' => 'INV-20260909-0001',
            'user_id' => $user->id,
            'total_bayar' => 18000,
            'jumlah_bayar' => 20000,
            'kembalian' => 2000,
            'metode_bayar' => 'Cash',
            'tanggal' => now(),
        ]);

        TransactionDetail::create([
            'transaction_id' => $trx->id,
            'product_id' => $product->id,
            'jumlah_beli' => 1,
            'subtotal' => 18000,
        ]);

        $historyResponse = $this->actingAs($user)->get(route('transactions.history'));
        $historyResponse->assertStatus(200);
        $historyResponse->assertSee($trx->no_invoice);

        $showResponse = $this->actingAs($user)->get(route('transactions.show', $trx));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($trx->no_invoice);
        $showResponse->assertSee('Espresso');

        $receiptResponse = $this->actingAs($user)->get(route('transactions.receipt', $trx));
        $receiptResponse->assertStatus(200);
        $receiptResponse->assertSee($trx->no_invoice);
    }

    public function test_admin_pages_render_successfully(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)->get(route('admin.categories.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.products.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.users.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.reports.index'))->assertStatus(200);
    }
}
