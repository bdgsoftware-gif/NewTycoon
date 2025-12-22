@extends('frontend.layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-8 text-center">Flash Message System Demo</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Test Buttons -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold mb-4">Test Flash Messages</h2>

                <button onclick="flash('Success! Product added to cart.', 'success', 5000, 'You can view your cart anytime')"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Success Message
                </button>

                <button onclick="flash('Error! Something went wrong.', 'error', 5000, 'Please try again or contact support')"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Error Message
                </button>

                <button onclick="flash('Warning! Low stock remaining.', 'warning', 5000, 'Only 3 items left in stock')"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Warning Message
                </button>

                <button
                    onclick="flash('Information: Profile updated.', 'info', 5000, 'Your changes have been saved successfully')"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Info Message
                </button>
            </div>

            <!-- Advanced Tests -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold mb-4">Advanced Tests</h2>

                <button onclick="testMultipleMessages()"
                    class="w-full bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Multiple Messages
                </button>

                <button onclick="testDifferentDurations()"
                    class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Different Durations
                </button>

                <button onclick="testHoverPause()"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Hover Pause (10s)
                </button>

                <button onclick="testCustomEvent()"
                    class="w-full bg-gray-700 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Custom Event
                </button>
            </div>

            <!-- Data Attribute Tests -->
            <div class="col-span-1 md:col-span-2 space-y-4">
                <h2 class="text-xl font-semibold mb-4">Data Attribute Tests (No JS Required)</h2>

                <button data-flash data-flash-message="Added to wishlist!" data-flash-type="success"
                    data-flash-duration="3000" data-flash-description="You can find it in your wishlist"
                    class="w-full bg-teal-500 hover:bg-teal-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Data Attribute (Success)
                </button>

                <button data-flash data-flash-message="Failed to save!" data-flash-type="error" data-flash-duration="4000"
                    class="w-full bg-rose-500 hover:bg-rose-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Test Data Attribute (Error)
                </button>
            </div>

            <!-- Instructions -->
            <div class="col-span-1 md:col-span-2 mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Instructions & Features</h2>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2">✓</span>
                        <span><strong>Progress Bar:</strong> Shows time remaining, shrinks from right to left</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2">✓</span>
                        <span><strong>Hover Pause:</strong> Hover over any message to pause the timer</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2">✓</span>
                        <span><strong>Smooth Animations:</strong> Slide in/out with fade effects</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2">✓</span>
                        <span><strong>Multiple Messages:</strong> Up to 5 messages shown at once</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2">✓</span>
                        <span><strong>Better SVG Icons:</strong> Modern, consistent icons for each type</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2">✓</span>
                        <span><strong>Vanilla JS:</strong> No Alpine.js or jQuery dependencies</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2">✓</span>
                        <span><strong>Responsive:</strong> Works perfectly on mobile devices</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Test functions
        function testMultipleMessages() {
            const messages = [
                ['First message!', 'success', 3000],
                ['Second message!', 'info', 4000],
                ['Third message!', 'warning', 5000],
                ['Fourth message!', 'error', 6000],
                ['Fifth message!', 'success', 7000]
            ];

            messages.forEach((msg, index) => {
                setTimeout(() => {
                    flash(msg[0], msg[1], msg[2], `Message ${index + 1} of ${messages.length}`);
                }, index * 800);
            });
        }

        function testDifferentDurations() {
            flash('Short message (2s)', 'success', 2000);
            setTimeout(() => flash('Medium message (4s)', 'info', 4000), 500);
            setTimeout(() => flash('Long message (8s)', 'warning', 8000), 1000);
        }

        function testHoverPause() {
            flash('Hover over me to pause!', 'info', 10000, 'Move mouse away to resume timer');
        }

        function testCustomEvent() {
            // Method 1: Using flash function
            flash('Custom event triggered!', 'success', 3000);

            // Method 2: Using event dispatch
            window.dispatchEvent(new CustomEvent('flash', {
                detail: {
                    message: 'Dispatched via custom event!',
                    type: 'info',
                    duration: 4000,
                    description: 'This shows you can trigger from anywhere'
                }
            }));
        }

        // Console debugging
        console.log('Flash System Test Page Loaded');
        console.log('Available functions:');
        console.log('- flash(message, type, duration, description)');
        console.log('- window.flashSystem for advanced control');
    </script>

    <style>
        /* Custom button styles */
        button {
            transition: all 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        button:active {
            transform: translateY(0);
        }
    </style>
@endsection
