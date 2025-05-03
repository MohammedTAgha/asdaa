@extends('dashboard')
@section('title', "المشاريع")

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Statistics Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Projects Card --}}
        <div class="bg-white rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-gray-500 text-sm">إجمالي المشاريع</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['distribution_statistics']['total_distributions'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-project-diagram text-2xl text-blue-600"></i>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-green-500">
                    <i class="fas fa-arrow-up ml-1"></i>
                    {{ $stats['distribution_statistics']['total_distributions']  ?? 0 }}
                </span>
                <span class="text-gray-500 mr-2">منذ الشهر الماضي</span>
            </div>
        </div>

        {{-- Beneficiaries Card --}}
        <div class="bg-white rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-gray-500 text-sm">المستفيدين</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['benefited_citizens_statistics']['benefited_citizens_count'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-users text-2xl text-green-600"></i>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-gray-500">متوسط المشاريع لكل مستفيد:</span>
                <span class="text-blue-600 font-medium mr-1">
                    {{ $stats['benefited_citizens_statistics']['average_distributions_per_person'] }}
                </span>
            </div>
        </div>

        {{-- Active Distributions Card --}}
        <div class="bg-white rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-gray-500 text-sm">المشاريع النشطة</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $activeDistributions ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-yellow-600">
                    {{ $pendingBeneficiaries ?? 0 }}
                </span>
                <span class="text-gray-500 mr-2">مستفيد في الانتظار</span>
            </div>
        </div>

        {{-- Coverage Card --}}
        <div class="bg-white rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-gray-500 text-sm">تغطية المناطق</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['regional_statistics']['benefited_regions_count'] }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-map-marker-alt text-2xl text-purple-600"></i>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-purple-600 h-2 rounded-full" 
                     style="width: {{ ($stats['regional_statistics']['benefited_regions_count'] / $totalRegions) * 100 }}%">
                </div>
            </div>
        </div>
    </div>

    {{-- Actions Bar --}}
    <div class="bg-white rounded-lg shadow-lg p-4 mb-8">
        <div class="flex flex-wrap items-center justify-between">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('distributions.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-plus ml-2"></i>
                    مشروع جديد
                </a>
                <div class="relative">
                    <input type="text" 
                           id="search" 
                           placeholder="البحث في المشاريع..." 
                           class="w-64 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <button class="text-gray-600 hover:text-gray-800 p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-filter"></i>
                </button>
                <a href="{{ route('distributions.exportDistributionStatistics') }}" 
                   class="text-gray-600 hover:text-gray-800 p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Projects Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @foreach ($distributions as $distribution)
        @include('components.distribution-card', ['distribution' => $distribution])
    @endforeach
       
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    document.getElementById('search').addEventListener('keyup', function(e) {
        let searchText = e.target.value.toLowerCase();
        document.querySelectorAll('.grid > div').forEach(card => {
            let projectName = card.querySelector('h3').textContent.toLowerCase();
            let projectCategory = card.querySelector('.text-gray-600').textContent.toLowerCase();
            
            if(projectName.includes(searchText) || projectCategory.includes(searchText)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Animation on scroll
    function animateOnScroll() {
        const cards = document.querySelectorAll('.grid > div');
        cards.forEach((card, index) => {
            card.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1}s forwards`;
        });
    }

    document.addEventListener('DOMContentLoaded', animateOnScroll);
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush
@endsection
