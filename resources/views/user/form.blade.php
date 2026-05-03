<div class="row">
    <div class="col-md-6 col-lg-4 form-group">
        <label for="name">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}" autocomplete="off" maxlength="255" required>
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 col-lg-4 form-group">
        <label for="username">ชื่อผู้ใช้งาน <span class="text-danger">*</span></label>
        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"
            value="{{ old('username', $user->username ?? '') }}" autocomplete="off" maxlength="30" required>
        @error('username')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 col-lg-4 form-group">
        <label for="email">อีเมล <span class="text-danger">*</span></label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email ?? '') }}" autocomplete="off" maxlength="255" required>
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 col-lg-4 form-group">
        <label for="compensation_channel">ช่องทางการชำระ / รับค่าตอบแทน</label>
        <input type="text" name="compensation_channel" id="compensation_channel"
            class="form-control @error('compensation_channel') is-invalid @enderror"
            value="{{ old('compensation_channel', $user->compensation_channel ?? '') }}" autocomplete="off" maxlength="255"
            placeholder="เช่น พร้อมเพย์, บัญชีธนาคาร, ไม่รับค่าตอบแทน">
        @error('compensation_channel')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 col-lg-4 form-group">
        <label for="status_payto_research_participant">สถานะการชำระเงิน</label>
        <select name="status_payto_research_participant" id="status_payto_research_participant"
            class="form-select @error('status_payto_research_participant') is-invalid @enderror">
            <option value="">กรุณาเลือก</option>
            <option value="รอชำระค่าตอบแทน" {{ old('status_payto_research_participant', $user->status_payto_research_participant ?? '') === 'รอชำระค่าตอบแทน' ? 'selected' : '' }}>รอชำระค่าตอบแทน</option>
            <option value="ชำระแล้ว" {{ old('status_payto_research_participant', $user->status_payto_research_participant ?? '') === 'ชำระแล้ว' ? 'selected' : '' }}>ชำระแล้ว</option>
            <option value="ไม่ขอรับค่าตอบแทน" {{ old('status_payto_research_participant', $user->status_payto_research_participant ?? '') === 'ไม่ขอรับค่าตอบแทน' ? 'selected' : '' }}>ไม่ขอรับค่าตอบแทน</option>
        </select>
        @error('status_payto_research_participant')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 col-lg-4 form-group">
        <label for="role">ประเภทผู้ใช้งาน <span class="text-danger">*</span></label>
        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="">กรุณาเลือก</option>
            <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="research_participant" {{ old('role', $user->role ?? '') === 'research_participant' ? 'selected' : '' }}>ผู้เข้าร่วมวิจัย</option>
        </select>
        @error('role')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 col-lg-4 form-group">
        <label for="password">รหัสผ่าน @if (request()->routeIs('user.create')) <span class="text-danger">*</span> @endif</label>
        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
            autocomplete="new-password" maxlength="255" @if (request()->routeIs('user.create')) required @endif>
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6 col-lg-4 form-group">
        <label for="password_confirmation">ยืนยันรหัสผ่าน @if (request()->routeIs('user.create')) <span class="text-danger">*</span> @endif</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            class="form-control @error('password_confirmation') is-invalid @enderror"
            autocomplete="new-password" maxlength="255" @if (request()->routeIs('user.create')) required @endif>
        @error('password_confirmation')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
