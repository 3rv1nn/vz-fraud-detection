@vite('resources/js/fraud-scan-history/fraud-scan-history.js')
<x-layout>
    <x-slot name="sidebar">
        <div class="col-span-1 border-r-1 border-t border-gray-950/5 bg-white">
            <div class="mt-2 ml-4 mb-2 gap-2 flex items-center">
                <a class="text-xl" href="/"><-</a>
                <h3 class="text-gray-600 font-bold underline underline-offset-1">Fraud Scan History</h3>
            </div>
            <ol class="fraud-scan-list h-100 ml-4 overflow-auto">
                @forelse ($fraudScans as $fraudScan)
                    <li class="fraud-scan-item text-gray-600 hover:text-sky-500 cursor-pointer" data-customers="{{ $fraudScan->customers }}">Scan performed <span class="font-bold">{{ $fraudScan->created_at->diffForHumans() }}</span></li>
                @empty
                    <p class="no-fraud-scans-text text-gray-600">No fraud scans have yet been performed</p>
                @endforelse
            </ol>
        </div>
    </x-slot>
    <div class="customers-container">
        <h2 class="mt-4 ml-4 font-bold text-xl">Results</h2>
        <div class="customers-card-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @include("/components/customer-card")
        </div>
    </div>
</x-layout>