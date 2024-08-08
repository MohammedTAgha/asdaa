<div id="addCitizensReportModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header  text-white">
                <h5 class="modal-title">تقرير إضافة المواطنين</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>تمت إضافة {{ $report['added']['count'] }} مواطن:</h6>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>المعرف</th>
                            <th>الاسم</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report['added']['citizens'] as $citizen)
                        <tr>
                            <td>{{ $citizen['id'] }}</td>
                            <td>{{ $citizen['firstname'] }} {{ $citizen['lastname'] }}</td>
                            <td>تمت الإضافة</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <h6>{{ $report['existing']['count'] }} مواطن موجود مسبقاً:</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>المعرف</th>
                            <th>الاسم</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report['existing']['citizens'] as $citizenId)
                        <tr>
                            <td>{{ $citizenId }}</td>
                            <td>غير محدد</td>
                            <td>موجود مسبقاً</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($report['updated'] || $report['updated']['count'] ==0 )
                <h6>{{ $report['updated']['count'] }} مواطن محدث في قاعدة البيانات:</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>المعرف</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($report['updated']['citizens'] as $citizenId)
                        <tr>
                            <td>{{ $citizenId }}</td>
                            <td>غير موجود</td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
                @endif

                <h6>{{ $report['nonexistent']['count'] }} مواطن غير موجود في قاعدة البيانات:</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>المعرف</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($report['nonexistent']['citizens'] as $citizenId)
                        <tr>
                            <td>{{ $citizenId }}</td>
                            <td>غير موجود</td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                {{-- <a href="{{ route('report.export', ['report' => base64_encode(serialize($report))]) }}" class="btn btn-success">تصدير إلى Excel</a>            </div> --}}
        </div>
    </div>
</div>