@extends('dashboard')
@section('title', "بحث childs")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>البحث برقم الهوية</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('records.search-childs') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="ids">ادخل الهويات (كل هوية في سطر جديد)</label>
                            <textarea name="ids" id="ids" class="form-control mb-3" rows="5" style="direction: ltr;">{{ session('search_ids') }}</textarea>
                            <div class="text-start">
                                <button type="button" class="btn btn-secondary" id="validateIdsBtn">التحقق من الهويات</button>
                                <button type="submit" class="btn btn-primary">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($results))
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>نتائج البحث</h3>
                </div>
                <div class="card-body">
                    @if(count($results) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered shadow-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>رقم الهوية</th>
                                    <th>الاسم</th>
                                    
                                    <th>الاب</th>
                                    <th>الاب</th>
                                    <th>الميلاد</th>
                                    <th>العمر</th>
                                    <th>الجنس</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $citizen)

                                @if (!empty($citizen->getChilds()))
                                    @foreach ($citizen->getChilds() as $child )
                                    <tr>
                                        <td>{{ $child->CI_ID_NUM }}</td>
                                        <td>{{ $child->full_name }}</td>
                                        <td>{{ $citizen->CI_ID_NUM }}</td>
                                        <td>{{ $citizen->full_name }}</td>
                                        <td>{{ $child->CI_BIRTH_DT }}</td>
                                        <td>{{ $child->age }}</td>

                                        <td>{{ $child->CI_SEX_CD }}</td>
                                      
                                    </tr>
                                    @endforeach
                                @endif
                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>لم يتم العثور على نتائج.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.getElementById('validateIdsBtn').addEventListener('click', function() {
    const textarea = document.getElementById('ids');
    const ids = textarea.value.split(/[\n,]/).map(id => id.trim()).filter(id => id);
    const validIds = [];
    const invalidIds = [];

    ids.forEach(id => {
        if (validatePalestinianID(id)) {
            validIds.push(id);
        } else {
            invalidIds.push(id);
        }
    });

    let message = '';
    if (validIds.length > 0) {
        message += `الهويات الصحيحة (${validIds.length}):\n${validIds.join('\n')}\n\n`;
    }
    if (invalidIds.length > 0) {
        message += `الهويات غير الصحيحة (${invalidIds.length}):\n${invalidIds.join('\n')}`;
    }

    alert(message || 'لا يوجد هويات للتحقق منها');
});

function validatePalestinianID(id) {
    if (id.length === 9 && /^\d{9}$/.test(id)) {
        let sum = 0;
        for (let i = 0; i < 8; i++) {
            let digit = parseInt(id[i]);
            if (i % 2 === 0) {
                sum += digit;
            } else {
                let doubled = digit * 2;
                sum += doubled > 9 ? doubled - 9 : doubled;
            }
        }
        let checkDigit = (10 - (sum % 10)) % 10;
        return checkDigit === parseInt(id[8]);
    }
    return false;
}
</script>
@endpush
@endsection
