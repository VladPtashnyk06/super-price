<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Characteristic;
use App\Models\Color;
use App\Models\DeliveryMethod;
use App\Models\DeliveryService;
use App\Models\Material;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Producer;
use App\Models\Region;
use App\Models\Size;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
             'name' => 'Admin',
             'last_name' => 'Admin',
             'phone' => '0971037978',
             'email' => 'Admin@gmail.com',
             'role' => 'Admin',
             'password' => \Hash::make('admin'),
         ]);
        \App\Models\User::factory()->create([
             'name' => 'User',
             'last_name' => 'User',
             'phone' => '0000000000',
             'email' => 'User@gmail.com',
             'password' => \Hash::make('user'),
         ]);

        $deliveryServices = ['Нова Пошта', 'Укрпошта', 'Міст'];
        foreach ($deliveryServices as $service) {
            DeliveryService::create([
                'delivery_title' => $service,
            ]);
        }

        $deliveryMethods = [
            'Укрпошта' => [
                'Експрес відділення',
                'Експрес кур\'єр',
                'Стандарт відділення',
                'Стандарт кур\'єр',
            ],
            'Нова пошта' => [
                'Доставка у відділення',
                'Доставка кур\'єром',
                'Доставка в поштомат',
            ],
            'Міст' => [
                'Meest: відділення',
                'Meest: поштомат',
                'Meest: кур\'єр',
            ],
        ];
        foreach ($deliveryMethods as $serviceName => $methods) {
            $service = DeliveryService::where('delivery_title', $serviceName)->first();

            foreach ($methods as $method) {
                DeliveryMethod::create([
                    'delivery_service_id' => $service->id,
                    'method_title' => $method,
                ]);
            }
        }

        $regions = [
            'Вінницька область', 'Волинська область', 'Дніпропетровська область', 'Донецька область', 'Житомирська область', 'Закарпатська область', 'Запорізька область', 'Івано-Франківська область', 'Київська область', 'Кіровоградська область', 'Луганська область', 'Львівська область', 'Миколаївська область', 'Одеська область', 'Полтавська область', 'Рівненська область', 'Сумська область', 'Тернопільська область', 'Харківська область', 'Херсонська область', 'Хмельницька область', 'Черкаська область', 'Чернівецька область', 'Чернігівська область', 'місто Київ', 'місто Севастополь',
        ];
        foreach ($regions as $region) {
            Region::create([
                'title' => $region,
            ]);
        }

        PaymentMethod::create([
            'title' => 'Оплата при доставці'
        ]);
        PaymentMethod::create([
            'title' => 'Банківський переказ'
        ]);

        Status::create([
            'title' => 'Є у наявності'
        ]);
        Status::create([
            'title' => 'Немає у наявності'
        ]);
        Status::create([
            'title' => 'Скоро буде у наявності'
        ]);

         Producer::create([
             'title' => 'Китай'
         ]);
        Producer::create([
            'title' => 'Україна'
        ]);
        Producer::create([
            'title' => 'Польща'
        ]);

        Package::create([
            'title' => 12
        ]);
        Package::create([
            'title' => 10
        ]);
        Package::create([
            'title' => 8
        ]);

        Material::create([
            'title' => 'Тканина'
        ]);
        Material::create([
            'title' => 'Пластик'
        ]);
        Material::create([
            'title' => 'Двухнитка'
        ]);

        Characteristic::create([
            'height' => 12,
            'width' => 12,
            'length' => 12,
        ]);
        Characteristic::create([
            'height' => 10,
            'width' => 10,
            'length' => 10,
        ]);
        Characteristic::create([
            'height' => 12,
            'width' => 10,
            'length' => 8,
        ]);

        Color::create([
            'title' => 'Червоний'
        ]);
        Color::create([
            'title' => 'Чорний'
        ]);
        Color::create([
            'title' => 'Білий'
        ]);
        Color::create([
            'title' => 'Сірий'
        ]);

        Size::create([
            'title' => 'M'
        ]);
        Size::create([
            'title' => 'XL'
        ]);
        Size::create([
            'title' => '14'
        ]);
    }
}
