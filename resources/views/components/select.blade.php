<select {{ $attributes->merge(['class' => 'rounded border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 block w-full']) }}>
    {{ $slot }}
</select>
