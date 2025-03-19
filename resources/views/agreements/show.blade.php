@extends('layouts.dash')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg p-6 rounded-lg">
    <!-- Header -->
    <header class="mb-6">
        <h1 class="text-3xl font-light text-gray-900 flex items-center gap-3">
            <span>{{ $agreement->agreement_number }}</span>
            <!-- Status badge if you'd like to highlight it -->
            <span class="px-2 py-1 rounded text-sm 
                @if($agreement->agreement_status === 'Active') bg-green-100 text-green-800 
                @elseif($agreement->agreement_status === 'Draft') bg-yellow-100 text-yellow-800 
                @elseif($agreement->agreement_status === 'Terminated') bg-red-100 text-red-800 
                @else bg-gray-100 text-gray-600 @endif
            ">
                {{ $agreement->agreement_status }}
            </span>
        </h1>
        <p class="text-gray-600 text-sm">Agreement Details &amp; Advanced Actions</p>
    </header>

    <!-- Main info: simple definition list -->
    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <div>
            <dt class="text-gray-700 font-semibold">Legal Entity:</dt>
            <dd class="text-gray-900">{{ $agreement->legal_entity }}</dd>
        </div>
        <div>
            <dt class="text-gray-700 font-semibold">Business Unit:</dt>
            <dd class="text-gray-900">{{ $agreement->business_unit }}</dd>
        </div>

        <div>
            <dt class="text-gray-700 font-semibold">Agreement Type:</dt>
            <dd class="text-gray-900">{{ $agreement->agreement_type }}</dd>
        </div>
        <div>
            <dt class="text-gray-700 font-semibold">Agreement Status:</dt>
            <dd class="text-gray-900">{{ $agreement->agreement_status }}</dd>
        </div>

        <div>
            <dt class="text-gray-700 font-semibold">Agreement Amount:</dt>
            <dd class="text-gray-900">
                ${{ number_format($agreement->agreement_amount ?? 0, 2) }}
            </dd>
        </div>
        <div>
            <dt class="text-gray-700 font-semibold">Min Release Amount:</dt>
            <dd class="text-gray-900">
                ${{ number_format($agreement->minimum_release_amount ?? 0, 2) }}
            </dd>
        </div>

        <div>
            <dt class="text-gray-700 font-semibold">Released Amount:</dt>
            <dd class="text-gray-900">
                ${{ number_format($agreement->released_amount ?? 0, 2) }}
            </dd>
        </div>
        <div>
            <dt class="text-gray-700 font-semibold">Effective Date:</dt>
            <dd class="text-gray-900">
                {{ \Carbon\Carbon::parse($agreement->effective_date)->format('M d, Y') }}
            </dd>
        </div>

        <div>
            <dt class="text-gray-700 font-semibold">Expiration Date:</dt>
            <dd class="text-gray-900">
                {{ \Carbon\Carbon::parse($agreement->expiration_date)->format('M d, Y') }}
            </dd>
        </div>
    </dl>

    <!-- Divider line -->
    <hr class="my-8 border-gray-200">

    <!-- Attachments (example placeholder) -->
    <section class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Attachments</h2>
        <!-- If you have an attachments array, loop it; else show "No attachments" -->
        @if(!empty($agreement->attachments) && count($agreement->attachments) > 0)
            <ul class="list-disc list-inside text-gray-800">
                @foreach($agreement->attachments as $file)
                    <li>
                        <a href="{{ route('agreements.downloadAttachment', [$agreement->id, $file['id']]) }}" 
                           class="text-blue-600 hover:underline"
                           target="_blank">
                            {{ $file['filename'] }}
                        </a>
                        <span class="text-xs text-gray-500">({{ $file['size'] }} KB)</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-500 italic">No attachments available.</p>
        @endif

        <!-- Example: add new attachment button (trigger a modal or separate route) -->
        <button class="px-3 py-2 mt-3 bg-blue-600 text-white rounded shadow 
                       hover:bg-blue-700 transition-colors duration-200 text-sm">
            Add Attachment
        </button>
    </section>

    <!-- Agreement Lifecycle / Revisions (example placeholder) -->
    <section class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Revisions / Lifecycle</h2>
        <!-- If you store lifecycle or revision history, you can loop them here. Example: -->
        @if(isset($agreement->revisions) && count($agreement->revisions) > 0)
            <ol class="list-decimal list-inside space-y-1 text-sm text-gray-800">
                @foreach($agreement->revisions as $rev)
                    <li>
                        <span class="font-medium">{{ $rev['date'] }}:</span> {{ $rev['description'] }}
                    </li>
                @endforeach
            </ol>
        @else
            <p class="text-sm text-gray-500 italic">No revisions documented.</p>
        @endif

        <!-- Example: add revision button -->
        <button class="px-3 py-2 mt-3 bg-indigo-600 text-white rounded shadow 
                       hover:bg-indigo-700 transition-colors duration-200 text-sm">
            Add Revision
        </button>
    </section>

    <!-- Advanced Actions: Export, Edit, Back, etc. -->
    <div class="flex flex-wrap gap-3">
        <!-- Export to PDF (example) -->
        <a href="{{ route('agreements.exportPdf', $agreement->id) }}"
           class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm">
            Export PDF
        </a>

        <!-- Export CSV for just this agreement or a main listing? 
             If you want a direct route for the single record: -->
        <a href="{{ route('agreements.exportSingleCsv', $agreement->id) }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-sm">
            Export CSV
        </a>

        <!-- Edit -->
        <a href="{{ route('agreements.edit', $agreement->id) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm">
            Edit
        </a>

        <!-- Back -->
        <a href="{{ route('agreements.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200 text-sm">
            Back to List
        </a>
    </div>
</div>
@endsection
