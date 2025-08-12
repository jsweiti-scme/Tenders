<div>
    <button type="button" class="btn btn-custome" data-mdb-toggle="modal" data-mdb-target="#CompanyDetails{{$company->id}}">
       تفاصيل الشركة
    </button>
    <style>
    .flex-row {
        display: flex;
    }
    .flex-th {
        flex: 1;
    }
    .flex-td {
        flex: 4;
    }
    </style>
        <div class="modal fade" id="CompanyDetails{{$company->id}}" tabindex="-1" aria-labelledby="CompanyDetails{{$company->id}}" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CompanyDetails{{$company->id}}">تفاصيل الشركة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="datatable" class="table table-bordered">
                                            <tbody>
                                                <tr class="flex-row">
                                                    <th class="flex-th">الرقم التعريفي</th>
                                                    <td class="flex-td">{{ $company->id }}</td>
                                                </tr>
                                                <tr class="flex-row">
                                                    <th class="flex-th">اسم الشركة</th>
                                                    <td class="flex-td">{{ $company->CompanyInfo->company_name }}</td>
                                                </tr>
                                                <tr class="flex-row">
                                                    <th class="flex-th">رقم الجوال</th>
                                                    <td class="flex-td">{{ $company->CompanyInfo->mobile_number }}</td>
                                                </tr>
                                                <tr class="flex-row">
                                                    <th class="flex-th">رقم الارضي</th>
                                                    <td class="flex-td">{{ $company->CompanyInfo->phone_number }}</td>
                                                </tr>
                                                <tr class="flex-row">
                                                    <th class="flex-th">العنوان</th>
                                                    <td class="flex-td">{{ $company->CompanyInfo->City->city}} - {{$company->address}}</td>
                                                </tr>
                                                <tr class="flex-row">
                                                    <th class="flex-th">رقم المشتغل المرخص</th>
                                                    <td class="flex-td">{{ $company->CompanyInfo->license_worker_number }}</td>
                                                </tr>
                                                <tr class="flex-row">
                                                    <th class="flex-th">شهادة المشتغل المرخص</th>
                                                    <td class="flex-td">
                                                        <img src="{{ Storage::url($company->CompanyInfo->license_worker_certification) }}" alt="لا يوجد صورة">
                                                    </td>
                                                </tr>
                                                <tr class="flex-row">
                                                    <th class="flex-th">شهادة خصم مصدر</th>
                                                    <td class="flex-td">
                                                        <img src="{{ Storage::url($company->CompanyInfo->discount_certification_issuer) }}" alt="لا يوجد صورة">
                                                    </td>
                                                </tr>
                                                <tr class="flex-row">
                                                    <th class="flex-th">تاريخ نهاية خصم المصدر </th>
                                                    <td class="flex-td">
                                                    @if ($company->CompanyInfo->discount_certification_issuer_expired_date)
                                                    {{ $company->CompanyInfo->discount_certification_issuer_expired_date }}
                                                    @else
                                                    غير محدد
                                                    @endif
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    