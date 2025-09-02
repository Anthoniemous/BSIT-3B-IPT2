<x-guest-layout>
    <div class="container" id="container">
        

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Login</h1>
            <!-- Email Address -->
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required autofocus>
            </div>

            <!-- Password -->
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</x-guest-layout>
