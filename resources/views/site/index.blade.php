<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @include('site.product.include-views.rec-products')
                @include('site.product.include-views.viewed-products')
                @include('site.product.include-views.blogs')
            </div>
        </div>
    </div>
</x-app-layout>