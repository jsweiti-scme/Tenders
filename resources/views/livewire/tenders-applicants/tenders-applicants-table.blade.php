<div>
    <div class="card-body">
        <div class="table-rep-plugin">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>الرقم التعريفي</th>
                            <th>اسم الشركة</th>
                            <th>رقم الجوال</th>
                            <th>رقم ارضي</th>
                            <th>العنوان</th>
                            <th>رقم المشتغل</th>
                            <th>الإجراءات</th>
                            <th>ارساء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applicants as $applicant)
                            <tr>
                                <td>{{ $applicant->CompanyInfo->id }}</td>
                                <td>{{ $applicant->CompanyInfo->company_name }}</td>
                                <td>{{ $applicant->CompanyInfo->mobile_number }}</td>
                                <td>{{ $applicant->CompanyInfo->phone_number }}</td>
                                <td>{{ $applicant->CompanyInfo->City->city }} - {{ $applicant->CompanyInfo->address }}
                                </td>
                                <td>{{ $applicant->CompanyInfo->license_worker_number }}</td>
                                <td>@include('livewire.tenders-applicants.applicant-details')</td>
                                <td>
                                    @if (auth()->user()->type == 1 && $tender->winner_id == null)
                                        <button wire:click="SetWinner({{ $applicant->id }})" class="btn btn-custome"
                                            wire:confirm="هل انت متأكد من ارساء العطاء على هذه الشركة ؟ لا يمكن تغيير الحالة فيما بعد">ارساء
                                            العطاء</button>
                                    @elseif($tender->winner_id == null)
                                        لم يتم ارساء العطاء
                                    @elseif($applicant->id == $tender->winner_id)
                                        تم الارساء
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $applicants->links() }}
        </div>
    </div>
</div>
