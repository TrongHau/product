@if ($paginator->hasPages())
    <nav aria-label="Page navigation example" style="margin-top: 5px; margin-left: 20px;">
        <ul class="list-style-none flex">
            @if ($paginator->onFirstPage())

            @else
            <li>
                <a
                    class="w-[33px] h-[33px] paginate-button cursor-pointer relative block rounded-full bg-[#F7F8F9] p-2 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100  dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                    href="{{ $paginator->previousPageUrl() }}"
                ><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_10343_23408)">
                            <path d="M10.7759 4.94L9.83594 4L5.83594 8L9.83594 12L10.7759 11.06L7.7226 8L10.7759 4.94Z" fill="#4B5768"></path>
                        </g>
                        <defs>
                            <clipPath id="clip0_10343_23408">
                                <rect width="16" height="16" fill="white" transform="translate(0.5)"></rect>
                            </clipPath>
                        </defs>
                    </svg></a>
            </li>
            @endif
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span
                            class="relative block rounded-full bg-[#F7F8F9] px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100  dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                        >{{ $element }}</span>
                    </li>
                @endif


                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page">
                                <a class="paginate-button pointer-events-none relative block rounded-full bg-[#F20000] px-3 py-1.5 text-sm font-medium text-white transition-all duration-300"
                                    href="{{ $url }}"
                                >{{ $page }}
                                    <span
                                        class="cursor-pointer absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]"
                                    >{{ $page }}</span
                                    >
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="paginate-button mx-1 cursor-pointer relative block rounded-full bg-[#F7F8F9] px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100  dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                                    href="{{ $url }}"
                                >{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach


            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a
                        class="mx-1 paginate-button cursor-pointer relative block rounded-full bg-[#F7F8F9] px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100  dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                        href="{{ $paginator->nextPageUrl() }}"
                    >@lang('pagination.next')</a>
                </li>
            @else

            @endif
        </ul>
    </nav>
@endif
