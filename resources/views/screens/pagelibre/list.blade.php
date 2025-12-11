@extends('platform::app')

@section('title', 'Liste des pages de présentation')

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
                                <th class="px-3 py-2">Titre</th>
                                <th class="px-3 py-2">Page</th>
                                <th class="px-3 py-2">Langue</th>
                                <th class="px-3 py-2">Spotlight</th>
                                <th class="px-3 py-2">État</th>
                                <!-- <th class="px-3 py-2">Créé le</th> -->
                                <!-- <th class="px-3 py-2">Modifié le</th> -->
                                <th class="px-3 py-2 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagelibres as $pagelibre)
                                <tr>
                                    <td class="px-3 py-2">{{ $pagelibre->id }}</td>
                                    <td class="px-3 py-2">
                                        @if ($pagelibre->vignette)
                                            @php $ext = pathinfo($pagelibre->vignette, PATHINFO_EXTENSION); @endphp
                                            @if(in_array(strtolower($ext), ['jpg','jpeg','png','webp','gif']))
                                                <img src="{{ asset($pagelibre->vignette) }}" width="50" class="rounded shadow">
                                            @else
                                                <a href="{{ asset($pagelibre->vignette) }}" class="btn btn-outline-primary btn-sm" download>
                                                    📄 Télécharger
                                                </a>
                                            @endif
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">{{ $pagelibre->titre }}<br /><span>{{ $pagelibre->resume }}</span></td>
                                    <td class="px-3 py-2">
                                        @if ($pagelibre->parent > 0)
                                            {{ $pagelibre->pageparent->titre ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($pagelibre->langue_id > 0)
                                            {{ $pagelibre->langue->name ?? '' }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <form method="POST" action="{{ route('platform.pagelibre.toggleSpotlight') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $pagelibre->id }}">
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                {{ $pagelibre->spotlight ? '✅' : '❌' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-3 py-2">
                                        <form method="POST" action="{{ route('platform.pagelibre.toggleEtat') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $pagelibre->id }}">
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                {{ $pagelibre->etat ? '✅' : '❌' }}
                                            </button>
                                        </form>
                                    </td>
                                    <!-- <td class="px-3 py-2">{{ $pagelibre->created_at }}</td> -->
                                    <!-- <td class="px-3 py-2">{{ $pagelibre->updated_at }}</td> -->
                                    <td class="px-3 py-2 text-end">
                                        <a href="{{ route('platform.pagelibre.show', $pagelibre->id) }}" class="btn btn-info btn-sm">
                                            🔍 Détail
                                        </a>
                                        
                                        <a href="{{ route('platform.pagelibre.edit', $pagelibre->id) }}" class="btn btn-warning btn-sm">
                                            ✏️ Modifier
                                        </a>
                                        
                                        <form method="POST" action="{{ route('platform.pagelibre.delete') }}" style="display:inline-block">
                                            @csrf
                                            <input type="hidden" name="pagelibre" value="{{ $pagelibre->id }}">
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
