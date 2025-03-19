@extends('layouts.dash')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white shadow-md rounded-md overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gray-800 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400 mr-3">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <h1 class="text-xl font-semibold text-white">Agreement Creation Form</h1>
            </div>
        </div>

        <!-- Error Display -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('agreements.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Agreement Details -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">Agreement Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="agreement_number" class="block text-sm font-medium text-gray-700 mb-1">Agreement Number *</label>
                        <input type="text" name="agreement_number" id="agreement_number" value="{{ old('agreement_number') }}"
                               class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <div>
                        <label for="legal_entity" class="block text-sm font-medium text-gray-700 mb-1">Legal Entity *</label>
                        <input type="text" name="legal_entity" id="legal_entity" value="{{ old('legal_entity', 'UNFPA') }}"
                               class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
            </div>
            
            <!-- Organization Details -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">Organization Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="business_unit" class="block text-sm font-medium text-gray-700 mb-1">Business Unit *</label>
                        <input type="text" name="business_unit" id="business_unit" value="{{ old('business_unit') }}"
                               class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <div>
                        <label for="agreement_type" class="block text-sm font-medium text-gray-700 mb-1">Agreement Type *</label>
                        <select name="agreement_type" id="agreement_type" 
                                class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select Type</option>
                            <option value="Purchase" {{ old('agreement_type') == 'Purchase' ? 'selected' : '' }}>Purchase Agreement</option>
                            <option value="Service" {{ old('agreement_type') == 'Service' ? 'selected' : '' }}>Service Agreement</option>
                            <option value="Consulting" {{ old('agreement_type') == 'Consulting' ? 'selected' : '' }}>Consulting Agreement</option>
                            <option value="Distribution" {{ old('agreement_type') == 'Distribution' ? 'selected' : '' }}>Distribution Agreement</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="agreement_status" class="block text-sm font-medium text-gray-700 mb-1">Agreement Status *</label>
                        <select name="agreement_status" id="agreement_status"
                                class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select Status</option>
                            <option value="Draft" {{ old('agreement_status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Pending" {{ old('agreement_status') == 'Pending' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="Active" {{ old('agreement_status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Expired" {{ old('agreement_status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Financial Details -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">Financial Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="agreement_amount" class="block text-sm font-medium text-gray-700 mb-1">Agreement Amount ($)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" name="agreement_amount" id="agreement_amount" value="{{ old('agreement_amount') }}"
                                   class="block w-full border border-gray-300 rounded pl-7 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="minimum_release_amount" class="block text-sm font-medium text-gray-700 mb-1">Minimum Release ($)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" name="minimum_release_amount" id="minimum_release_amount" value="{{ old('minimum_release_amount') }}"
                                   class="block w-full border border-gray-300 rounded pl-7 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="released_amount" class="block text-sm font-medium text-gray-700 mb-1">Released Amount ($)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" name="released_amount" id="released_amount" value="{{ old('released_amount') }}"
                                   class="block w-full border border-gray-300 rounded pl-7 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Timeline -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">Agreement Timeline</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="effective_date" class="block text-sm font-medium text-gray-700 mb-1">Effective Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" name="effective_date" id="effective_date" value="{{ old('effective_date') }}"
                                   class="block w-full border border-gray-300 rounded pl-10 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="expiration_date" class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" name="expiration_date" id="expiration_date" value="{{ old('expiration_date') }}"
                                   class="block w-full border border-gray-300 rounded pl-10 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="pt-4 border-t border-gray-200 flex justify-end space-x-4">
                <a href="{{ route('agreements.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    Create Agreement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection