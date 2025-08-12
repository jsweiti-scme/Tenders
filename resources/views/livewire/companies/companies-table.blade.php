<div>
    @include('livewire.companies.add-company')
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr>
                                <td>{{ $company->CompanyInfo->id }}</td>
                                <td>{{ $company->CompanyInfo->company_name }}</td>
                                <td>{{ $company->CompanyInfo->mobile_number }}</td>
                                <td>{{ $company->CompanyInfo->phone_number }}</td>
                                <td>{{ $company->CompanyInfo->City->city}} - {{$company->address}}</td>
                                <td>{{ $company->CompanyInfo->license_worker_number }}</td>
                                <td class="form-switch">
                                    @if ($company->status == 1)
                                        <input class="form-check-input" type="checkbox" role="switch" wire:confirm="هل انت متأكد من حظر هذا الحساب ؟ لن يتمكن من تسجيل الدخول" wire:click="active({{ $company->id }})" wire:model="editMode" id="editModeToggle" checked> 
                                    @else
                                        <input class="form-check-input" type="checkbox" role="switch" wire:confirm="هل انت متأكد من الغاء حظر هذا الحساب ؟ سوف يتمكن من تسجيل الدخول" wire:click="active({{ $company->id }})" wire:model="editMode" id="editModeToggle" > 
                                    @endif
                                    @include('livewire.companies.company-details')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$companies->links()}}
        </div>
    </div>
</div>