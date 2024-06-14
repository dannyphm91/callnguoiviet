@props(['status'])
<span
    class="px-2 py-[0.13]  rounded bg-error-50 dark:bg-error-800 gap-x-[0.125rem] inline-flex items-center justify-center heading-08 text-error-700 dark:text-error-200">
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 12L12 4M4 4L12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
    {{ ucfirst($status) }}
</span>
