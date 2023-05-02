// require('./bootstrap');
// require('alpinejs');

// Dropdown
import axios from "axios";

let dropdownVisible = false;
const dropdownTrigger = document.querySelector('[data-dropdown-trigger]');
const dropdownElem = document.querySelector('[data-dropdown-elem]');

const handleDropdownTriggerClick = (e) => {
    dropdownVisible ? hideDropdown() : showDropdown();
    dropdownVisible = !dropdownVisible;
};

const showDropdown = () => {
    dropdownElem.style.display = 'block';
}

const hideDropdown = () => {
    dropdownElem.style.display = 'none';
}

if (dropdownTrigger) {
    const handleClickDropdownTrigger = (e) => {
        const isClickInside = dropdownTrigger.contains(e.target);

        if (!isClickInside) {
            hideDropdown();
            dropdownVisible = false;
        } else {
            handleDropdownTriggerClick(e);
        }
    };

    document.addEventListener('click', handleClickDropdownTrigger);
}

// Burger menu
let burgerVisible = false;
const burgerTrigger = document.querySelector('[data-burger-trigger]');
const burgerElem = document.querySelector('[data-burger-elem]');
const burgerPathA = document.querySelector('[data-burger-path-a]');
const burgerPathB = document.querySelector('[data-burger-path-b]');

const toggleBurger = (e) => {
    burgerVisible ? hideBurger() : showBurger();
    burgerVisible = !burgerVisible;
};

const showBurger = () => {
    burgerElem.classList.add('block');
    burgerElem.classList.remove('hidden');

    burgerPathA.classList.add('hidden');
    burgerPathA.classList.remove('inline-flex');

    burgerPathB.classList.add('inline-flex');
    burgerPathB.classList.remove('hidden');
}

const hideBurger = () => {
    burgerElem.classList.add('hidden');
    burgerElem.classList.remove('block');

    burgerPathA.classList.add('inline-flex');
    burgerPathA.classList.remove('hidden');

    burgerPathB.classList.add('hidden');
    burgerPathB.classList.remove('inline-flex');
}

if (burgerTrigger) {
    const handleBurgerTriggerClick = (e) => {
        const isClickInside = burgerTrigger.contains(e.target);

        if (!isClickInside) {
            hideBurger();
            burgerVisible = false;
        } else {
            toggleBurger(e);
        }
    };

    document.addEventListener('click', handleBurgerTriggerClick);
}

// Password input type toggle
const passwordTypeTogglers = document.querySelectorAll('[data-toggle-type]');

const handlePasswordTypeToggle = (e, item) => {
    const inputId = item.getAttribute('data-toggle-type');
    const inputElem = document.getElementById(inputId);
    const oldType = inputElem.getAttribute('type');
    const newType = oldType === 'password' ? 'text' : 'password';
    const newLabel = oldType === 'password' ? 'Skrýt heslo' : 'Zobrazit heslo';
    inputElem.setAttribute('type', newType);

    e.target.innerHTML = newLabel;
};

passwordTypeTogglers.forEach((item) => item.addEventListener('click', (e) => handlePasswordTypeToggle(e, item)))

// Change pagination items count
const paginationInput = document.getElementById('pagination-change');

if (paginationInput) {
    const handlePaginationChange = ({target}) => {
        // target.closest('form').submit();
        const formId = target.getAttribute('data-form');
        const form = document.getElementById(formId);

        if (form) {
            const formPaginationInput = form.querySelector('#pagination');
            formPaginationInput.value = target.value;

            form.submit();
        }
    };

    paginationInput.addEventListener('change', handlePaginationChange)
}

// Contact form submitting
const contactForm = document.getElementById('contact-form');

if (contactForm) {
    const handleContactFormSubmit = (e) => {
        e.preventDefault();
        const data = {
            _token: contactForm.querySelector('[name="_token"]').value,
            name: contactForm.querySelector('[name="name"]').value,
            email: contactForm.querySelector('[name="email"]').value,
            message: contactForm.querySelector('[name="message"]').value,
        };

        axios.post('/contact', data)
            .then(({data}) => {
                contactForm.classList.add(data.status === 200 ? 'success' : 'error');
            })
            .catch((error) => {
                contactForm.classList.add('error');
            });
    }

    contactForm.addEventListener('submit', handleContactFormSubmit);
}

// Floating contact form
const floatingContactFormTrigger = document.getElementById('floating-contact-trigger');

if (floatingContactFormTrigger) {
    const floatingContactForm = document.getElementById('floating-contact-form');
    const floatingContactFormClose = document.getElementById('floating-contact-form-close');

    const openFloatingContactForm = (e) => {
        floatingContactForm.classList.add('active');
    };

    const closeFloatingContactForm = (e) => {
        floatingContactForm.classList.remove('active');
    };

    floatingContactFormTrigger.addEventListener('click', openFloatingContactForm);
    floatingContactFormClose.addEventListener('click', closeFloatingContactForm);

    // Handle click outside
    const handleFloatingContactFormClickOutside = ({target}) => {
        if (!floatingContactForm.contains(target) && !floatingContactFormTrigger.contains(target)) {
            closeFloatingContactForm();
        }
    };
    document.addEventListener('click', handleFloatingContactFormClickOutside);
}

// Lazy loading
const handleLazy = () => {
    const items = document.querySelectorAll('[data-lazy]');

    items.forEach(function (item) {
        item.setAttribute('src', item.getAttribute('data-lazy'));
    });
};

window.addEventListener('load', handleLazy);

window.sendToGtm = (data) => {
    dataLayer.push(data);
};

// Analytics
const addToCardButtons = document.querySelectorAll('[data-price]');
if (addToCardButtons) {
    const handleAddToCart = ({target}) => {
        const amount = parseInt(target.getAttribute('data-amount'));
        const price = parseInt(target.getAttribute('data-price'));

        const data = {
            event: 'add_to_cart',
            content_name: 'Kredity',
            currency: 'CZK',
            value: price,
            items: [
                {
                    item_id: amount,
                    item_name: `${amount} kreditů`,
                    currency: 'CZK',
                    discount: 0,
                    price: price,
                    quantity: 1
                }
            ]
        };

        window.sendToGtm(data);
    };

    addToCardButtons.forEach(btn => btn.addEventListener('click', handleAddToCart))
}

// Admin Users Search
const userSearchForm = document.getElementById('admin-users-search');

if (userSearchForm) {
    const userSearchInput = userSearchForm.querySelector('input');
    const userSearchTableRows = document.getElementById('admin-users-table').querySelectorAll('tr:not(:first-of-type)');

    const filterTableRows = (query) => {
        userSearchTableRows.forEach((row) => {
            let show = false;
            const cells = row.querySelectorAll('td');

            cells.forEach((cell) => {
                if (cell.innerText.toLowerCase().includes(query)) {
                    show = true;
                }
            });

            show ? row.classList.remove('hidden') : row.classList.add('hidden');
        });
    };

    const showAllTableRows = () => {
        userSearchTableRows.forEach((row) => {
            row.classList.remove('hidden');
        });
    }

    const handleUserSearch = () => {
        const {value} = userSearchInput;
        const query = value.trim().toLowerCase();

        if (query === '') {
            showAllTableRows();
            return;
        }

        filterTableRows(query);
    }

    userSearchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        handleUserSearch();
    });
    userSearchInput.addEventListener('input', handleUserSearch);

}
