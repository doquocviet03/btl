@php
    $navLinks = [
        ['route' => 'public.home', 'pattern' => 'public.home', 'label' => 'Home'],
        ['route' => 'public.dich-vu.index', 'pattern' => 'public.dich-vu.*', 'label' => 'Services'],
        ['route' => 'public.tho-cat-toc.index', 'pattern' => 'public.tho-cat-toc.*', 'label' => 'Barbers'],
        ['route' => 'public.san-pham.index', 'pattern' => 'public.san-pham.*', 'label' => 'Shop'],
        ['route' => 'public.blog.index', 'pattern' => 'public.blog.*', 'label' => 'Blog'],
        ['route' => 'public.cua-hang.index', 'pattern' => 'public.cua-hang.*', 'label' => 'Stores'],
    ];
@endphp

<nav class="hidden xl:flex items-center gap-1 rounded-full border border-white/10 bg-white/[.06] p-1 text-xs font-black text-zinc-300 backdrop-blur-2xl">
    @foreach($navLinks as $link)
        <a href="{{ route($link['route']) }}"
           class="rounded-full px-4 py-2.5 transition {{ request()->routeIs($link['pattern']) ? 'bg-white text-black shadow-[0_10px_30px_rgba(255,255,255,.12)]' : 'hover:bg-white/10 hover:text-white' }}">
            {{ $link['label'] }}
        </a>
    @endforeach
</nav>
