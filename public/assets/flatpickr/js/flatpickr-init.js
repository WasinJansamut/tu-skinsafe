// ฟังก์ชันสำหรับเริ่มต้น Flatpickr บน input ที่รับเข้ามา
// โดยจะทำงานเฉพาะ input ที่เป็น type date หรือ datetime-local
function initFlatpickrOnInput(input) {
    // ถ้า input นั้นเคยถูก init Flatpickr แล้ว จะไม่ init ซ้ำ (เช็คจาก class)
    if (input.classList.contains('flatpickr-input')) return;

    // ปิด autocomplete เพื่อป้องกันเบราว์เซอร์แสดงค่าที่เก็บไว้
    input.setAttribute('autocomplete', 'off');

    // เช็คว่าเป็น input type date หรือ datetime-local เท่านั้น
    const isDateOnly = input.type === 'date';
    const isDateTime = input.type === 'datetime-local';
    if (!isDateOnly && !isDateTime) return;

    // หาค่า hidden input ที่อยู่ถัดจาก input ตัวจริง (ใช้เก็บค่ารูปแบบ ISO จริงสำหรับส่งเซิร์ฟเวอร์)
    let hiddenInput = input.nextElementSibling;
    // ถ้าไม่มี หรือไม่ใช่ hidden input ให้สร้าง hidden input ใหม่ขึ้นมาแทรกไว้ข้างหลัง input ตัวจริง
    if (!hiddenInput || hiddenInput.type !== 'hidden') {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = input.name; // โอนชื่อฟิลด์ไปให้ hidden input แทน
        input.removeAttribute('name'); // ลบชื่อออกจาก input ตัวจริง เพื่อไม่ให้ส่งข้อมูลซ้ำกัน
        input.parentNode.insertBefore(hiddenInput, input.nextSibling);
    }

    // เติมค่า hiddenInput.value จาก input.value ถ้า hiddenInput ยังไม่มีค่า
    if (!hiddenInput.value && input.value) {
        // สมมติว่า input.value อาจจะเป็นรูปแบบ d/m/Y หรือ ISO แล้วแต่กรณี
        const parts = input.value.split('/');
        if (parts.length === 3) {
            // ถ้าเป็น d/m/Y ให้แปลงเป็น ISO format Y-m-d
            const isoDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
            hiddenInput.value = isoDate;
        } else {
            // กรณีอื่น เช่น input.value เป็น ISO format อยู่แล้ว ให้ใช้ตามนั้นเลย
            hiddenInput.value = input.value;
        }
    }

    // เรียกใช้ flatpickr เพื่อสร้าง date picker บน input นี้
    let previousDateValue = ""; // ตัวแปรเก็บค่าวันที่ก่อนเปลี่ยน
    flatpickr(input, {
        enableTime: isDateTime, // ถ้าเป็น datetime-local ให้เปิดเวลา
        dateFormat: isDateOnly ? "d/m/Y" : "d/m/Y H:i:S", // รูปแบบวันที่แสดงใน input
        time_24hr: true, // ใช้เวลาแบบ 24 ชั่วโมง
        locale: "th", // ใช้ locale ภาษาไทย
        allowInput: true, // อนุญาตให้พิมพ์วันที่เองได้
        disableMobile: true, // ปิด native picker บนมือถือเพื่อใช้ flatpickr แทน
        defaultDate: hiddenInput.value ? new Date(hiddenInput.value) : null, // กำหนดวันที่เริ่มต้นใน Calendar ให้ตรงกับค่าที่เก็บใน hidden input (รูปแบบ ISO) โดยแปลงเป็น Date object เพื่อให้ Flatpickr แสดงและ Focus วันที่ได้ถูกต้องจริง ๆ
        onOpen: function (selectedDates, dateStr, instance) { // เมื่อวันที่ถูกเลือกหรือเปลี่ยนแปลง
            // เก็บค่าวันที่ปัจจุบันเมื่อเปิด picker
            previousDateValue = instance.input.value;
        },
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                // แปลงวันที่เป็นรูปแบบ ISO สำหรับเก็บจริง
                const isoStr = instance.formatDate(selectedDates[0], "Y-m-d" + (isDateTime ? " H:i:S" : ""));
                hiddenInput.value = isoStr;
            } else {
                hiddenInput.value = "";
            }
        },
        onClose: function (selectedDates, dateStr, instance) {  // เมื่อปิด Picker (คลิกออกนอก) ตรวจสอบปีว่าถูกต้องหรือไม่
            const parts = dateStr.split('/');
            const year = parseInt(parts[2]);
            // ตรวจสอบว่าปีที่กรอกเป็นปีพุทธศักราชหรือไม่ โดยเปรียบเทียบกับปีปัจจุบัน
            // ถ้าปีที่กรอกมากกว่าปีปัจจุบันเกิน 100 แสดงว่าเป็นปีพุทธศักราช
            if (year - new Date().getFullYear() > 100) {
                // ไม่เคลียร์ แต่ย้อนค่ากลับเป็นของเดิม
                Swal.fire({
                    icon: 'warning',
                    title: 'ปีไม่ถูกต้อง',
                    text: 'กรุณาใส่ปี ค.ศ. เท่านั้น',
                    confirmButtonText: 'ตกลง'
                });
                instance.setDate(previousDateValue, true); // ย้อนค่ากลับ
            } else {
                previousDateValue = instance.input.value; // ถ้าเป็นปี ค.ศ. ถูกต้อง ค่อยอัปเดตค่าที่เก็บไว้
            }
        }
    });
}

