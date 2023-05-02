const COOKIE_NAME = 'nadzasoby_cookies';
const BASE_COOKIES_GRANTED = {required: 'granted'};

const ANALYTICS_COOKIES_DENIED = {analytics_storage: 'denied'};
const AD_COOKIES_DENIED = {ad_storage: 'denied'};

const ANALYTICS_COOKIES_GRANTED = {analytics_storage: 'granted'};
const AD_COOKIES_GRANTED = {ad_storage: 'granted'};

const ALL_COOKIES_GRANTED = {...BASE_COOKIES_GRANTED, ...ANALYTICS_COOKIES_GRANTED, ...AD_COOKIES_GRANTED};
const ALL_COOKIES_DENIED = {...BASE_COOKIES_GRANTED, ...ANALYTICS_COOKIES_DENIED, ...AD_COOKIES_DENIED};


const cookieBar = document.getElementById('cookie-bar');

function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

if (cookieBar) {
    const cookieClose = document.getElementById('cookie-bar-close');
    const cookieAccept = document.getElementById('cookie-bar-accept');
    const cookieDeny = document.getElementById('cookie-bar-deny');

    const closeCookieBar = () => {
        cookieBar.classList.add('translate-y-full')

        setTimeout(() => {
            cookieClose.removeEventListener('click', handleCookieCloseClick);
            cookieAccept.removeEventListener('click', handleCookieAcceptClick);
            cookieDeny.removeEventListener('click', handleCookieDenyClick);
            cookieBar.remove();
        }, 510);
    };

    const handleCookieCloseClick = (e) => {
        e.preventDefault();
        closeCookieBar();
    };

    const handleCookieAcceptClick = (e) => {
        e.preventDefault();
        setCookie(COOKIE_NAME, JSON.stringify(ALL_COOKIES_GRANTED), 365);
        closeCookieBar();
    };

    const handleCookieDenyClick = (e) => {
        e.preventDefault();
        setCookie(COOKIE_NAME, JSON.stringify(ALL_COOKIES_DENIED), 7);
        closeCookieBar();
    };

    cookieClose.addEventListener('click', handleCookieCloseClick);
    cookieAccept.addEventListener('click', handleCookieAcceptClick);
    cookieDeny.addEventListener('click', handleCookieDenyClick);
}
