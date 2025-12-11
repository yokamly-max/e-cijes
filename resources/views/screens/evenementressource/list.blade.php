@extends('platform::app')

@section('title', 'Liste des paiements des évènements')

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
                                <th class="px-3 py-2">Date</th>
                                <th class="px-3 py-2">Membre</th>
                                <th class="px-3 py-2">Entreprise</th>
                                <th class="px-3 py-2">Accompagnement</th>
                                <th class="px-3 py-2">Montant</th>
                                <th class="px-3 py-2">Ressource</th>
                                <th class="px-3 py-2">Evenement</th>
                                <th class="px-3 py-2">Statut</th>
                                <th class="px-3 py-2">Spotlight</th>
                                <th class="px-3 py-2">État</th>
                                <!-- <th class="px-3 py-2">Créé le</th> -->
                                <!-- <th class="px-3 py-2">Modifié le</th> -->
                                <th class="px-3 py-2 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evenementressources as $evenementressource)
                                <tr>
                                    <td class="px-3 py-2">{{ $evenementressource->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($evenementressource->created_at)->format('d/m/Y') }}</td>
                                    <td class="px-3 py-2">
                                        @if ($evenementressource->membre_id > 0)
                                            {{ $evenementressource->membre->nom_complet ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($evenementressource->entreprise_id > 0)
                                            {{ $evenementressource->entreprise->nom ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($evenementressource->accompagnement_id > 0)
                                            {{ $evenementressource->accompagnement->nom_complet ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">{{ $evenementressource->montant }}<br /><small>{{ $evenementressource->reference }}</small></td>
                                    <td class="px-3 py-2">
                                        @if ($evenementressource->ressourcecompte_id > 0)
                                            {{ $evenementressource->ressourcecompte->nom_complet ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($evenementressource->evenement_id > 0)
                                            {{ $evenementressource->evenement->titre ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($evenementressource->paiementstatut_id > 0)
                                            {{ $evenementressource->paiementstatut->titre ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <form method="POST" action="{{ route('platform.evenementressource.toggleSpotlight') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $evenementressource->id }}">
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                {{ $evenementressource->spotlight ? '✅' : '❌' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-3 py-2">
                                        <form method="POST" action="{{ route('platform.evenementressource.toggleEtat') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $evenementressource->id }}">
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                {{ $evenementressource->etat ? '✅' : '❌' }}
                                            </button>
                                        </form>
                                    </td>
                                    <!-- <td class="px-3 py-2">{{ $evenementressource->created_at }}</td> -->
                                    <!-- <td class="px-3 py-2">{{ $evenementressource->updated_at }}</td> -->
                                    <td class="px-3 py-2 text-end">
                                        <a href="{{ route('platform.evenementressource.show', $evenementressource->id) }}" class="btn btn-info btn-sm">
                                            🔍 Détail
                                        </a>
                                        
                                        <a href="{{ route('platform.evenementressource.edit', $evenementressource->id) }}" class="btn btn-warning btn-sm">
                                            ✏️ Modifier
                                        </a>
                                        
                                        <form method="POST" action="{{ route('platform.evenementressource.delete') }}" style="display:inline-block">
                                            @csrf
                                            <input type="hidden" name="evenementressource" value="{{ $evenementressource->id }}">
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
