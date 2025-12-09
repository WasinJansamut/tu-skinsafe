document.addEventListener('DOMContentLoaded', function () {
    const banner = document.getElementById('network-banner');
    let wasOffline = false;

    const offlineText = banner.dataset.offlineText || "ไม่มีการเชื่อมต่ออินเทอร์เน็ต";
    const onlineText = banner.dataset.onlineText || "กลับมาออนไลน์แล้ว";

    // ฟังก์ชันเช็กอินเทอร์เน็ตจริง
    async function checkInternet() {
        try {
            const response = await fetch("/ping.txt?ts=" + Date.now(), { cache: "no-store" });
            return response.ok;
        } catch {
            return false;
        }
    }

    async function updateNetworkStatus() {
        const online = await checkInternet();

        if (!online) {
            wasOffline = true;
            banner.className = "h6 alert-striped bg-danger text-white text-center p-2 m-0 position-fixed top-0 start-0 w-100";
            banner.textContent = offlineText;
            banner.classList.remove("d-none");
        } else {
            if (wasOffline) {
                banner.className = "h6 alert-striped bg-success text-white text-center p-2 m-0 position-fixed top-0 start-0 w-100";
                banner.textContent = onlineText;
                banner.classList.remove("d-none");
                setTimeout(() => banner.classList.add("d-none"), 2000);
                wasOffline = false;
            }
        }
    }

    // เรียกตอนโหลด
    updateNetworkStatus();

    // ฟัง event online/offline
    window.addEventListener('online', updateNetworkStatus);
    window.addEventListener('offline', updateNetworkStatus);
});
