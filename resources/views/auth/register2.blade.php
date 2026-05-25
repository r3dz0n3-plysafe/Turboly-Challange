<x-guest-layout>

    <form method="POST" id="form-register" action="{{ route('register2') }}">
        @csrf

        <input name="name" id="name" type="text" placeholder="Nama">
        <input name="email" id="email" type="email" placeholder="Email ...">
        <input name="password" id="password" type="password" placeholder="Password">
        <input name="password_confirmation" id="password_confirmation" type="password" placeholder="Retype Password...">

        <button type="submit"
                class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
            Save
        </button>

    </form>
</x-guest-layout>
