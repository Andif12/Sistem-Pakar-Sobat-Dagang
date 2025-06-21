@extends('layouts.home')

@section('content')
<div class="bg-white flex justify-center py-10 px-4">
  <div class="max-w-3xl w-full">
    <h1
      class="fredoka text-6xl font-extrabold text-center mb-8"
      style="color: #f9a825; text-shadow: 2px 2px 0 #000000;"
    >
      FAQ
    </h1>
    <ul class="space-y-4 text-base font-semibold text-black max-w-full">
      @foreach($faqs as $faq)
        <li>
          <button
            type="button"
            class="w-full flex items-start focus:outline-none"
            aria-expanded="false"
            aria-controls="faq{{ $faq->id }}"
            onclick="toggleDropdown('faq{{ $faq->id }}', this)"
          >
            <span class="mt-1 mr-2 text-black">&#9654;</span>
            {{ $faq->pertanyaan }}
          </button>
          <div
            id="faq{{ $faq->id }}"
            class="mt-2 ml-7 hidden text-base font-normal text-gray-800"
          >
            {{ $faq->jawaban }}
          </div>
        </li>
      @endforeach
    </ul>
  </div>
</div>

<script>
  function toggleDropdown(id, btn) {
    const content = document.getElementById(id);
    const isHidden = content.classList.contains('hidden');
    // Close all open dropdowns
    document.querySelectorAll('ul > li > div').forEach((div) => {
      div.classList.add('hidden');
    });
    document.querySelectorAll('ul > li > button').forEach((button) => {
      button.setAttribute('aria-expanded', 'false');
      button.querySelector('span').innerHTML = '&#9654;';
    });
    if (isHidden) {
      content.classList.remove('hidden');
      btn.setAttribute('aria-expanded', 'true');
      btn.querySelector('span').innerHTML = '&#9660;';
    } else {
      content.classList.add('hidden');
      btn.setAttribute('aria-expanded', 'false');
      btn.querySelector('span').innerHTML = '&#9654;';
    }
  }
</script>
@endsection
