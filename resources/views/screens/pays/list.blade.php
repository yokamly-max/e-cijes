@extends('platform::app')

@section('title', 'Liste des pays')

@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endpush

@section('content')
<fieldset class="mb-3">
<div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column gap-3">
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white rounded-2xl shadow p-4 mb-6 overflow-hidden">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-3 py-2">#</th>
                                <th class="px-3 py-2">Drapeau</th>
                                <th class="px-3 py-2">Nom</th>
                                <th class="px-3 py-2">Code</th>
                                <th class="px-3 py-2">Indicatif</th>
                                <th class="px-3 py-2">Monnaie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payss as $pays)
                                <tr>
                                    <td class="px-3 py-2">{{ $pays->id }}</td>
                                    <td class="px-3 py-2">
                                        @if ($pays->flag_url)
                                            @php $ext = pathinfo($pays->flag_url, PATHINFO_EXTENSION); @endphp
                                            @if(in_array(strtolower($ext), ['jpg','jpeg','png','webp','gif']))
                                                <img src="{{ asset($pays->flag_url) }}" width="50" class="rounded shadow">
                                            @else
                                                <a href="{{ asset($pays->flag_url) }}" class="btn btn-outline-primary btn-sm" download>
                                                    📄 Télécharger
                                                </a>
                                            @endif
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">{{ $pays->name }}</td>
                                    <td class="px-3 py-2">{{ $pays->iso_code }}</td>
                                    <td class="px-3 py-2">{{ $pays->calling_code }}</td>
                                    <td class="px-3 py-2">{{ $pays->currency_id }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</fieldset>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('#datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
                },
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthChange: true,
                order: [[0, 'desc']],
            });
        });
    </script>
@endpush
