<x-app-layout>
    @section('title', 'Dashboard')
    Welcome <b>{{ auth()->user()->name }}</b> <br/><br/>
    {{ __("You're logged in!") }}
</x-app-layout>
