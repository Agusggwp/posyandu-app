@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(180deg,#fbfcfd 0%, #ffffff 100%);">
  <div class="max-w-2xl w-full p-6 text-center">
    <div class="mx-auto w-full bg-white rounded-lg shadow-md p-8" style="border:1px solid #eef2f5;">
      <div class="flex items-center justify-center mb-4">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <circle cx="12" cy="12" r="10" stroke="#cbd5e1" stroke-width="1.2" fill="none" />
          <path d="M12 7v6" stroke="#6b7280" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="12" cy="16" r="0.75" fill="#6b7280" />
        </svg>
      </div>

      <div class="text-sm text-gray-500 mb-1">Kode</div>
      <div class="text-2xl font-semibold text-gray-800 mb-2">@yield('code')</div>
      <h1 class="text-xl font-medium text-gray-800 mb-2">@yield('title')</h1>
      <p class="text-gray-600 mb-6">@yield('message')</p>

      <div class="flex items-center justify-center gap-3">
        <a href="{{ url('/') }}" class="px-5 py-2 bg-gray-800 text-white rounded-md text-sm">Kembali ke Beranda</a>
        <a href="javascript:history.back()" class="px-4 py-2 border border-gray-200 rounded-md text-sm text-gray-700">Kembali</a>
        <a href="mailto:support@example.com?subject=Error%20Report%20%40%20{{ request()->path() }}" class="px-4 py-2 border border-gray-200 rounded-md text-sm text-gray-700">Laporkan</a>
      </div>

      @if(config('app.debug') && isset($exception))
        <div class="mt-6 text-left bg-gray-50 border border-gray-100 rounded-md p-3 text-xs text-gray-700">
          <strong>Debug:</strong>
          <div class="mt-2"><em>Message:</em> {{ $exception->getMessage() }}</div>
          <div class="mt-2"><em>File:</em> {{ $exception->getFile() }} : {{ $exception->getLine() }}</div>
          <details class="mt-2"><summary class="text-xs text-gray-600">Stack trace</summary>
            <pre class="whitespace-pre-wrap text-xs">{{ $exception->getTraceAsString() }}</pre>
          </details>
        </div>
      @endif
    </div>
  </div>
</div>

@endsection
