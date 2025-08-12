<div>
    <button type="button" class="btn btn-custome" data-mdb-toggle="modal" data-mdb-target="#addCompanyModal">
        إضافة شركة
    </button>

    <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCompanyModalLabel">إضافة شركة</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="create">
                        <div class="mb-3">
                            <label for="name" class="form-label">البريد الإلكتروني</label>
                            <input class="form-control" type="email" placeholder="البريد الإلكتروني" wire:model="newCompany.email" required>
                            @error('newCompany.email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">كلمة المرور</label>
                            <input class="form-control" type="password" placeholder="كلمة المرور" wire:model="newCompany.password"  required>
                            @error('newCompany.password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">تأكيد كلمة المرور</label>
                            <input class="form-control" type="password" placeholder="تأكيد كلمة المرور" wire:model="newCompany.password_confirmation" required>
                            @error('newCompany.password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الشركة</label>
                            <input class="form-control" type="text" placeholder="اسم الشركة" wire:model="newCompany.company_name">
                            @error('newCompany.company_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">رقم الهاتف</label>
                            <input class="form-control" type="tel" placeholder="رقم الهاتف" wire:model="newCompany.phone_number">
                            @error('newCompany.phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">رقم الجوال</label>
                            <input class="form-control" type="tel" placeholder="رقم الجوال" wire:model="newCompany.mobile_number">
                            @error('newCompany.mobile_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">المدينة</label>
                            <select class="form-select" id="city_id" wire:model="newCompany.city_id">
                                <option value="null" disabled selected>المدينة</option>
                                @foreach ($cities as $city)
                                    <option value="{{$city->id}}">{{$city->city}}</option>
                                @endforeach
                            </select>
                            @error('newCompany.city_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">العنوان</label>
                            <input class="form-control" type="text" placeholder="العنوان" wire:model="newCompany.address" >
                            @error('newCompany.address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="license_worker_number" class="form-label">رقم المشتغل المرخص</label>
                            <input class="form-control" type="number" placeholder="رقم المشتغل المرخص" wire:model="newCompany.license_worker_number" >
                            @error('newCompany.license_worker_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="license_worker_certification" class="form-label">شهادة المشتغل المرخص</label>
                            <input class="form-control" type="file" placeholder="شهادة المشتغل المرخص" wire:model="newCompany.license_worker_certification" >
                            @error('newCompany.license_worker_certification') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="discount_certification_issuer" class="form-label">شهادة  خصم المصدر</label>
                            <input class="form-control" type="file" placeholder="شهادة خصم المصدر" wire:model="newCompany.discount_certification_issuer"  accept=".pdf,image/jpeg,image/jpg,image/png">
                            @error('newCompany.discount_certification_issuer') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="discount_certification_issuer_expired_date" class="form-label">تاريخ انتهاء شهادة  خصم المصدر</label>
                            <input class="form-control" type="date" placeholder="تاريخ انتهاء شهادة خصم المصدر" wire:model="newCompany.discount_certification_issuer_expired_date"  accept=".pdf,image/jpeg,image/jpg,image/png">
                            @error('newCompany.discount_certification_issuer_expired_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-success">إضافة</button>
                        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal" >إغلاق</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
