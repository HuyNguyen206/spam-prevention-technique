<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('post.store') }}">
                        @csrf
                        <div class="" style="display: none">
                            <!-- Name field, time to flag spam -->
                            <div>
                                <x-label for="name" :value="__('name')" />

                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus />
                            </div>
                            <div>
                                <x-label for="time" :value="__('My time')" />

                                <x-input id="time" class="block mt-1 w-full" type="text" name="time" value="{{microtime(true)}}" required autofocus />
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div>
                            <x-label for="title" :value="__('Title')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>

                        <div>
                            <x-label for="body" :value="__('Body')" />
                            <textarea class="block mt-1 w-full" name="body" id="body" rows="5"></textarea>

                        </div>



                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
