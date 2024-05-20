<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-6 text-center">Рекомендовані продукти</h1>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if(!empty($recProducts))
                            @foreach($recProducts as $recProduct)
                                <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                                    @foreach($recProduct->product->getMedia($recProduct->product_id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <a href="{{ route('site.product.showOneProduct', $recProduct->product_id) }}"><img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4"></a>
                                        @endif
                                    @endforeach
                                    <div class="text-center">
                                        <a href="{{ route('site.product.showOneProduct', $recProduct->product_id) }}"><p class="text-xl font-semibold mb-2">{{ $recProduct->product->name }}</p></a>
                                        @if($recProduct->product->package)
                                            <p class="text-lg mb-2">В упаковці: {{ $recProduct->product->package->title }}</p>
                                        @endif
                                        <p class="text-lg mb-2">Колір, розмір, доступно:</p>
                                        @foreach($recProduct->product->productVariants()->get() as $productVariant)
                                            <ul class="text-lg mb-2">
                                                <li>{{ $productVariant->color->title }} - {{ $productVariant->size->title }} - {{ $productVariant->quantity }}</li>
                                            </ul>
                                        @endforeach

                                        @if($recProduct->product->price()->get())
                                            @foreach($recProduct->product->price()->get() as $price)
                                                <p class="text-lg mb-2">Ціна за шт - {{ $price->pair }} грн.</p>
                                                <p class="text-lg mb-2">Ціна за пакування - {{ $price->package }} грн.</p>
                                                <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ $price->rec_pair }} грн.</p>
                                            @endforeach
                                        @else
                                            <p class="text-lg mb-2">Ціна не вказана</p>
                                        @endif
                                        {{--                                        <a href="{{ route('product.', $product->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Купити</a>--}}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            Немає рекомендованих товарів
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
