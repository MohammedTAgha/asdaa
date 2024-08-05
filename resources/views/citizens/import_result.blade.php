@extends('dashboard')

@section('content')
<div class="container">
    <h1>Import Results</h1>

    <!-- Modal -->
    <div class="modal fade" id="importResultModal" tabindex="-1" aria-labelledby="importResultModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importResultModalLabel">نتائج استيراد الكشف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <p><strong>{{ $message }}</strong></p>
                        <p>المضافة بنجاح: {{ $addedCount }} | فشل في: {{ $failedCount }}</p>
                    </div>
                     
                    @if($failedCount > 0)
                        <h6>الاسماء التي بها مشاكل:</h6>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>الهوية</th>
                                        <th>الاسم</th>
                                        <th>errors</th>
                                        <th>الخلل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($failedRows as $row)
                                     
                                    <tr>
                                        <td>{{ $row['id']}}</td>
                                        <td>{{ $row['firstname']}} {{ $row['lastname']}}</td>
                                        <td>{{ $row['errors']}}</td>
                                        <td>{{ $row['values']}}</td>
                                        
                                         
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($failedExcelPath)
                            <a href="{{ $failedExcelPath }}" class="btn btn-secondary" download>تحميل الكشف</a>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    var myModal = new bootstrap.Modal(document.getElementById('importResultModal'));
    myModal.show();
});
</script>
@endsection