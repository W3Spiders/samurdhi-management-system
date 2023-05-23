<form>
    <div class="mb-3">
        <label for="primaryMemberInput" class="form-label">Primary Member</label>

        <div class="d-flex justify-content-between align-items-center gap-3">
            <div class="form-control">
                <span>-</span>
            </div>
            <a class="btn btn-success">Edit</a>
        </div>

        {{-- @if ($familyUnit->primary_member_id)
                        <div class="form-control">{{ $familyUnit->primary_member_id }}
    </div>
    @else
    <select class="form-select" id="primaryMemberInput" name="primary_member" aria-label="Select primary member">

        @foreach ($familyUnit->adult_members as $adult_member)
        <option value="{{ $adult_member->id }}"
            {{ $adult_member->id == $familyUnit->primary_member_id ? 'selected' : '' }}>
            {{ $adult_member->full_names }}</option>
        @endforeach

    </select>

    @endif --}}
    </div>

    <div class="mb-3">
        <label for="addressLine1Input" class="form-label">Address Line 1</label>
        <input class="form-control" type="text" id="addressLine1Input" name="address_line_1"
            value="{{ $familyUnit->address_line_1 }}" disabled>
    </div>

    <div class="mb-3">
        <label for="addressLine2Input" class="form-label">Address Line 2</label>
        <input class="form-control" type="text" id="addressLine1Input" name="address_line_2"
            value="{{ $familyUnit->address_line_2 }}" disabled>
    </div>

    <div class="mb-3">
        <label for="cityInput" class="form-label">City</label>
        <input class="form-control" type="text" id="cityInput" name="city" value="{{ $familyUnit->city }}" disabled>
    </div>

    <div class="mb-3">
        <label for="postalCodeInput" class="form-label">Postal Code</label>
        <input class="form-control" type="text" id="postalCodeInput" name="postal_code"
            value="{{ $familyUnit->postal_code }}" disabled>
    </div>

</form>