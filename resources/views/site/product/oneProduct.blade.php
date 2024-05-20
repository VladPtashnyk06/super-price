<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-6 text-center">Продукт</h1>
                    <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                        @foreach($product->getMedia($product->id) as $media)
                            @if($media->getCustomProperty('main_image') === 1)
                                <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4">
                            @endif
                        @endforeach
                        <div class="text-center">
                            <p class="text-xl font-semibold mb-2">{{ $product->title }}</p>
                            @if($product->package)
                                <p class="text-lg mb-2">В упаковці: {{ $product->package->title }}</p>
                            @endif
                            @foreach($product->productVariants()->get() as $productVariant)
                                <p class="text-lg mb-2">Колір, розмір, доступно:</p>
                                <ul class="text-lg mb-2">
                                    <li>{{ $productVariant->color->title }} - {{ $productVariant->size->title }} - {{ $productVariant->quantity }}</li>
                                </ul>
                            @endforeach

                            @if($product->price()->get())
                                @foreach($product->price()->get() as $price)
                                    <p class="text-lg mb-2">Ціна за шт - {{ $price->pair }} грн.</p>
                                    <p class="text-lg mb-2">Ціна за пакування - {{ $price->package }} грн.</p>
                                    <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ $price->rec_pair }} грн.</p>
                                @endforeach
                            @else
                                <p class="text-lg mb-2">Ціна не вказана</p>
                            @endif
{{--                            <a href="{{ route('product.', $product->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Купити</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
