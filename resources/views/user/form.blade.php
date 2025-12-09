 <style>
     .role-card {
         position: relative;
         display: block;
         border: 2px solid #dee2e6;
         border-radius: 0.5rem;
         padding: 1rem;
         cursor: pointer;
         transition: all 0.2s;
         background-color: #f8f9fa;
     }

     .role-card:hover {
         border-color: #0d6efd;
         background-color: #eef5ff;
     }

     .role-card input[type="checkbox"] {
         position: absolute;
         opacity: 0;
         pointer-events: none;
     }

     .role-card:has(input[type="checkbox"]:checked) {
         background-color: #f1f8ff;
         border-color: #0d6efd;
     }

     .checkmark {
         position: absolute;
         top: 8px;
         right: 10px;
         font-size: 1.2rem;
         color: green;
         display: none;
     }

     .role-card:has(input[type="checkbox"]:checked) .checkmark {
         display: block;
     }
 </style>

 <div class="row">
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="employee_id">รหัสพนักงาน</label>
         <span class="text-danger">*</span>
         <input type="text" name="employee_id" id="employee_id"
             class="form-control @error('employee_id') is-invalid @enderror"
             value="{{ old('employee_id', $user->employee_id ?? '') }}" autocomplete="off" maxlength="30" required>
         @error('employee_id')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="name">ชื่อ-นามสกุล</label>
         <span class="text-danger">*</span>
         <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $user->name ?? '') }}" autocomplete="off" maxlength="255" required>
         @error('name')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="branch_id_main">สาขาหลัก</label>
         <span class="text-danger">*</span>
         <select name="branch_id_main" id="branch_id_main" class="form-select select2 @error('branch_id_main') is-invalid @enderror"
             required>
             <option value="">กรุณาเลือก</option>
             @foreach ($branches as $branch)
                 <option value="{{ $branch->id }}"
                     {{ old('branch_id_main', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                     [{{ $branch->code }}]
                     {{ $branch->name }}
                 </option>
             @endforeach
         </select>
         @error('branch_id_main')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="department_id">แผนก</label>
         <span class="text-danger">*</span>
         <select name="department_id" id="department_id"
             class="form-select select2 @error('department_id') is-invalid @enderror" required>
             <option value="">กรุณาเลือก</option>
             @foreach ($departments as $department)
                 <option value="{{ $department->id }}"
                     {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                     {{ $department->name_th }}
                     ({{ $department->name_en }})
                 </option>
             @endforeach
         </select>
         @error('department_id')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="level_id">ระดับ</label>
         <span class="text-danger">*</span>
         <select name="level_id" id="level_id" class="form-select select2 @error('level_id') is-invalid @enderror"
             required>
             <option value="">กรุณาเลือก</option>
             @foreach ($levels as $level)
                 <option value="{{ $level->id }}"
                     {{ old('level_id', $user->level_id) == $level->id ? 'selected' : '' }}>
                     {{ $level->name }}
                 </option>
             @endforeach
         </select>
         @error('level_id')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="email">อีเมล</label>
         <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email', $user->email ?? '') }}" autocomplete="off" maxlength="255">
         @error('email')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>

     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="password">รหัสผ่าน</label>
         @if (\Request::route()->getName() == 'user.create')
             <span class="text-danger">*</span>
         @endif
         <input type="password" name="password" id="password"
             class="form-control @error('password') is-invalid @enderror" autocomplete="off" maxlength="255"
             @if (\Request::route()->getName() == 'user.create') required @endif>
         @error('password')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
         @if (\Request::route()->getName() == 'user.create')
             <span class="text-danger">*</span>
         @endif
         <input type="password" name="password_confirmation" id="password_confirmation"
             class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="off" maxlength="255"
             @if (\Request::route()->getName() == 'user.create') required @endif>
         @error('password_confirmation')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="phone_no">เบอร์โทรศัพท์</label>
         <input type="text" name="phone_no" id="phone_no" class="form-control @error('phone_no') is-invalid @enderror"
             value="{{ old('phone_no', $user->phone_no ?? '') }}" autocomplete="off" maxlength="20">
         @error('phone_no')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-sm-12 col-md-4 col-lg-3 form-group">
         <label for="profile_image">รูปภาพประจำตัว</label>
         <input type="file" name="profile_image" id="profile_image"
             class="form-control @error('profile_image') is-invalid @enderror"
             accept="image/jpg, image/jpeg, image/png, image/svg">
         @error('profile_image')
             <span class="text-danger">{{ $message }}</span>
         @enderror
     </div>
     <div class="col-12">
         <fieldset class="reset border border-dark px-3 rounded-3 form-group">
             <legend class="reset text-dark float-none w-auto p-2">
                 <i class="fa-solid fa-lock-open me-1"></i>
                 สิทธิ์เข้าถึงเมนู
             </legend>
             <div class="row" id="departmentRoleList">
                 <div class="form-group">
                     <button type="button" class="btn btn-sm btn-light" id="btnCheckAllDepartmentRole">
                         <i class="fa-solid fa-check text-success me-1"></i>
                         เลือกทั้งหมด
                     </button>
                 </div>
                 @foreach ($departments as $department)
                     <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                         <label class="role-card">
                             <input type="checkbox" name="department_role[]" value="{{ $department->code }}"
                                 {{ in_array($department->code, old('department_role', $user->department_role ?? [])) ? 'checked' : '' }}>
                             <div class="checkmark"><i class="fa-solid fa-check"></i></div> {{-- ✅ แสดงเครื่องหมายถูก --}}
                             <small class="text-gray">{{ $department->code }}</small>
                             <div class="fw-bold text-primary">{{ $department->name_th }}</div>
                         </label>
                     </div>
                 @endforeach
             </div>
         </fieldset>
     </div>
 </div>

 <div class="col-12 form-group">
     <div class="alert alert-light pb-0">
         <div class="row" id="branchList">
             <h3>สาขาที่สามารถเข้าถึงได้</h3>
             <div class="form-group">
                 <button type="button" class="btn btn-sm btn-light" id="btnCheckAllBranch">
                     <i class="fa-solid fa-check text-success me-1"></i>
                     เลือกทั้งหมด
                 </button>
             </div>
             @foreach ($branches as $branch)
                 <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                     <label class="role-card">
                         <input type="checkbox" class="form-check-input" id="branch_id[{{ $branch->id }}]" name="branch_id[{{ $branch->id }}]"
                             {{ old("branch_id.{$branch->id}") !== null || in_array($branch->id, $branch_relate_array ?? []) ? 'checked' : '' }}>
                         <div class="checkmark"><i class="fa-solid fa-check"></i></div>
                         <small class="text-gray">{{ $branch->code }}</small>
                         <div class="fw-bold text-primary">{{ $branch->name }}</div>
                     </label>
                 </div>
             @endforeach
         </div>
     </div>
 </div>

 <script>
     function updateBtnText(button, checkboxes, stateVarName) {
         const allChecked = [...checkboxes].every(cb => cb.checked);
         window[stateVarName] = allChecked;
         button.innerHTML = allChecked ?
             '<i class="fa-solid fa-xmark text-danger me-1"></i> ยกเลิกทั้งหมด' :
             '<i class="fa-solid fa-check text-success me-1"></i> เลือกทั้งหมด';
     }

     document.addEventListener("DOMContentLoaded", function() {
         const btnCheckAllDepartmentRole = document.getElementById('btnCheckAllDepartmentRole');
         const checkboxesDepartmentRole = document.querySelectorAll('#departmentRoleList input[type="checkbox"]');

         let allCheckedDepartmentRole = false;

         btnCheckAllDepartmentRole.addEventListener('click', function() {
             allCheckedDepartmentRole = !allCheckedDepartmentRole;
             checkboxesDepartmentRole.forEach(cb => cb.checked = allCheckedDepartmentRole);
             updateBtnText(btnCheckAllDepartmentRole, checkboxesDepartmentRole, 'allCheckedDepartmentRole');
         });

         updateBtnText(btnCheckAllDepartmentRole, checkboxesDepartmentRole, 'allCheckedDepartmentRole');

         // ส่วนของ branch
         const btnCheckAllBranch = document.getElementById('btnCheckAllBranch');
         const checkboxesBranch = document.querySelectorAll('#branchList input[type="checkbox"]');
         let allCheckedBranch = false;

         btnCheckAllBranch.addEventListener('click', function() {
             allCheckedBranch = !allCheckedBranch;
             checkboxesBranch.forEach(cb => cb.checked = allCheckedBranch);
             updateBtnText(btnCheckAllBranch, checkboxesBranch, 'allCheckedBranch');
         });

         updateBtnText(btnCheckAllBranch, checkboxesBranch, 'allCheckedBranch');
     });
 </script>
