@extends('dashboard')
@section('title', "بحث بالهوية")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>البحث برقم الهوية</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('records.search-by-ids') }}" method="POST">
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
                        <div class="mb-2 text-end">
                            <button class="btn btn-outline-success btn-sm" id="copyTableBtn">
                                نسخ الجدول
                            </button>
                        </div>
                        <table class="table table-striped table-hover table-bordered shadow-sm" id="resultsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>رقم الهوية</th>
                                    <th>الاسم</th>
                                    <th>الاسم الأول</th>
                                    <th>اسم الأب</th>
                                    <th>اسم الجد</th>
                                    <th>اسم العائلة</th>
                                    <th>الحالة</th>
                                    <th>الزوجة</th>
                                    <th>الزوجة</th>
                                    <th>المدينة</th>
                                    <th>العنوان</th>
                                    <th>الميلاد</th>
                                    <th>الجنس</th>
                                    <th>العمر</th>
                                    <th>الوفاة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $citizen)
                                <tr>
                                    <td>{{ $citizen->CI_ID_NUM }}</td>
                                    <td>{{ $citizen->full_name }}</td>
                                    <td>{{ $citizen->CI_FIRST_ARB }}</td>
                                    <td>{{ $citizen->CI_FATHER_ARB }}</td>
                                    <td>{{ $citizen->CI_GRAND_FATHER_ARB }}</td>
                                    <td>{{ $citizen->CI_FAMILY_ARB }}</td>
                                     <td>{{ $citizen->CI_PERSONAL_CD === "متزوج" ? ($citizen->getWife() ? $citizen->getWife()->CI_ID_NUM : '-') : '-' }}</td>
                                    <td>{{ $citizen->CI_PERSONAL_CD === "متزوج" ? ($citizen->getWife() ? $citizen->getWife()->full_name : '-') : '-' }}</td>
                                    <td>{{ $citizen->CI_PERSONAL_CD }}</td>
                                    <td>{{ $citizen->CITTTTY }}</td>
                                    <td>{{ $citizen->CITY }}</td>
                                    <td>{{ $citizen->CI_BIRTH_DT }}</td>
                                    <td>{{ $citizen->CI_SEX_CD }}</td>
                                    <td>{{ $citizen->age }}</td>
                                    <td>{{ $citizen->CI_DEAD_DT }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @push('scripts')
                        <script>
                        document.getElementById('copyTableBtn').addEventListener('click', function() {
                            const table = document.getElementById('resultsTable');
                            let rows = Array.from(table.rows);
                            let text = rows.map(row =>
                                Array.from(row.cells).map(cell => cell.innerText).join('\t')
                            ).join('\n');
                            // Copy to clipboard
                            navigator.clipboard.writeText(text).then(function() {
                                alert('تم نسخ الجدول! يمكنك لصقه في Excel.');
                            }, function() {
                                alert('حدث خطأ أثناء النسخ.');
                            });
                        });
                        </script>
                        @endpush
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
