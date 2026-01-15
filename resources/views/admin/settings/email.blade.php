@extends('admin.layouts.app')

@section('title', 'Email Settings')
@section('page-title', 'Email Settings')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.settings.index') }}" class="text-gray-500 hover:text-gray-700">Settings</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Email</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Email Settings</h3>
                    <p class="text-sm text-gray-500 mt-1">Configure email server and notification settings</p>
                </div>

                <form method="POST" action="{{ route('admin.settings.update.email') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Mail Configuration -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Mail Configuration</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Driver</label>
                                    <select name="mail_mailer"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        @foreach ($mailers as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $settings['mail_mailer'] == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mail_mailer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Host</label>
                                    <input type="text" name="mail_host"
                                        value="{{ old('mail_host', $settings['mail_host']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('mail_host')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Port</label>
                                    <input type="number" name="mail_port"
                                        value="{{ old('mail_port', $settings['mail_port']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('mail_port')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Encryption</label>
                                    <select name="mail_encryption"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="tls"
                                            {{ $settings['mail_encryption'] == 'tls' ? 'selected' : '' }}>
                                            TLS</option>
                                        <option value="ssl"
                                            {{ $settings['mail_encryption'] == 'ssl' ? 'selected' : '' }}>
                                            SSL</option>
                                        <option value="" {{ empty($settings['mail_encryption']) ? 'selected' : '' }}>
                                            None
                                        </option>
                                    </select>
                                    @error('mail_encryption')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                    <input type="text" name="mail_username"
                                        value="{{ old('mail_username', $settings['mail_username']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('mail_username')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <input type="password" name="mail_password"
                                        value="{{ old('mail_password', $settings['mail_password']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('mail_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password</p>
                                </div>
                            </div>
                        </div>

                        <!-- From Address -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">From Address</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">From Address</label>
                                    <input type="email" name="mail_from_address"
                                        value="{{ old('mail_from_address', $settings['mail_from_address']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('mail_from_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">From Name</label>
                                    <input type="text" name="mail_from_name"
                                        value="{{ old('mail_from_name', $settings['mail_from_name']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('mail_from_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Reply To Address</label>
                                    <input type="email" name="mail_reply_to"
                                        value="{{ old('mail_reply_to', $settings['mail_reply_to']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('mail_reply_to')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Test Email -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Test Email Configuration</h4>
                            <p class="text-sm text-gray-600 mb-4">Send a test email to verify your configuration</p>

                            <div class="flex items-center space-x-4">
                                <input type="email" id="testEmail" placeholder="Enter email address"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <button type="button" onclick="sendTestEmail()"
                                    class="px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Send Test Email
                                </button>
                            </div>
                            <div id="testEmailResult" class="mt-3 hidden">
                                <div class="text-sm" id="testEmailMessage"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Save Email Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Email Templates -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Email Templates</h3>

                <div class="space-y-4">
                    @php
                        $emailTemplates = [
                            [
                                'name' => 'Welcome Email',
                                'description' => 'Sent to new users after registration',
                                'status' => 'active',
                                'trigger' => 'User Registration',
                            ],
                            [
                                'name' => 'Order Confirmation',
                                'description' => 'Sent when an order is placed',
                                'status' => 'active',
                                'trigger' => 'Order Placed',
                            ],
                            [
                                'name' => 'Order Shipped',
                                'description' => 'Sent when an order is shipped',
                                'status' => 'active',
                                'trigger' => 'Order Shipped',
                            ],
                            [
                                'name' => 'Password Reset',
                                'description' => 'Sent when user requests password reset',
                                'status' => 'active',
                                'trigger' => 'Password Reset',
                            ],
                            [
                                'name' => 'Newsletter',
                                'description' => 'Marketing and promotional emails',
                                'status' => 'inactive',
                                'trigger' => 'Manual/Scheduled',
                            ],
                        ];
                    @endphp

                    @foreach ($emailTemplates as $template)
                        <div
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="p-2 bg-blue-50 rounded-lg">
                                        <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $template['name'] }}</h4>
                                    <p class="text-sm text-gray-500">{{ $template['description'] }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs text-gray-500">Trigger: {{ $template['trigger'] }}</span>
                                        <span class="mx-2 text-gray-300">•</span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $template['status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($template['status']) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button class="text-primary hover:text-primary-dark text-sm font-medium">
                                Edit Template
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function sendTestEmail() {
            const email = document.getElementById('testEmail').value;
            const resultDiv = document.getElementById('testEmailResult');
            const messageDiv = document.getElementById('testEmailMessage');

            if (!email || !validateEmail(email)) {
                resultDiv.classList.remove('hidden');
                resultDiv.classList.add('bg-red-50', 'border', 'border-red-200', 'p-3', 'rounded-lg');
                messageDiv.innerHTML = '<span class="text-red-600">Please enter a valid email address</span>';
                return;
            }

            // Show loading
            resultDiv.classList.remove('hidden');
            resultDiv.classList.add('bg-blue-50', 'border', 'border-blue-200', 'p-3', 'rounded-lg');
            messageDiv.innerHTML = '<span class="text-blue-600">Sending test email...</span>';

            // Simulate API call
            setTimeout(() => {
                resultDiv.classList.remove('bg-blue-50', 'border-blue-200');
                resultDiv.classList.add('bg-green-50', 'border-green-200');
                messageDiv.innerHTML = `
            <span class="text-green-600">
                Test email sent successfully to ${email}. 
                Please check your inbox (and spam folder) to confirm receipt.
            </span>
        `;
            }, 2000);
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
@endpush
