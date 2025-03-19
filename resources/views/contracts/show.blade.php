@extends('layouts.dash')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Contract Details</h1>

  @if(session('success'))
  <div class="mb-4 text-green-600">
    {{ session('success') }}
  </div>
  @endif

  <div class="mb-4 space-y-2">
    <p><strong>Contract #:</strong> {{ $contract->contract_number }}</p>
    <p><strong>Title:</strong> {{ $contract->title ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ $contract->status }}</p>
    <p><strong>Effective Date:</strong> {{ $contract->effective_date ?? 'N/A' }}</p>
    <p><strong>Expiration Date:</strong> {{ $contract->expiration_date ?? 'N/A' }}</p>
    <p><strong>Total Value:</strong> @if($contract->total_value) 
      {{ number_format($contract->total_value,2) }} {{ $contract->currency }} 
      @else N/A 
      @endif
    </p>
    <p><strong>Description:</strong> {{ $contract->description ?? 'None' }}</p>
  </div>

  <!-- Contract Lines -->
  <div class="mb-6">
    <h2 class="text-xl font-light mb-2">Contract Lines</h2>
    <a href="{{ route('contracts.create_line', $contract->id) }}" class="inline-block mb-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
      Add Contract Line
    </a>

    @if($contract->lines->count() > 0)
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b">Item</th>
          <th class="py-2 px-4 border-b">Description</th>
          <th class="py-2 px-4 border-b">Quantity</th>
          <th class="py-2 px-4 border-b">Unit Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach($contract->lines as $line)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b">{{ $line->line_item }}</td>
          <td class="py-2 px-4 border-b">{{ $line->description }}</td>
          <td class="py-2 px-4 border-b">{{ $line->quantity }}</td>
          <td class="py-2 px-4 border-b">
            @if($line->unit_price) 
              {{ number_format($line->unit_price,2) }} 
            @else 
              N/A 
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="text-gray-600">No lines added yet.</p>
    @endif
  </div>

  <!-- Contract Revisions -->
  <div class="mb-6">
    <h2 class="text-xl font-light mb-2">Revisions</h2>
    <a href="{{ route('contracts.create_revision', $contract->id) }}" class="inline-block mb-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
      Create Revision
    </a>

    @if($contract->revisions->count() > 0)
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b">Revision #</th>
          <th class="py-2 px-4 border-b">Status</th>
          <th class="py-2 px-4 border-b">Initiated By</th>
          <th class="py-2 px-4 border-b">Notes</th>
          <th class="py-2 px-4 border-b">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($contract->revisions as $rev)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b">{{ $rev->revision_number }}</td>
          <td class="py-2 px-4 border-b">{{ $rev->revision_status }}</td>
          <td class="py-2 px-4 border-b">{{ $rev->initiated_by ?? 'N/A' }}</td>
          <td class="py-2 px-4 border-b">{{ $rev->revision_notes ?? 'N/A' }}</td>
          <td class="py-2 px-4 border-b">
            <!-- Approve or Reject a revision -->
            <form action="{{ route('contracts.update_revision', $rev->id) }}" method="POST" class="inline-block mr-1">
              @csrf
              <input type="hidden" name="revision_status" value="Approved">
              <button type="submit" class="text-green-600 hover:underline">Approve</button>
            </form>
            <form action="{{ route('contracts.update_revision', $rev->id) }}" method="POST" class="inline-block">
              @csrf
              <input type="hidden" name="revision_status" value="Rejected">
              <button type="submit" class="text-red-600 hover:underline">Reject</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="text-gray-600">No revisions yet.</p>
    @endif
  </div>

  <div class="mt-4">
    <a href="{{ route('contracts.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to List</a>
  </div>
</div>
@endsection
