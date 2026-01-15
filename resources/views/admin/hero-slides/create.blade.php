@extends('admin.layouts.app')

@section('title', 'Create Slide')
@section('page-title', 'Create New Hero Slide')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.hero-slides.index') }}" class="text-gray-500 hover:text-gray-700">Hero Slides</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Create</span>
    </li>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data" id="slideForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column: Form -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Form Header -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Slide Information</h2>
                                    <p class="text-sm text-gray-600 mt-1">Create hero slide details</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.hero-slides.index') }}"
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </a>
                                    <button type="submit" data-loading data-loading-text="Creating..."
                                        class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                        Create Slide
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Content -->
                        <div class="p-6 space-y-6">
                            <!-- Background & Type -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Background & Type</h3>

                                <div class="space-y-4">
                                    <!-- Type -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Slide Type *
                                        </label>
                                        <div class="mt-2 space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="type" value="image" checked
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Image</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="type" value="video"
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Video</span>
                                            </label>
                                        </div>
                                        @error('type')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Background File -->
                                    <div>
                                        <label for="background" class="block text-sm font-medium text-gray-700 mb-1">
                                            Background File *
                                        </label>
                                        <input type="file" name="background" id="background" accept="image/*,video/*"
                                            required
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                        <p class="mt-1 text-xs text-gray-500">
                                            Images: JPG, PNG, WEBP (Max: 10MB) | Videos: MP4, MOV, AVI (Max: 10MB)
                                        </p>
                                        @error('background')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Content Settings -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Content</h3>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="has_content" value="1" id="hasContent"
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Enable Content</span>
                                    </label>
                                </div>

                                <div id="contentFields" class="space-y-6 hidden">
                                    <!-- Content Position -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Content Position *
                                        </label>
                                        <div class="mt-2 space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="content_position" value="left" checked
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Left</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="content_position" value="center"
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Center</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="content_position" value="right"
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Right</span>
                                            </label>
                                        </div>
                                        @error('content_position')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Badge -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="badge_en" class="block text-sm font-medium text-gray-700 mb-1">
                                                Badge (English)
                                            </label>
                                            <input type="text" name="badge_en" id="badge_en"
                                                value="{{ old('badge_en') }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="e.g., New, Sale, Limited">
                                            @error('badge_en')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="badge_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                                Badge (বাংলা)
                                            </label>
                                            <input type="text" name="badge_bn" id="badge_bn"
                                                value="{{ old('badge_bn') }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="যেমনঃ নতুন, বিক্রি, সীমিত">
                                            @error('badge_bn')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Title -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">
                                                Title (English)
                                            </label>
                                            <textarea name="title_en" id="title_en" rows="2"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="Enter main title">{{ old('title_en') }}</textarea>
                                            @error('title_en')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="title_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                                Title (বাংলা)
                                            </label>
                                            <textarea name="title_bn" id="title_bn" rows="2"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="মূল শিরোনাম লিখুন">{{ old('title_bn') }}</textarea>
                                            @error('title_bn')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Subtitle -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="subtitle_en" class="block text-sm font-medium text-gray-700 mb-1">
                                                Subtitle (English)
                                            </label>
                                            <textarea name="subtitle_en" id="subtitle_en" rows="3"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="Enter supporting text">{{ old('subtitle_en') }}</textarea>
                                            @error('subtitle_en')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="subtitle_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                                Subtitle (বাংলা)
                                            </label>
                                            <textarea name="subtitle_bn" id="subtitle_bn" rows="3"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="সহায়ক পাঠ্য লিখুন">{{ old('subtitle_bn') }}</textarea>
                                            @error('subtitle_bn')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Settings -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Call to Action</h3>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="has_cta" value="1" id="hasCta"
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Enable CTA Buttons</span>
                                    </label>
                                </div>

                                <div id="ctaFields" class="space-y-4 hidden">
                                    <div id="ctaButtonsContainer" class="space-y-4">
                                        <div class="p-4 border border-gray-200 rounded-xl space-y-4">
                                            <div class="flex justify-between items-center">
                                                <h4 class="text-sm font-medium text-gray-900">Button 1</h4>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                                        Label (English) *
                                                    </label>
                                                    <input type="text" name="cta_buttons[0][label_en]"
                                                        value="{{ old('cta_buttons.0.label_en') }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                        placeholder="e.g., Shop Now">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                                        Label (বাংলা)
                                                    </label>
                                                    <input type="text" name="cta_buttons[0][label_bn]"
                                                        value="{{ old('cta_buttons.0.label_bn') }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                        placeholder="যেমনঃ কিনুন">
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                                        URL *
                                                    </label>
                                                    <input type="text" name="cta_buttons[0][url]"
                                                        value="{{ old('cta_buttons.0.url') }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                        placeholder="e.g., /shop or https://example.com">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                                        Style *
                                                    </label>
                                                    <select name="cta_buttons[0][style]"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                                        <option value="primary" selected>Primary</option>
                                                        <option value="secondary">Secondary</option>
                                                        <option value="outline">Outline</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" onclick="addCtaButton()"
                                        class="text-primary hover:text-primary/80 flex items-center">
                                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add Another Button
                                    </button>
                                </div>
                            </div>

                            <!-- Settings -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Settings</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Status
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" checked
                                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                            <span class="ml-2 text-sm text-gray-700">Active</span>
                                        </label>
                                        @error('is_active')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Sort Order -->
                                    <div>
                                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">
                                            Sort Order
                                        </label>
                                        <input type="number" name="sort_order" id="sort_order"
                                            value="{{ old('sort_order', 0) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="0">
                                        @error('sort_order')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('admin.hero-slides.index') }}"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                    Cancel
                                </a>
                                <button type="submit" data-loading data-loading-text="Creating..."
                                    class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all flex items-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create Slide
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Preview -->
                <div class="lg:sticky lg:top-6 h-fit">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Live Preview</h3>
                            <p class="text-sm text-gray-600 mt-1">Preview how your slide will look</p>
                        </div>

                        <div class="p-6">
                            <div class="relative aspect-video w-full overflow-hidden rounded-xl bg-gray-900"
                                id="previewContainer">
                                <!-- Preview will be inserted here by JavaScript -->
                                <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                    <div class="text-center">
                                        <svg class="h-12 w-12 mx-auto mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm">Upload a file to preview</p>
                                    </div>
                                </div>

                                <!-- Content Preview -->
                                <div id="contentPreview" class="absolute inset-0 flex items-center p-8 hidden">
                                    <div class="max-w-2xl" id="previewContent">
                                        <!-- Content will be dynamically added -->
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Controls -->
                            <div class="mt-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Content Position:</span>
                                    <span id="previewPosition" class="text-sm text-gray-600">Left</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Has Content:</span>
                                    <span id="previewHasContent" class="text-sm text-gray-600">No</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Has CTA:</span>
                                    <span id="previewHasCta" class="text-sm text-gray-600">No</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle content fields
        document.getElementById('hasContent').addEventListener('change', function() {
            const contentFields = document.getElementById('contentFields');
            contentFields.classList.toggle('hidden', !this.checked);

            // Update preview
            updatePreview();
        });

        // Toggle CTA fields
        document.getElementById('hasCta').addEventListener('change', function() {
            const ctaFields = document.getElementById('ctaFields');
            ctaFields.classList.toggle('hidden', !this.checked);

            // Update preview
            updatePreview();
        });

        // Handle file upload preview
        document.getElementById('background').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const previewContainer = document.getElementById('previewContainer');
            const placeholder = previewContainer.querySelector('.absolute.inset-0.flex');

            if (placeholder) {
                placeholder.remove();
            }

            const url = URL.createObjectURL(file);
            const type = document.querySelector('input[name="type"]:checked').value;

            let mediaElement;
            if (type === 'video') {
                mediaElement = document.createElement('video');
                mediaElement.className = 'absolute inset-0 w-full h-full object-cover';
                mediaElement.autoplay = true;
                mediaElement.muted = true;
                mediaElement.loop = true;
                mediaElement.playsInline = true;
                mediaElement.src = url;
            } else {
                mediaElement = document.createElement('img');
                mediaElement.className = 'absolute inset-0 w-full h-full object-contain lg:object-cover';
                mediaElement.src = url;
            }

            previewContainer.insertBefore(mediaElement, previewContainer.firstChild);

            // Show content preview if enabled
            updatePreview();
        });

        // Update preview based on form values
        function updatePreview() {
            const hasContent = document.getElementById('hasContent').checked;
            const hasCta = document.getElementById('hasCta').checked;
            const contentPosition = document.querySelector('input[name="content_position"]:checked')?.value || 'left';

            // Update preview indicators
            document.getElementById('previewHasContent').textContent = hasContent ? 'Yes' : 'No';
            document.getElementById('previewHasCta').textContent = hasCta ? 'Yes' : 'No';
            document.getElementById('previewPosition').textContent = contentPosition.charAt(0).toUpperCase() +
                contentPosition.slice(1);

            const contentPreview = document.getElementById('contentPreview');
            const previewContent = document.getElementById('previewContent');

            if (!hasContent) {
                contentPreview.classList.add('hidden');
                return;
            }

            contentPreview.classList.remove('hidden');

            // Update content position
            contentPreview.classList.remove('justify-start', 'justify-center', 'justify-end');
            if (contentPosition === 'left') {
                contentPreview.classList.add('justify-start');
                previewContent.classList.remove('text-center', 'text-right');
                previewContent.classList.add('text-left');
            } else if (contentPosition === 'center') {
                contentPreview.classList.add('justify-center');
                previewContent.classList.remove('text-left', 'text-right');
                previewContent.classList.add('text-center');
            } else {
                contentPreview.classList.add('justify-end');
                previewContent.classList.remove('text-left', 'text-center');
                previewContent.classList.add('text-right');
            }

            // Update content
            const badge = document.getElementById('badge_en')?.value || '';
            const title = document.getElementById('title_en')?.value || 'Sample Title';
            const subtitle = document.getElementById('subtitle_en')?.value ||
                'Sample subtitle text that describes your offer';

            let html = '';

            if (badge) {
                html +=
                    `<span class="inline-block px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium mb-4">${badge}</span>`;
            }

            html += `<h3 class="text-3xl font-bold text-white mb-3">${title}</h3>`;
            html += `<p class="text-gray-200 mb-6">${subtitle}</p>`;

            if (hasCta) {
                html += `<div class="flex flex-wrap gap-3">`;
                // Get all CTA buttons
                const ctaInputs = document.querySelectorAll('[name^="cta_buttons"]');
                let buttonIndex = 0;

                for (let i = 0; i < ctaInputs.length; i += 4) {
                    const style = ctaInputs[i + 3]?.value || 'primary';
                    let buttonClass = 'px-6 py-2.5 rounded-lg font-medium transition-colors ';

                    switch (style) {
                        case 'primary':
                            buttonClass += 'bg-primary text-white hover:bg-primary/90';
                            break;
                        case 'secondary':
                            buttonClass += 'bg-gray-700 text-white hover:bg-gray-600';
                            break;
                        case 'outline':
                            buttonClass += 'border-2 border-white text-white bg-transparent hover:bg-white/10';
                            break;
                    }

                    html += `<button class="${buttonClass}">Button ${buttonIndex + 1}</button>`;
                    buttonIndex++;
                }
                html += `</div>`;
            }

            previewContent.innerHTML = html;
        }

        // Listen to form changes for live preview
        document.querySelectorAll('#slideForm input, #slideForm textarea, #slideForm select').forEach(element => {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        });

        // Listen to radio button changes
        document.querySelectorAll('input[name="content_position"]').forEach(radio => {
            radio.addEventListener('change', updatePreview);
        });

        // CTA button management
        let ctaButtonIndex = 1;

        function addCtaButton() {
            if (ctaButtonIndex >= 3) {
                alert('Maximum 3 buttons allowed');
                return;
            }

            const container = document.getElementById('ctaButtonsContainer');
            const newButton = document.createElement('div');
            newButton.className = 'p-4 border border-gray-200 rounded-xl space-y-4';
            newButton.innerHTML = `
                <div class="flex justify-between items-center">
                    <h4 class="text-sm font-medium text-gray-900">Button ${ctaButtonIndex + 1}</h4>
                    <button type="button" onclick="removeCtaButton(this)" class="text-red-500 hover:text-red-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Label (English) *
                        </label>
                        <input type="text" name="cta_buttons[${ctaButtonIndex}][label_en]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                               placeholder="e.g., Shop Now">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Label (বাংলা)
                        </label>
                        <input type="text" name="cta_buttons[${ctaButtonIndex}][label_bn]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                               placeholder="যেমনঃ কিনুন">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            URL *
                        </label>
                        <input type="text" name="cta_buttons[${ctaButtonIndex}][url]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                               placeholder="e.g., /shop or https://example.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Style *
                        </label>
                        <select name="cta_buttons[${ctaButtonIndex}][style]"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="primary">Primary</option>
                            <option value="secondary">Secondary</option>
                            <option value="outline">Outline</option>
                        </select>
                    </div>
                </div>
            `;

            container.appendChild(newButton);
            ctaButtonIndex++;

            // Update preview
            updatePreview();
        }

        function removeCtaButton(button) {
            if (ctaButtonIndex <= 1) return;

            button.closest('.p-4').remove();
            // Reindex remaining buttons
            const buttons = document.querySelectorAll('#ctaButtonsContainer > div');
            buttons.forEach((div, index) => {
                div.querySelector('h4').textContent = `Button ${index + 1}`;
                // Update input names
                const inputs = div.querySelectorAll('[name^="cta_buttons["]');
                inputs.forEach(input => {
                    const name = input.name;
                    const newName = name.replace(/cta_buttons\[\d+\]/, `cta_buttons[${index}]`);
                    input.name = newName;
                });
            });
            ctaButtonIndex = buttons.length;

            // Update preview
            updatePreview();
        }

        // Initialize preview
        updatePreview();
    </script>
@endpush
