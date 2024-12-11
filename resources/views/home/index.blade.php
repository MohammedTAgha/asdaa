
@extends('dashboard')
@section('title','الرئيسية')
@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
    <!-- Total Citizens Card -->
    <div class="bg-blue-50 border-l-4 border-blue-300 shadow-md rounded-lg p-6">
        <h3 class="text-blue-700 text-xl font-semibold">عدد الافراد الاجمالي</h3>
        <p class="text-5xl font-bold text-blue-800  mt-4" id="citizen-counter" data-target="45000">0</p>
    </div>

      <!-- Total Citizens Card -->
      <div class="bg-blue-50 border-l-4 border-blue-300 shadow-md rounded-lg p-6">
        <h3 class="text-blue-700 text-xl font-semibold">عدد المساعدات المقدمة للنازحين</h3>
        <p class="text-5xl font-bold text-blue-800  mt-4" id="citizen-counter" data-target="125">0</p>
    </div>
    
    <!-- Aids Distributed Card -->
    <div class="bg-blue-50 border-l-4 border-blue-300 shadow-md rounded-lg p-6">
        <h3  class="text-blue-700 text-xl font-semibold">عدد الطرود التي تم توزيعها </h3>
        <p class="text-5xl font-bold text-blue-800  mt-4" id="citizen-counter" data-target="12000">0</p>
    </div>
{{--     
    <!-- Packages Count Card -->
    <div class="bg-blue-50 border-l-4 border-blue-300 shadow-md rounded-lg p-6">
        <h3 class="text-blue-700 text-lg font-semibold">Packages Distributed</h3>
        <p class="text-3xl font-bold text-blue-800">8,200</p>
    </div>

    <div class="bg-orange-50 border-l-4 border-orange-300 shadow-md rounded-lg p-6">
        <h3 class="text-orange-700 text-lg font-semibold">Area Served (sq.km)</h3>
        <p class="text-3xl font-bold text-orange-800">3,500</p>
    </div>

    <!-- Students Enrolled Card -->
    <div class="bg-blue-50 border-l-4 border-blue-300 shadow-md rounded-lg p-6">
        <h3 class="text-blue-700 text-lg font-semibold">Students in School</h3>
        <p class="text-3xl font-bold text-blue-800">1,200</p>
    </div>

    <!-- Water Sublimation Per Day Card with Progress -->
    <div class="bg-orange-50 border-l-4 border-orange-300 shadow-md rounded-lg p-6">
        <h3 class="text-orange-700 text-lg font-semibold">Water Sublimation (L/day)</h3>
        <div class="flex items-center mt-2">
            <div class="w-full bg-orange-100 rounded-full h-4">
                <div class="bg-orange-300 h-4 rounded-full" style="width: 75%"></div>
            </div>
            <span class="ml-2 text-orange-700 font-bold">75%</span>
        </div>
    </div>

    <!-- Medical Centers Card -->
    <div class="bg-blue-50 border-l-4 border-blue-300 shadow-md rounded-lg p-6">
        <h3 class="text-blue-700 text-lg font-semibold">Medical Centers</h3>
        <p class="text-3xl font-bold text-blue-800">15</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
        <h2 class="text-gray-500 text-sm uppercase font-semibold">Total Citizens</h2>
        <div class="text-4xl font-bold text-gray-800 mt-2">
            <span id="citizen-counter" data-target="5000">0</span>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
        <h2 class="text-gray-500 text-sm uppercase font-semibold">Distributions Completed</h2>
        <div class="relative w-32 h-32 mx-auto mt-4">
            <svg class="w-full h-full">
                <circle cx="50%" cy="50%" r="48" stroke="#e2e8f0" stroke-width="8" fill="none" />
                <circle cx="50%" cy="50%" r="48" stroke="#4f46e5" stroke-width="8" fill="none"
                    stroke-dasharray="300" stroke-dashoffset="150" class="progress-circle" />
            </svg>
            <div class="absolute inset-0 flex items-center justify-center text-2xl font-semibold text-gray-800">
                <span id="percentage-counter">50</span>%
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
        <h2 class="text-gray-500 text-sm uppercase font-semibold">Distribution Goal Progress</h2>
        <div class="w-full bg-gray-200 rounded-full h-4 mt-4">
            <div class="bg-blue-500 h-4 rounded-full" style="width: 70%;"></div>
        </div>
        <p class="text-gray-600 mt-2 text-sm">70% completed</p>
    </div> --}}
    
</div>



<script>
    document.querySelectorAll('[data-target]').forEach(counter => {
    const target = +counter.getAttribute('data-target');
    const updateCounter = () => {
        const current = +counter.innerText;
        const increment = target / 200; // Adjust speed

        if (current < target) {
            counter.innerText = Math.ceil(current + increment);
            setTimeout(updateCounter, 10);
        } else {
            counter.innerText = target;
        }
    };
    updateCounter();
});

const circle = document.querySelector('.progress-circle');
const percentageCounter = document.getElementById('percentage-counter');
const percentage = 75; // Set desired percentage

let currentPercent = 0;
const updateProgress = () => {
    if (currentPercent < percentage) {
        currentPercent++;
        percentageCounter.innerText = currentPercent;
        circle.style.strokeDashoffset = 300 - (300 * currentPercent) / 100;
        setTimeout(updateProgress, 20); // Adjust speed
    }
};
updateProgress();

</script>

@endsection