<?php

namespace App\Providers;

use App\Events\EntriBarang;
use App\Events\EntriPemakaian;
use App\Events\EntriPemakaianBarangHabis;
use App\Events\PengembalianDiterima;
use Illuminate\Support\Facades\Event;
use App\Listeners\UbahStatusPemakaian;
use Illuminate\Auth\Events\Registered;
use App\Events\EntriTransaksiPengadaan;
use App\Events\PeminjamanBarangCreated;
use App\Listeners\UbahStatusInventaris;
use App\Listeners\UpdateStatusInventaris;
use App\Listeners\IsiKodeSlugKondisiStatusInventarisBarang;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\IsiKodeSlugKondisiStatusInventarisTransaksiPengadaan;
use App\Listeners\UbahStatusPemakaianBarangHabis;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EntriBarang::class => [
            IsiKodeSlugKondisiStatusInventarisBarang::class,
        ],
        EntriTransaksiPengadaan::class => [
            IsiKodeSlugKondisiStatusInventarisTransaksiPengadaan::class,
        ],
        PeminjamanBarangCreated::class => [
            UbahStatusInventaris::class,
        ],
        PengembalianDiterima::class => [
            UpdateStatusInventaris::class,
        ],
        EntriPemakaian::class => [
            UbahStatusPemakaian::class,
        ],
        EntriPemakaianBarangHabis::class => [
            UbahStatusPemakaianBarangHabis::class,
        ],
    ];





    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
