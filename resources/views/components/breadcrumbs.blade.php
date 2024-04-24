@if (count(session('breadcrumbs')) > 1)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ _('Home') }}</a></li>
            @foreach (session('breadcrumbs') as $breadcrumb)
                @if ($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($breadcrumb) }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route($breadcrumb) }}">{{ ucfirst($breadcrumb) }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
