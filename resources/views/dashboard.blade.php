<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <!-- Purchased Services Table -->
            <div class="mt-8">
                <h3 class="mb-4" style="color:#F56289;font-weight:700;">Your Purchased Services</h3>
                <div class="card shadow-sm">
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @php
                            $purchasedServices = \App\Models\PurchasedService::where('user_id', auth()->id())->get();
                        @endphp
                        @if($purchasedServices->count())
                            <ul class="list-group list-group-flush">
                                @foreach($purchasedServices as $service)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <strong>{{ $service->service_name }}</strong><br>
                                            <small>{{ $service->description }}</small>
                                        </span>
                                        <span class="badge bg-pink text-white">{{ $service->status }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center text-muted py-5">No purchased services found.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
