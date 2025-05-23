@extends('dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Category Details</h1>
            <div>
                <a href="{{ route('categories.edit', $category) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit Category
                </a>
                <a href="{{ route('categories.add-citizens', $category) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mr-2">
                    Add Citizens
                </a>
                <a href="{{ route('categories.export', $category) }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded mr-2">
                    Export to Excel
                </a>
                <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Name</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->name }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>

                    @if($category->description)
                    <div class="col-span-2">
                        <h3 class="text-sm font-medium text-gray-500">Description</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->description }}</p>
                    </div>
                    @endif

                    @if($category->notes)
                    <div class="col-span-2">
                        <h3 class="text-sm font-medium text-gray-500">Notes</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->notes }}</p>
                    </div>
                    @endif

                    @if($category->amount)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Amount</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->amount }}</p>
                    </div>
                    @endif

                    @if($category->size)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Size</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->size }}</p>
                    </div>
                    @endif

                    @if($category->date)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Date</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->date->format('Y-m-d') }}</p>
                    </div>
                    @endif

                    @if($category->color)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Color</h3>
                        <div class="mt-1 flex items-center">
                            <div class="h-6 w-6 rounded mr-2" style="background-color: {{ $category->color }}"></div>
                            <span class="text-sm text-gray-900">{{ $category->color }}</span>
                        </div>
                    </div>
                    @endif

                    @if($category->property1)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Property 1</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->property1 }}</p>
                    </div>
                    @endif

                    @if($category->property2)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Property 2</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->property2 }}</p>
                    </div>
                    @endif

                    @if($category->property3)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Property 3</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->property3 }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($category->familyMembers->count() > 0)
        <div class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Associated Family Members</h2>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relationship</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Added Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($category->familyMembers as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $member->firstname }} {{ $member->lastname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $member->relationship }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $member->pivot->created_at->format('Y-m-d') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
