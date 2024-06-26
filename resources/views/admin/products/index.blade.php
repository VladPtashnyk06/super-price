<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 114rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Продукти</h1>
                    <div class="text-center mb-4">
                        <a href="{{ route('product.create') }}" class="bg-green-600 hover:bg-green-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити продукт</a>
                    </div>
                    <div class="text-center mb-4">
                        <form action="{{ route('product.index') }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                            <div class="mb-4" style="flex: 1;">
                                <label for="code" class="block mb-2 font-bold">Код товару:</label>
                                <input type="text" name="code" id="code" value="{{ !empty(request()->input('code')) ? request()->input('code') : '' }}">
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="producer_id" class="block mb-2 font-bold">Виробники:</label>
                                <select name="producer_id" id="producer_id" class="w-full border rounded px-3 py-2">
                                    <option value="">Усі виробники</option>
                                    @foreach ($producers as $producer)
                                        <option value="{{ $producer->id }}" @if(request()->input('producer_id') == $producer->id) selected @endif>{{ $producer->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="category_id" class="block mb-2 font-bold">Категорії:</label>
                                <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2">
                                    <option value="">Усі категорії</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if(request()->input('category_id') == $category->id) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="product_promotion" class="block mb-2 font-bold">Акційні продукти:</label>
                                <select name="product_promotion" id="product_promotion" class="w-full border rounded px-3 py-2">
                                    <option value=""> Всі </option>
                                    <option value="1" @if(request()->input('product_promotion') == '1') selected @endif> Так </option>
                                    <option value="No" @if(request()->input('product_promotion') == 'No') selected @endif> Ні </option>
                                </select>
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="top_product" class="block mb-2 font-bold">Топ продукти:</label>
                                <select name="top_product" id="top_product" class="w-full border rounded px-3 py-2">
                                    <option value=""> Всі </option>
                                    <option value="1" @if(request()->input('top_product') == '1') selected @endif> Так </option>
                                    <option value="No" @if(request()->input('top_product') == 'No') selected @endif> Ні </option>
                                </select>
                            </div>
                            <div class="ml-2 mb-4">
                                <div class="mt-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                    <button type="button" onclick="window.location='{{ route('product.index') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Зображення</th>
                            <th class="p-2 text-lg">Код товару</th>
                            <th class="p-2 text-lg">Назва товару</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Колір</th>
                            <th class="p-2 text-lg">Розмір</th>
                            <th class="p-2 text-lg">Кількість товару</th>
                            <th class="p-2 text-lg">К-сть. в упакуванні</th>
                            <th class="p-2 text-lg">Виробник</th>
                            <th class="p-2 text-lg">Акційний</th>
                            <th class="p-2 text-lg">Топ продукт</th>
                            <th class="p-2 text-lg">Ціна за пару</th>
                            <th class="p-2 text-lg">Роздрібна ціна</th>
                            <th class="p-2 text-lg">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($product->getMedia($product->id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-16 w-auto rounded-md object-cover">
                                        @endif
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->code }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->category->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($product->productVariants()->get() as $productVariant)
                                        {{ $productVariant->color->title }}<br>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($product->productVariants()->get() as $productVariant)
                                        {{ $productVariant->size->title }}<br>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @foreach($product->productVariants()->get() as $productVariant)
                                        {{ $productVariant->quantity }}<br>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ isset($product->package->title) ? $product->package->title : 'Не вказано' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->producer->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->product_promotion == 0 ? 'Ні' : 'Так' }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $product->top_product == 0 ? 'Ні' : 'Так' }}</td>
                                @foreach($prices as $price)
                                    @if($price->product_id == $product->id)
                                        <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $price->pair }}</td>
                                    @endif
                                @endforeach
                                @foreach($prices as $price)
                                    @if($price->product_id == $product->id)
                                        <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $price->retail }}</td>
                                    @endif
                                @endforeach
                                <td class="px-6 py-4 text-right flex" style="vertical-align: top;">
                                    <div class="mr-4">
                                        <a href="{{ route('product.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 block" style="display: block;text-align: center;font-weight: bold;padding: 0.5rem 1rem;border-radius: 0.375rem;transition: background-color 0.3s ease-in-out;">
                                            Редагувати
                                        </a>
                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full" style="display: block;text-align: center;font-weight: bold;padding: 0.5rem 1rem;border-radius: 0.375rem;transition: background-color 0.3s ease-in-out;">
                                                Видалити
                                            </button>
                                        </form>
                                    </div>
                                    <div>
                                        <a href="{{ route('related-product.index', $product->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full mb-2" style="display: block;text-align: center;font-weight: bold;padding: 0.5rem 1rem;border-radius: 0.375rem;transition: background-color 0.3s ease-in-out;">
                                            Супутні
                                        </a>
                                        <a href="{{ route('product.comments', $product->id) }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full" style="display: block;text-align: center;font-weight: bold;padding: 0.5rem 1rem;border-radius: 0.375rem;transition: background-color 0.3s ease-in-out;">
                                            Коментарі
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
