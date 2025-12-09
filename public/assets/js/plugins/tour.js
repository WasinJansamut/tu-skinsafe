(function (window) {
    const scriptTag = document.currentScript; // Gets the current script element
    const auth_name = document.currentScript.getAttribute('data-name');

    document.addEventListener('DOMContentLoaded', function () {
        const tour = new Shepherd.Tour({
            defaultStepOptions: {
                cancelIcon: {
                    enabled: true
                },
                classes: 'class-1 class-2',
                scrollTo: { behavior: 'smooth', block: 'center' },
                when: {
                    cancel: function () {
                        IQUtils.saveSessionStorage('tour', 'true');
                    }
                }
            },
        });

        tour.addSteps(
            [
                {
                    title: `<h4>เมนู</h4>`,
                    text: `<p class="mb-0">ท่านสามารถเลือกใช้งานเมนูต่างๆได้จากแถบด้านซ้ายนี้ </p>`,
                    attachTo: {
                        element: '#first-tour',
                        on: 'right'
                    },
                    buttons: [
                        {
                            action() {
                                return this.next();
                            },
                            text: 'ถัดไป <i class="fa-solid fa-arrow-right ms-1"></i>'
                        },
                    ],
                    id: 'first-tour'
                },
                {
                    title: `<h4>โปรไฟล์</h4>`,
                    text: `<p class="mb-0">สามารถแก้ไขรหัสผ่านหรือรูปภาพโปรไฟล์ หรือออกจากระบบได้ที่นี่</p>`,
                    attachTo: {
                        element: '#itemdropdown1',
                        on: 'bottom'
                    },
                    buttons: [
                        {
                            action() {
                                return this.back();
                            },
                            classes: 'shepherd-button-secondary',
                            text: '<i class="fa-solid fa-arrow-left me-1"></i> ย้อนกลับ'
                        },
                        {
                            action() {
                                return this.next();
                            },
                            text: 'ถัดไป <i class="fa-solid fa-arrow-right ms-1"></i>'
                        }
                    ],
                    id: 'dropdown1'
                },
                {
                    title: `<h4>CGM-ERP</h4>`,
                    text: `<p class="mb-0">ยินดีต้อนรับคุณ` + auth_name + `</p>`,
                    attachTo: {
                        element: '#settingbutton',
                        on: 'right'
                    },
                    buttons: [
                        {
                            action() {
                                return this.back();
                            },
                            classes: 'shepherd-button-secondary',
                            text: '<i class="fa-solid fa-arrow-left me-1"></i> ย้อนกลับ'
                        },
                        {
                            action() {
                                IQUtils.saveSessionStorage('tour', 'true');
                                return this.next();
                            },
                            text: '<i class="fa-solid fa-check me-1"></i> ฉันเข้าใจแล้ว'
                        }
                    ],
                    id: 'title'
                },
            ]
        )
        // check media screen
        if (window.matchMedia('(min-width: 1198px)').matches) {
            setTimeout(() => {
                const liveCusomizer = IQUtils.getQueryString('live-customizer')
                if (liveCusomizer != 'open') {
                    if (IQUtils.getSessionStorage('tour') !== 'true') {
                        tour.start();
                        $('.shepherd-modal-overlay-container').addClass('shepherd-modal-is-visible')
                    }
                }
            }, 400)
        }
    })
})(window)
