<div id="addCitizensReportModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تقرير إضافة المواطنين</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>تمت إضافة {{ $report['added']['count'] }} مواطن:</h6>
                <ul>
                    @foreach($report['added']['citizens'] as $citizen)
                        <li>{{ $citizen['firstname'] }} {{ $citizen['lastname'] }}</li>
                    @endforeach
                </ul>
                
                <h6>{{ $report['existing']['count'] }} مواطن موجود مسبقاً:</h6>
                <ul>
                    @foreach($report['existing']['citizens'] as $citizen)
                        <li>{{ $citizen['firstname'] }} {{ $citizen['lastname'] }}</li>
                    @endforeach
                </ul>
                
                <h6>{{ $report['nonexistent']['count'] }} مواطن غير موجود في قاعدة البيانات:</h6>
                <ul>
                    @foreach($report['nonexistent']['citizens'] as $citizenId)
                        <li>معرف المواطن: {{ $citizenId }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>