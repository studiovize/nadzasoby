@section('title', title('Uživatelé'))
<x-app-layout>
    <x-slot name="header">
        <div class="md:flex-grow flex items-center justify-start">
            <x-title>Uživatelé</x-title>
        </div>
    </x-slot>

    <x-container>
        <x-inner-container class="mb-8">
            <form class="flex flex-col md:flex-row gap-4 w-full justify-center items-center md:items-end"
                  action=""
                  method="get"
                  id="admin-users-search"
                  autocomplete="off"
            >
                <div class="relative w-full lg:w-1/2 text-left">
                    <x-input type="text"
                             name="query"
                             id="query"
                             class="w-full py-3"
                             autocomplete="off"
                    />
                </div>
                <x-button type="submit">Hledat</x-button>
            </form>
        </x-inner-container>

        <table class="w-full bg-white border-b-2 table-auto border-collapse border border-gray-200"
               id="admin-users-table"
        >
            <tr>
                <th class="border border-gray-200 p-2">ID</th>
                <th class="border border-gray-200 p-2">Jméno</th>
                <th class="border border-gray-200 p-2">E-mail</th>
                <th class="border border-gray-200 p-2">Akce</th>
            </tr>
            @foreach($users as $user)
                <tr class="hover:bg-gray-100 transition-colors duration-200">
                    <td class="border border-gray-200 p-2 text-center">{{ $user->id }}</td>
                    <td class="border border-gray-200 p-2">
                        <div class="flex items-center gap-2">
                            {{ $user->name }}
                            @if($user->hasRole('admin'))
                                <span
                                    class="text-xs bg-green-400 p-1 rounded font-bold text-white uppercase">Admin</span>
                            @endif
                        </div>
                    </td>
                    <td class="border border-gray-200 p-2">{{ $user->email }}</td>
                    <td class="border border-gray-200 p-2 text-center">
                        <x-button-link size="small"
                                       href="{{ route('admin.users.show', $user->id) }}"
                                       theme="primary"
                        >Zobrazit
                        </x-button-link>
                    </td>
                </tr>
            @endforeach
        </table>
    </x-container>

</x-app-layout>
