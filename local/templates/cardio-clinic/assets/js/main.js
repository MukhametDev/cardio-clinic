'use strict';

document.addEventListener("DOMContentLoaded", function () {
    var cardioclinic = (function () {
        const menu = document.querySelector('.menu');
        const nav = document.querySelector('.nav');
        const navLinkOnly = document.querySelectorAll('.nav__list-link:only-of-type');
        const navWrap = document.querySelector('.header__nav-wrapper');
        const header = document.querySelector('.header');
        const btn = document.querySelector('.header__btn.modal__btn');
        const logo = document.querySelector('.header__logo');
        const headerBottom = document.querySelector('.header__bottom');
        const logoSVG = document.querySelector('.header__logo svg');
        const headerGroup = document.querySelector('.header__group');
        const social = document.querySelector('.header__group .social-list');
        const exclamation = document.querySelector('.header__exclamation');
        const headerGroupBtn = document.querySelector('.header__group-btn');
        const navContentTop = document.querySelector('.header__nav-top-content');
        const navContentBottom = document.querySelector('.header__nav-bottom-content');
        const infoList = document.querySelector('.info-list');
        const infoList_number = document.querySelector('.info-list__item--phone');
        const infoList_address = document.querySelector('.info-list__item--address');
        const infoList_schedule = document.querySelector('.info-list__item--schedule');
        const infoList_email = document.querySelector('.info-list__item--email').cloneNode(true);

        function isHasElement(e) {
            if (typeof (e) != 'undefined' && e != null) {
                return e;
            } else {
                console.log('The element does not exist');
                return '';
            }
        }

        function firstPlaceForElements() {
            isHasElement(navContentTop).prepend(isHasElement(exclamation));
            isHasElement(navContentTop).prepend(isHasElement(btn));
            isHasElement(navContentTop).prepend(isHasElement(infoList_number));

            isHasElement(navContentBottom).prepend(isHasElement(infoList_email));
            isHasElement(navContentBottom).prepend(isHasElement(infoList_schedule));
            isHasElement(navContentBottom).prepend(isHasElement(infoList_address));

            isHasElement(navWrap).prepend(isHasElement(social));
            isHasElement(navWrap).prepend(isHasElement(logo));
        }

        function secondPlaceForElements() {
            isHasElement(menu).before(isHasElement(isHasElement(btn)));
            isHasElement(headerGroupBtn).prepend(isHasElement(exclamation));
            isHasElement(headerBottom).prepend(isHasElement(logo));
            isHasElement(headerGroup).prepend(isHasElement(social));

            isHasElement(infoList).append(isHasElement(infoList_number));
            isHasElement(infoList).append(isHasElement(infoList_address));
            isHasElement(infoList).append(isHasElement(infoList_schedule));
            isHasElement(infoList_email).remove();
        }

        function initMenu() {
            document.addEventListener('click', function () {
                const html = document.documentElement;
                const width = html.clientWidth;

                if (menu) {
                    if (event.target.classList.contains('nav-menu__toggler')) {
                        event.target.classList.toggle('active');
                        nav.classList.toggle('active');
                        header.classList.toggle('header--menu-open');

                        // move logo, btn "Записаться на приём", "Онлайн-консультации"
                        function moveElements() {
                            if (width <= 650) {
                                if (header.classList.contains('header--menu-open')) {
                                    firstPlaceForElements();
                                    isHasElement(logoSVG).setAttribute("viewBox", "0 0 212 50");
                                } else {
                                    secondPlaceForElements();
                                    isHasElement(logoSVG).setAttribute("viewBox", "0 0 50 50");
                                }
                            }
                        }

                        moveElements();

                        if (menu.classList.contains('active')) {
                            html.style.overflowY = 'hidden';
                        } else {
                            html.style.overflowY = null;
                        }
                    }
                    if (event.target.classList.contains('nav__close')) {
                        document.querySelector('.menu.nav-menu__toggler').classList.toggle('active');
                    }
                }
            });
        }

        function initItemsMenu() {
            function allOpenItemsMenu() {
                isHasElement(navLinkOnly).forEach(e => e.classList.add('active'))
            }

            allOpenItemsMenu();
            document.addEventListener('click', function () {
                if (event.target.classList.contains('nav__item-toggler')) {
                    event.preventDefault();
                    event.target.classList.toggle('active');
                }
            });
        }

        function initModal() {
            document.addEventListener('click', function () {
                if (event.target.classList.contains('modal__btn')) {
                    event.preventDefault();
                    event.target.classList.add('active');
                    document.querySelector('html').style.overflowY = 'hidden';
                    document.querySelector(event.target.getAttribute('data-target')).classList.add('active');
                }
                if (event.target.classList.contains('modal_close') || (event.target.classList.contains('modal') && event.target.classList.contains('active'))) {
                    if (!menu.classList.contains('active')) {
                        document.querySelector('html').style.overflowY = 'auto';
                    }
                    document.querySelector('.modal.active').classList.remove('active');
                    document.querySelector('.modal__btn.active').classList.remove('active');
                }
            });
        }

        function maskForInput() {
            [].forEach.call(document.querySelectorAll('input[type="tel"]'), function (input) {

                var keyCode;

                function mask(event) {
                    event.keyCode && (keyCode = event.keyCode);

                    var pos = this.selectionStart;

                    if (pos < 3) event.preventDefault();

                    var matrix = "+7 (___) ___-__-__",
                        i = 0,
                        def = matrix.replace(/\D/g, ""),
                        val = this.value.replace(/\D/g, ""),
                        new_value = matrix.replace(/[_\d]/g, function (a) {
                            return i < val.length ? val.charAt(i++) || def.charAt(i) : a
                        });

                    i = new_value.indexOf("_");

                    if (i != -1) {
                        i < 5 && (i = 3);
                        new_value = new_value.slice(0, i)
                    }

                    var reg = matrix.substr(0, this.value.length).replace(/_+/g,
                        function (a) {
                            return "\\d{1," + a.length + "}"
                        }).replace(/[+()]/g, "\\$&");

                    reg = new RegExp("^" + reg + "$");

                    if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) this.value = new_value;
                    if (event.type == "blur" && this.value.length < 5) this.value = ""
                }

                input.addEventListener("input", mask, false);
                input.addEventListener("focus", mask, false);
                input.addEventListener("blur", mask, false);
                input.addEventListener("keydown", mask, false)
            });
        }

        function init() {
            initMenu();
            initItemsMenu();
            initModal();
            maskForInput();
        }

        return {
            init: init
        };
    })();

    cardioclinic.init();
});