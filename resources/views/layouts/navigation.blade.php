<nav x-data="{ open: false }" class="bg-gray-800 border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('site.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex ml-4">
                    @if(Auth::user() && Auth::user()->role == 'admin')
                        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
                            {{ __('Користувачі') }}
                        </x-nav-link>
                        <x-nav-link :href="route('product.index')" :active="request()->routeIs('product.index')">
                            {{ __('Продукт') }}
                        </x-nav-link>
                        <x-nav-link :href="route('promotional.index')" :active="request()->routeIs('promotional.index')">
                            {{ __('Акційній товари') }}
                        </x-nav-link>
                        <x-nav-link :href="route('order.index')" :active="request()->routeIs('order.index')">
                            {{ __('Замовлення') }}
                        </x-nav-link>
                        <x-nav-link :href="route('promoCode.index')" :active="request()->routeIs('promoCode.index')">
                            {{ __('Промокоди') }}
                        </x-nav-link>
                        <x-nav-link :href="route('blog.index')" :active="request()->routeIs('blog.index')">
                            {{ __('Блог') }}
                        </x-nav-link>
                        <x-nav-link :href="route('comment.index')" :active="request()->routeIs('comment.index')">
                            {{ __('Коментар до сайту') }}
                        </x-nav-link>
                        <x-nav-link :href="route('product.ratingProduct')" :active="request()->routeIs('product.ratingProduct')">
                            {{ __('Рейтинги товарів') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('site.catalog.index')" :active="request()->routeIs('site.catalog.index')">
                            {{ __('Продукти') }}
                        </x-nav-link>
                        <x-nav-link :href="route('site.product.likedProducts')" :active="request()->routeIs('site.product.likedProducts')">
                            {{ __('Вподобані продукти') }}
                        </x-nav-link>
                        @if(Auth::user() && Auth::user()->role == 'operator')
                            <x-nav-link :href="route('operator.order.index')" :active="request()->routeIs('operator.order.index')">
                                {{ __('Замовлення') }}
                            </x-nav-link>
                        @else
                            @if(Auth::user() && Auth::user()->role == 'user')
                                <x-nav-link :href="route('site.order.index')" :active="request()->routeIs('site.order.index')">
                                    {{ __('Всі мої замовлення') }}
                                </x-nav-link>
                            @endif
                        @endif
                    @endif
                </div>
            </div>

            @if(Auth::user())
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Профіль') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Вийти') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    @if(Auth::user()->role == 'user')
                        <div>
                            <p class="text-gray-400">
                                Бали: {{ Auth::user()->points }} {{ session()->get('currency') }}
                            </p>
                        </div>
                    @endif
                </div>
            @else
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Увійти</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">Зареєструватися</a>
                    @endif
                </div>
            @endif

            <div class="relative flex items-center ml-6 w-full" style="max-width: 350px;">
                <div class="flex-grow">
                    <input type="text" class="border rounded w-full px-4 py-2 shadow-sm focus:ring focus:ring-indigo-300 focus:border-indigo-300" name="search" id="search" placeholder="Пошук товарів...">
                    <ul id="search-results" class="absolute bg-white border rounded mt-1 w-full z-10 hidden shadow-lg max-h-60 overflow-y-auto">
                        <!-- Результати пошуку будуть тут -->
                    </ul>
                </div>
            </div>

            <!-- Currency Selector and Cart -->
            @if(!Auth::user() || Auth::user()->role == 'user')
                <div class="flex items-center ml-4">
                    <form action="{{ route('change-currency') }}" method="post" id="currency-form" class="flex items-center mr-4">
                        @csrf
                        <select name="currency" id="currency-select" class="rounded-l-md border border-gray-300 focus:border-blue-500 focus:outline-none py-2 px-4 bg-white text-sm w-20" style="color: black">
                            <option value="UAH" @if(session('currency') == 'UAH') selected @endif>UAH</option>
                            <option value="USD" @if(session('currency') == 'USD') selected @endif>USD</option>
                            <option value="EUR" @if(session('currency') == 'EUR') selected @endif>EUR</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm">Змінити</button>
                    </form>

                    <!-- Cart Icon -->
                    <div class="relative ml-4">
                        <a href="{{ route('cart') }}" class="text-gray-600 focus:outline-none transition duration-150 ease-in-out">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="30px" height="30px" viewBox="0 0 512 512" xml:space="preserve" style="fill: #FFFFFF;">
                                <path d="M420.25,64l54.844,384H36.875L91.75,64H420.25 M448,32H64L0,480h512L448,32L448,32z"/>
                                <path d="M384,128c0-17.688-14.312-32-32-32s-32,14.313-32,32c0,10.938,5.844,20.125,14.25,25.906
                                        C326.5,211.375,293.844,256,256,256c-37.813,0-70.5-44.625-78.25-102.094C186.156,148.125,192,138.938,192,128
                                        c0-17.688-14.313-32-32-32s-32,14.313-32,32c0,12.563,7.438,23.188,17.938,28.406C155.125,232.063,200.031,288,256,288
                                        s100.875-55.938,110.062-131.594C376.594,151.188,384,140.563,384,128z"/>
                        </svg>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        @if(Auth::user())
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Профіль') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Вийти') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const resultsContainer = document.getElementById('search-results');

        searchInput.addEventListener('input', function() {
            let query = this.value;

            if (query.length > 0) {
                fetch(`/search?query=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';

                        data.forEach(product => {
                            let li = document.createElement('li');
                            li.classList.add('p-4', 'border-b', 'hover:bg-gray-100', 'flex', 'items-center');

                            let productLink = document.createElement('a');
                            productLink.href = `/product/${product.id}`;
                            productLink.classList.add('flex', 'items-center', 'w-full');

                            let productImage = document.createElement('img');
                            productImage.src = product.image;
                            productImage.alt = product.alt;
                            productImage.classList.add('h-16', 'w-16', 'rounded-md', 'object-cover', 'mr-4');
                            productLink.appendChild(productImage);

                            let productInfo = document.createElement('div');
                            productInfo.classList.add('flex', 'flex-col');

                            let productTitle = document.createElement('p');
                            productTitle.textContent = product.title;
                            productTitle.classList.add('text-gray-800', 'font-semibold', 'text-sm', 'mb-1');
                            productInfo.appendChild(productTitle);

                            let productPrice = document.createElement('p');
                            productPrice.textContent = `${product.price} ${product.currency}`;
                            productPrice.classList.add('text-gray-600', 'text-sm');
                            productInfo.appendChild(productPrice);

                            productLink.appendChild(productInfo);
                            li.appendChild(productLink);
                            resultsContainer.appendChild(li);
                        });

                        resultsContainer.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                resultsContainer.innerHTML = '';
                resultsContainer.classList.add('hidden');
            }
        });

        searchInput.addEventListener('focus', function() {
            let query = this.value;

            if (query.length >= 0) {
                fetch(`/search?query=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';

                        data.forEach(product => {
                            let li = document.createElement('li');
                            li.classList.add('p-4', 'border-b', 'hover:bg-gray-100', 'flex', 'items-center');

                            let productLink = document.createElement('a');
                            productLink.href = `/product/${product.id}`;
                            productLink.classList.add('flex', 'items-center', 'w-full');

                            let productImage = document.createElement('img');
                            productImage.src = product.image;
                            productImage.alt = product.alt;
                            productImage.classList.add('h-16', 'w-16', 'rounded-md', 'object-cover', 'mr-4');
                            productLink.appendChild(productImage);

                            let productInfo = document.createElement('div');
                            productInfo.classList.add('flex', 'flex-col');

                            let productTitle = document.createElement('p');
                            productTitle.textContent = product.title;
                            productTitle.classList.add('text-gray-800', 'font-semibold', 'text-sm', 'mb-1');
                            productInfo.appendChild(productTitle);

                            let productPrice = document.createElement('p');
                            productPrice.textContent = `${product.price} ${product.currency}`;
                            productPrice.classList.add('text-gray-600', 'text-sm');
                            productInfo.appendChild(productPrice);

                            productLink.appendChild(productInfo);
                            li.appendChild(productLink);
                            resultsContainer.appendChild(li);
                        });

                        resultsContainer.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                resultsContainer.innerHTML = '';
                resultsContainer.classList.add('hidden');
            }
        });

        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
                resultsContainer.classList.add('hidden');
            }
        });
    });
</script>
