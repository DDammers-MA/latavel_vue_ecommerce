<x-app-layout>

<form action="{{route('password.email')}}" method="post" class="w-[400px] mx-auto p-6 my-16">
    @csrf
        <h2 class="text-2xl font-semibold text-center mb-5">
          Enter your Email to reset password 
        </h2>
        <p class="text-center text-gray-500 mb-6">
          or
          <a
            href="{{route('login')}}"
            class="text-purple-600 hover:text-purple-500"
            >login with existing account</a
          >
        </p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <div class="mb-3">
          <x-input
            id="loginEmail"
            type="email"
            name="email"
            :value="old('email')"
            placeholder="Your email address"
            required
            autofocus
            class="border-gray-500"
          />
        </div>
        <button
          class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full"
        >
          Submit
        </button>
      </form>


    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
  

   
</x-app-layout>
