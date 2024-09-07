@props(['distributionId' => null,'distribution'=>null])

<p>{{$distributionId}}<p>
<div class="modal fade" id="AddCitizensIdListModal" aria-labelledby="AddCitizensIdListModalLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddCitizensIdListModalLabel">إضافة المواطنين إلى كشف التوزيع</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST"
                    action="{{ route('distributions.addCitizens', ['distributionId' => $distributionId ?? null]) }}">
                    @csrf

                    <div class="form-group">
                        <label for="citizen-ids">أدخل أرقام الهوية الوطنية للمواطنين (كل رقم في سطر)</label>
                        <textarea class="form-control" id="citizen-ids" name="citizens" rows="6"
                            placeholder="......&#10;.....&#10;..."></textarea>
                    </div>
                    @if ($distribution->id )
                    <input type="text" id="distributionId" name="distributionId" value="{{ $distribution->id   }}" />
                     
                    @else
                    no dist {{$distribution->id}}
                    <div class="form-group">
                        <label for="distributionId">رقم كشف التوزيع</label>
                        <input type="text" class="form-control" id="distributionId" name="distributionId"
                            value="{{ $distributionId  }}" readonly>
                    </div>
                    @endif
                   

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">إضافة المواطنين</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
