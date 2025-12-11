@extends('platform::app')

@section('title', 'Liste des évènements')

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
                                <th class="px-3 py-2">Vignette</th>
                                <th class="px-3 py-2">Date</th>
                                <th class="px-3 py-2">Titre</th>
                                <th class="px-3 py-2">Type</th>
                                <th class="px-3 py-2">Pays</th>
                                <th class="px-3 py-2">Langue</th>
                                <th class="px-3 py-2">Spotlight</th>
                                <th class="px-3 py-2">État</th>
                                <!-- <th class="px-3 py-2">Créé le</th> -->
                                <!-- <th class="px-3 py-2">Modifié le</th> -->
                                <th class="px-3 py-2 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evenements as $evenement)
                                <tr>
                                    <td class="px-3 py-2">{{ $evenement->id }}</td>
                                    <td class="px-3 py-2">
                                        @if ($evenement->vignette)
                                            @php $ext = pathinfo($evenement->vignette, PATHINFO_EXTENSION); @endphp
                                            @if(in_array(strtolower($ext), ['jpg','jpeg','png','webp','gif']))
                                                <img src="{{ asset($evenement->vignette) }}" width="50" class="rounded shadow">
                                            @else
                                                <a href="{{ asset($evenement->vignette) }}" class="btn btn-outline-primary btn-sm" download>
                                                    📄 Télécharger
                                                </a>
                                            @endif
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($evenement->dateevenement)->format('d/m/Y H:i') }}</td>
                                    <td class="px-3 py-2">{{ $evenement->titre }}<br /><span>{{ $evenement->resume }}</span></td>
                                    <td class="px-3 py-2">
                                        @if ($evenement->evenementtype_id > 0)
                                            {{ $evenement->evenementtype->titre ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($evenement->pays_id > 0)
                                            {{ $evenement->pays->name ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($evenement->langue_id > 0)
                                            {{ $evenement->langue->name ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <form method="POST" action="{{ route('platform.evenement.toggleSpotlight') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $evenement->id }}">
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                {{ $evenement->spotlight ? '✅' : '❌' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-3 py-2">
                                        <form method="POST" action="{{ route('platform.evenement.toggleEtat') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $evenement->id }}">
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                {{ $evenement->etat ? '✅' : '❌' }}
                                            </button>
                                        </form>
                                    </td>
                                    <!-- <td class="px-3 py-2">{{ $evenement->created_at }}</td> -->
                                    <!-- <td class="px-3 py-2">{{ $evenement->updated_at }}</td> -->
                                    <td class="px-3 py-2 text-end">
                                        <a href="{{ route('platform.evenement.show', $evenement->id) }}" class="btn btn-info btn-sm">
                                            🔍 Détail
                                        </a>
                                        
                                        <a href="{{ route('platform.evenement.edit', $evenement->id) }}" class="btn btn-warning btn-sm">
                                            ✏️ Modifier
                                        </a>
                                        
                                        <form method="POST" action="{{ route('platform.evenement.delete') }}" style="display:inline-block">
                                            @csrf
                                            <input type="hidden" name="evenement" value="{{ $evenement->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">🗑 Supprimer</button>
                                        </form>
                                    </td>
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