// ฟังก์ชันแปลงวันที่จาก ISO format (Y-m-d) เป็นรูปแบบ d/m/Y สำหรับแสดงใน input
function formatDateToDMY(isoDateStr) {
    if (!isoDateStr) return "";
    const d = new Date(isoDateStr);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}/${month}/${year}`;
}

// เริ่มต้นการติดตั้ง Flatpickr ให้กับ input[type="date"] และ input[type="datetime-local"]
// ที่มีอยู่ใน DOM ตอนโหลดครั้งแรก
document.querySelectorAll('input[type="date"], input[type="datetime-local"]').forEach(input => {
    // console.log('Init flatpickr for', input);
    initFlatpickrOnInput(input);

    // หา hidden input ที่อยู่ถัดไปเพื่อตั้งค่า value ของ input ให้แสดงวันที่ในรูปแบบ d/m/Y
    let hiddenInput = input.nextElementSibling;
    // console.log('Hidden input:', hiddenInput);
    if (hiddenInput && hiddenInput.type === 'hidden' && hiddenInput.value) {
        // console.log('Setting input.value from hidden input value:', hiddenInput.value);
        input.value = formatDateToDMY(hiddenInput.value);
    }
});

// สร้าง MutationObserver เพื่อตรวจจับการเพิ่ม input วันที่ใหม่ ๆ ที่เข้ามาใน DOM แบบ dynamic
const observer = new MutationObserver(mutations => {
    for (const mutation of mutations) {
        mutation.addedNodes.forEach(node => {
            if (node.nodeType !== 1) return; // ข้ามถ้าไม่ใช่ element node
            // ถ้า node ที่เพิ่มมาเป็น input[type=date หรือ datetime-local] ให้ init flatpickr ให้
            if (node.matches && node.matches('input[type="date"], input[type="datetime-local"]')) {
                initFlatpickrOnInput(node);
            }
            // ถ้า node เป็น container ให้ค้นหา input เหล่านี้ภายในและ init ให้ด้วย
            node.querySelectorAll && node.querySelectorAll('input[type="date"], input[type="datetime-local"]').forEach(initFlatpickrOnInput);
        });
    }
});

// เริ่ม observer เฝ้าดูการเปลี่ยนแปลง child nodes ทั้งหมดใน body (แบบลึก)
observer.observe(document.body, {
    childList: true,
    subtree: true
});
