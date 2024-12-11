
@extends('dashboard')
@section('title','اجراءات')
@section('content')

@props(['distributionId' => null,'distribution'=>null])

<p>{{$distributionId}}<p>
    <div class="w-90">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddCitizensIdListModalLabel">إضافة المواطنين إلى كشف التوزيع</h5>
                 
            </div>
            <div class="modal-body">
                {{-- <form id="citizen-form" method="POST" action="{{ route('distributions.addCitizens', ['distributionId' => $distributionId ?? null]) }}">
                    @csrf --}}
                
                    <div class="form-group">
                        <label for="citizen-ids">أدخل أرقام الهوية الوطنية للمواطنين (كل رقم في سطر)</label>
                        <textarea class="form-control" id="citizen-ids" name="citizens" rows="6" placeholder="......&#10;.....&#10;..."></textarea>
                    </div>
                
                    {{-- @if (isset($distribution))
                        <input type="hidden" id="distributionId" name="distributionId" value="{{ $distribution->id }}" />
                    @else
                        <div class="form-group">
                            <label for="distributionId">رقم كشف التوزيع</label>
                            <input type="text" class="form-control" id="distributionId" name="distributionId" value="{{ $distributionId }}" readonly>
                        </div>
                    @endif --}}
                
                    <div class="modal-footer" style="direction: rtl">
                       
                        <button type="submit" class="btn btn-primary">فحص ارقام هوايا  </button>
                        <button type="submit" class="btn btn-danger">حذف ارقام هوايا</button>
                        <button type="submit" class="btn btn-primary"> تغيير المندوب </button>
                        
                        <button type="submit" class="btn btn-primary"> تصدير البيانات </button>
                        <button type="submit" class="btn btn-primary"> تفعيل </button>
                        <button type="submit" class="btn btn-primary"> الغاء تفعيل </button>
                        <button type="submit" class="btn btn-primary"> فحص الكابونات </button>
                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>

</div>


@push('scripts')
<script>
     document.getElementById('citizen-ids').addEventListener('blur', function(event) {
        const textarea = document.getElementById('citizen-ids');
        const citizenIds = textarea.value.trim().split(/\r?\n/); // Split by new lines
        // Join the IDs into a comma-separated string
        const formattedIds = citizenIds.join(',');

        // Update the citizens input value to the comma-separated string
        textarea.value = formattedIds;
    });
</script>
@endpush

@endsection