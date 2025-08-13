<div>
    <button type="button" class="btn btn-custome" data-mdb-toggle="modal" data-mdb-target="#addTenderModal">
        إضافة عطاء
    </button>

    <div class="modal fade" id="addTenderModal" tabindex="-1" aria-labelledby="addTenderModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTenderModalLabel">إضافة عطاء</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="create">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">معلومات العطاء الأساسية</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">العنوان</label>
                                <input type="text" class="form-control" id="title" wire:model="newTender.title"
                                    required>
                                @error('newTender.title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">الوصف</label>
                                <textarea class="form-control" id="description" wire:model="newTender.description" required rows="3"></textarea>
                                @error('newTender.description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">تاريخ البداية</label>
                                <input type="datetime-local" class="form-control" id="start_date"
                                    wire:model="newTender.start_date" required>
                                @error('newTender.start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">تاريخ النهاية</label>
                                <input type="datetime-local" class="form-control" id="end_date"
                                    wire:model="newTender.end_date" required>
                                @error('newTender.end_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">بنود العطاء</h6>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-success me-2" wire:click="addNewItem">
                                        <i class="fas fa-plus"></i> إضافة بند جديد
                                    </button>
                                    <button type="button" class="btn btn-info" data-mdb-toggle="modal"
                                        data-mdb-target="#selectItemModal">
                                        <i class="fas fa-search"></i> اختيار من البنود الموجودة
                                    </button>
                                </div>

                                @if (count($selectedItems) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>اسم البند</th>
                                                    <th>الوصف</th>
                                                    <th>وحدة القياس</th>
                                                    <th>الكمية</th>
                                                    <th>الإجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($selectedItems as $index => $item)
                                                    <tr>
                                                        <td>
                                                            @if ($item['is_new'])
                                                                <input type="text" class="form-control"
                                                                    wire:model="selectedItems.{{ $index }}.name"
                                                                    placeholder="اسم البند" required>
                                                            @else
                                                                {{ $item['name'] }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($item['is_new'])
                                                                <textarea class="form-control" wire:model="selectedItems.{{ $index }}.description" placeholder="الوصف"
                                                                    rows="2"></textarea>
                                                            @else
                                                                {{ $item['description'] ?? 'لا يوجد وصف' }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($item['is_new'])
                                                                <input type="text" class="form-control"
                                                                    wire:model="selectedItems.{{ $index }}.unit"
                                                                    placeholder="وحدة القياس" required>
                                                            @else
                                                                {{ $item['unit'] }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" min="1"
                                                                class="form-control"
                                                                wire:model="selectedItems.{{ $index }}.quantity"
                                                                placeholder="الكمية" required>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                wire:click="removeItem({{ $index }})">
                                                                <i class="fas fa-trash"></i> حذف
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info text-center">
                                        <i class="fas fa-info-circle"></i> لم يتم إضافة أي بنود للعطاء بعد
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success me-2">إضافة العطاء</button>
                            <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="selectItemModal" tabindex="-1" aria-labelledby="selectItemModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectItemModalLabel">اختيار البنود الموجودة</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" wire:model="searchItems"
                            placeholder="البحث في البنود...">
                    </div>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="50">اختيار</th>
                                    <th>اسم البند</th>
                                    <th>الوصف</th>
                                    <th>وحدة القياس</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($availableItems && count($availableItems) > 0)
                                    @foreach ($availableItems as $item)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-check-input"
                                                    value="{{ $item['id'] }}" wire:model="tempSelectedItems">
                                            </td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['description'] ?? 'لا يوجد وصف' }}</td>
                                            <td>{{ $item['unit'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">لا توجد بنود متاحة</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" wire:click="addSelectedItems"
                        data-mdb-dismiss="modal">إضافة البنود المحددة</button>
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
    }

    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 1020;
    }

    .btn-custome {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .btn-custome:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        color: white;
    }

    .modal-xl {
        max-width: 90%;
    }

    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .alert {
        border-radius: 0.375rem;
    }
</style>
