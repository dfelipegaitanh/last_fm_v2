@props([
    'class' => '',
    'viewBox' => '0 0 20 20',
    'fill' => '',
    'stroke' => 'currentColor',
    'fill_rule' => '',
    'clip_rule' => '',
    'stroke_linecap' => '',
    'stroke_linejoin' => '',
    'stroke_width' => '',
])

<svg
    class="{{ $class }}"
    xmlns="http://www.w3.org/2000/svg"
    viewBox="{{ $viewBox }}"
    stroke="{{ $stroke }}"
    fill="{{ $fill }}"
>
    <path
        fill-rule="{{ $fill_rule }}"
        clip-rule="{{ $clip_rule }}"
        stroke-linecap="{{ $stroke_linecap }}"
        stroke-linejoin="{{ $stroke_linejoin }}"
        stroke-width="{{ $stroke_width }}"
        d="{{ $slot }}"
    />
</svg>
