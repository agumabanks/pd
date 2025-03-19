@extends('layouts.app')

@section('content')
<div class="py-8 px-4 md:py-12 md:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden" x-data="registrationForm()">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-900 p-6 md:p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Supplier Registration Portal</h1>
                    <p class="mt-2 text-blue-100">United Nations E-Procurement Platform</p>
                </div>
                <div class="hidden md:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            
            <!-- Progress Indicator -->
            <div class="mt-8 relative">
                <div class="h-2 bg-blue-600 rounded-full">
                    <div class="h-2 bg-white rounded-full transition-all duration-500 ease-in-out" :style="`width: ${(currentStep * 100) / totalSteps}%`"></div>
                </div>
                <div class="mt-4 grid grid-cols-4 gap-2">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full transition-all duration-300"
                                :class="{ 
                                    'bg-white text-blue-800 font-bold': currentStep > index,
                                    'bg-white text-blue-800 font-bold': currentStep === index,
                                    'bg-blue-700 text-white': currentStep < index
                                }">
                                <span x-text="index + 1"></span>
                            </div>
                            <p class="mt-1 text-xs text-blue-100" x-text="step"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="p-6 md:p-8">
            <form id="registration-form" enctype="multipart/form-data" @submit.prevent="submitForm" class="space-y-8">
                @csrf

                <!-- Step 1: Company Details -->
                <div x-show="currentStep === 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="bg-gray-50 p-4 mb-6 rounded-lg border-l-4 border-blue-600">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Company Information
                        </h2>
                        <p class="text-gray-600 mt-1">Provide official company registration information</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="dunsNumber" class="block text-sm font-medium text-gray-700">D-U-N-S Number</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="dunsNumber" name="dunsNumber" x-model="formData.dunsNumber" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="000000000" 
                                    @blur="validateField('dunsNumber')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.dunsNumber">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.dunsNumber" x-text="errors.dunsNumber"></p>
                            <p class="mt-1 text-xs text-gray-500">The 9-digit D-U-N-S Number is a unique identifier for businesses.</p>
                        </div>

                        <div>
                            <label for="taxpayerId" class="block text-sm font-medium text-gray-700">Taxpayer ID</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="taxpayerId" name="taxpayerId" x-model="formData.taxpayerId" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="Tax ID / VAT Number" 
                                    @blur="validateField('taxpayerId')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.taxpayerId">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.taxpayerId" x-text="errors.taxpayerId"></p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="companyName" class="block text-sm font-medium text-gray-700">Legal Company Name</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="companyName" name="companyName" x-model="formData.companyName" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="Official Registered Company Name" 
                                    @blur="validateField('companyName')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.companyName">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.companyName" x-text="errors.companyName"></p>
                        </div>

                        <div>
                            <label for="contactDetails" class="block text-sm font-medium text-gray-700">Company Contact Number</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="contactDetails" name="contactDetails" x-model="formData.contactDetails" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="+1 (555) 000-0000" 
                                    @blur="validateField('contactDetails')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.contactDetails">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.contactDetails" x-text="errors.contactDetails"></p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="legalAddress" class="block text-sm font-medium text-gray-700">Registered Business Address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <textarea id="legalAddress" name="legalAddress" x-model="formData.legalAddress" rows="3"
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Full legal address as registered with authorities"
                                    @blur="validateField('legalAddress')"></textarea>
                                <div class="absolute top-0 right-0 pr-3 pt-3 pointer-events-none" x-show="errors.legalAddress">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.legalAddress" x-text="errors.legalAddress"></p>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Documentation -->
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="bg-gray-50 p-4 mb-6 rounded-lg border-l-4 border-blue-600">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Required Documentation
                        </h2>
                        <p class="text-gray-600 mt-1">Please upload the following documents in PDF, DOC, DOCX, JPG or PNG format</p>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white rounded-lg border border-gray-200 p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <label for="bankingProof" class="block text-sm font-medium text-gray-700">Banking Information</label>
                                    <p class="text-xs text-gray-500 mt-1 mb-3">Bank statement or letter confirming account details (max 10MB)</p>
                                    
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md" x-data="{ fileName: '' }">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="bankingProof" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="bankingProof" name="bankingProof" type="file" class="sr-only" accept=".pdf,.jpg,.png" 
                                                        @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''; validateField('bankingProof')">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, JPG or PNG up to 10MB</p>
                                            <p class="text-sm text-blue-600 mt-2" x-show="fileName" x-text="fileName"></p>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-sm text-red-600" x-show="errors.bankingProof" x-text="errors.bankingProof"></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <label for="registrationDocuments" class="block text-sm font-medium text-gray-700">Business Registration Certificate</label>
                                    <p class="text-xs text-gray-500 mt-1 mb-3">Official document showing company is legally registered (max 10MB)</p>
                                    
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md" x-data="{ fileName: '' }">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="registrationDocuments" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="registrationDocuments" name="registrationDocuments" type="file" class="sr-only" accept=".pdf,.doc,.docx,.jpg,.png" 
                                                        @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''; validateField('registrationDocuments')">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG or PNG up to 10MB</p>
                                            <p class="text-sm text-blue-600 mt-2" x-show="fileName" x-text="fileName"></p>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-sm text-red-600" x-show="errors.registrationDocuments" x-text="errors.registrationDocuments"></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <label for="womenOwnershipDocument" class="block text-sm font-medium text-gray-700">Women-Owned Business Certificate (Optional)</label>
                                    <p class="text-xs text-gray-500 mt-1 mb-3">Documentation certifying women ownership or leadership</p>
                                    
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md" x-data="{ fileName: '' }">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="womenOwnershipDocument" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="womenOwnershipDocument" name="womenOwnershipDocument" type="file" class="sr-only" accept=".pdf,.doc,.docx,.jpg,.png" 
                                                        @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG or PNG up to 10MB</p>
                                            <p class="text-sm text-blue-600 mt-2" x-show="fileName" x-text="fileName"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Director Details -->
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="bg-gray-50 p-4 mb-6 rounded-lg border-l-4 border-blue-600">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Primary Director Information
                        </h2>
                        <p class="text-gray-600 mt-1">Details of authorized company representative with signing authority</p>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="directorFirstName" class="block text-sm font-medium text-gray-700">First Name</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" id="directorFirstName" name="directorFirstName" x-model="formData.directorFirstName" 
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                        placeholder="First Name" 
                                        @blur="validateField('directorFirstName')">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.directorFirstName">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-red-600" x-show="errors.directorFirstName" x-text="errors.directorFirstName"></p>
                            </div>

                            <div>
                                <label for="directorLastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" id="directorLastName" name="directorLastName" x-model="formData.directorLastName" 
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                        placeholder="Last Name" 
                                        @blur="validateField('directorLastName')">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.directorLastName">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-red-600" x-show="errors.directorLastName" x-text="errors.directorLastName"></p>
                            </div>

                            <div>
                                <label for="directorPosition" class="block text-sm font-medium text-gray-700">Position/Title</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" id="directorPosition" name="directorPosition" x-model="formData.directorPosition" 
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                        placeholder="e.g. CEO, Managing Director" 
                                        @blur="validateField('directorPosition')">
                                </div>
                            </div>

                            <div>
                                <label for="directorEmail" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="email" id="directorEmail" name="directorEmail" x-model="formData.directorEmail" 
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                        placeholder="director@company.com" 
                                        @blur="validateField('directorEmail')">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.directorEmail">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-red-600" x-show="errors.directorEmail" x-text="errors.directorEmail"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Certification & Declarations -->
                    <div class="bg-blue-50 p-5 rounded-lg border border-blue-200">
                        <h3 class="text-md font-medium text-blue-800 mb-3">Director's Certification</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="declaration1" name="declaration1" type="checkbox" x-model="formData.declarations.authorizedSignatory" 
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="declaration1" class="font-medium text-gray-700">I certify that I am an authorized signatory of this organization</label>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="declaration2" name="declaration2" type="checkbox" x-model="formData.declarations.accurateInformation" 
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="declaration2" class="font-medium text-gray-700">I confirm all information provided is accurate and complete</label>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="declaration3" name="declaration3" type="checkbox" x-model="formData.declarations.unEthics" 
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="declaration3" class="font-medium text-gray-700">I confirm our organization adheres to UN Global Compact ethical principles</label>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-red-600" x-show="errors.declarations" x-text="errors.declarations"></p>
                    </div>
                </div>

                <!-- Step 4: Platform User Details -->
                <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="bg-gray-50 p-4 mb-6 rounded-lg border-l-4 border-blue-600">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>
                            Platform Access
                        </h2>
                        <p class="text-gray-600 mt-1">Create login credentials for the e-procurement platform</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="userFirstName" class="block text-sm font-medium text-gray-700">First Name</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="userFirstName" name="userFirstName" x-model="formData.userFirstName" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="First Name" 
                                    @blur="validateField('userFirstName')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.userFirstName">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.userFirstName" x-text="errors.userFirstName"></p>
                        </div>

                        <div>
                            <label for="userLastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="userLastName" name="userLastName" x-model="formData.userLastName" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="Last Name" 
                                    @blur="validateField('userLastName')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.userLastName">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.userLastName" x-text="errors.userLastName"></p>
                        </div>

                        <div>
                            <label for="userEmail" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="email" id="userEmail" name="userEmail" x-model="formData.userEmail" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="user@company.com" 
                                    @blur="validateField('userEmail')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.userEmail">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.userEmail" x-text="errors.userEmail"></p>
                        </div>

                        <div>
                            <label for="userEmailConfirm" class="block text-sm font-medium text-gray-700">Confirm Email Address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="email" id="userEmailConfirm" name="userEmailConfirm" x-model="formData.userEmailConfirm" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="Confirm Email" 
                                    @blur="validateField('userEmailConfirm')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.userEmailConfirm">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.userEmailConfirm" x-text="errors.userEmailConfirm"></p>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" id="password" name="password" x-model="formData.password" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="Password" 
                                    @blur="validateField('password')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.password">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.password" x-text="errors.password"></p>
                            <p class="mt-1 text-xs text-gray-500">Minimum 8 characters with at least one uppercase, lowercase, and number</p>
                        </div>

                        <div>
                            <label for="passwordConfirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" id="passwordConfirm" name="passwordConfirm" x-model="formData.passwordConfirm" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="Confirm Password" 
                                    @blur="validateField('passwordConfirm')">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="errors.passwordConfirm">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-red-600" x-show="errors.passwordConfirm" x-text="errors.passwordConfirm"></p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="source" class="block text-sm font-medium text-gray-700">How did you learn about our procurement system?</label>
                            <div class="mt-1">
                                <select id="source" name="source" x-model="formData.source" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Please select...</option>
                                    <option value="un_website">UN Website</option>
                                    <option value="partner_org">Partner Organization</option>
                                    <option value="social_media">Social Media</option>
                                    <option value="conference">Conference/Event</option>
                                    <option value="word_of_mouth">Word of Mouth</option>
                                    <option value="search_engine">Search Engine</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="md:col-span-2" x-show="formData.source === 'other'">
                            <label for="referralComments" class="block text-sm font-medium text-gray-700">Please specify</label>
                            <div class="mt-1">
                                <textarea id="referralComments" name="referralComments" x-model="formData.referralComments" rows="2" 
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="Please tell us how you learned about our system"></textarea>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <fieldset>
                                <legend class="text-sm font-medium text-gray-700">Would you like to receive email updates about procurement opportunities?</legend>
                                <div class="mt-2 space-y-3">
                                    <div class="flex items-center">
                                        <input id="emailPrefYes" name="emailPreference" type="radio" x-model="formData.emailPreference" value="yes" 
                                            class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        <label for="emailPrefYes" class="ml-3 block text-sm font-medium text-gray-700">
                                            Yes, send me relevant opportunities
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="emailPrefNo" name="emailPreference" type="radio" x-model="formData.emailPreference" value="no" 
                                            class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        <label for="emailPrefNo" class="ml-3 block text-sm font-medium text-gray-700">
                                            No, only send essential communications
                                        </label>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-red-600" x-show="errors.emailPreference" x-text="errors.emailPreference"></p>
                            </fieldset>
                        </div>

                        <div class="md:col-span-2 mt-4">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" x-model="formData.terms" 
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-blue-600 hover:text-blue-800 underline">Terms and Conditions</a> and <a href="#" class="text-blue-600 hover:text-blue-800 underline">Privacy Policy</a></label>
                                    <p class="mt-1 text-sm text-red-600" x-show="errors.terms" x-text="errors.terms"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" 
                        x-show="currentStep > 0" 
                        @click="currentStep--" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous
                    </button>
                    
                    <button type="button" 
                        x-show="currentStep < totalSteps - 1" 
                        @click="goToNextStep()" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Next
                        <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    
                    <button type="submit" 
                        x-show="currentStep === totalSteps - 1" 
                        :disabled="isSubmitting"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!isSubmitting">Complete Registration</span>
                        <span x-show="isSubmitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Processing Overlay -->
        <div x-show="showProcessing" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75" style="display: none;">
            <div class="bg-white p-8 max-w-md w-full rounded-lg shadow-xl transform transition-all sm:max-w-lg">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                        <svg class="h-10 w-10 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-xl font-medium text-gray-900">Processing Registration</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Please wait while we create your account and process your documents...
                    </p>
                    <div class="mt-5 w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" x-bind:style="{ width: progressPercent + '%' }"></div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500" x-text="progressStatus"></p>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div x-show="showSuccess" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75" style="display: none;">
            <div class="bg-white p-6 max-w-md w-full rounded-lg shadow-xl transform transition-all sm:max-w-lg">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
                        <svg class="h-10 w-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-2xl font-bold text-gray-900">Registration Successful!</h3>
                    <div class="mt-6 text-left">
                        <p class="text-gray-700">Thank you for registering your company as a supplier. Your account has been created successfully.</p>
                        
                        <div class="mt-5 bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 text-lg mb-2">Next Steps:</h4>
                            <ol class="list-decimal list-inside space-y-2 text-gray-700">
                                <li>Check your email at <span class="font-semibold text-blue-700" x-text="formData.userEmail"></span></li>
                                <li>Click the verification link to activate your account</li>
                                <li>Log in to access the supplier portal and procurement opportunities</li>
                            </ol>
                        </div>
                        
                        <p class="mt-5 text-sm text-gray-500 italic">If you don't see the email in your inbox, please check your spam or junk folder.</p>
                    </div>
                    <div class="mt-6">
                        <button @click="window.location.href = '/dashboard'" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Go to Login Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js and Form Handling -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<script>
    function registrationForm() {
        return {
            currentStep: 0,
            steps: ['Company Information', 'Documentation', 'Director Details', 'User Access'],
            totalSteps: 4,
            isSubmitting: false,
            showProcessing: false,
            showSuccess: false,
            progressPercent: 0,
            progressStatus: 'Initializing registration...',
            formData: {
                // Company Details
                dunsNumber: '',
                taxpayerId: '',
                companyName: '',
                contactDetails: '',
                legalAddress: '',
                
                // Director Details
                directorFirstName: '',
                directorLastName: '',
                directorPosition: '',
                directorEmail: '',
                declarations: {
                    authorizedSignatory: false,
                    accurateInformation: false,
                    unEthics: false
                },
                
                // User Details
                userFirstName: '',
                userLastName: '',
                userEmail: '',
                userEmailConfirm: '',
                password: '',
                passwordConfirm: '',
                source: '',
                referralComments: '',
                emailPreference: '',
                terms: false
            },
            errors: {},
            
            validateField(field) {
                this.errors[field] = null;
                
                // Validation rules
                switch(field) {
                    case 'dunsNumber':
                        if (!this.formData.dunsNumber) {
                            this.errors[field] = 'D-U-N-S Number is required';
                        } else if (!/^\d{9}$/.test(this.formData.dunsNumber)) {
                            this.errors[field] = 'D-U-N-S Number must be 9 digits';
                        }
                        break;
                        
                    case 'taxpayerId':
                        if (!this.formData.taxpayerId) {
                            this.errors[field] = 'Taxpayer ID is required';
                        }
                        break;
                        
                    case 'companyName':
                        if (!this.formData.companyName) {
                            this.errors[field] = 'Company Name is required';
                        }
                        break;
                        
                    case 'contactDetails':
                        if (!this.formData.contactDetails) {
                            this.errors[field] = 'Contact Details are required';
                        }
                        break;
                        
                    case 'legalAddress':
                        if (!this.formData.legalAddress) {
                            this.errors[field] = 'Legal Address is required';
                        }
                        break;
                        
                    case 'bankingProof':
                        // File validation would be handled differently
                        break;
                        
                    case 'registrationDocuments':
                        // File validation would be handled differently
                        break;
                        
                    case 'directorFirstName':
                        if (!this.formData.directorFirstName) {
                            this.errors[field] = 'Director First Name is required';
                        }
                        break;
                        
                    case 'directorLastName':
                        if (!this.formData.directorLastName) {
                            this.errors[field] = 'Director Last Name is required';
                        }
                        break;
                        
                    case 'directorEmail':
                        if (this.formData.directorEmail && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.formData.directorEmail)) {
                            this.errors[field] = 'Please enter a valid email address';
                        }
                        break;
                        
                    case 'userFirstName':
                        if (!this.formData.userFirstName) {
                            this.errors[field] = 'First Name is required';
                        }
                        break;
                        
                    case 'userLastName':
                        if (!this.formData.userLastName) {
                            this.errors[field] = 'Last Name is required';
                        }
                        break;
                        
                    case 'userEmail':
                        if (!this.formData.userEmail) {
                            this.errors[field] = 'Email is required';
                        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.formData.userEmail)) {
                            this.errors[field] = 'Please enter a valid email address';
                        }
                        break;
                        
                    case 'userEmailConfirm':
                        if (!this.formData.userEmailConfirm) {
                            this.errors[field] = 'Please confirm your email';
                        } else if (this.formData.userEmail !== this.formData.userEmailConfirm) {
                            this.errors[field] = 'Email addresses do not match';
                        }
                        break;
                        
                    case 'password':
                        if (!this.formData.password) {
                            this.errors[field] = 'Password is required';
                        } else if (this.formData.password.length < 8) {
                            this.errors[field] = 'Password must be at least 8 characters';
                        } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(this.formData.password)) {
                            this.errors[field] = 'Password must include uppercase, lowercase, and a number';
                        }
                        break;
                        
                    case 'passwordConfirm':
                        if (!this.formData.passwordConfirm) {
                            this.errors[field] = 'Please confirm your password';
                        } else if (this.formData.password !== this.formData.passwordConfirm) {
                            this.errors[field] = 'Passwords do not match';
                        }
                        break;
                        
                    case 'emailPreference':
                        if (!this.formData.emailPreference) {
                            this.errors[field] = 'Please select an email preference';
                        }
                        break;
                        
                    case 'terms':
                        if (!this.formData.terms) {
                            this.errors[field] = 'You must agree to the terms and conditions';
                        }
                        break;
                }
                
                return !this.errors[field];
            },
            
            validateStep() {
                let isValid = true;
                this.errors = {}; // Clear previous errors
                
                // Validate fields based on current step
                if (this.currentStep === 0) {
                    // Company Details validation
                    const fields = ['dunsNumber', 'taxpayerId', 'companyName', 'contactDetails', 'legalAddress'];
                    fields.forEach(field => {
                        if (!this.validateField(field)) {
                            isValid = false;
                        }
                    });
                } 
                else if (this.currentStep === 1) {
                    // Documentation validation
                    // For file uploads, you might need to validate on the form submit
                    // Here we're just checking if the file input exists in the DOM
                    const bankingProofInput = document.getElementById('bankingProof');
                    const registrationDocsInput = document.getElementById('registrationDocuments');
                    
                    if (bankingProofInput && !bankingProofInput.files[0]) {
                        this.errors.bankingProof = 'Banking proof document is required';
                        isValid = false;
                    }
                    
                    if (registrationDocsInput && !registrationDocsInput.files[0]) {
                        this.errors.registrationDocuments = 'Registration document is required';
                        isValid = false;
                    }
                } 
                else if (this.currentStep === 2) {
                    // Director Details validation
                    const fields = ['directorFirstName', 'directorLastName'];
                    fields.forEach(field => {
                        if (!this.validateField(field)) {
                            isValid = false;
                        }
                    });
                    
                    // Validate optional director email if provided
                    if (this.formData.directorEmail) {
                        this.validateField('directorEmail');
                    }
                    
                    // Check declarations
                    if (!this.formData.declarations.authorizedSignatory || 
                        !this.formData.declarations.accurateInformation || 
                        !this.formData.declarations.unEthics) {
                        this.errors.declarations = 'All declarations must be accepted';
                        isValid = false;
                    }
                } 
                else if (this.currentStep === 3) {
                    // User Details validation
                    const fields = ['userFirstName', 'userLastName', 'userEmail', 'userEmailConfirm', 'password', 'passwordConfirm', 'emailPreference', 'terms'];
                    fields.forEach(field => {
                        if (!this.validateField(field)) {
                            isValid = false;
                        }
                    });
                }
                
                return isValid;
            },
            
            goToNextStep() {
                if (this.validateStep()) {
                    this.currentStep++;
                }
            },
            
            submitForm() {
                if (!this.validateStep()) {
                    return; // Don't submit if validation fails
                }
                
                this.isSubmitting = true;
                this.showProcessing = true;
                
                // Simulate form submission with progress updates
                this.simulateFormSubmission();
            },
            
            simulateFormSubmission() {
                // This is just a demo of the processing animation
                // In a real app, you would replace this with an actual AJAX form submission
                
                const totalSteps = 5;
                let currentStep = 0;
                
                const processStep = () => {
                    currentStep++;
                    this.progressPercent = (currentStep / totalSteps) * 100;
                    
                    switch(currentStep) {
                        case 1:
                            this.progressStatus = 'Validating company information...';
                            break;
                        case 2:
                            this.progressStatus = 'Uploading documents...';
                            break;
                        case 3:
                            this.progressStatus = 'Creating supplier profile...';
                            break;
                        case 4:
                            this.progressStatus = 'Setting up user access...';
                            break;
                        case 5:
                            this.progressStatus = 'Registration complete!';
                            
                            // Show success and hide processing after a short delay
                            setTimeout(() => {
                                this.showProcessing = false;
                                this.showSuccess = true;
                                this.isSubmitting = false;
                            }, 500);
                            return; // End the simulation
                    }
                    
                    // Continue to next step after delay
                    setTimeout(processStep, 800);
                };
                
                // Start the process
                setTimeout(processStep, 500);
                
                // In a real implementation, you would use fetch or axios:
                /*
                const formData = new FormData(document.getElementById('registration-form'));
                
                fetch('{{ route('company.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    this.showProcessing = false;
                    if (data.success) {
                        this.showSuccess = true;
                    } else {
                        // Handle validation errors
                        this.errors = data.errors || {};
                        this.isSubmitting = false;
                        
                        // Show error notification
                        this.$dispatch('show-notification', {
                            type: 'error',
                            message: data.message || 'An error occurred during registration.'
                        });
                    }
                })
                .catch(error => {
                    this.showProcessing = false;
                    this.isSubmitting = false;
                    
                    // Show error notification
                    this.$dispatch('show-notification', {
                        type: 'error',
                        message: 'A network error occurred. Please try again.'
                    });
                });
                */
            }
        };
    }
</script>
@endsection