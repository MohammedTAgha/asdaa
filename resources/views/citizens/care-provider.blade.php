@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">{{ __('تعيين مقدم الرعاية') }}</h1>
        <a href="{{ route('citizens.show', $citizen) }}" class="btn-secondary">{{ __('عودة') }}</a>
    </div>

    @if($familyMembers->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4">
            {{ __('لا يوجد أفراد في العائلة يمكن تعيينهم كمقدم رعاية') }}
        </div>
    @else
        <div class="bg-white shadow-sm rounded-lg">
            <form action="{{ route('citizens.update-care-provider', $citizen) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="care_provider_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('اختر مقدم الرعاية') }}</label>
                    <select name="care_provider_id" id="care_provider_id" class="form-select w-full">
                        <option value="">{{ __('اختر فردًا من العائلة') }}</option>
                        @foreach($familyMembers as $member)
                            <option value="{{ $member->id }}" @selected($citizen->care_provider_id == $member->id)>
                                {{ $member->firstname }} {{ $member->secondname }} {{ $member->lastname }} ({{ __($member->relationship) }})
                            </option>
                        @endforeach
                    </select>
                    @error('care_provider_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn-primary">{{ __('حفظ التغييرات') }}</button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
