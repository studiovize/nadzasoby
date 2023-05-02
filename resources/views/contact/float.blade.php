<div
    class="fixed bottom-4 right-4 bg-red-500 border-2 border-white p-4 rounded-full cursor-pointer z-10 flex transform hover:scale-110 transition-transform duration-200"
    id="floating-contact-trigger"
>
    <div class="w-6 text-white m-auto">
        {!! svg('icons/message.svg') !!}
    </div>
</div>

<div
    class="fixed bottom-0 sm:bottom-4 right-0 sm:right-4 bg-white p-6 z-20 border-b-2 border-gray-200 w-full max-w-full sm:max-w-md shadow-lg flex flex-col transform transition-transfrom duration-300"
    id="floating-contact-form"
>
    <button class="relative w-6 inline-flex self-end z-20 text-gray-500" id="floating-contact-form-close">
        {!! svg('icons/close.svg') !!}
    </button>
    <x-contact-form/>
</div>
