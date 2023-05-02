@section('title', title('Upravit inzerát'))
<x-app-layout>
    <x-slot name="header">
        <div class="md:flex-grow flex items-center justify-start">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Upravit inzerát
            </h1>
        </div>
    </x-slot>

    <x-container id="form-create"/>

    @push('scripts')
        <script>
            window.Laravel = {!! json_encode([
                   'csrfToken' => csrf_token(),
                   'apiToken' => Auth::user()->api_token ?? null,
               ]) !!};
            window.categories = `{!! json_encode($categories) !!}`;
            window.conditions = `{!! json_encode($conditions) !!}`;
            window.units = `{!! json_encode($units) !!}`;
            window.areas = `{!! json_encode($areas) !!}`;
            window.listing = `{!! json_encode($listing) !!}`
        </script>
        <script src="{{ mix('js/form-edit.js') }}"></script>
    @endpush
</x-app-layout>

