<div>
    <button type="button" class="btn btn-custome" data-bs-toggle="modal"
        data-bs-target="#TenderCommitteModal{{ $tender->id }}">
        اللجنة
    </button>

    <div class="modal fade" id="TenderCommitteModal{{ $tender->id }}" tabindex="-1"
        aria-labelledby="TenderCommitteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TenderCommitteModalLabel">اللجنة</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateCommittes({{ $tender->id }})">
                        <div class="mb-3">
                            <label for="committeeTypeSelect{{ $tender->id }}">اختر نوع اللجنة</label>
                            <select wire:model.live="committeeTypeFilter.{{ $tender->id }}"
                                id="committeeTypeSelect{{ $tender->id }}" class="form-select mb-3">
                                <option value="all">جميع اللجان</option>
                                <option value="3">لجنة داخلية </option>
                                <option value="4">لجنة خارجية </option>
                            </select>

                            @php
                                $selectedType = $committeeTypeFilter[$tender->id] ?? 'all';
                                $filteredCommittees =
                                    $selectedType === 'all' ? $committes : $committes->where('type', $selectedType);
                            @endphp

                            @foreach ($filteredCommittees as $committe)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $committe->id }}"
                                        id="committe{{ $committe->id }}"
                                        wire:model="selectedCommittes.{{ $tender->id }}">
                                    <label class="form-check-label d-flex justify-content-between align-items-center"
                                        for="committe{{ $committe->id }}">
                                        <span>{{ $committe->name }}</span>
                                        <span
                                            class="badge {{ $committe->type == 3 ? 'bg-success' : 'bg-warning text-dark' }} ms-2">
                                            {{ $committe->type == 3 ? 'داخلية' : 'خارجية' }}
                                        </span>

                                    </label>
                                </div>
                            @endforeach

                            @if (count($filteredCommittees) == 0)
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    لا توجد لجان من هذا النوع
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success">تحديث</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
