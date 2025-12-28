<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi user
            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('mitra_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Jenis layanan
            $table->enum('service_type', ['ride', 'jastip']);

            // Lokasi jemput
            $table->string('pickup_address');
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();

            // Lokasi tujuan
            $table->string('destination_address');
            $table->decimal('destination_lat', 10, 7)->nullable();
            $table->decimal('destination_lng', 10, 7)->nullable();

            // Catatan barang (jastip)
            $table->text('item_description')->nullable();

            // Jarak & harga
            $table->decimal('distance_km', 8, 2);
            $table->decimal('price', 12, 2);

            // Pembayaran
            $table->enum('payment_method', ['cash', 'ewallet']);

            // STATUS ORDER (WAJIB SAMA DENGAN CONTROLLER)
            $table->enum('status', [
                'pending',        // menunggu driver
                'accepted',       // driver menerima
                'arrived',        // driver tiba di titik jemput
                'on_the_way',     // perjalanan berlangsung
                'completed',      // selesai
                'rejected',       // ditolak driver
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};