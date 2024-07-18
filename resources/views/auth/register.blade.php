<x-app-layout>

<form

        action="{{route('register')}}"
        method="post"
        class="w-[400px] mx-auto p-6 my-16"
      >
      @csrf
        <h2 class="text-2xl font-semibold text-center mb-4">Create an account</h2>
        <p class="text-center text-gray-500 mb-3">
          or
          <a
            href="route{{route('login')}}"
            class="text-sm text-purple-700 hover:text-purple-600"
            >login with existing account</a
          >
        </p>
        <div class="mb-4">
          <x-input
            placeholder="Your name"
            type="text"
            name="name"
              class="border-gray-500"
              :value="old('name')"
          />

        </div>
        </p>
        <div class="mb-4">
          <x-input
            placeholder="Your Email"
            type="email"
            name="email"
         class="border-gray-500"
          :value="old('email')"
          />

        </div>
        <div class="mb-4">
          <x-input
            placeholder="Password"
            type="password"
            name="password"
        class="border-gray-500"
          />
       
        </div>
        </div>
        <div class="mb-4">
          <x-input
            placeholder="Repeat Password"
            type="password"
            name="password_confirmation"
            class="border-gray-500"
          />
   
  
        </div>

        <button
          class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full"
        >
          Signup
        </button>
      </form>
</x-app-layout>
