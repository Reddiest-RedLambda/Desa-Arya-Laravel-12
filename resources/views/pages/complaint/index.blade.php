@extends('layouts.app')

@section('content')
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">{{ auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN ? 'Pengaduan Warga' : 'Pengaduan' }}</h1>
                        @if (isset(auth()->user()->resident))
                        <a href="/complaint/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Report</a>
                        @endif
                    </div>

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                title: "Proceeded",
                                text: "{{ session()->get('success') }}",
                                icon: "success"
                            });
                        </script>
                    @endif

                    @if (session('error'))
                        <script>
                            Swal.fire({
                                title: "Couldn't Proceed",
                                text: "{{ session()->get('error') }}",
                                icon: "error"
                            });
                        </script>
                    @endif

                    {{-- Table --}}
                    <div class="row">
                        <div class="col">
                            <div class="card shadow">
                                <div class="card-body">
                                    <table class="table table-responsive table-bordered table-hovered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            @if (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                            <th>Nama Penduduk</th>
                                            @endif
                                            <th>Judul</th>
                                            <th>Isi Aduan</th>
                                            <th>Status</th>
                                            <th>Foto Bukti</th>
                                            <th>Tanggal Laporan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if (count($complaints) < 1)
                                        <tbody>
                                            <tr>
                                                <td colspan="11">
                                                    <p class="pt-3 text-center">Tidak ada Data Penduduk</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            @foreach ($complaints as $item)
                                            <tr>
                                                <td>{{ $loop->iteration + $complaints->firstItem() - 1 }}</td>
                                                @if (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                                <td>{{ $item->resident->name }}</td>
                                                @endif
                                                <td>{{ $item->title }}</td>
                                                <td>{!! wordwrap($item->content ,50, "<br>\n"); !!}</td>
                                                <td>
                                                    <span class="badge badge-{{ $item->status_color }}">{{ $item->status_label }}</span>
                                                </td>
                                                <td>
                                                    @if (isset($item->photo_proof))
                                                        @php
                                                            $filePath = 'storage/' . $item->photo_proof;
                                                        @endphp
                                                        <a href="{{ $filePath }}" target="_blank" rel="noopener noreferrer">
                                                            <img src="{{ $filePath }}" alt="Foto Bukti" style="max-width: 300px;">
                                                        </a>
                                                    @else
                                                        None
                                                    @endif
                                                </td>
                                                <td>{{ $item->report_date_label }}</td>
                                                <td>
                                                    @if (auth()->user()->role_id == \App\Models\Role::ROLE_USER && isset(auth()->user()->resident) && $item->status == 'new')
                                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                                        <a href="/complaint/{{ $item->id }}" class="d-inline-block btn btn-sm btn-warning">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                            <i class="fas fa-eraser"></i>
                                                        </button>
                                                    </div>
                                                    @elseif (auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                                                    <div>
                                                        <form id="formChangeStatus-{{ $item->id }}" action="/complaint/update-status/{{ $item->id }}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <div class="form-group">
                                                                <select name="status" id="status" class="form-control" style="min-width: 103px;" oninput="document.getElementById('formChangeStatus-{{ $item->id }}').submit()">
                                                                    @foreach ([
                                                                        (object) [
                                                                            'label' => 'New',
                                                                            'value' => 'new',    
                                                                        ],
                                                                        (object) [
                                                                            'label' => 'Process',
                                                                            'value' => 'processing',    
                                                                        ],
                                                                        (object) [
                                                                            'label' => 'Done',
                                                                            'value' => 'completed',    
                                                                        ],
                                                                    ] as $status)
                                                                        <option value="{{ $status->value }}" @selected($item->status == $status->value)>{{ $status->label }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                                @include('pages.complaint.confirmation-delete')
                                            @endforeach
                                        </tbody>
                                    @endif
                                    </table>
                                </div>
                                @if ($complaints->lastPage() > 1)
                                <div class="card-footer">
                                    {{ $complaints->links('pagination::bootstrap-5') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
@endsection
